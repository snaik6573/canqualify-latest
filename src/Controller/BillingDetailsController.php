<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Mailer\MailerAwareTrait;

/**
 * BillingDetails Controller
 *
 * @property \App\Model\Table\BillingDetailsTable $BillingDetails
 *
 * @method \App\Model\Entity\BillingDetail[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BillingDetailsController extends AppController
{

    use MailerAwareTrait;
   
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

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['States', 'Countries']
        ];
        $billingDetails = $this->paginate($this->BillingDetails);

        $this->set(compact('billingDetails'));
    }

    /**
     * View method
     *
     * @param string|null $id Billing Detail id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $billingDetail = $this->BillingDetails->get($id, [
            'contain' => ['States', 'Countries']
        ]);

        $this->set('billingDetail', $billingDetail);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $billingDetail = $this->BillingDetails->newEntity();
        if ($this->request->is('post')) {
            $billingDetail = $this->BillingDetails->patchEntity($billingDetail, $this->request->getData());
            if ($this->BillingDetails->save($billingDetail)) {
                $this->Flash->success(__('The billing detail has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The billing detail could not be saved. Please, try again.'));
        }
        $states = $this->BillingDetails->States->find('list', ['limit' => 200]);
        $countries = $this->BillingDetails->Countries->find('list', ['limit' => 200]);
        $this->set(compact('billingDetail', 'states', 'countries'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Billing Detail id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $billingDetail = $this->BillingDetails->get($id, [
            'contain' => []
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $billingDetail = $this->BillingDetails->patchEntity($billingDetail, $this->request->getData());
            $arr_card_details = [ 'card_type' => $this->request->getData('cctype'), 'name_on_card'=> $this->request->getData('ccname'), 'card_number' => $this->request->getData('ccnumber') , 'card_expiration_month' => $this->request->getData('ccexpirationmonth')['month'], 'card_expiration_year' => $this->request->getData('ccexpirationyear')['year']];
                $billingDetail->card_details    = $arr_card_details;

                $billingDetail->modified_by = $this->getRequest()->getSession()->read('Auth.User.id');

            if ($this->BillingDetails->save($billingDetail)) {
                $this->Flash->success(__('The billing detail has been saved.'));
                return $this->redirect(['action' => 'manageCards']);
            }
            $this->Flash->error(__('The billing detail could not be saved. Please, try again.'));
        }
        $states = $this->BillingDetails->States->find('list', ['limit' => 200]);
        $countries = $this->BillingDetails->Countries->find('list', ['limit' => 200]);
        $this->set(compact('billingDetail', 'states', 'countries'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Billing Detail id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $billingDetail = $this->BillingDetails->get($id);
        if ($this->BillingDetails->delete($billingDetail)) {
            $this->Flash->success(__('The card detail has been deleted.'));
        } else {
            $this->Flash->error(__('The card detail could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'renewSubscription']);
    }


    public function manageCards() {
	    $contractor_id = $this->getRequest()->getSession()->read('Auth.User.contractor_id');
	    $card_details =  $this->BillingDetails->find('list', ['keyField' => 'id', 'valueField' => 'card_details'])->where(['contractor_id'=>$contractor_id])->toArray();

	    $this->set(compact('card_details'));
    }
}
