<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;

/**
 * PaymentDiscounts Controller
 *
 * @property \App\Model\Table\PaymentDiscountsTable $PaymentDiscounts
 *
 * @method \App\Model\Entity\PaymentDiscount[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PaymentDiscountsController extends AppController
{
    public function isAuthorized($user)
    {
    // Admin can access every action
    if (isset($user['role_id']) && $user['active'] == 1) {
        if($user['role_id'] == SUPER_ADMIN || $user['role_id'] == ADMIN){       
            return true;
        }
    }
    // Default deny
    return false;
    }

    public function generateDiscount($contractor_id=null)
    {
        //$this->viewBuilder()->setLayout('ajax');
        
        $paymentDiscount = $this->PaymentDiscounts->newEntity();
         if ($this->request->is(['patch', 'post', 'put'])) {
            $id=$this->request->getData('id');
            if(!empty($id)){
            $paymentDiscount = $this->PaymentDiscounts->get($id, [
                'contain' => []  ]);
            }
            $paymentDiscount = $this->PaymentDiscounts->patchEntity($paymentDiscount, $this->request->getData());
            
            $paymentDiscount->contractor_id = $contractor_id;

            if ($this->PaymentDiscounts->save($paymentDiscount)) {
                $this->Flash->success(__('The payment discount has been saved.'));

                return $this->redirect(['controller'=>'Contractors','action' => 'index']);
            }
            $this->Flash->error(__('The payment discount could not be saved. Please, try again.'));
        }
        $contractors = $this->PaymentDiscounts->Contractors->find('list', ['limit' => 200]);
        $updateDiscount = $this->PaymentDiscounts->find('all')->where(['contractor_id'=>$contractor_id])->first();
      
        $this->set(compact('paymentDiscount', 'contractors','updateDiscount'));
    }


    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Contractors']
        ];
        $paymentDiscounts = $this->paginate($this->PaymentDiscounts);

        $this->set(compact('paymentDiscounts'));
    }

    /**
     * View method
     *
     * @param string|null $id Payment Discount id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $paymentDiscount = $this->PaymentDiscounts->get($id, [
            'contain' => ['Contractors']
        ]);

        $this->set('paymentDiscount', $paymentDiscount);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $paymentDiscount = $this->PaymentDiscounts->newEntity();
        if ($this->request->is('post')) {
            $paymentDiscount = $this->PaymentDiscounts->patchEntity($paymentDiscount, $this->request->getData());
            if ($this->PaymentDiscounts->save($paymentDiscount)) {
                $this->Flash->success(__('The payment discount has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The payment discount could not be saved. Please, try again.'));
        }
        $contractors = $this->PaymentDiscounts->Contractors->find('list', ['limit' => 200]);
        $this->set(compact('paymentDiscount', 'contractors'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Payment Discount id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $paymentDiscount = $this->PaymentDiscounts->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $paymentDiscount = $this->PaymentDiscounts->patchEntity($paymentDiscount, $this->request->getData());
            if ($this->PaymentDiscounts->save($paymentDiscount)) {
                $this->Flash->success(__('The payment discount has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The payment discount could not be saved. Please, try again.'));
        }
        $contractors = $this->PaymentDiscounts->Contractors->find('list', ['limit' => 200]);
        $this->set(compact('paymentDiscount', 'contractors'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Payment Discount id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $paymentDiscount = $this->PaymentDiscounts->get($id);
        if ($this->PaymentDiscounts->delete($paymentDiscount)) {
            $this->Flash->success(__('The payment discount has been deleted.'));
        } else {
            $this->Flash->error(__('The payment discount could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

}
