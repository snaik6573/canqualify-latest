<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Upload $upload
 */
use Cake\Core\Configure;
$uploaded_path = Configure::read('uploaded_path');
?>

<?php if(!empty($fileUpload)) {
if(isset($profile_photo)) {
	echo '<div class="profile_photo uploadUrl" data-file="'.$fileUpload['name'].'"><img src="'.$uploaded_path.$fileUpload['name'].'" /></div>';
	
	echo $this->Html->link('Change', [], ['escape'=>false, 'title' => 'Change', 'class'=>'ajaxfileChange btn btn-sm btn-success']);
	echo $this->Html->link('Remove', ['controller'=>'Uploads', 'action' => 'deleteFile', $fileUpload['name']], ['escape'=>false, 'title' => 'Remove', 'class'=>'ajaxfileDelete btn btn-sm btn-danger']);
} 
else {
	echo '<a href="'.$uploaded_path.$fileUpload['name'].'" class="uploadUrl" data-file="'.$fileUpload['name'].'" target="_Blank">'.$fileUpload['name'].'</a>';
	echo $this->Html->link('<i class="fa fa-times-circle"></i>', ['controller'=>'Uploads', 'action' => 'deleteFile', $fileUpload['name']],['escape'=>false, 'title' => 'Remove', 'class'=>'ajaxfileDelete btn btn-sm']);
}
} 
?>
