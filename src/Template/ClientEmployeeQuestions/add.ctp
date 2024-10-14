<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ClientEmployeeQuestion $clientEmployeeQuestion
 */
?>

<div class="row clientEmployeeQuestions">
<div class="col-md-12">
<div class="card">
	<div class="card-header">
		<strong>Manage</strong> Client Employee Questions
	</div>
	<?php if($activeUser['role_id'] == SUPER_ADMIN || $activeUser['role_id'] == ADMIN) { ?>
	<div class="card-body card-block">	
	    <?= $this->Form->create() ?>	
	    <div class="row form-group">
	    <?php $selectedClient = !empty($client) ? $client->id : reset($clients); ?>
		    <label class="col-sm-3">Select Client</label>
		    <div class="col-sm-6"><?= $this->Form->control('current_client_id', ['options'=>$clients, 'default'=>$selectedClient, 'required'=>true,'empty'=>false, 'label'=>false, 'class'=>'form-control']); ?></div>
		    <div class="col-sm-3"><?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type'=>'submit', 'class'=>'btn btn-primary btn-sm']) ?></div>
	    </div>
	    <?= $this->Form->end() ?>
	</div>
	<?php } ?>
	<div class="card-body card-block">
	<?php if(!empty($client)) { ?>
	<div class="row">
	<div class="col-md-12">
	<div class="panel-group" id="accordionMenu" role="tablist" aria-multiselectable="true">
		<div class="panel panel-default">
		<?php
		$i=0;
		foreach ($employeeCategories as $cat) {
			if(empty($cat->employee_questions)) {
				continue;
			}
		?>		
		<div class="panel-heading" role="tab">
			<h4 class="panel-title">
			<a role="button" data-toggle="collapse" data-parent="#accordionMenu" href="#collapse<?= $i ?>" <?php if($i==0) { echo 'aria-expanded="true"'; } ?> aria-controls="collapse<?= $i ?>"><?= $cat->name;?><i class="fa fa-sort-down"></i></a>
			</h4>
		</div>

		<div id="collapse<?= $i ?>" class="panel-collapse collapse in mt-4 <?php if($i==0) { echo 'show'; } ?>" role="tabpanel" aria-labelledby="heading<?= $i ?>">
		<div class="panel-body mt">
		<div class="col-sm-12 alert-wrap-<?= $i ?>"></div>
		<?= $this->Form->create($client, ['class'=>'saveAjax', 'data-responce'=>".alert-wrap-$i"]);?>
		
		<table class="table">
		<thead>		
			<tr>
			<th colspan="2">
			<?= $this->Form->control('employee_category_id', ['type'=>'hidden', 'value'=>$cat->id]) ?>
			<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> <span>Save All</span>', ['type'=>'submit', 'class'=>'btn btn-success btn-sm pull-right ml-2 ']); ?>
			</th>
			</tr>
		</thead>
		<thead>
		<tr>
			<th scope="col" class="noBorder" width="80%">Question</th>
			<th scope="col" class="noBorder">is compulsory</th>
		</tr>
		<tr>
			<th><input type="checkbox" name="selectAll" value="questions" class="select_all" data-check="questions"> Select All</th>
			<th><input type="checkbox" name="selectAll" value="Bike" class="select_all" data-check="compulsory"> Select All</th>
		</tr>
		</thead>
		<tbody>
		<?php 		
		$j = 0;
        $parent_questions = [];
		foreach ($cat->employee_questions as $v) {
			$cq=(object)[];
			$checked =false;
			$cq->question_id =$v->id;
			$cq->is_compulsory =false;              
            if($v->is_parent) { $parent_questions[] = $v->id; }    
   		?>    
		<tr>
			<td>
			<?php if(!empty($v->client_employee_questions)) {				
				$checked =true;
				$cq = $v->client_employee_questions[0];			
				echo $this->Form->control('client_employee_questions.'.$j.'.id', ['type'=>'hidden', 'value'=>$v->client_employee_questions[0]->id]);
			} ?>
           <div class="<?= $v->is_parent ? 'root-question' : '' ?><?= in_array($v->employee_question_id, $parent_questions) && $v->employee_question_id != '' ? ' child-question' : '' ?>"  data-questionId="<?= $v->id?>" <?= $v->parent_option!= '' ? 'data-parentqId="'.$v->employee_question_id.'" data-parent="'.$v->employee_question_id.'-'.$v->parent_option.'"' : ''?> >
			<?= $this->Form->checkbox('client_employee_questions.'.$j.'.employee_question_id', ['value'=>$v->id, 'checked'=>$checked, 'class'=>'questions mr-2']); ?><label><?= $v->question;?></label>
			</td>
			<td><?= $this->Form->checkbox('client_employee_questions.'.$j.'.is_compulsory',['checked'=>$cq->is_compulsory,'class'=>'compulsory']) ?>
			</td>
		</tr>
		<?php 
		$j++;
		} ?>						
		</tbody>
		</table>
		<?= $this->Form->end() ?>
		
		</div><!-- .panel-body mt -->
		</div>
		<?php
		$i++;
		}
		?>
		</div>
	</div><!-- .accordionMenu -->
	</div>
	</div>
	<?php } ?>
	</div><!-- .card-body -->
</div>
</div>
</div>

<?php /*
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Client Employee Questions'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Clients'), ['controller' => 'Clients', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Client'), ['controller' => 'Clients', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Employee Questions'), ['controller' => 'EmployeeQuestions', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Employee Question'), ['controller' => 'EmployeeQuestions', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="clientEmployeeQuestions form large-9 medium-8 columns content">
    <?= $this->Form->create($clientEmployeeQuestion) ?>
    <fieldset>
        <legend><?= __('Add Client Employee Question') ?></legend>
        <?php
            echo $this->Form->control('client_id', ['options' => $clients]);
            echo $this->Form->control('employee_question_id', ['options' => $employeeQuestions]);
            echo $this->Form->control('is_compulsory');
            echo $this->Form->control('correct_answer');
            echo $this->Form->control('created_by');
            echo $this->Form->control('modified_by');
            echo $this->Form->control('employee_category_id');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
*/?>