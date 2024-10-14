<?php
namespace App\Controller\Component;
use Cake\Controller\Component;
use Cake\Controller\Controller;
use Cake\Datasource\ConnectionManager;
use Cake\Core\Configure;
require_once(ROOT."/vendor/aws/aws-autoloader.php"); 
use Aws\S3\S3Client;
use Aws\S3\MultipartUploader;

/**
 * File Uploading Component
 *
 * @author        Zankat Kalpesh
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
class Fileuploads3Component extends Component {
    public function fileuploadcredential()
    {
	$s3 = S3Client::factory(array( 'version' => 'latest',
		'region'  => 'us-east-1',  
		'credentials' => array(
		'key' => $_SERVER['S3_ACCESS_KEY'],
		'secret'  => $_SERVER['S3_ACCESS_SECRET']
	) ));	
	return $s3;
    }

    public function uploadFile($s3=null, $file=null, $filenmHandle=null)
    {
	$bucket = Configure::read('bucket_path');

	//$filename = $file['name'];
	$path_parts = pathinfo($file["name"]);
	$filename = $path_parts['filename'].'-'.time().'.'.$path_parts['extension'];

	if($filenmHandle != null) {
		$filename = $filenmHandle.'.'.$path_parts['extension'];

		if($s3->doesObjectExist($bucket, $filename)) {
			$filename = $filenmHandle.'-'.time().'.'.$path_parts['extension'];
		}
	}

	try {
		$upload = $s3->putObject([
			'Bucket'       => $bucket,
			'Key'          => $filename,
			'SourceFile'   => $file['tmp_name'],
			'ContentType'  => $file['type'],
			'ACL'          => 'public-read',
			'StorageClass' => 'REDUCED_REDUNDANCY',
			'MetadataDirective' => 'REPLACE'
		]);						
		if($upload['@metadata']['statusCode']==200){
			$data['name'] = $filename;
			return $data;
		}
	} catch (S3Exception $e) {
		echo $e->getMessage();
	}
	return false;
    }

    public function uploadVideoFile($s3=null, $file=null)
    {
	$bucket = Configure::read('bucket_path');
	$filename = $file['name'];

	// Prepare the upload parameters.
	$uploader = new MultipartUploader($s3, $file['tmp_name'], [
	    'bucket' => $bucket,
	    'key'    => $file["name"],
	    'ACL'    => 'public-read'
	]);

	// Perform the upload.
	try {
		$upload = $uploader->upload();
		if($upload['@metadata']['statusCode']==200){
			$data['name'] = $filename;
			return $data;
		}
	} catch (MultipartUploadException $e) {
	    echo $e->getMessage() . PHP_EOL;
	}

	return false;
    }


     public function removeFile($s3=null, $file=null)
    {
    	
		$sourcebucket = Configure::read('bucket_path');
		$targetbucket = Configure::read('bucket_path_backup');
		
		try {
		
			$s3->copyObject([
			    'Bucket'       => $targetbucket,
			    'Key'          => $file,
			    'CopySource'   => $sourcebucket.'/'.$file
			]);
			$s3->deleteObject([
			    'Bucket' => $sourcebucket,
			    'Key'    => $file
			]);


		} catch (S3Exception $e) {
			return $e->getMessage();
		}
		return false;
	}
	public function listobject($s3=null){

	    $bucket = Configure::read('bucket_path');
		// $bucket = Configure::read('bucket_path_backup');
		try {
		    $objects = $s3->listObjects([
		        'Bucket' => $bucket		        
		       
		    ]);
		    	 
		    $data = array();
		
			    foreach ($objects['Contents']  as $object) {
			    	array_push($data, $object['Key']);
			    }
			 
		    return $data;
		} catch (S3Exception $e) {
		    echo $e->getMessage() . PHP_EOL;
		}
	}
	 public function deleteFile($s3=null, $file=null)
    {
    	$bucket = Configure::read('bucket_path');
		// $bucket = Configure::read('bucket_path_backup');
		try {
				$s3->deleteObject([
			    'Bucket' => $sourcebucket,
			    'Key'    => $file
			]);

			} catch (S3Exception $e) {
		    echo $e->getMessage() . PHP_EOL;
		}
    }
    public function uploadskillDoc($s3=null, $file=null, $filenmHandle=null)
    {
	$bucket = Configure::read('bucket_path');

	//$filename = $file['name'];
	$path_parts = pathinfo($file["name"]);
	$filename = $path_parts['filename'].'-'.time().'.'.$path_parts['extension'];

	if($filenmHandle != null) {
		$filename = $filenmHandle.'.'.$path_parts['extension'];

		if($s3->doesObjectExist($bucket, $filename)) {
			$filename = $filenmHandle.'-'.time().'.'.$path_parts['extension'];
		}
	}

	try {
		$upload = $s3->putObject([
			'Bucket'       => $bucket,
			'Key'          => "skill_assessments/".$filename,
			'SourceFile'   => $file['tmp_name'],
			'ContentType'  => $file['type'],
			'ACL'          => 'public-read',
			'StorageClass' => 'REDUCED_REDUNDANCY',
			'MetadataDirective' => 'REPLACE'
		]);						
		if($upload['@metadata']['statusCode']==200){
			$data['name'] = $filename;
			return $data;
		}
	} catch (S3Exception $e) {
		echo $e->getMessage();
	}
	return false;
    }

}
