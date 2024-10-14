<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Client[]|\Cake\Collection\CollectionInterface $clients
 */ 
use Cake\Core\Configure;
$iconList = Configure::read('icons'); //, array('0'=>'Grey','1'=>'Red','2'=>'Yellow','3'=>'Green')
$dayList = array('8'=>'8 Days','15'=>'15 Days','30'=>'1 Month');
?>
<div class="row clients">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
	<strong class="card-title"><?= __('Contractor List') ?></strong>				
	<div class="pull-right">
	<?= $this->Form->create($CustomerRepresentative, ['class'=>'form-inline']) ?>
		<div class="form-group">
           	<label for="client-id">Filter subscription date by </label>
		<?= $this->Form->select('sub_date', $dayList, ['class'=>"form-control ml-2", 'empty'=>'Select Days', 'default'=>$filterDate, 'onchange'=>'this.form.submit();']) ?>
		</div>
		<?= $this->Form->end() ?>
	</div>
	</div>

	<div class="card-body table-responsive">
	<table id="bootstrap-data-table" class="table table-striped table-bordered" data-order="[[ 5, &quot;asc&quot; ],[ 7, &quot;desc&quot; ]]">
	<thead>
	<tr>
		<th></th>		
		<th scope="col"><?= h('Contractor Name') ?></th>
		<th scope="col"><?= h('No. of Clients') ?></th>
		<th scope="col"><?= h('Primary Contact') ?></th>
		<th scope="col"><?= h('Phone') ?></th>
		<th scope="col"><?= h('Email') ?></th>
		<th scope="col"><?= h('Subscription Date') ?></th>
		<th scope="col"><?= h('Active') ?></th>
		<th scope="col"><?= h('Paid') ?></th>
	    <th scope="col"><?= h('Open Tasks') ?></th> 
		<th scope="col" class="noExport"><?= h('Actions') ?></th>
	</tr>
	</thead>
	<tbody>	
	<?php foreach ($contList as $c):
    $getClients = $this->User->getClients($c['id']);
    $clients = [];
    foreach ($getClients as $cid) {
         $clients[] = $allClients[$cid];
    }     
	?>		
	<tr>	
		<td><?php echo $this->Form->checkbox('contractor_id', ['type'=>'hidden','required'=>false, 'label'=>false,'id'=>'cont-id','value'=>$c['id']]); ?></td>	
		<td><?= $this->Html->link($c['company_name'], ['controller' => 'Contractors','action' => 'dashboard', $c['id']],['escape'=>false, 'title' => 'View']) ?></td>
		<td><a href="#" data-placement="top" title="<?= implode(',', $clients) ?>"><?= count($clients); ?></a></td>
		<td><?= h($c['pri_contact_fn'].' '.$c['pri_contact_ln']); ?></td>
		<td><?= h($c['pri_contact_pn']) ?></td>
		<td><?= h($c['username']); ?></td>
		<td><?= h($c['subscription_date']) ?></td>
		<td>
            <span style="display:none;"><?= $c['active'] ? '1' : '0' ?></span>
			<?= $this->Form->create($contractor,['class'=>'saveAjax', 'data-responce'=>'.alert-wrap']) ?>
			<?= $this->Form->control('user.active', ['required'=>false, 'label'=>false, 'class'=>'ajaxClick', 'checked'=>$c['active'] ? 'checked' : '']); ?>
			<?= $this->Form->control('user.username', ['type'=>'hidden', 'value'=>$c['username']]); ?>
			<?= $this->Form->control('id', ['type'=>'hidden', 'value'=>$c['id']]); ?>
			<?= $this->Form->end() ?>
		</td>
		<td><?= $c['payment_status'] ? __('Yes') : __('No'); ?></td>
	    <td></td> 
		<td>
		<?= $this->Html->link(__('Add Note / Follow up'), ['controller' => 'Notes','action'=>'addCrNote', $c['id']], ['class'=>'btn btn-sm btn-success', 'target'=>'_BLANK']) ; ?>
		<br />
		<?= $c['renew_subscription'] && !$c['send_invoice'] ? $this->Html->link(__('Send Invoice'), ['action'=>'sendInvoice', $c['id']], ['class'=>'ajaxmodal btn btn-sm btn-success mt-2', 'data-toggle'=>'modal', 'data-target'=>'#scrollmodal2']) : '' ?>
		<!--<?= $c['renew_subscription'] && !$c['send_invoice'] ? $this->Html->link(__('Send Invoice'), ['action'=>'sendInvoice', $c['id']], ['class'=>'btn btn-sm btn-success mt-2', 'escape'=>false, 'title'=>'Send Invoice']) : '' ?>-->
		</td>
	</tr>
	<?php endforeach; ?>
	</tbody>
	    <div class="form-actions form-group">
          <?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Create List', ['type' => 'button', 'class'=>'btn btn-success mb-2 c-list']); ?>
         </div>
	</table>
	</div>
</div>
</div>
</div>

<!--
<div class="modal fade" id="scrollmodal" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">
	<div class="modal-header">
		<h5 class="modal-title">Add Note / Follow up</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	</div>
	<div class="modal-body">
	</div>
</div>
</div>
</div>-->
<div class="modal fade" id="scrollmodal1" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">
	<div class="modal-header">
		<h5 class="modal-title">Open Tasks</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	</div>
	<div class="modal-body">
	</div>
</div>
</div>
</div>

<div class="modal fade" id="scrollmodal2" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">
	<div class="modal-header">
		<h5 class="modal-title">Send Invoice</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	</div>
	<div class="modal-body">
	</div>
</div>
</div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Save Campaign Contact List</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?= $this->Form->create(null, ['id'=>'createList','url' => ['controller'=>'CampaignContactLists','action' => 'add']]) ?>
          <div class="form-group">
            <?= $this->Form->label('name', 'Contact List Name', ['class' => 'font-weight-bold']); ?>
            <?= $this->Form->control('name', ['class'=>'form-control', 'required'=>true,'label'=>false]); ?>
         </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Save List', ['type' => 'submit', 'class'=>'btn btn-success']); ?>
        </div>
       <?= $this->Form->end(); ?>
      </div>
       </div>
  </div>
</div>