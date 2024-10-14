<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Client $client
 */
use Cake\Core\Configure;
$uploaded_path = Configure::read('uploaded_path');
?>
<div class="row clients">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong>Add New</strong> Client
	</div>

	<div class="card-body card-block">

	<div class="stepwizard">
	<div class="stepwizard-row setup-panel">
    <?php
    $stepCount = 3;
    if($client->registration_status < 4) {
        $stepCount = 4;
    }
    for($i=1; $i<=$stepCount; $i++) { ?>
   		<div class="stepwizard-step">
			<a href="#step-<?= $i ?>" data-step="<?= $i ?>" type="button" class="btn btn-primary btn-circle" <?= $stepCount!=1 ? 'disabled="disabled"' : '' ?>><?= $i ?></a>
			<p>Step <?= $i ?></p>
		</div>
    <?php } ?>
    </div>
	</div><!-- .stepwizard -->

    <?php $stepNo = 1; ?>
	<div class="row setup-content" id="step-<?= $stepNo ?>">
	<div class="col-md-6">
		<?=  $this->Form->create($client, ['url'=> ['action'=>'add', 1, $client->id], 'class'=>'clients_add']);?>
		<div class="form-group">
			<?= $this->Form->control('user.username', ['class'=>'form-control','label'=>'Email','required'=>false,'oninput'=>'this.value=this.value.toLowerCase()']); ?>
		</div>
		<?php
		if($client->has('id')) { 
		}
		else { ?>
		<div class="form-group">
			<?= $this->Form->control('user.password', ['class'=>'form-control','required'=>false, 'value'=> '']); ?>
		</div>
		<div class="form-group">
			<?= $this->Form->control('user.confirm_password', ['type'=>'password','class'=>'form-control','required'=>false]); ?>
		</div>
		<?php } ?>
       <!--<div class="form-group">
			<?php //echo $this->Form->control('customer_representative_id', ['options'=>$customer_rep,'value'=> $client['customer_representative_id'], 'empty'=>true, 'class'=>'form-control', 'multiple'=>true]); ?>
		</div>-->
       <div class="form-group">
			<?php echo $this->Form->control('client_service_rep', ['options'=>$users,'value'=> $client['client_service_rep'], 'empty'=>true, 'class'=>'form-control', 'label'=>'Client Service Representative']); ?>
		</div>	
       <!--<div class="form-group">
			<?php //echo $this->Form->control('contractor_custrep_id', ['options'=>$customer_rep,'value'=> $client['contractor_custrep_id'], 'empty'=>true, 'class'=>'form-control', 'label'=>'Contractor Customer Representative']); ?>
		</div>
		<div class="form-group">
			<?php //echo $this->Form->control('lead_custrep_id', ['options'=>$customer_rep,'value'=> $client['lead_custrep_id'], 'empty'=>true, 'class'=>'form-control', 'label'=>'Lead Customer Representative']); ?>
		</div>-->
        <div class="form-group">
			<?= $this->Form->control('user.under_configuration',[]); ?>
        </div>
		<div class="form-actions form-group">
			<?= $this->Form->control('registration_status', ['type'=>'hidden','value'=>'1']); ?>
			<?= $this->Form->control('user.active', ['type'=>'hidden','value'=>true]); ?>
			<?= $this->Form->control('user.role_id', ['type'=>'hidden','value'=>'3']); ?>
			<?= $this->Form->control('user.created_by', ['type'=>'hidden','value'=>$user_id]); ?>
			<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Save & continue', ['type'=>'submit', 'class'=>'btn btn-success nextBtn']); ?>
		</div>
		<?= $this->Form->end() ?>
	</div>
	</div><!-- .setup-content -->

    <?php $stepNo = 2; ?>
	<div class="row setup-content" id="step-<?= $stepNo ?>">  
	<div class="col-md-6">  
		<?= $this->Form->create($client, ['url'=> ['action'=>'add', 2, $client->id], 'class'=>'clients_add']) ?>
		<div class="form-group">
			<?= $this->Form->control('pri_contact_fn', ['class'=>'form-control','label'=>'First Name', 'required'=>false]); ?>
		</div>
		<div class="form-group">
			<?= $this->Form->control('pri_contact_ln', ['class'=>'form-control','label'=>'Last Name', 'required'=>false]); ?>
		</div>
		<div class="form-group">
			<?= $this->Form->control('pri_contact_pn', ['class'=>'form-control','label'=>'Phone No.', 'required'=>false, 'placeholder'=>'(123)-456-7890','id'=>'txtPhone']); ?>
		</div>
		<div class="form-group">
			<?= $this->Form->control('company_name', ['class'=>'form-control','required'=>false]); ?>
		</div>
		<div class="row form-group">
			<?php $fileCss = $client->company_logo!='' ? "display:none;" : ""; ?>
			<?= $this->Form->label('Company Logo', null, ['class'=>'col-sm-3']); ?><br />
			<div class="col-sm-9 uploadWraper">
				<?php echo $this->Form->control('company_logo', ['label'=>false, 'type'=>'hidden', 'class'=>'documentName']); ?>
				<?php echo $this->Form->file('uploadFile', ['label'=>false,'style'=>$fileCss]); ?>
			   <div class="uploadResponse">
			   <?php if($client->company_logo!='') { ?>
					<a href="<?= $uploaded_path.$client->company_logo ?>" class="uploadUrl" data-file="<?= $client->company_logo ?>" target="_Blank"><?= $client->company_logo ?></a>
					<?= $this->Html->link('<i class="fa fa-times-circle"></i>', ['controller'=>'Uploads', 'action' => 'deleteFile', $client->company_logo], ['escape'=>false, 'title' => 'Remove', 'class'=>'ajaxfileDelete btn btn-sm']);?>
			   <?php  }   ?>
			   </div>
			 </div>
		</div>
		<div class="form-group">
			<?= $this->Form->control('addressline_1', ['class'=>'form-control', 'required'=>false]); ?>
		</div>
		<div class="form-group">
			<?= $this->Form->control('addressline_2', ['class'=>'form-control']); ?>
		</div>
		<div class="form-group">
			<?= $this->Form->control('city', ['class'=>'form-control', 'required'=>false]); ?>
		</div>
		<?php if($client->registration_status > 1){ ?> <!-- edit code --> 
		<div class="form-group">
		<?php
		 echo $this->Form->control('country_id',['class'=>'form-control ajaxChange searchSelect', 'options' => $countries,'data-url'=>'/countries/getStates/false', 'data-responce'=>'.ajax-responce','required' => false]); ?>
		</div>
		<div class="form-group ajax-responce">
         <?php $state = [];
          if(empty($states)) {  
        	echo $this->Form->control('state_id', ['class'=>'form-control searchSelect', 'options' => $state, 'empty' => true,'label'=>'State','required' => false]); 
            }else{ 
            echo $this->Form->control('state_id', ['class'=>'form-control searchSelect', 'options' => $states,'empty' => true, 'label'=>'State','required' => false]); 
          } ?>
          <small id="countryHelp" class="form-text text-muted">States will be auto populated on country selection.</small>
		</div>	
	  <?php }else{ ?>  <!--- Add form code -->
		<div class="form-group">
		<?= $this->Form->label('Country'); ?>
		<div class="form-group">
		<?php  $otherOption = array('0' => "Other");
			$countries = $otherOption + $countries;
			   //$countries = array_merge($otherOption,$countries);		  
		    echo $this->Form->control('country_id',['class'=>'form-control ajaxChange otherCountrySelection searchSelect','id'=>'otherCountrySelection', 'options' =>$countries , 'empty' => 'Please select country', 'data-url'=>'/countries/getStates/true', 'data-responce'=>'.ajax-responce','label'=>false, 'required'=>false]); ?>
	    </div>
		</div>
		<div class="form-group userEnterCountry" style="display: none;">
		<?= $this->Form->control('country', ['type'=>'text', 'class'=>'form-control userEnterCountry','id'=>'userEnterCountry', 'placeholder'=>'Please enter your country','required'=>false]); ?> 
		</div>
		<div class="form-group userEnterCountry" style="display: none;">
		<?= $this->Form->control('state', ['type'=>'text', 'class'=>'form-control userEnterCountry','id'=>'userEnterCountry','placeholder'=>'Please enter your state','required'=>false]); ?>
		</div>
		<div class="form-group ajax-responce statelist">
		<?= $this->Form->label('State'); ?>
        <?php if(!empty($stateOptions)) { 
        	     echo $this->Form->control('state_id', ['class'=>'form-control searchSelect', 'options' => $stateOptions, 'label'=>false,'required' => false]);
             }else{ 
                 echo $this->Form->control('state_id', ['class'=>'form-control searchSelect', 'options' => [], 'label'=>false, 'required' => false]);
            } ?>
         <small id="countryHelp" class="form-text text-muted">States will be auto populated on country selection.</small>
		</div>
	  <?php } ?>
		<div class="form-group">
			<?= $this->Form->control('zip', ['class'=>'form-control', 'type'=>'text']); ?>
		</div>
		<div class="form-actions form-group">
			<?= $this->Form->control('registration_status', ['type'=>'hidden', 'value'=>'2']); ?>
			<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Save & continue', ['type'=>'submit', 'class'=>'btn btn-success nextBtn']); ?>
		</div>
		<?= $this->Form->end() ?>
	</div>
	</div><!-- .setup-content -->

    <?php 
    $stepNo = 3;
    if($client->registration_status < 4) {// if new Client  ?>
	<div class="row setup-content" id="step-<?= $stepNo ?>">
	<div class="col-md-12">
		<?=  $this->Form->create($client, ['url'=> ['action'=>'add', 3, $client->id], 'class'=>'clients_add']);?>
		<table class="table table-responsive">
		<tr>
			<th scope="col"><?= __('Service') ?></th>
			<th scope="col"><?= __('Is Safety Sensitive') ?></th>
			<th scope="col"><?= __('Is Safety Non-sensitive') ?></th>
			<th scope="col"><?= __('Discount') ?></th>
			<th scope="col" class="actions"><?= __('Is Percentage?') ?></th>
		</tr>
		<?php
		$i = 0;
		if(!empty($client->client_services)) {
		foreach ($client->client_services as $key=>$val) { ?>
		<tr>
			<td><?= $this->Form->checkbox('client_services.'.$i.'.service_id', ['value'=>$val->service_id]); ?><label><?= $val->service->name; ?></label></td>
			<td><?= $this->Form->checkbox('client_services.'.$i.'.is_safety_sensitive', ['label'=>false]); ?></td>
			<td><?= $this->Form->checkbox('client_services.'.$i.'.is_safety_nonsensitive', ['label'=>false]); ?></td>
			<td><?= $this->Form->control('client_services.'.$i.'.discount', ['class'=>'form-control', 'min'=>'0', 'label'=>false]); ?></td>
			<td><?= $this->Form->checkbox('client_services.'.$i.'.is_percentage', ['label'=>false]); ?>
			<?= $this->Form->control('client_services.'.$i.'.created_by', ['type'=>'hidden', 'value'=>$user_id]); ?>
			<?= $this->Form->control('client_services.'.$i.'.id'); ?>
			</td>
		</tr>
		<?php 
		$i++; 
		}
		}
		foreach ($services as $key=>$val) {
		if(!in_array($key, $clids)) {
		?>
		<tr>		
			<td><?= $this->Form->checkbox('client_services.'.$i.'.service_id', ['value'=>$key]); ?><label><?= $val; ?></label></td>
			<td><?= $this->Form->checkbox('client_services.'.$i.'.is_safety_sensitive', ['label'=>false]); ?></td>
			<td><?= $this->Form->checkbox('client_services.'.$i.'.is_safety_nonsensitive', ['label'=>false]); ?></td>
			<td><?= $this->Form->control('client_services.'.$i.'.discount', ['class'=>'form-control', 'min'=>'0', 'label'=>false]); ?></td>
			<td><?= $this->Form->checkbox('client_services.'.$i.'.is_percentage', ['label'=>false]); ?>
			<?= $this->Form->control('client_services.'.$i.'.created_by', ['type'=>'hidden', 'value'=>$user_id]); ?>
			</td>
		</tr>
		<?php
		}
		$i++;
		}
		?>
		</table>
		<br/><br/>

		<table class="table table-responsive">
		<tr><th>Please select Modules : </th></tr>
		<?php
		$i = 0;
		if(!empty($client->client_modules)) {		
		foreach ($client->client_modules as $key=>$val){ ?>
		<tr><td>
		<?= $this->Form->checkbox('client_modules.'.$i.'.module_id', ['value'=>$val->module_id]); ?><label><?= $val->module->name; ?></label>
		<?= $this->Form->control('client_modules.'.$i.'.created_by', ['type'=>'hidden', 'value'=>$user_id]); ?></td>
		<?= $this->Form->control('client_modules.'.$i.'.id', ['type'=>'hidden']); ?>
		</td></tr>
		<?php
		$i++;
		}
		}

		foreach($modules as $key=>$val) { 
		if(!in_array($key, $modclids)) {
		?>
		<tr>
		<td><?= $this->Form->checkbox('client_modules.'.$i.'.module_id', ['value'=>$key, 'label'=>false, 'required'=>false]);?><?= $val;?>
		<?= $this->Form->control('client_modules.'.$i.'.client_id', ['type'=>'hidden', 'value'=>$client->id]) ?>
		<?= $this->Form->control('client_modules.'.$i.'.created_by', ['type'=>'hidden', 'value'=>$user_id]); ?></td>
		</tr>
		<?php 
		}
		$i++;
		}
		?>
		</table>

		<div class="form-actions form-group">
			<?= $this->Form->control('registration_status', ['type'=>'hidden', 'value'=>'3']); ?>
			<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Save & continue', ['type'=>'submit', 'class'=>'btn btn-success nextBtn']); ?>
		</div>		
		<?= $this->Form->end() ?>
	</div>
	</div><!-- .setup-content -->
        <?php // if new Client 
        $stepNo = 4;
    } ?>

	<div class="row setup-content" id="step-<?= $stepNo ?>">
	<div class="col-md-12">		
		<div class="panel-group" id="accordionMenu" role="tablist" aria-multiselectable="true">
		<div class="panel panel-default">
		<?php
		$i=0;
        $c=0;
		$insureQual =array();		
		foreach ($servicelist as $cl) { 				
		if($cl->service->id == 2) { // skip insureQual
			$insureQual = $cl->service; 
			continue;
		}
		if($cl->service->id == 4 || $cl->service->id == 6){ // skip employeeQual and safetyQual
			continue;
		}
		?>		
		<div class="panel-heading" role="tab">
			<h4 class="panel-title">
			<a role="button" data-toggle="collapse" data-parent="#accordionMenu" href="#collapse<?= $i ?>" <?php if($i==0) { echo 'aria-expanded="true"'; } ?> aria-controls="collapse<?= $i ?>"><?= $cl->service->name;?><i class="fa fa-sort-down"></i></a>
			</h4>
		</div>

		<div id="collapse<?= $i ?>" class="panel-collapse collapse in mt-4 <?php if($i==0) { echo 'show'; } ?>" role="tabpanel" aria-labelledby="heading<?= $i ?>">
		<div class="panel-body mt">

		<?php		
		foreach ($cl->service->categories as $cat) { ?>
		<ul class="nav mt-4">
		<li>
		<div class="modal fade" id="addQuestion_<?= $cat->id ?>" tabindex="-1" role="dialog" aria-labelledby="addQuestionLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
		<?= $this->Form->create($question, ['url'=>['action'=>'addquestions', $client->id]]);?>
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="mediumModalLabel">Add Question</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<?= $this->Form->control('question', ['class'=>'form-control', 'required'=>false]) ?>
				</div>
				<div class="form-group">
					<?= $this->Form->control('question_options', ['class'=>'form-control']) ?>
				</div>
				<div class="form-group">
					<?= $this->Form->control('question_type_id', ['class'=>'form-control', 'options'=>$questionTypes, 'empty'=>false]) ?>
				</div>
				<div class="form-group">
					<?= $this->Form->control('allow_multiselect', ['class'=>'']) ?>
				</div>
				<div class="form-group">
					<?= $this->Form->control('active', ['class'=>'', 'checked'=>'checked']) ?>
				</div>
				<div class="form-group">
					<?= $this->Form->control('help', ['class'=>'form-control']) ?>
				</div>
				<?= $this->Form->control('category_id', ['type'=>'hidden',  'value'=>$cat->id]); ?>
				<?= $this->Form->control('client_id', ['type'=>'hidden', 'value'=>$client->id]); ?>
				<?= $this->Form->control('step', ['type'=>'hidden', 'value'=>$step]); ?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
				<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Save', ['type'=>'submit', 'class'=>'btn btn-primary btn-sm']); ?>
			</div>
		</div>
		<?= $this->Form->end() ?>
		</div>
		</div><!-- .modal -->
		<div class="col-sm-12 alert-wrap-<?= $c ?>"></div>
		<?= $this->Form->create($client, ['url'=> ['action'=>'addClientQuestions', 4, $client->id], 'class'=>'clientQuestion saveAjax', 'data-responce'=>".alert-wrap-$c"]);?>
       
		<table class="table table-responsive">
		<thead class="thead-dark">		
			<tr>
			<th><label><?= $cat->name; ?></label></th>	
             					
			<th colspan="4"><?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> <span>Save All</span>', ['type'=>'submit', 'class'=>'btn btn-success btn-sm pull-right ml-2 ']); ?>
<button type="button" class="btn btn-secondary btn-sm mb-1 pull-right" data-toggle="modal" data-target="#addQuestion_<?= $cat->id;?>">Add Question</button></th>
			</tr>
		</thead>
		<thead>
			<tr>
			  <th scope="col" class="noBorder">Question</th>
			  <th scope="col" class="noBorder">is safety sensitive</th>
			  <th scope="col" class="noBorder">is safety nonsensitive</th>
			  <th scope="col" class="noBorder">is compulsory</th>
			  <!--<th scope="col" class="noBorder">Question Order</th>-->
			</tr>
			<tr>
			<th class="noBorder"><input type="checkbox" class="select_all" data-check="questions"> Select All</th>
			<th class="noBorder"><input type="checkbox" class="select_all" data-check="safty-sen"> Select All</th>
			<th class="noBorder"><input type="checkbox" class="select_all" data-check="safty-nonsen"> Select All</th>
			<th class="noBorder"><input type="checkbox" class="select_all" data-check="compulsory"> Select All</th>
			<!--<th class="noBorder"></th>-->
			</tr>
		</thead>
		<tbody>
		<?php 	
		echo $this->Form->control('category_id', ['type'=>'hidden', 'value'=>$cat->id]);
		$j =0;
        $parent_questions = [];
		foreach ($cat->questions as $v) { 
			$cq=(object)[];
			$checked =false;
			$cq->question_id =$v->id;
            //$cq->ques_order ='';
			$cq->is_safety_sensitive =false;
			$cq->is_safety_nonsensitive =false;
			$cq->is_compulsory =false;              
            if($v->is_parent) { $parent_questions[] = $v->id; }    
   		?>    
		<tr>
			<td>
			<?php if(!empty($v->client_questions)) {				
				$checked =true;
				$cq = $v->client_questions[0];			
				echo $this->Form->control('client_questions.'.$j.'.id', ['type'=>'hidden', 'value'=>$v->client_questions[0]->id]);
			} ?>
           <div class="<?= $v->is_parent ? 'root-question' : '' ?><?= in_array($v->question_id, $parent_questions) && $v->question_id != '' ? ' child-question' : '' ?>"  data-questionId="<?= $v->id?>" <?= $v->parent_option!= '' ? 'data-parentqId="'.$v->question_id.'" data-parent="'.$v->question_id.'-'.$v->parent_option.'"' : ''?> >
			<?= $this->Form->checkbox('client_questions.'.$j.'.question_id', ['value'=>$v->id, 'checked'=>$checked, 'class'=>'questions mr-2']); ?><label><?= $v->question;?></label>
			</td>
			<td><?= $this->Form->checkbox('client_questions.'.$j.'.is_safety_sensitive',['checked'=>$cq->is_safety_sensitive,'class'=>'safty-sen']); ?></td>
			<td><?= $this->Form->checkbox('client_questions.'.$j.'.is_safety_nonsensitive',['checked'=>$cq->is_safety_nonsensitive,'class'=>'safty-nonsen']); ?></td>
			<td><?= $this->Form->checkbox('client_questions.'.$j.'.is_compulsory',['checked'=>$cq->is_compulsory,'class'=>'compulsory']) ?>
			<!--<td><?= $this->Form->control('client_questions.'.$j.'.ques_order', ['label'=>false,'type'=>'number', 'value'=>$cq->ques_order]) ?></td>-->
			<?= $this->Form->control('client_questions.'.$j.'.client_id', ['type'=>'hidden', 'value'=>$client->id]) ?>
			<?= $this->Form->control('client_questions.'.$j.'.created_by', ['type'=>'hidden', 'value'=>$user_id]) ?>
			
			</td>
		</tr>
		<?php 
        $c++;
		$j++;
		} ?>						
		</tbody>
		</table>
		<?= $this->Form->end() ?>
			
		</li>
		</ul> <!-- .nav mt-4 -->
		<?php
		} // foreach
		$i++;
		?>
		</div><!-- .panel-body mt -->
		</div>
		<?php 
		} 		
		if(!empty($insureQual)){
		?>			
		<div class="panel-heading" role="tab">
			<h4 class="panel-title">
			<a role="button" data-toggle="collapse" data-parent="#accordionMenu" href="#collapse_insure" aria-controls="collapse_test"><?= $insureQual->name;?><i class="fa fa-sort-down"></i></a>
			</h4>
		</div>

		<div id="collapse_insure" class="panel-collapse collapse in mt-4" role="tabpanel" aria-labelledby="heading_2">
		<div class="panel-body mt">
		<?php		
		foreach ($insureQual->categories as $cat) {
			if(empty($cat->questions)){ continue; }
		?>
		<ul class="nav mt-4">
		<li>
		<div class="modal fade" id="addQuestion_<?= $cat->id ?>" tabindex="-1" role="dialog" aria-labelledby="addQuestionLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
		<?= $this->Form->create($question, ['url'=>['action'=>'addquestions', $client->id]]);?>
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="mediumModalLabel">Add Question</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<?= $this->Form->control('question', ['class'=>'form-control', 'required'=>false]) ?>
				</div>
				<div class="form-group">
					<?= $this->Form->control('question_options', ['class'=>'form-control']) ?>
				</div>
				<div class="form-group">
					<?= $this->Form->control('question_type_id', ['class'=>'form-control', 'options'=>$questionTypes, 'empty'=>false]) ?>
				</div>
				<div class="form-group">
					<?= $this->Form->control('allow_multiselect', ['class'=>'']) ?>
				</div>
				<div class="form-group">
					<?= $this->Form->control('active', ['class'=>'', 'checked'=>'checked']) ?>
				</div>
				<div class="form-group">
					<?= $this->Form->control('help', ['class'=>'form-control']) ?>
				</div>
				<?= $this->Form->control('category_id', ['type'=>'hidden',  'value'=>$cat->id]); ?>
				<?= $this->Form->control('client_id', ['type'=>'hidden', 'value'=>$client->id]); ?>
				<?= $this->Form->control('step', ['type'=>'hidden', 'value'=>$step]); ?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
				<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Save', ['type'=>'submit', 'class'=>'btn btn-primary btn-sm']); ?>
			</div>
		</div>
		<?= $this->Form->end() ?>
		</div>
		</div><!-- .modal -->
		<div class="col-sm-12 alert-wrap-<?= $c ?>"></div>	
		<?= $this->Form->create($client, ['url'=> ['action'=>'addClientQuestions', 4, $client->id], 'class'=>'clientQuestion saveAjax', 'data-responce'=>".alert-wrap-$c"]);?>
		<table class="table table-responsive">
		<thead class="thead-dark">		
			<tr>
			<th><label><?= $cat->name; ?></label></th>					
			<th colspan="5"><?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> <span>Save All</span>', ['type'=>'submit', 'class'=>'btn btn-success btn-sm pull-right ml-2']); ?><button type="button" class="btn btn-secondary btn-sm mb-1 pull-right" data-toggle="modal" data-target="#addQuestion_<?= $cat->id;?>">Add Question</button></th>
			</tr>
		</thead>
		<thead>
			<tr>
			<th scope="col" class="noBorder">Question</th>
			<!--<th scope="col" class="noBorder">Correct Answer</th>
			<th scope="col" class="noBorder">is safety sensitive</th>-->
			<th scope="col" class="noBorder">is safety nonsensitive</th>
			<th scope="col" class="noBorder">is compulsory</th>
          <!--<th scope="col" class="noBorder">Question Order</th>-->
			</tr>
			<tr>
			<th class="noBorder"><input type="checkbox" class="select_all" data-check="questions"> Select All</th>
			<!--<th class="noBorder"></th>-->
			<th class="noBorder"><input type="checkbox" class="select_all" data-check="safty-sen"> Select All</th>
			<th class="noBorder"><input type="checkbox" class="select_all" data-check="safty-nonsen"> Select All</th>
			<th class="noBorder"><input type="checkbox" class="select_all" data-check="compulsory"> Select All</th>
			</tr>
		</thead>
		<tbody>
		<?php 		
		$j =0;
		foreach ($cat->questions as $v) {
			$cq=(object)[];
			$checked =false;
			//$cq->correct_answer = '';
			$cq->question_id =$v->id;
			$cq->is_safety_sensitive =false;
			$cq->is_safety_nonsensitive =false;
			$cq->is_compulsory =false;
		?>
		<tr>
			<td>
			<?php if(!empty($v->client_questions)) {				
				$checked =true;
				$cq = $v->client_questions[0];			
				echo $this->Form->control('client_questions.'.$j.'.id', ['type'=>'hidden', 'value'=>$v->client_questions[0]->id]);
			} ?>
			<?= $this->Form->checkbox('client_questions.'.$j.'.question_id', ['value'=>$v->id, 'checked'=>$checked, 'class'=>'questions mr-2']); ?><label><?= $v->question;?></label>
			</td>
			<!--<td><?= $this->element('client_questions/client_question_'.$v->question_type->name, ["key" => $j, "question" => $v, "answer" => $cq->correct_answer]) ?></td>-->
			<!--<?= $this->Form->control('client_questions.'.$j.'.correct_answer',['value'=>$cq->correct_answer,'class'=>'form-control','label'=>false]) ?>-->
			<td><?= $this->Form->checkbox('client_questions.'.$j.'.is_safety_sensitive',['checked'=>$cq->is_safety_sensitive,'class'=>'safty-sen']); ?></td>
			<td><?= $this->Form->checkbox('client_questions.'.$j.'.is_safety_nonsensitive',['checked'=>$cq->is_safety_nonsensitive,'class'=>'safty-nonsen']); ?></td>
			<td><?= $this->Form->checkbox('client_questions.'.$j.'.is_compulsory',['checked'=>$cq->is_compulsory,'class'=>'compulsory']) ?>
			<!--<td><?= $this->Form->control('client_questions.'.$j.'.ques_order', ['label'=>false,'type'=>'number', 'value'=>$client->ques_order]) ?></td>-->
			<?= $this->Form->control('client_questions.'.$j.'.client_id', ['type'=>'hidden', 'value'=>$client->id]) ?>
			<?= $this->Form->control('client_questions.'.$j.'.created_by', ['type'=>'hidden', 'value'=>$user_id]) ?>
			</td>
		</tr>
		<?php 
        $c++;
		$j++;
		} ?>						
		</tbody>
		</table>
		<?= $this->Form->end() ?>
		</li>
		</ul> <!-- .nav mt-4 -->
		<?php
		} // foreach
		?>
		</div><!-- .panel-body mt -->       
		</div>
         <?php }?>
		<div class="form-actions form-group">
			<?= $this->Form->create($client, ['url'=> ['action'=>'add', 4, $client->id], 'class'=>'clients_add']);?>
			<?= $this->Form->control('registration_status', ['class'=>'form-control','type'=>'hidden','value'=>'4']); ?>
			<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Finish', ['type'=>'submit', 'class'=>'btn btn-success nextBtn pull-right']); ?>
			<?= $this->Form->end() ?>
		</div>
	     <!-- .setup-content -->	
		</div>
		
        </div><!-- .card -->
    </div>
    </div>
</div>

