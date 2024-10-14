<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;

/**
 * IndustryAverages Controller
 *
 * @property \App\Model\Table\IndustryAveragesTable $IndustryAverages
 *
 * @method \App\Model\Entity\IndustryAverage[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class IndustryAveragesController extends AppController
{
    public function isAuthorized($user)
    {
	$clientNav = false;
	if($user['role_id'] == SUPER_ADMIN  || $user['role_id'] == ADMIN || $user['role_id'] == CLIENT || $user['role_id'] == CLIENT_ADMIN || $user['role_id'] == CLIENT_VIEW) {
		$clientNav = true;
	}
	$this->set('clientNav', $clientNav);

	if (isset($user['role_id']) && $user['active'] == 1) {
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
        ini_set('memory_limit','-1');   
        $this->loadModel('NaiscCodes');       

        $industryAverage = $this->NaiscCodes
        ->find('all')        
        ->contain(['IndustryAverages'=>[
            'fields'=>['id','year','naisc_code_id'],
            'queryBuilder' => function ($q) { return $q->order(['year'=>'ASC']); }  ]])    
        ->toArray();        
        $this->set(compact('industryAverage'));
        
    }

    /**
     * View method
     *
     * @param string|null $id Industry Average id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $industryAverage = $this->IndustryAverages->get($id, [
            'contain' => ['NaiscCodes']
        ]);

        $this->set('industryAverage', $industryAverage);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->viewBuilder()->setLayout('ajax');
  
        $industryAverage = $this->IndustryAverages->newEntity();
        if ($this->request->is('post')) {
			$created_by = $this->getRequest()->getSession()->read('Auth.User.id');
            $industryAverage = $this->IndustryAverages->patchEntity($industryAverage, $this->request->getData());
			$industryAverage->created_by = $this->getRequest()->getSession()->read('Auth.User.id');
            if ($this->IndustryAverages->save($industryAverage)) {
                $this->Flash->success(__('The industry average has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The industry average could not be saved. Please, try again.'));
        }
        $naiscCodes = $this->IndustryAverages->NaiscCodes->find('list', ['limit' => 200]);
        $this->set(compact('industryAverage', 'naiscCodes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Industry Average id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->viewBuilder()->setLayout('ajax');
        
        $industryAverage = $this->IndustryAverages->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $industryAverage = $this->IndustryAverages->patchEntity($industryAverage, $this->request->getData());
			$industryAverage->modified_by = $this->getRequest()->getSession()->read('Auth.User.id');
            if ($this->IndustryAverages->save($industryAverage)) {
                $this->Flash->success(__('The industry average has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The industry average could not be saved. Please, try again.'));
        }
        $naiscCodes = $this->IndustryAverages->NaiscCodes->find('list', ['limit' => 200]);
        $this->set(compact('industryAverage', 'naiscCodes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Industry Average id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $industryAverage = $this->IndustryAverages->get($id);
        if ($this->IndustryAverages->delete($industryAverage)) {
            $this->Flash->success(__('The industry average has been deleted.'));
        } else {
            $this->Flash->error(__('The industry average could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
	public function importData()
    {

	$this->loadModel('NaiscCodes');
    $matchNotFound = array();
    $recordsAdded = 0;
    $recordsUpdated = 0;
    $worksheetData = array();
    $comment = '';

      if ($this->request->is('post')) {

          /*read post data*/
          $year = trim($this->request->getData('year'));
          $document = $this->request->getData('file');

          /*Validate post data*/
          $err = 0;
          $errMsg = '';
          $allowedFiles =  array('xlsx', 'csv', 'xls'); // etc...
          $filename = $document['name'];
          $ext = pathinfo($filename, PATHINFO_EXTENSION);

          if(empty($year)){$err = 1;$errMsg = 'Year could not be empty. Please enter Year.';}
          if(empty($document) || $document['error'] != 0 || $document['size'] <= 0){$err = 1;$errMsg = 'Upload failed or empty file. Please try again.';}
          elseif (!in_array($ext, $allowedFiles)){$err = 1;$errMsg = 'Only Excel and CSV document are allowed to import. Please upload file of valid type..';}

          if($err == 1){
              $this->Flash->error($errMsg);
          }
          else {
              /*save file*/
              $fuConfig['upload_path'] = IMPORT_IA;
              $fuConfig['allowed_types'] = '*';
              $fuConfig['max_size'] = 0;
              $this->Fileupload->init($fuConfig);
              if (!$this->Fileupload->upload($document)) {
                  $fError = $this->Fileupload->errors();
              } else {
                  /*Read data to be uploaded*/
                  $fileName = $this->Fileupload->output('file_name');
                  $worksheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(IMPORT_IA . $fileName);
                  $worksheetData = $worksheet->getSheet(0)->toArray();

                  /*Array to store Records that are not eligible to upload*/
                  $headers = array_shift($worksheetData);
                  array_push($headers,'Comment');
                  array_push($matchNotFound, $headers);

                  foreach ($worksheetData as $key=>$value) {
                      $allInputsValid = 0;
                      if(is_numeric($value[2]) && is_numeric($value[3]) &&is_numeric($value[4]) &&is_numeric($value[5]) &&is_numeric($value[6]))
                      {
                          $allInputsValid = 1;
                      }
                      $NaiscCodesRecord = $this->NaiscCodes->find('all')->select(['id', 'naisc_code'])->where(['naisc_code' => $value[1]])
                          ->first();
                      if (!empty($NaiscCodesRecord) && $allInputsValid == 1) {
                          $industryAvgRecord = $this->IndustryAverages->find('all')
                              ->select(['id', 'naisc_code_id', 'year'])
                              ->where(['naisc_code_id' => $NaiscCodesRecord->id, 'year' => $year])
                              ->first();
                          if(!empty($industryAvgRecord)){
                              $industryAverage = $this->IndustryAverages->get($industryAvgRecord->id);
                              $recordsUpdated++;
                              }
                          else{
                              $industryAverage = $this->IndustryAverages->newEntity();
                              $recordsAdded++;
                          }


                          $industryAverage->naisc_code_id = $NaiscCodesRecord->id;
                          $industryAverage->total_recordable_cases = trim($value[2]);
                          $industryAverage->total = trim($value[3]);
                          $industryAverage->cases_with_days_away_from_work = trim($value[4]);
                          $industryAverage->cases_with_job_transfer_or_restriction = trim($value[5]);
                          $industryAverage->other_recordable_cases = trim($value[6]);
                          $industryAverage->year = $year;

                          $this->IndustryAverages->save($industryAverage);
                      } else {
                          if($allInputsValid != 1){$comment = 'Incomplete Data';}
                              $possibleNaiscCodes = $this->NaiscCodes->find('all')->select(['id', 'naisc_code'])
                                  ->where(['title ILIKE' => '%'.trim($value[0]).'%'])
                                  ->first();
                              if(empty($possibleNaiscCodes)){
                                  $comment = 'No NAICS Code Found';
                              }
                              else{
                                  $comment = $possibleNaiscCodes->naisc_code;
                              }

                          array_push($value, $comment);
                          array_push($matchNotFound, $value);
                      }
                  }

                  $this->Flash->success(__('The industry average  has been saved.'));


              }
          }
      }
        if(!empty($matchNotFound) && count($matchNotFound) > 1)
       /* {
            $fileName = 'returned.xlsx';
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();


            for ($i = 0, $l = sizeof($matchNotFound); $i < $l; $i++) { // row $i
                $j = 0;
                foreach ($matchNotFound[$i] as $k => $v) { // column $j
                    $sheet->setCellValueByColumnAndRow($j + 1, ($i + 1 + 1), $v);
                    $j++;
                }
            }

            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="'. urlencode($fileName).'"');
            $writer->save('php://output');
        }*/


        $this->set(compact('matchNotFound','recordsAdded','recordsUpdated'));
	}
}


