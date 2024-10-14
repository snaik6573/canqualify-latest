<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Uploads Controller
 *
 * @property \App\Model\Table\UploadsTable $Uploads
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UploadsController extends AppController
{
    public function isAuthorized($user)
    {
		return true;
    }

    public function uploadFile()
    {
    ini_set('memory_limit','-1');
	$this->viewBuilder()->setLayout('ajax_content');
	$s3 = $this->Fileuploads3->fileuploadcredential();

	$fileData = $this->request->getData('files');

	$skillDoc = $this->request->getData('skillAssessments');
// pr($this->request->getData()); die();
	if($fileData['type']=='video/mp4' || $fileData['type']=='video/3gp' || $fileData['type']=='video/ogg' || $fileData['type']=='video/webm') {
		$fileUpload = $this->Fileuploads3->uploadVideoFile($s3, $fileData);
	}
	else {
		$filenmHandle = '';
		if($this->request->getData('filenmHandle') != null) {
			$filenmHandle = $this->request->getData('filenmHandle');
		}
		if($skillDoc){
			$fileUpload = $this->Fileuploads3->uploadskillDoc($s3, $fileData, $filenmHandle);
		}else{
		$fileUpload = $this->Fileuploads3->uploadFile($s3, $fileData, $filenmHandle);
		}
	}
	
	if($this->request->getData('profile_photo') != null) { 
		 $this->set('profile_photo', true);
	}
        $this->set(compact('fileUpload'));
    }

    public function deleteFile($filename=null) {
    	//$s3 = $this->Fileuploads3->fileuploadcredential();
		//$fileUpload = $this->Fileuploads3->removeFile($s3, $filename);
		echo "File Removed Successfully!";
    }

    public function index($s3=null,$filename=null){
    	$s3 = $this->Fileuploads3->fileuploadcredential();
    	$listObj = $this->Fileuploads3->listobject($s3, $filename);
    	$this->set('listObj', $listObj);       
    }
}
