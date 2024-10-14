<?php
namespace App\Controller;
use Cake\I18n\Time;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\Mailer\MailerAwareTrait;       //  Built in function use for sending multiple email
use Cake\ORM\TableRegistry;
/**
 * Payments Controller
 *
 * @property \App\Model\Table\PaymentsTable $Payments
 *
 * @method \App\Model\Entity\Payment[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PaymentsController extends AppController
{
    use MailerAwareTrait;
   
    public function isAuthorized($user)
    {
	$contractorNav = false;
	if($user['role_id'] == CR) {
		$contractorNav = true;
	}
	$this->set('contractorNav', $contractorNav);
	
	if (isset($user['role_id'])) {
		return true;
	}
	// Default deny
	return false;
    }

   public function checkout($renew_subscription=false)
    {
    $this->loadModel('Clients');
	$this->loadModel('States');
	$this->loadModel('Countries');
	$this->loadModel('BillingDetails');
	$this->loadModel('Contractors');
	$this->loadModel('Users');
	$this->loadModel('ContractorClients');

	$contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');
	$contractor = $this->Contractors->get($contractor_id, ['contain'=>['Users','States','Countries']]);
	$contClients = $this->ContractorClients->find('list',['keyField' => 'id', 'valueField' => 'client_id'])->where(['contractor_id'=>$contractor_id])->toArray();	
	//$errorMessages = '';
	
	$services = $this->User->getContractorServices($contractor_id, true);
	if($renew_subscription) {
		$calculatePayment = $this->User->calculatePayment($contractor_id, $services,true);
	}
	else {
		if($this->User->isSubscriptionRenewed($contractor) == false) {
			return $this->redirect(['controller'=>'Payments', 'action' => 'checkout', 1]);
            exit;
		}
		
		$calculatePayment = $this->User->calculatePayment($contractor_id, $services);//pr($calculatePayment);
	}

	$totalprice = $calculatePayment['final_price'];

    if($contractor->registration_status < 3) { $payment_type = Configure::read('payment_type.contractor.new'); }
	elseif($renew_subscription) { $payment_type = Configure::read('payment_type.contractor.renew_subscription'); }
	elseif($calculatePayment['new_client']==true) { $payment_type = Configure::read('payment_type.contractor.new_client'); }
	elseif($calculatePayment['new_service']==true) { $payment_type = Configure::read('payment_type.contractor.new_service'); }
	//elseif($calculatePayment['employee_slot']==true) { $payment_type = Configure::read('payment_type.contractor.employee_slot'); }
    else { $payment_type = Configure::read('payment_type.contractor.new_site'); }

    /*if(!isset($payment_type)) {
		return $this->redirect(['controller'=>'ContractorSites', 'action' => 'add']);
    }*/
	$clientIds = array();
	 foreach ($calculatePayment['services'] as $calPayment){
    	foreach ($calPayment['client_ids'] as $key => $cli) {
     		$clientIds[] = $cli;
    		}    
	} 
 	$clientIds = array_unique($clientIds);
 	
	$payment = $this->Payments->newEntity();
	if ($this->request->is('post')) {
	
	if((empty($contClients) && (!in_array(4, $clientIds))) || ($renew_subscription )) {
		$this->User->associateWithMarketplace($contractor_id,$renew_subscription); 	
	}	
		if(empty($calculatePayment['services']) && $totalprice == 0){
			// move tempSites to sites
            //	$this->moveTempSites();
		    // move tempClients to contractorClients
			$this->moveTempClients();

			$this->Flash->success(__('The payment has been saved.'));
			if($this->User->isContractor()) {
				return $this->redirect(['controller'=>'Contractors', 'action' => 'dashboard']);
                exit;
			}
			else {
				return $this->redirect(['controller'=>'Contractors', 'action' => 'dashboard', $contractor_id]);
                exit;
			}
		}

		// save BillingDetails
		//$this->saveBillingDetails($this->request->getData());	
		
		// Paypal Request
		$nvp_response_array = $this->SendPaypalRequest($this->request->getData(), $contractor, $totalprice, $payment_type);
	    if(isset($nvp_response_array['EMAIL']) && $nvp_response_array['EMAIL'] == 'arundhati.lambore@canqualify.com') {
		    $totalprice = 1;
	    }
      
		// Parse the API response and save payments
		$payment = $this->Payments->patchEntity($payment, $this->request->getData());
		$payment->totalprice = $totalprice;
		$payment->contractor_id = $contractor_id;
		$payment->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
		$payment->payment_type = $payment_type;
		$payment->email = isset($nvp_response_array['EMAIL']) ? $nvp_response_array['EMAIL'] : '';
		
		if(!empty($nvp_response_array)) {
			$payment->response = json_encode($nvp_response_array);

			$payment->p_amt = isset($nvp_response_array['AMT']) ? $nvp_response_array['AMT'] : null;
			$payment->transaction_status = isset($nvp_response_array['ACK']) ? $nvp_response_array['ACK'] : '';
			$payment->p_transactionid = isset($nvp_response_array['TRANSACTIONID']) ? $nvp_response_array['TRANSACTIONID'] : '';

			$payment->p_avscode = isset($nvp_response_array['AVSCODE']) ? $nvp_response_array['AVSCODE'] : '';
			$payment->p_cvv2match = isset($nvp_response_array['CVV2MATCH']) ? $nvp_response_array['CVV2MATCH'] : '';
			$payment->p_timestamp = isset($nvp_response_array['TIMESTAMP']) ? $nvp_response_array['TIMESTAMP'] : '';
			$payment->p_correlationid = isset($nvp_response_array['CORRELATIONID']) ? $nvp_response_array['CORRELATIONID'] : '';

            // On error
			//if ($nvp_response_array['ACK'] == 'Failure' || $nvp_response_array['ACK'] == 'FailureWithWarning') {
			$payment->p_errorcode0 = isset($nvp_response_array['L_ERRORCODE0']) ? $nvp_response_array['L_ERRORCODE0'] : '';
			$payment->p_shortmessage0 = isset($nvp_response_array['L_SHORTMESSAGE0']) ? $nvp_response_array['L_SHORTMESSAGE0'] : '';
			// $payment->p_longmessage0 = 'This transaction cannot be processed. Please enter a valid credit card number and type.';
			$payment->p_longmessage0 = isset($nvp_response_array['L_LONGMESSAGE0']) ? $nvp_response_array['L_LONGMESSAGE0'] : '';
			$payment->p_serveritycode0 = isset($nvp_response_array['L_SEVERITYCODE0']) ? $nvp_response_array['L_SEVERITYCODE0'] : '';
            //}

		} else {
			$payment->transaction_status = 'Failure';
		} 
		
		$errorMessages = $payment->p_longmessage0;
		
		if ($result = $this->Payments->save($payment)) {
		if ($result['transaction_status'] == 'Success' || $result['transaction_status'] == 'SuccessWithWarning') {
			// Set contractor payment_status and registration_status
            $subscription_date = $contractor->subscription_date;

			// contractor payment first time
			if($contractor->registration_status < 3) {
    			$new_contractor = true;

				$contractor->payment_status = 1;
				$contractor->registration_status = 3;
				$this->getRequest()->getSession()->write('Auth.User.registration_status', 3);

				$subscription_date = date('Y-m-d', strtotime('+ 1 year')); //n/d/Y
			}
			if($contractor->registration_status == 3 && count($contClients)==1 && in_array(4, $contClients)){
				$subscription_date = date('Y-m-d', strtotime('+ 1 year')); 
			}
	        if($renew_subscription) { 							
                $subscription_date = strtotime($contractor->subscription_date);				
				$todayDate = strtotime(date('m/d/Y'));
				
				if($subscription_date < $todayDate) {
					$diff = $todayDate -$subscription_date;				
					$datediff = abs(round($diff / 86400));
					if($datediff<=60){
						$subscription_date = date('Y-m-d', strtotime('+ 1 year', $subscription_date)); //n/d/Y
					}elseif($datediff > 60){
						$subscription_date = date('Y-m-d', strtotime('+ 1 year', $todayDate)); //n/d/Y
					}
				}else{        		
					$subscription_date = date('Y-m-d', strtotime('+ 1 year', $subscription_date)); //n/d/Y
        		}				
				$this->Users->query()->update()->set(['login_secret_key'=>null])
					->where(['id'=>$contractor->user_id])
					->execute();
				 $this->Users->query()->update()->set(['active'=>true])
				 	->where(['id'=>$contractor->user_id])
				 	->execute();
				 $this->getRequest()->getSession()->write('Auth.User.active', true);
				
				//$contractor->user->login_secret_key = null;
            }
            if($this->getRequest()->getSession()->read('Auth.User.active')==false){
            $this->Users->query()->update()->set(['active'=>true])
					->where(['id'=>$contractor->user_id])
					->execute();
				$this->getRequest()->getSession()->write('Auth.User.active', true);
			}
			if($contractor->forced_renew == true){ //forcefully enable Renew Subscription Link 
				$contractor->forced_renew = false;
			}
			$contractor->subscription_date = $subscription_date;
            $contractor->expired = false;
			$this->Contractors->save($contractor);

			$payment->subscription_date = $subscription_date;
			
			$paymentStartDate =  date('Y/m/d');	
			$paymentEndDate = date('Y/m/d', strtotime($contractor['subscription_date']));		
			$payment->payment_start = $paymentStartDate;
			$payment->payment_end = $paymentEndDate;
			$payment->reactivation_fee = $calculatePayment['reactivation_fee'];
			$payment->canqualify_discount = $calculatePayment['canqualify_discount'];
			
			$payment = $this->Payments->save($payment);

			// move tempSites to sites
			// $this->moveTempSites();

			// move tempSites to sites
			$this->moveTempClients();

			// Set default Customer Representative for contractor
			/*if(isset($new_contractor)) {
            $contractor_clients =  $this->User->getClients($contractor_id);
            if(!empty($contractor_clients)) {
                $firstClient  = $this->Clients->get($contractor_clients[0]);
                if($firstClient->contractor_custrep_id!=null) {
                     $contractor->customer_representative_id = $firstClient->contractor_custrep_id;
                     $this->Contractors->save($contractor);
                }
           } 
           }*/

			// save ContractorServices and paymentDetails
			$this->savePaymentDetails($calculatePayment, $result->id);
			
			// set default icon
			$this->setDefaultIcon();

			$this->Flash->success(__('The payment has been saved.'));
			if($this->User->isContractor()) {
				return $this->redirect(['controller'=>'Payments', 'action' => 'invoice', $payment->id]);				
			}
			else {
				return $this->redirect(['controller'=>'Contractors', 'action' => 'dashboard', $contractor_id]);
			}
		}
        else {
    		$this->Flash->error(__('The payment could not be completed..! Please contact your Customer Representative.'), ['params' => ['errors' => $errorMessages]]);
			//return $this->redirect(['controller'=>'Payments', 'action' => 'checkout']);
			if($this->User->isContractor()) {
			    return $this->redirect(['controller'=>'Contractors', 'action' => 'dashboard']);
			}
			else {
				return $this->redirect(['controller'=>'Contractors', 'action' => 'dashboard', $contractor_id]);
			}
		}
		} // if Payment save

		$this->Flash->error(__('The payment could not be completed..! Please contact your Customer Representative.'), ['params' => ['errors' => $errorMessages]]);
		if($this->User->isContractor()) {
		    return $this->redirect(['controller'=>'Contractors', 'action' => 'dashboard']);
		}
		else {
			return $this->redirect(['controller'=>'Contractors', 'action' => 'dashboard', $contractor_id]);
		}
	}

	$states = $this->States->find('list', ['keyField' => 'id', 'valueField' => 'name'])->where(['user_entered'=>false])->toArray();
	$countries = $this->Countries->find('list', ['keyField' => 'id', 'valueField' => 'name'])->where(['user_entered'=>false])->toArray();
	//$card_details =  $this->BillingDetails->find('list', ['keyField' => 'id', 'valueField' => 'card_details'])->where(['contractor_id'=>$contractor_id])->toArray();

	$this->set(compact('payment', 'states', 'countries', 'calculatePayment', 'totalprice', 'contractor_id', 'renew_subscription','contractor','contClients'));
    // 'card_details'
	$this->set('secret_link', null !==$this->request->getData('secret_link') ? $this->request->getData('secret_link') : '' );
    }

    public function slotPurchase(){
    	$this->loadModel('ContractorServices');
		$this->loadModel('PaymentDetails');
		$this->loadModel('States');
		$this->loadModel('Countries');
		$this->loadModel('TempEmployeeSlots');
		$this->loadModel('PaymentDiscounts');

		$contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');
    	$contractor = $this->Payments->Contractors->get($contractor_id, ['contain'=>['Users']]);

        $slot = $this->TempEmployeeSlots->find()->where(['contractor_id'=>$contractor_id])->first();
        $productprice = $slot->price;
        $totalprice = $slot->price;
        $canqualify_discounts = $this->PaymentDiscounts->find('all')->where(['contractor_id'=>$contractor_id])->first();
        if(!empty($canqualify_discounts)){
    		$canq_discount =$canqualify_discounts->discount_price;
			$valid_date =  	$canqualify_discounts->valid_date;
			$todayDate = strtotime(date('m/d/Y'));
			$validDate = strtotime(date('m/d/Y', strtotime($valid_date))); 
			if(!empty($canq_discount)&& $validDate >=$todayDate){
	            $slot['canqualify_discount'] = $canq_discount;    
	            $totalprice = $totalprice - $slot['canqualify_discount'];
	        } }      

       	$payment_type = Configure::read('payment_type.contractor.employee_slot');
		$paymentStartDate =  date('Y/m/d');	
		$paymentEndDate = date('Y/m/d', strtotime($contractor['subscription_date']));		
		$payment = $this->Payments->newEntity();
		if ($this->request->is('post')) {
	      	// save BillingDetails
		    // $this->saveBillingDetails($this->request->getData());
			// Paypal Request
			$nvp_response_array = $this->SendPaypalRequest($this->request->getData(), $contractor, $totalprice, $payment_type);
		    if(isset($nvp_response_array['EMAIL']) && $nvp_response_array['EMAIL'] == 'arundhati.lambore@canqualify.com') {
			    $totalprice = 1;
		    }
      
			// Parse the API response and save payments
			$payment = $this->Payments->patchEntity($payment, $this->request->getData());
			$payment->canqualify_discount = isset($slot['canqualify_discount'])?$slot['canqualify_discount'] : '';
			$payment->totalprice = $totalprice;
			$payment->contractor_id = $contractor_id;
			$payment->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
			$payment->payment_type = $payment_type;
			$payment->email = isset($nvp_response_array['EMAIL']) ? $nvp_response_array['EMAIL'] : '';
			$payment->payment_start = $paymentStartDate;
			$payment->payment_end = $paymentEndDate;
			if(!empty($nvp_response_array)) {
				$payment->response = json_encode($nvp_response_array);

				$payment->p_amt = isset($nvp_response_array['AMT']) ? $nvp_response_array['AMT'] : null;
				$payment->transaction_status = isset($nvp_response_array['ACK']) ? $nvp_response_array['ACK'] : '';
				$payment->p_transactionid = isset($nvp_response_array['TRANSACTIONID']) ? $nvp_response_array['TRANSACTIONID'] : '';

				$payment->p_avscode = isset($nvp_response_array['AVSCODE']) ? $nvp_response_array['AVSCODE'] : '';
				$payment->p_cvv2match = isset($nvp_response_array['CVV2MATCH']) ? $nvp_response_array['CVV2MATCH'] : '';
				$payment->p_timestamp = isset($nvp_response_array['TIMESTAMP']) ? $nvp_response_array['TIMESTAMP'] : '';
				$payment->p_correlationid = isset($nvp_response_array['CORRELATIONID']) ? $nvp_response_array['CORRELATIONID'] : '';

	            // On error
				//if ($nvp_response_array['ACK'] == 'Failure' || $nvp_response_array['ACK'] == 'FailureWithWarning') {
				$payment->p_errorcode0 = isset($nvp_response_array['L_ERRORCODE0']) ? $nvp_response_array['L_ERRORCODE0'] : '';
				$payment->p_shortmessage0 = isset($nvp_response_array['L_SHORTMESSAGE0']) ? $nvp_response_array['L_SHORTMESSAGE0'] : '';
				$payment->p_longmessage0 = isset($nvp_response_array['L_LONGMESSAGE0']) ? $nvp_response_array['L_LONGMESSAGE0'] : '';
				$payment->p_serveritycode0 = isset($nvp_response_array['L_SEVERITYCODE0']) ? $nvp_response_array['L_SEVERITYCODE0'] : '';
	            //}

			} else {
				$payment->transaction_status = 'Failure';
			}
			
			$errorMessages = $payment->p_longmessage0;
			//pr($payment);die;
			if ($result = $this->Payments->save($payment)) {
				if ($result['transaction_status'] == 'Success' || $result['transaction_status'] == 'SuccessWithWarning') {
				/* save to ContractorService and BilllingDetails */ 
				$contractorService = $this->ContractorServices->find('all')->where(['contractor_id'=>$contractor_id,'service_id'=>4])->first();
				if(!empty($contractorService)) {  // update
					$contractorService->modified_by = $this->getRequest()->getSession()->read('Auth.User.id');
					$contractorService->slot = $slot->slot +$contractorService->slot;
					$this->ContractorServices->save($contractorService);
					
				   // save PaymentDetails
					$paymentDetail = $this->PaymentDetails->newEntity();
					$paymentDetail->client_ids =  $contractorService->client_ids;
					$paymentDetail->service_id = 4;
					// $paymentDetail->product_price = $totalprice;
					// $paymentDetail->price = $totalprice;
					
					// After Add Canqualify discount Functionality 
					$paymentDetail->product_price = $productprice;
					$paymentDetail->price = $productprice;
					$paymentDetail->payment_id = $result->id;
					$paymentDetail->created_by= $this->getRequest()->getSession()->read('Auth.User.id');
					$this->PaymentDetails->save($paymentDetail);
				
					// move tempEmployeeSlots to sites
					$this->delTempEmployeeSlots($contractor_id);

					$this->Flash->success(__('The payment has been saved.'));
					if($result) {
						return $this->redirect(['controller'=>'Payments', 'action' => 'invoice', $payment->id]);
					}
					else {
						return $this->redirect(['controller'=>'Contractors', 'action' => 'dashboard', $contractor_id]);
					}
				}
				}
                else {
					$this->Flash->error(__('The payment could not be completed..! Please contact your Customer Representative.'), ['params' => ['errors' => $errorMessages]]);
					//return $this->redirect(['controller'=>'Payments', 'action' => 'checkout']);
			        if($this->User->isContractor()) {
				        return $this->redirect(['controller'=>'Contractors', 'action' => 'dashboard']);
			        }
			        else {
				        return $this->redirect(['controller'=>'Contractors', 'action' => 'dashboard', $contractor_id]);
			        }
				}
			}

			$this->Flash->error(__('The payment could not be completed..! Please contact your Customer Representative.'), ['params' => ['errors' => $errorMessages]]);
			//return $this->redirect(['controller'=>'Payments', 'action' => 'checkout']);
			if($this->User->isContractor()) {
			      return $this->redirect(['controller'=>'Contractors', 'action' => 'dashboard']);
			}
			else {
				return $this->redirect(['controller'=>'Contractors', 'action' => 'dashboard', $contractor_id]);
			}
		}

    	$states = $this->States->find('list', ['keyField' => 'id', 'valueField' => 'name'])->where(['user_entered'=>false])->toArray();
		$countries = $this->Countries->find('list', ['keyField' => 'id', 'valueField' => 'name'])->where(['user_entered'=>false])->toArray();
		
	    $this->set(compact('payment','states', 'countries', 'calculatePayment','slot', 'totalprice', 'contractor_id'));
		$this->set('secret_link', null !==$this->request->getData('secret_link') ? $this->request->getData('secret_link') : '' );	 
    }

   function delTempEmployeeSlots($contractor_id) {
	    $this->loadModel('TempEmployeeSlots');
	    // Delete TempEmployeeSlots
	    $this->TempEmployeeSlots->query()
		    ->delete()				
		    ->where(['contractor_id'=>$contractor_id])
		    ->execute();
    }

    function moveTempClients() {
    
	$this->loadModel('ContractorTempclients');
	$this->loadModel('ContractorClients');
	$this->loadModel('ClientRequests');
	$this->loadModel('CronClientAdd');
	$this->loadModel('ContractorSites');
	$this->loadModel('Sites');
	$clientRequests = [];
	$contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');
	
	$allcontractorClients = $this->ContractorTempclients->find()->select(['contractor_id', 'client_id'])->where(['contractor_id'=>$contractor_id])->enableHydration(false)->toArray();
	foreach($allcontractorClients as $client){
		$clientRequests[$client['client_id']] = $client['client_id'];
		//$contractorClientExist = $this->ContractorClients->find()->where(['contractor_id'=>$contractor_id])->first();		
		$contractorClientExist = $this->ContractorClients->find()->where(['contractor_id'=>$contractor_id, 'client_id'=>$client['client_id']])->first();
		if(empty($contractorClientExist)) {
			$saveDt = $this->ContractorClients->newEntity();
			//$cronClient = $this->CronClientAdd->newEntity();
			$saveDt = $this->ContractorClients->patchEntity($saveDt, $client);
			//$cronClient = $this->CronClientAdd->patchEntity($cronClient, $client);
			$saveDt->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
			//$cronClient->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
			$this->ContractorClients->save($saveDt);
			//$this->CronClientAdd->save($cronClient);

            /*Add location to contractor if client has only one location associated with it*/
            $clientSites = $this->Sites->find('all')->where(['client_id '=>$client['client_id']])->toArray();
            if(isset($clientSites) && count($clientSites) == 1){
               /*check if contractor id - client id combination is already exists*/
                $theOlnySite = isset($clientSites[0]['id']) ? $clientSites[0]['id'] : 0;

                if($theOlnySite != 0){
                    $contractorSiteExists = 0;
                    $contractorSiteExists = $this->ContractorSites->find('all')->where(['contractor_id'=>$contractor_id,'site_id'=> $theOlnySite])->count();
                    if($contractorSiteExists > 0){}
                    else{
                        /*save site*/
                        $ContractorSites = $this->ContractorSites->newEntity();
                        $ContractorSites->site_id = $theOlnySite;
                        $ContractorSites->contractor_id = $contractor_id;
                        $ContractorSites->client_id = $client['client_id'];
                        $ContractorSites->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
                        $this->ContractorSites->save($ContractorSites);
                    }
                }



            }

		}
	}
 
	// Delete Contractor Temp sites
	$this->ContractorTempclients->query()
			->delete()				
			->where(['contractor_id'=>$contractor_id])
			->execute();

	//update clientRequest status
	if(!empty($clientRequests)) {
		$this->ClientRequests->query()
			->update()
			->set(['status'=>2])
			->where(['status'=>1, 'contractor_id'=>$contractor_id, 'client_id IN'=>$clientRequests])
			->execute();
	}
    }

    function savePaymentDetails($calculatePayment=array(), $payment_id=0) {
	$this->loadModel('ContractorServices');
	$this->loadModel('PaymentDetails');

	$contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');

	foreach($calculatePayment['services'] as $service_id => $service) { 
		$contractorService = $this->ContractorServices->find('all')->where(['contractor_id'=>$contractor_id, 'service_id'=>$service_id])->first();
		if(!empty($contractorService)) { // Update
            // Merge new clients with old
			$client_ids = array_unique(array_merge($contractorService->client_ids['c_ids'], $service['client_ids']));

			$contractorService = $this->ContractorServices->patchEntity($contractorService, $service);
			$contractorService->client_ids = ['c_ids' => array_values($client_ids)];
			$contractorService->modified_by = $this->getRequest()->getSession()->read('Auth.User.id');

			$this->ContractorServices->save($contractorService);
		} else { // New
			$contractorService = $this->ContractorServices->newEntity();
			$contractorService = $this->ContractorServices->patchEntity($contractorService, $service);
			$contractorService->client_ids =['c_ids' => array_values($service['client_ids'])];
			$contractorService->contractor_id = $contractor_id;
			$contractorService->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
			$this->ContractorServices->save($contractorService);
			$this->Notification->updateNotification($contractor_id,2,CONTRACTOR);
		}

		// save PaymentDetails
		$paymentDetail = $this->PaymentDetails->newEntity();
		$paymentDetail = $this->PaymentDetails->patchEntity($paymentDetail, $service);
		$paymentDetail->client_ids = ['c_ids' => array_values($service['client_ids'])];	
		if(isset($service['price'])) { 
		$paymentDetail->product_price = $service['price'];
		$paymentDetail->discount = $service['discount'];
		$paymentDetail->price = $service['final_price'];
		}
		$paymentDetail->payment_id = $payment_id;
		$paymentDetail->created_by = $this->getRequest()->getSession()->read('Auth.User.id');

		$this->PaymentDetails->save($paymentDetail);
	}
    }

    function setDefaultIcon() {
	$this->loadModel('OverallIcons');

	$contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');
	$client_ids = $this->User->getClients($contractor_id);

	foreach($client_ids as $client_id) {
		$overallicons = $this->OverallIcons->find('all')->where(['contractor_id'=>$contractor_id, 'client_id'=>$client_id])->count();
		if($overallicons == 0){
			$overallIcon = $this->OverallIcons->newEntity();
			$overallIcon->client_id = $client_id;
			$overallIcon->contractor_id = $contractor_id;
			$overallIcon->bench_type = 'OVERALL';
			$overallIcon->icon = 0;
			$overallIcon->created_by = $this->getRequest()->getSession()->read('Auth.User.id');

			$this->OverallIcons->save($overallIcon);
		}
	}
    }

   /* function moveTempSites() {    	
	$this->loadModel('ContractorTempsites');
	$this->loadModel('ContractorSites');
	$this->loadModel('ClientRequests');

	$clients = [];
	$contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');

	$allcontractorSites = $this->ContractorTempsites->find()->select(['contractor_id','site_id','client_id'])->where(['contractor_id'=>$contractor_id])->toArray();	
	foreach($allcontractorSites as $site){
		$clients[$site->client_id] = $site->client_id;
		$contractorSiteExist = $this->ContractorSites->find()->where(['contractor_id'=>$contractor_id,'is_archived'=>false, 'site_id'=>$site->site_id])->first();
		if(empty($contractorSiteExist)) {
			$site = json_decode(json_encode($site), true);						
			$saveDt = $this->ContractorSites->newEntity();					
			$saveDt = $this->ContractorSites->patchEntity($saveDt, $site);
			$saveDt->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
			$this->ContractorSites->save($saveDt);			
		}		
	}
 
	// Delete Contractor Temp sites
	$this->ContractorTempsites->query()
				->delete()				
				->where(['contractor_id'=>$contractor_id])
				->execute();

	// update clientRequest status
	if(!empty($clients)) {
		$this->ClientRequests->query()
			->update()
			->set(['status'=>2])
			->where(['status'=>1, 'contractor_id'=>$contractor_id, 'client_id IN'=>$clients])
			->execute();
	}
    } */

    /*public function saveBillingDetails($requestData=array()) {
	$this->loadModel('BillingDetails');

	$contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');

	if(isset($requestData['savecard']) && 1 == $requestData['savecard'] ) {
		$arr_billing_address = [ 'addess1' => $requestData['address1'], 'address2' => $requestData['address2'], 'city' => $requestData['city'], 'zipcode' => $requestData['zip'] ];
		$arrmixLocation = $this->States->find()->select( ['id', 'country_id', 'name'])->where(['name'=>$requestData['state']] )->toArray();

		$arr_card_details = [ 'card_type' => $requestData['cctype'], 'name_on_card'=> $requestData['ccname'], 'card_number' => $requestData['ccnumber'] , 'card_expiration_month' => $requestData['ccexpirationmonth']['month'], 'card_expiration_year' => $requestData['ccexpirationyear']['year']];

		$billing_details = $this->BillingDetails->newEntity();
		$billing_details->first_name      = $requestData['firstname'];
		$billing_details->last_name       = $requestData['lastname'];
		$billing_details->email           = $requestData['email'];
		$billing_details->billing_address = $arr_billing_address;
		$billing_details->card_details    = $arr_card_details;
		$billing_details->state_id        = $arrmixLocation[0]->id;
		$billing_details->country_id      = $arrmixLocation[0]->country_id; 
		$billing_details->created_by      = $this->getRequest()->getSession()->read('Auth.User.id');
		$billing_details->contractor_id   = $contractor_id;

		$this->BillingDetails->save($billing_details);
	}
    }*/

    public function SendPaypalRequest($requestData=array(), $contractor=array(), $totalprice=0, $pType=0) {
	$paypal = false;
	// Store request params in an array		
	if(isset($_SERVER['ENVIRONMENT']) && $_SERVER['ENVIRONMENT'] == 'production') {	
		$paypal = true;
	}
	else {
		$paypal = Configure::read('paypalDirectSandbox.sandbox');			
	}

    $payment_types = Configure::read('payment_type.contractor');
    $payment_type_nm = array_search($pType,$payment_types);

	$request_params = array();
	// Set PayPal API version and credentials.
	$api_version = '85.0';
	$api_endpoint = Configure::read('paypalDirectSandbox.api_endpoint');
	$api_username = Configure::read('paypalDirectSandbox.api_username');
	$api_password = Configure::read('paypalDirectSandbox.api_password');
	$api_signature = Configure::read('paypalDirectSandbox.api_signature');
		
	if(isset($requestData['card_details']) && $requestData['card_details']!=null) {
		$billingId = $requestData['card_details'];

		$billingDetails = $this->BillingDetails->get($billingId);
		$billing_address = $billingDetails->billing_address;
		$card_details = $billingDetails->card_details;

		$request_params = array (
			'CREDITCARDTYPE' => $card_details['card_type'],
			'ACCT' => str_replace(' ','',$card_details['card_number']),
			'EXPDATE' => $card_details['card_expiration_month'].$card_details['card_expiration_year'],
			'CVV2' => $this->request->getData('cccvv'),
			'FIRSTNAME' => $billingDetails->first_name,
			'LASTNAME' => $billingDetails->last_name,
			'STREET' => $billing_address['addess1']." ".$billing_address['address2'],
			'CITY' => $billing_address['city'],
			'STATE' => $billingDetails->state_id,
			'COUNTRYCODE' => $billingDetails->country_id,
			'CURRENCYCODE' => 'USD',
			'ZIP' => $billing_address['zipcode'],
			'EMAIL' => $billingDetails->email,
		);	
		if($billing_address['address2']!==null) {
			$request_params['STREET2'] = $billing_address['address2'];
		}
	}
	elseif(isset($requestData['cctype']) && isset($requestData['state_id'])){
		$state= $this->States
        ->find('list', ['keyField'=>'name', 'valueField'=>'name'])
        ->where(['id'=>$requestData['state_id']])
        ->first();
		$request_params = array (
			'CREDITCARDTYPE' => $requestData['cctype'],
			'ACCT' => str_replace(' ','',$requestData['ccnumber']),
			'EXPDATE' => $requestData['ccexpirationmonth']['month'].$requestData['ccexpirationyear']['year'],
			'CVV2' => $requestData['cccvv'],
			'FIRSTNAME' => $requestData['firstname'],
			'LASTNAME' => $requestData['lastname'],
			'STREET' => $requestData['address1'],
			'CITY' => $requestData['city'],
			'STATE' => $state,
			'COUNTRYCODE' => $requestData['country_id'],
			'CURRENCYCODE' => 'USD',
			'ZIP' => $requestData['zip'],
            'EMAIL' => $requestData['email'],
		);
		if($requestData['address2']!==null) {
			$request_params['STREET2'] = $requestData['address2'];
		}
	}

    // set for $1 transaction
    if(isset($request_params['EMAIL']) && $request_params['EMAIL'] == 'arundhati.lambore@canqualify.com') {
	    $totalprice = 1;
    }

	$request_params['USER'] = $api_username;
	$request_params['PWD'] = $api_password;
	$request_params['SIGNATURE'] = $api_signature;
	$request_params['VERSION']= $api_version;
	$request_params['METHOD'] = 'DoDirectPayment';
	$request_params['PAYMENTACTION'] = 'Sale';
	$request_params['IPADDRESS'] =  $_SERVER['REMOTE_ADDR'];
	$request_params['SOFTDESCRIPTOR'] = 'CanQualify Subscription';
	$request_params['SOFTDESCRIPTORCITY'] ='support@canqualify.com';
	//$request_params['DESC'] = 'CanQualify Subscription - Payment Type : '.$payment_type_nm.', USER ID : '.$contractor->user->id.', Company Name : '.$contractor->company_name.', Email : '.$contractor->user->username;
    $request_params['DESC'] = 'CanQualify Subscription';
	$request_params['AMT'] = $totalprice;
	$request_params['CUSTOM'] = '';
	$request_params['INVNUM'] = '';

    // set for dummy transaction
	if(isset($_SERVER['ENVIRONMENT']) && $_SERVER['ENVIRONMENT'] == 'production') {	
    if(isset($request_params['EMAIL']) && $request_params['EMAIL'] == 'aaron.harker@mstindia.co') {
        $paypal = false;
    }
    if($totalprice == 0){
    	$paypal = false;
    }
    }

	$nvp_string = '';
	foreach($request_params as $var=>$val) {
	   $nvp_string .= '&'.$var.'='.urlencode($val);
	}

	$nvp_response_array = array();
	if($paypal == true)
	{
		$api_endpoint = Configure::read('paypalDirectSandbox.api_endpoint');
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_VERBOSE, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
		curl_setopt($curl, CURLOPT_URL, $api_endpoint);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $nvp_string);

		$result = curl_exec($curl);
		curl_close($curl);
		$nvp_response_array = $this->NVPToArray($result);
	}
	else{
		// dummy transaction
		$nvp_response_array = $this->dummyDetails($request_params);
	}

	return $nvp_response_array;
    }

    function NVPToArray($NVPString)
    {
    	$proArray = array();
	    while(strlen($NVPString))
	    {
	       // name
	       $keypos= strpos($NVPString,'=');
	       $keyval = substr($NVPString,0,$keypos);
	       // value
	       $valuepos = strpos($NVPString,'&') ? strpos($NVPString,'&'): strlen($NVPString);
	       $valval = substr($NVPString,$keypos+1,$valuepos-$keypos-1);
	       // decoding the respose
	       $proArray[$keyval] = urldecode($valval);
	       $NVPString = substr($NVPString,$valuepos+1,strlen($NVPString));
	    }
	    return $proArray;
    }

    public function dummyDetails($response_array=array())
    {
	    $now = Time::now();

	    $nvp_response_array= array();
	    $nvp_response_array['TIMESTAMP'] = $now;
	    $nvp_response_array['ACK'] = 'Success';
        $nvp_response_array['EMAIL'] = isset($response_array['EMAIL']) ? $response_array['EMAIL'] : '';

	    /*$nvp_response_array['CORRELATIONID'] = '';
	    $nvp_response_array['VERSION'] = 85;
	    $nvp_response_array['BUILD'] = 46457558;
	    $nvp_response_array['AVSCODE'] = 'Y';
	    $nvp_response_array['CVV2MATCH'] = 'M';
	    $nvp_response_array['TRANSACTIONID'] = '6YU49355DG1111111';*/

	    return $nvp_response_array;
    }

    // Function to convert NTP string to an array    
    public function paymentHistory()
    {
	    $this->loadModel('Clients');
	    $this->loadModel('Contractors');

        $contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');
		$contractor = $this->Contractors->find()->where(['id'=>$contractor_id])->first();
		 
        $allClients = $this->Clients->find('list', ['keyField'=>'id', 'valueField'=>'company_name' ])->toArray();

		$renew_subscription = false;
    	$services = $this->User->getContractorServices($contractor_id, true);
		
		if($this->User->isSubscriptionRenewed($contractor) == false) {
			$renew_subscription = true;
			//$calculatePayment = $services;
			$calculatePayment = $this->User->calculatePayment($contractor_id, $services,true);
        }
		else {
			$calculatePayment = $this->User->calculatePayment($contractor_id, $services); 
		}

        $payments = $this->Payments
		->find('all')
		->contain(['PaymentDetails'])
		->where(['contractor_id'=>$contractor_id])
		->order(['id'])
		->toArray();

        $this->set(compact('payments', 'calculatePayment', 'allClients','contractor', 'renew_subscription'));
    }
   
    function receipt($payment_id) {
	    $this->viewBuilder()->setLayout('ajax');

	    $contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');

	    $payment = $this->Payments
               ->find('all')
               ->where(['id'=>$payment_id, 'contractor_id'=>$contractor_id])
               ->contain(['PaymentDetails'=>['fields'=>['id', 'payment_id','service_id', 'price', 'client_ids','product_price','discount']] ])
               ->contain(['PaymentDetails.Services'=>['fields'=>['id','name']] ])
               ->first();
        $this->set(compact('payment'));
    }

    public function invoice($payment_id=null,$sendEmail=false) {
	    $this->loadModel('PaymentDetails');
	    $this->loadModel('Contractors');
	    $contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');

	    $contractor = $contractor = $this->Contractors->get($contractor_id, [
            'contain'=>['States', 'Countries', 'Users']
        ]);

	    $invoice = $this->Payments
            ->find('all')
            ->where(['id'=>$payment_id, 'contractor_id'=>$contractor_id])
            ->contain(['PaymentDetails'=>['fields'=>['id', 'payment_id','service_id', 'price', 'client_ids','product_price','discount']] ])
            ->contain(['PaymentDetails.Services'=>['fields'=>['id','name']] ])
            ->first();
	//pr($invoice);
	    if($sendEmail==true)
	    {
		    $data = array();
		    $img = WWW_ROOT.'img/logo.png';
		    $data[0][] = 'Paid Invoice for '.$contractor->company_name;
		    $data[1][] = 'Service Name';
		    $data[1][] = 'Qty';
		    $data[1][] = 'Unit Price';
		    $data[1][] = 'Discount';
		    $data[1][] = 'Total Price';
		    $i = 2;
		   foreach ($invoice->payment_details as $pdatails){
			    $data[$i][] = $pdatails->service->name;
			    $data[$i][] = count($pdatails->client_ids['c_ids']);
			    $data[$i][] = h("$ ".$pdatails->price);
			    $data[$i][] = h("$ ".$pdatails->discount);
			    $data[$i][] = h("$ ".$pdatails->final_price);
			    $i++;
		    }
		    $data[$i][] = 'Total';
		    $data[$i][] = '';
		    $data[$i][] = h("$ ".$invoice->totalprice);

		   // $this->Export->XportToPDF($data, $img, $contractor_id, IMPORT_INVOICE);
		    $this->getMailer('User')->send('send_paidInvoice', [$contractor, $invoice]);

		    $this->Flash->success(__('The invoice has been sent to the contractor.'));

            return $this->redirect(['controller'=>'Payments', 'action' => 'invoice', $payment_id]);

           $builder = $this->viewBuilder();            // configure as needed
           $builder->setLayout('print');
           $builder->setTemplate('/Payments/invoice');   //Here you can use elements also
           $builder->setHelpers(['Html']);           
           $sendEmail = true;
           // create a view instance
           $view = $builder->build(compact('payment_id', 'sendEmail', 'contractor_id', 'invoice','contractor'));   
           $output = $view->render();  
           
           $this->Export->htmlToPDF($output, IMPORT_INVOICE);
           exit;
	    }
	    $this->set(compact('invoice', 'contractor_id', 'payment_id', 'contractor'));
    }

    /*public function pdfInvoice($payment_id=null) {
            // create a builder
            $builder = $this->viewBuilder();

            // configure as needed
            $builder->setLayout('print');
            $builder->setTemplate('/Payments/invoice');   //Here you can use elements also
            $builder->setHelpers(['Html']);

            $sendEmail = true;
            // create a view instance
            $view = $builder->build(compact('payment_id', 'sendEmail', 'contractor_id', 'invoice','contractor'));   //Pass the variables to the view

            // render to a variable
            $output = $view->render();

		    $this->Export->htmlToPDF($output, IMPORT_INVOICE);
            exit;
    }*/

    /* Update existing payment records for BAE - DOCUQUAL and SAFETYQUAL */
    public function managePayments()
    {
	    $this->loadModel('PaymentDetails');	
	    $this->loadModel('ContractorServices');
	    
	    $userId = $this->getRequest()->getSession()->read('Auth.User.id');

	    $this->Payments->query()->update()
	    ->set(['transaction_status'=> 'Failure'])
	    ->where(['response LIKE' => '%Failure%'])
	    ->execute();

	    $this->Payments->query()->update()
	    ->set(['transaction_status'=> 'Success'])
	    ->where(['response LIKE' => '%Success%'])
	    ->execute();

	    $allpayments = $this->Payments->find('all')->where(['totalprice'=>99, 'transaction_status'=>'Success'])->toArray();	
	    
	    foreach($allpayments as $payment) {
		    $services = [1=>99,6=>0];
		    $client_ids = ['c_ids' => [3]];
		    foreach($services as $service_id=>$service_price) {				
			    $cntInvoice = $this->PaymentDetails->newEntity();
			    $cntInvoice->payment_id = $payment->id;
			    $cntInvoice->service_id = $service_id;
			    $cntInvoice->client_ids = $client_ids;
			    $cntInvoice->price = $service_price;
			    $cntInvoice->created_by = $payment->created_by;
			    
			    if($save = $this->PaymentDetails->save($cntInvoice)) {			
				    $this->Flash->success(__('The payment details has been saved.'));				
			    }
			    
			    $contractorService = $this->ContractorServices->find('all')->where(['contractor_id'=>$payment->contractor_id, 'service_id'=>$service_id])->first();
			    if(empty($contractorService)) {
			    $contractorService = $this->ContractorServices->newEntity();
			    $contractorService->contractor_id = $payment->contractor_id;
			    $contractorService->service_id = $service_id;
			    $contractorService->client_ids = $client_ids;
			    $contractorService->created_by = $payment->created_by;
			    if($save = $this->ContractorServices->save($contractorService)) {
				    $this->Flash->success(__('The payment details has been saved.'));			
			    }
			    }
		    }
	    }
    }

    /* Update existing billing records - json format issue */
    public function updateBillingDetails()
    {
        $this->loadModel('BillingDetails');

	    $billingDetails = $this->BillingDetails->find('all')->toArray();
	    foreach($billingDetails as $dt) {
            $arr_billing_address = json_decode($dt->billing_address, true);
            $arr_card_details = json_decode($dt->card_details, true);
            unset($arr_card_details['cvv']);

		    $dt->billing_address = $arr_billing_address;
		    $dt->card_details    = $arr_card_details;          

		    $this->BillingDetails->save($dt);
        }

    }
    /* Update existing product_price ( null to total price) */
    public function updateProductPrice()
    {
        $this->loadModel('PaymentDetails');
	    $paymentDetails = $this->PaymentDetails->find()->select(['id','payment_id','price','product_price','discount'])->toArray();
	    foreach($paymentDetails as $dt) {
           if(empty($dt['product_price'])){
           	$dt['product_price'] = $dt['price'];           	
           }
          /*if(empty($dt['discount'])){
           	 $dt['discount'] = 0;
           } */
             $this->PaymentDetails->save($dt);             
        }
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
	$totalCount = $this->Payments->find('all')->count();		
        $this->paginate = [
        'contain' => ['Contractors'],
	    'limit'  => $totalCount,
        'maxLimit'=> $totalCount
        ];
        $payments = $this->paginate($this->Payments);
        $payment_types = Configure::read('payment_type.contractor');
        $this->set(compact('payments','payment_types'));
    }

    /**
     * View method
     *
     * @param string|null $id Payment id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
		$this->viewBuilder()->setLayout('ajax');
		
        $payment = $this->Payments->get($id, [
            'contain' => ['Contractors']
        ]);
        $this->set('payment', $payment);
    }
}
