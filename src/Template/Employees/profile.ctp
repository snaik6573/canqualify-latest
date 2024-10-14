<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
use Cake\Core\Configure;
$uploaded_path = Configure::read('uploaded_path');
$users = array(EMPLOYEE);
?>
<div class="row contractors">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<!-- <strong>Contact Information</strong>  -->
		<div class="form-group row m-0">
		<div class="col-sm-8 pull-left"><strong>Contact Information</strong> </div>		
		<?php if(in_array($activeUser['role_id'], $users)) { ?>
		<div class="col-sm-3 pull-right pr-0">
		 <?= $this->Form->label('Make My Profile searchable by Suppliers', null, ['class'=>'col-form-label font-weight-bold','style'=>'padding-right:0px;']); ?></div>
		 <?= $this->Form->create($employee) ?>
		 <div class="col-sm-1  pull-right" style="padding-left: 0px;"><?= $this->Form->control('profile_search',['default'=>1,'type'=>'checkbox','label'=>false,'id'=>"toggle-one" ,'data-onstyle'=>"success", 'data-offstyle'=>"danger", 'onchange'=>"this.form.submit();"]); ?></div>
		 <?= $this->Form->end() ?>
		<?php } ?>
		</div>	
	</div>
	<div class="card-body card-block">
	<div class="form-group row">
	<div class="col-sm-3">
	<?php $profile_photo = $employee->user->profile_photo != null ? $uploaded_path. $employee->user->profile_photo : 'user-icon.jpeg'; ?>
	<div>	
			<?= $this->Html->image($profile_photo, ['alt'=>'User Profile','class'=>'user-avatar rounded-circle'])?>
	</div>
	</div>

	
	<div class="col-sm-9">
	<table class="table">		
		<?php if($employee['user_entered_email']== true) { ?>
		<tr>
			<th scope="row"><?= __('Email') ?></th>
			<td style="word-wrap: anywhere;"><?= h($employee->user->username) ?></td>
		</tr>
		<?php } ?>
		<?php if(!empty($employee->user->login_username)) { ?>
		<tr>
			<th scope="row"><?= __('Username') ?></th>
			<td style="word-wrap: anywhere;"><?= h($employee->user->login_username) ?></td>
		</tr>
		<?php } ?>
		<tr>
			<th scope="row"><?= __('Primary Contact') ?></th>
			<td><?= h($employee->pri_contact_fn).' '.h($employee->pri_contact_ln) ?></td>
		</tr>
		<!-- <tr>
			<th scope="row"><?= __('Phone No') ?></th>
			<td><?= h($employee->pri_contact_pn) ?></td>
		</tr> -->
		<!-- <tr>
			<th scope="row"><?= __('Address') ?></th>
			<td><?= h($employee->addressline_1) ?>, <?= h($employee->addressline_2) ?>, <?= h($employee->city)?>, <?= h($employee->state->name)?>, <?= h($employee->country->name)?>, <?= h($employee->zip)?>.</td>			
		</tr> -->				
		<tr>
			<th scope="row"><?= __('Position') ?></th>
			<td><?= h($employee->emp_position) ?></td>
		</tr>				
	</table>
</div>
</div>
</div>
</div>



<div class="card">
 <div class="card-header">
  <!-- Nav pills -->
  <ul class="nav nav-pills" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" data-toggle="pill" href="#about">About Me</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="pill" href="#resume">Resume</a>
    </li>    
  </ul></div>
<div class="card-body card-block">
  <!-- Tab panes -->
  <div class="tab-content">
    <div id="about" class="container tab-pane active"><br>
    <table class="table">
    <?php  foreach($questions as $key => $question) { 
    	if($question->employee_category_id == 19){
     ?>
     <tr>
    	<th scope="row" style="border-top:0px;"><?= htmlspecialchars_decode(h($question->question)) ?></b></th></tr><tr><td style="border-top:0px;border-bottom: 1px solid #dee2e6;">
    	<?php $question_type = $question->question_type->name;
		$employee_answers = $question->employee_answers; 
     	if($question_type == 'file') {
				foreach($employee_answers as $answer) {
					$answer->answer = explode(',',$answer->answer);
					foreach($answer->answer as $answer) {
						echo '<a href="'.$uploaded_path.$answer.'" target="_Blank">'.$answer.'</a>';
					}
				}
			}
			elseif($question_type == 'select' || $question_type == 'checkbox') {
				foreach($employee_answers as $answer) {
					$answer->answer = explode(',',$answer->answer);
					foreach($answer->answer as $answer) {
						echo $this->Text->autoParagraph(h($answer));
					}
				}
			}      
			elseif($question_type == 'checkbox_single') {
				foreach($employee_answers as $answer) {				
					echo $answer->answer ? __('Yes') : __('No');		
				}
			}  			  			
			else {
				foreach($employee_answers as $answer) {
					echo $answer->answer;
				}
			} } }?></td></tr></table>

        <?php
        if(!empty($employee->about)){
            echo $employee->about;
        }
        ?>
    </div>
    <div id="resume" class="container tab-pane fade"><br>
      <table class="table">
    <?php  foreach($questions as $key => $question) { 
    	if($question->employee_category_id == 20){
     ?>
     <tr>
    	<th scope="row" style="border-top:0px;"><?= htmlspecialchars_decode(h($question->question)) ?></b></th></tr><tr><td style="border-top:0px;border-bottom: 1px solid #dee2e6;">
    	<?php $question_type = $question->question_type->name;
		$employee_answers = $question->employee_answers; 
     	if($question_type == 'file') {
				foreach($employee_answers as $answer) {
					$answer->answer = explode(',',$answer->answer);
					foreach($answer->answer as $answer) {
						echo '<a href="'.$uploaded_path.$answer.'" target="_Blank">'.$answer.'</a>';
					}
				}
			}			 			  			
			else {
				foreach($employee_answers as $answer) {
					echo $answer->answer;
				}
			} } }?></td></tr></table>
        <?php
        if(!empty($employee->skills)){
            echo '<h4>Skills:</h4><div>'.$employee->skills.'</div>';
        }
        ?>
        <?php
        if(!empty($employee->work_experience)){
            echo '<h4>Work Experience:</h4><div>'.$employee->work_experience.'</div>';
        }
        ?>
    </div>  
  </div>
</div>
</div>
</div>
</div>

<script type="text/javascript">
	jQuery(function() {
   	 jQuery('#toggle-one').bootstrapToggle({
                    on: 'ON',
                    off: 'OFF'
  	}); })
</script>