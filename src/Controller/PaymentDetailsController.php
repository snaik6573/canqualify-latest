<?php
namespace App\Controller;
use Cake\I18n\Time;
use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\Mailer\MailerAwareTrait; 

/**
 * PaymentDetails Controller
 *
 * @property \App\Model\Table\PaymentDetailsTable $PaymentDetails
 *
 * @method \App\Model\Entity\PaymentDetail[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PaymentDetailsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
     public function isAuthorized($user)
    {
	$contractorNav = false;
	if($user['role_id'] == CR) {
		$contractorNav = true;
	}
	$this->set('contractorNav', $contractorNav);
	
	if (isset($user['role_id']) && $user['active']==1) {
		return true;
	}
	// Default deny
	return false;
    }
    public function index()
    {
        $this->paginate = [
            'contain' => ['Payments', 'Services']
        ];
        $paymentDetails = $this->paginate($this->PaymentDetails);

        $this->set(compact('paymentDetails'));
    }

    /**
     * View method
     *
     * @param string|null $id Payment Detail id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $paymentDetail = $this->PaymentDetails->get($id, [
            'contain' => ['Payments', 'Services']
        ]);

        $this->set('paymentDetail', $paymentDetail);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $paymentDetail = $this->PaymentDetails->newEntity();
        if ($this->request->is('post')) {
            $paymentDetail = $this->PaymentDetails->patchEntity($paymentDetail, $this->request->getData());
            if ($this->PaymentDetails->save($paymentDetail)) {
                $this->Flash->success(__('The payment detail has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The payment detail could not be saved. Please, try again.'));
        }
        $payments = $this->PaymentDetails->Payments->find('list', ['limit' => 200]);
        $services = $this->PaymentDetails->Services->find('list', ['limit' => 200]);
        $this->set(compact('paymentDetail', 'payments', 'services'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Payment Detail id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $paymentDetail = $this->PaymentDetails->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $paymentDetail = $this->PaymentDetails->patchEntity($paymentDetail, $this->request->getData());
            if ($this->PaymentDetails->save($paymentDetail)) {
                $this->Flash->success(__('The payment detail has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The payment detail could not be saved. Please, try again.'));
        }
        $payments = $this->PaymentDetails->Payments->find('list', ['limit' => 200]);
        $services = $this->PaymentDetails->Services->find('list', ['limit' => 200]);
        $this->set(compact('paymentDetail', 'payments', 'services'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Payment Detail id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $paymentDetail = $this->PaymentDetails->get($id);
        if ($this->PaymentDetails->delete($paymentDetail)) {
            $this->Flash->success(__('The payment detail has been deleted.'));
        } else {
            $this->Flash->error(__('The payment detail could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
     public function pdetails($payment_id=null)
    {
        $this->loadModel('Clients');
	    $contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');
        $paymentDetails = $this->PaymentDetails
        ->find('all')
        ->contain(['Services'=>['fields'=>['id','name']] ])
        ->where(['payment_id'=>$payment_id])
        ->toArray();

        $clients = $this->Clients->find('list', ['keyField'=>'id', 'valueField'=>'company_name'])->toArray();
        //pr($paymentDetails);

        $this->set(compact('paymentDetails', 'clients'));
    
    }
}
