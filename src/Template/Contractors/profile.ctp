<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
use Cake\Core\Configure;
$uploaded_path = Configure::read('uploaded_path');
$users = array(CONTRACTOR,CONTRACTOR_ADMIN);
?>
<div class="row contractors">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<div class="form-group row m-0">
		<div class="col-sm-8 pull-left"><strong>Company Information</strong> </div>		
		<?php if(in_array($activeUser['role_id'], $users)) { ?>
		<div class="col-sm-3 pull-right pr-0">
		 <?= $this->Form->label('Make My Profile searchable by Clients', null, ['class'=>'col-form-label font-weight-bold','style'=>'padding-right:0px;']); ?></div>
		 <?= $this->Form->create($contractor) ?>
		 <div class="col-sm-1  pull-right" style="padding-left: 0px;"><?= $this->Form->control('profile_search',['default'=>1,'type'=>'checkbox','label'=>false,'id'=>"toggle-one" ,'data-onstyle'=>"success", 'data-offstyle'=>"danger", 'onchange'=>"this.form.submit();"]); ?></div>
		 <?= $this->Form->end() ?>
		<?php } ?>
		</div>		
	</div>
	<div class="card-body card-block">
	<div class="form-group row">
	<div class="col-sm-3">
	<?php $company_logo = $contractor->company_logo != null ? $uploaded_path. $contractor->company_logo : 'user-icon.jpeg'; ?>
	<div>	
			<?= $this->Html->image($company_logo, ['alt'=>'Company Logo','class'=>'user-avatar'])?>
	</div>
	</div>

	
	<div class="col-sm-9">
	<table class="table">	
		<tr>
			<th scope="row"><?= __('Company Name') ?></th>
			<td><?= h($contractor->company_name) ?></td>
		</tr>		
		<!-- <tr>
			<th scope="row"><?= __('Address') ?></th>
			<td><?= h($contractor->addressline_1) ?>, <?= h($contractor->addressline_2) ?>, <?= h($contractor->city)?>, <?= h($contractor->state->name)?>, <?= h($contractor->country->name)?>, <?= h($contractor->zip)?>.</td>
		</tr> -->		
		<tr>
			<th scope="row"><?= __('Company TIN') ?></th>
			<td><?php
                $tempTin = preg_replace("/[^0-9.]/", '', $contractor->company_tin);
                $formatedTin =  substr($tempTin,0,2)."-";
                $formatedTin .= substr($tempTin,2);
                echo $formatedTin;
                //echo h($contractor->company_tin);
                ?></td>
		</tr>	
		<tr>
			<th scope="row"><?= __('Primary Contact') ?></th>
			<td><?= h($contractor->pri_contact_fn).' '.h($contractor->pri_contact_ln) ?></td>
		</tr>	
		<tr>
			<th scope="row"><?= __('Email') ?></th>
			<td style="word-wrap: anywhere;"><?= h($contractor->user->username) ?></td>
		</tr>			
	</table>
</div>
</div>
</div>
</div>
<!--<div class="card">
	<div class="card-header">
		<strong>Contact Information </strong> 
	</div>
	<div class="card-body card-block">
	<div class="form-group row">
	<div class="col-sm-5">
	<table class="table">
		<tr>
			<th scope="row"><?= __('Primary Contact') ?></th>
			<td><?= h($contractor->pri_contact_fn).' '.h($contractor->pri_contact_ln) ?></td>
		</tr>	
		<tr>
			<th scope="row"><?= __('Email') ?></th>
			<td style="word-wrap: anywhere;"><?= h($contractor->user->username) ?></td>
		</tr>	
		<tr>
			<th scope="row"><?= __('Phone No') ?></th>
			<td><?= h($contractor->pri_contact_pn) ?></td>
		</tr>	 			
	</table>
</div>
</div>
</div>
</div>-->
<div class="card">
	<div class="card-header">
		<strong>Contractor Services </strong> 
	</div>
	<div class="card-body card-block">
	<div class="form-group row">
	<div class="col-sm-12">
	<table class="table">
		<?php  foreach($questions as $key => $question) { 
		$contractor_answers = $question->contractor_answers;
		
		?>		
		<tr>
			<?php if($question->id == 2){ ?>
			<th scope="row" class="col-sm-4"><?= __('Primary NAICS Code ') ?></th>
			<?php }elseif ($question->id == 41) { ?>
				<th scope="row" class="col-sm-4"><?= __('Additional NAICS Code ') ?></th>
			<?php }elseif ($question->id == 214) { ?>
				<th scope="row" class="col-sm-4"><?= __('Description of Company Services') ?></th>			
			<?php }elseif ($question->id == 469) { ?>
				<th scope="row" class="col-sm-4"><?= __('Company Website') ?></th>
			<?php } 
			if(!empty($contractor_answers)){ ?>
			<td><?php 			
			foreach($contractor_answers as $answer) {			
				if ($question->id == 469) {
					echo '<a href="'.$answer->answer.'" target="_Blank">'.$answer->answer.'</a>';
				}else{
					echo $answer->answer;
				}
				} ?></td>
		</tr>	
		<?php } } ?>					
	</table>
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