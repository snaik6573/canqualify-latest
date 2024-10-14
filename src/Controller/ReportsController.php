<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;
use Cake\Core\Configure;

/**
 * Reports Controller
 *
 *
 * @method \App\Model\Entity\Report[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ReportsController extends AppController
{

    public function isAuthorized($user)
    {
        $clientNav = false;

        if($user['role_id'] == SUPER_ADMIN || $user['role_id'] == ADMIN) {
            $clientNav = true;
        }
        $this->set('clientNav', $clientNav);

        if (isset($user['role_id']) && $user['active'] == 1) {
            if($user['role_id'] == SUPER_ADMIN || $user['role_id'] == ADMIN || $user['role_id'] == CLIENT || $user['role_id'] == CLIENT_ADMIN || $user['role_id'] == CLIENT_VIEW || $user['role_id'] == CLIENT_BASIC || $user['role_id'] == CR) {
                return true;
            }
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
        $reports = $this->paginate($this->Reports);

        $this->set(compact('reports'));
    }

    public function safetyRates($client_id = null, $export_type = null){

        $this->loadModel('Contractors');
        $this->loadModel('SafetyRates');
        $this->loadModel('NaiscView');

        $conn = ConnectionManager::get('default');

        if ($client_id == null) {
            $client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');
        }
            $myContractors = $this->User->getContractors($client_id);
            $yearRange = $this->Category->yearRange();


             $qry = "SELECT contractors.id AS contractor_id, contractors.company_name, naisc_views.naisc_code, naisc_views.title, safety_rates.answer, safety_rates.type, safety_rates.year FROM contractors LEFT JOIN naisc_views ON contractors.id = naisc_views.contractor_id LEFT JOIN safety_rates ON contractors.id = safety_rates.contractor_id WHERE contractors.id in (" . implode(',', $myContractors) .") AND safety_rates.year in(". implode(',', $yearRange) .") ORDER BY (safety_rates.contractor_id, safety_rates.year)";

            $safetyRates = $conn->execute($qry)->fetchAll('assoc');
            $safetyRatesFormated = array();
            $contractor_id = 0;
            $year = 0;
            $index = 0;
            $temp = 0;
            if(!empty($safetyRates))
                foreach ($safetyRates as $row){
                    if($temp == 0){

                        $safetyRatesFormated[$index]['contractor_id'] = $row['contractor_id'];
                        $safetyRatesFormated[$index]['company_name'] = $row['company_name'];
                        $safetyRatesFormated[$index]['naics_code'] = $row['naisc_code'];//.'-'.$row['title'];
                        $safetyRatesFormated[$index]['TRIR'] = '';
                        $safetyRatesFormated[$index]['LWCR'] = '';
                        $safetyRatesFormated[$index]['DART'] = '';
                        $safetyRatesFormated[$index]['EMR'] = '';
                        $safetyRatesFormated[$index]['fatalities'] = '';
                        $safetyRatesFormated[$index]['citation'] = '';
                        $safetyRatesFormated[$index]['SR'] = '';
                        $safetyRatesFormated[$index]['year'] = $row['year'];
                        $safetyRatesFormated[$index][$row['type']] = $row['answer'];
                        $contractor_id = $row['contractor_id'];
                        $year = $row['year'];
                        $temp++;

                    }
                    else{
                        if($contractor_id == $row['contractor_id'] && $year == $row['year']) {
                            $safetyRatesFormated[$index][$row['type']] = $row['answer'];
                        }
                        else{
                            $index++;
                            $safetyRatesFormated[$index]['contractor_id'] = $row['contractor_id'];
                            $safetyRatesFormated[$index]['company_name'] = $row['company_name'];
                            $safetyRatesFormated[$index]['naics_code'] = $row['naisc_code'];//.'-'.$row['title'];
                            $safetyRatesFormated[$index]['TRIR'] = '';
                            $safetyRatesFormated[$index]['LWCR'] = '';
                            $safetyRatesFormated[$index]['DART'] = '';
                            $safetyRatesFormated[$index]['EMR'] = '';
                            $safetyRatesFormated[$index]['fatalities'] = '';
                            $safetyRatesFormated[$index]['citation'] = '';
                            $safetyRatesFormated[$index]['SR'] = '';
                            $safetyRatesFormated[$index]['year'] = $row['year'];
                            $safetyRatesFormated[$index][$row['type']] = $row['answer'];
                            $contractor_id = $row['contractor_id'];
                            $year = $row['year'];


                        }

                    }

                }
               //debug($safetyRatesFormated);die;
        $headT = array('Supplier ID', 'Company Name', 'NAICS Code', 'TRIR', 'LWCR', 'DART', 'EMR', 'Fatalities', 'Citation', 'SR', 'Year');
        $extras['file_name'] = 'safety_rates';
        $extras['client_name'] = '';
        $extras['client_name'] = $this->getRequest()->getSession()->read('Auth.User.client_company_name');
        if($export_type == 'excel') {
            $this->Export->XportAsExcel($safetyRatesFormated,$headT, $extras);
            exit;
        }
        if($export_type == 'csv') {
            $this->Export->XportAsCSV($safetyRatesFormated,$headT, $extras);
            exit;
        }

            $this->set(compact('safetyRatesFormated', 'client_id'));
        }


    /*List Client Users not having locations associated with them*/
    public function noLocationClientUsers(){

        $this->loadModel('Clients');
        $this->loadModel('ClientUsers');
        $clientUsers = $this->ClientUsers->find()->contain(['Clients' => ['fields' => ['company_name']]])->where(['ClientUsers.site_ids->s_ids' => ''])->first();
        debug($clientUsers);Die;


    }
    public function noTin($showAll = 0){
        $this->loadModel('Contractors');
        $where = array();
        if($showAll){
            $where = array(1);
        }else{
            $where = ['OR' => [['company_tin' => ''],['company_tin IS NULL'],['LENGTH(company_tin) !=' => 9]]];
        }

        $noTinSuppliers = $this->Contractors->find()
                            ->select(['id', 'company_tin', 'company_name'])
                            ->where($where)
                            ->all()->toArray();
        //debug($noTinSuppliers);
        $this->set(compact('noTinSuppliers','showAll'));
    }

    public function correctTin(){
        $this->loadModel('Contractors');
        $tinSuppliers = $this->Contractors->find()
            ->where(['AND' => [['company_tin !=' => ''],['company_tin >' => 0],['company_tin IS NOT NULL']]])
            ->select(['id', 'company_tin'])
            ->all()->toArray();
        if(!empty($tinSuppliers)){
            foreach ($tinSuppliers as $supplier){
                //$s = $this->Contractors->get($supplier['id'], ['contain' => []]);
                //$s = $this->Contractors->patchEntity($s);
                echo 'id = ' .$supplier['id']. ' ' .$supplier['company_tin'] . ' = ';
                $processedTin = preg_replace('/\D/', '', $supplier['company_tin']);
                echo $processedTin . '<br />';
                //$s->company_tin = $processedTin;
                //$this->Contractors->save($s);
                $conn = ConnectionManager::get('default');

                $clientList = $conn->execute("update contractors set company_tin = '".$processedTin."' where id = ".$supplier['id']);
            }
        }
        //debug($tinSuppliers);
        die;

    }
    public function suppliersWithSubs($export_type=null, $client_id = null){
        ini_set('memory_limit','-1');

        if($client_id == null){
            $client_id = $this->getRequest()->getSession()->read('Auth.User.client_id');
        }

        $iconList = Configure::read('icons');

        $supplierList = array();

        if(!empty($client_id)){
            $client_contractors = $this->User->getContractors($client_id);
            if(!empty($client_contractors)){
                $strCon = '';
                $strCon = implode(',', $client_contractors);
                $conn = ConnectionManager::get('default');
                $query = "SELECT contractors.id AS contractor_id, contractors.company_name, contractors.pri_contact_fn, contractors.pri_contact_ln, contractors.pri_contact_pn,
                                                      answer_columns.using_subs, 
                                                      answer_columns.total_subs,
                                                      answer_columns.subs_file,
                                                      final_overall_icons.icon,
                                                      users.active, users.username 
                                                      FROM contractors 
                                                      LEFT JOIN final_overall_icons ON(contractors.id = final_overall_icons.contractor_id AND final_overall_icons.client_id = 3)
                                                      LEFT JOIN users ON(contractors.user_id = users.id) 
                                                      LEFT JOIN answer_columns on (contractors.id = answer_columns.contractor_id)
                                                      WHERE contractors.id IN(".$strCon.")";
                $supplierList = $conn->execute($query)->fetchAll('assoc');


            }
        }
            if(in_array($export_type, array('excel', 'csv'))) {
                $i =0;
                $data = array();
                if(!empty($supplierList)) {
                    foreach ($supplierList as  $contractor) {

                        $data[$i]['icon'] = (isset($contractor['icon'])) ? $iconList[$contractor['icon']] : '';
                        $data[$i]['active'] = (isset($contractor['active']) && $contractor['active'] == 1) ? 'Yes' : 'No';
                        $data[$i]['company_name'] = $contractor['company_name'];
                        $data[$i]['pri_contact'] = $contractor['pri_contact_fn']." ".$contractor['pri_contact_ln'];
                        $data[$i]['pri_contact_pn'] = $contractor['pri_contact_pn'];
                        $data[$i]['username'] = $contractor['username'];
                        $data[$i]['using_subs'] = $contractor['using_subs'];
                        $data[$i]['total_subs'] = $contractor['total_subs'];
                        $i++;
                    }
                }

                $extras['file_name'] = 'subcontractors';
                $extras['title'] = 'subcontractors';
                $extras['client_name'] = '';
                $extras['client_name'] = $this->getRequest()->getSession()->read('Auth.User.client_company_name');
                /*company logo*/
                if(!empty($client_id)){
                    $extras['client_logo'] = $client_id . '.jpg';
                }

                        $headT = array('Status','Active','Contractor Company Name','Primary Contact','Phone','Email', 'Using Subs?' , 'Total Subs');

                if($export_type == 'excel') {
                    $this->Export->XportAsExcel($data, $headT, $extras);
                    exit;
                }
                if($export_type == 'csv') {
                    $this->Export->XportAsCSV($data, $headT, $extras);
                    exit;
                }
            }
        $currentPage = 'Suppliers Subcontractors Report';
        $parentPage = 'Reports';
        $this->set(compact('supplierList', 'client_id', 'iconList', 'currentPage', 'parentPage'));
    }

    function finalSubmitPending($limit = null, $offset = null){
        ini_set('memory_limit','-1');
        ini_set('max_execution_time','-1');
        $conn = ConnectionManager::get('default');
        $limitStr = "";
        if($limit == null && $offset == null){

        }elseif($limit == null && $offset >= 0){
            $limitStr = "OFFSET ".$offset;
        }elseif($limit >0 && $offset == null){
            $limitStr = "LIMIT ".$limit;
        }elseif($limit >0 && $offset >= 0){
            $limitStr = "LIMIT ".$limit." OFFSET ".$offset;
        }
        //debug($limitStr);
        $query = "select * from 
        (select contractors.id, contractors.company_name, max(contractor_clients.waiting_on) as agg_waiting_on from contractors 
        left join contractor_clients on (contractor_clients.contractor_id = contractors.id)
        where contractor_clients.client_id != 4
        group by contractors.id) as show_final_submit where agg_waiting_on = 1 ".$limitStr;
        $supplierList = $conn->execute($query)->fetchAll('assoc');
        //print_r(($supplierList));

        $supplierListAll = array();
        $query = "select * from 
        (select contractors.id, contractors.company_name, max(contractor_clients.waiting_on) as agg_waiting_on from contractors 
        left join contractor_clients on (contractor_clients.contractor_id = contractors.id)
        where contractor_clients.client_id != 4
        group by contractors.id) as show_final_submit where agg_waiting_on = 1";
        $supplierListAll = $conn->execute($query)->fetchAll('assoc');
        //print_r(($supplierListAll));
        //die;
        $this->set(compact('supplierList', 'supplierListAll'));
    }

    public function subscriptionsEndReport(){
        $iconList = Configure::read('icons');
        $this->loadModel('Contractors');
        $this->loadModel('ContractorServices');
        $this->loadModel('ClientServices');
        $this->loadModel('Clients');



        if ($this->request->is(['patch', 'post', 'put'])) {
            $this->viewBuilder()->setLayout('ajax');

            $contractor = $this->Contractors->find()->where(['Contractors.id'=>$this->request->getData('contractor.id')])->first();
            $contractor = $this->Contractors->patchEntity($contractor, $this->request->getData('contractor'));
            // send email on active
            /*$cr_ids = $contractor->customer_representative_id['cr_ids'];
            if($contractor->registration_status == 1 && !$prevActive && $contractor->user->active) {
                    //if(isset($contractor->customer_representative) && !empty($contractor->customer_representative) ){
                    //  $cr_email =  $contractor->customer_representative->user->username;
                    //}
                    $cr_emails = $this->CustomerRepresentative->find('list', ['keyField'=>'id', 'valueField'=>'user.username' ])->where(['CustomerRepresentative.id IN'=>$cr_ids])->contain(['Users'])->toArray();
                    $this->getMailer('User')->send('register_approve', [$contractor->user, $contractor, $cr_emails]);
            }*/

            if ($this->Contractors->save($contractor)) {
                echo '<div class="alert with-close alert-success alert-dismissible fade show" role="alert">The contractor has been saved.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';
            }
            else {
                echo '<div class="alert with-close alert-danger alert-dismissible fade show" role="alert">The contractor could not be saved. Please, try again.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button></div>';
            }
            exit;
        }else{
            $todaydate = date('m/d/Y');

            $contList = array();

            $where = ['CAST(subscription_date AS DATE) <='=>$todaydate];

            $contList = $this->Contractors
                ->find('all')
                ->select(['id', 'company_name', 'pri_contact_fn', 'pri_contact_ln', 'pri_contact_pn', 'subscription_date', 'expired'])
                ->contain(['Users'=>['fields'=>['username' ,'active']]])
                ->where($where)
                ->order('expired DESC')
                ->toArray();
//debug($contList);die;
            if(isset($export_type) && $export_type!='0') {
                $i =0;
                $data = array();
                if(!empty($contList)) {
                    foreach ($contList as  $contractor) {

                        $data[$i]['registration_status'] = '';
                        if(!empty($contractor['overall_icons'])) {
                            $data[$i]['registration_status'] = $iconList[$contractor['overall_icons'][0]->icon];
                        }
                        $data[$i]['active'] = $contractor->user['active'] == 1 ? 'Yes' : 'No'; ;
                        $data[$i]['company_name'] = $contractor['company_name'];
                        $data[$i]['pri_contact_fn'] = $contractor['pri_contact_fn']." ".$contractor['pri_contact_ln'];
                        $data[$i]['pri_contact_pn'] = $contractor['pri_contact_pn'];
                        $data[$i]['username'] = $contractor->user['username'];
                        if($this->getRequest()->getSession()->read('Auth.User.role_id') == 1){
                            $data[$i]['payment_status'] = ($contractor['payment_status'] == 1) ? 'YES' : 'NO';
                        }
                        $data[$i]['subscription_end_date']= !empty($contractor->subscription_date) ? date('m/d/Y', strtotime($contractor->subscription_date))  : '';
                        $i++;
                    }
                }
                $client_company_name = "All Expired Suppliers";
                $headT = array('Status','Active','Contractor Company Name','Primary Contact','Phone','Email','Paid','Member Since','Subscription End Date',$client_company_name);
                if($export_type == 'excel') {
                    $this->Export->XportToExcel2($data,$headT);
                    exit;
                }
                if($export_type == 'csv') {
                    $this->Export->XportToCSV2($data,$headT);
                    exit;
                }
            }
        }

        $this->set(compact('contList'));
    }
}
