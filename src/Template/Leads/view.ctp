<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Lead $lead
 */
use Cake\Core\Configure;
$note_type = Configure::read('note_type');
$users = array(SUPER_ADMIN, ADMIN, CR);
?>
<div class="row leads ">
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<?= h($lead->company_name) ?>
		<div class="pull-right">
		<?php if($activeUser['role_id'] == CR && !empty($lead->updated_fields)) {
			echo $this->Form->create($lead, ['class'=>'']);
			echo $this->Form->label('Mark As Read');
			echo $this->Form->control('is_read',['class'=>'ajaxClick', 'label'=>false]);
			echo $this->Form->control('id', ['type'=>'hidden', 'value'=>$lead->id]);
			echo $this->Form->end();
		}?>
		</div>
	</div>
	<div class="card-body card-block">
	<table class="<?= in_array($activeUser['role_id'], $users) && !empty($lead->updated_fields) ? implode(' ', $lead->updated_fields). ' hightlight_lead' : '' ?> table">
		<tr>
			<th scope="row"><?= __('Company Name') ?></th>
			<td class="company_name"><?= h($lead->company_name) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Status') ?></th>
			<td><?= h($lead->lead_status->status) ?></td>
       </tr>
		<tr>
			<th scope="row"><?= __(' First Name') ?></th>
			<td class="contact_name_first"><?= h($lead->contact_name_first) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Last Name') ?></th>
			<td class="contact_name_last"><?= h($lead->contact_name_last) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Phone') ?></th>
			<td class="phone_no"><?= h($lead->phone_no) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Email') ?></th>
			<td class="email"><?= h($lead->email) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('City') ?></th>
			<td class="city"><?= h($lead->city) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('State') ?></th>
			<td class="state"><?= h($lead->state) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Zip Code') ?></th>
			<td class="zip_code"><?= h($lead->zip_code) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Description Of Work') ?></th>
			<td class="description_of_work"><?= h($lead->description_of_work) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Client') ?></th>
			<td><?= $lead->has('client') ? $this->Html->link($lead->client->company_name, ['controller' => 'Clients', 'action' => 'view', $lead->client->id]) : '' ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Id') ?></th>
			<td><?= $this->Number->format($lead->id) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Created By') ?></th>
			<td><?= $this->Number->format($lead->created_by) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Modified By') ?></th>
			<td><?= $this->Number->format($lead->modified_by) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Created') ?></th>
			<td><?= h($lead->created) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Modified') ?></th>
			<td><?= h($lead->modified) ?></td>
		</tr>
	</table>
	</div>
</div>
</div>
</div>

<div class="row">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<?= __('Notes') ?>
	</div>
	<div class="card-body card-block">
	<?php if (!empty($lead->lead_notes)): ?>
	<table class="bootstrap-data-table-export table table-striped table-bordered"  data-order="[[ 4, &quot;asc&quot; ]]">
		<thead>
		<tr>
			<!--<th scope="col"><?= __('Id') ?></th>-->
			<th scope="col"><?= __('Subject') ?></th>
			<th scope="col"><?= __('Note Type') ?></th>                       
            <th scope="col"><?= __('Created by') ?></th>
            <th scope="col"><?= __('Created') ?></th>
			<th scope="col" class="actions"><?= __('Actions') ?></th>
		</tr>
		</thead>
		<tbody>
        
		<?php foreach ($lead->lead_notes as $lead_notes): ?>
		<tr>
			<!--<td><?= h($lead_notes->id) ?></td>-->
			<td><?= h($lead_notes->subject) ?></td>
			<td><?= h($note_type[$lead_notes->note_type]) ?></td>                        
            <td><?php if($lead_notes->role_id == SUPER_ADMIN || $lead_notes->role_id == ADMIN) { 
                    echo 'CanQualify'; 
                    }elseif($lead_notes->role_id== CR) {
                    echo '<b>CR</b> - '.$lead_notes->customer_representative->pri_contact_fn.' '.$lead_notes->customer_representative->pri_contact_ln;
                    }elseif($lead_notes->role_id == CLIENT || $lead_notes->role_id == CLIENT_ADMIN) { echo $lead->client->company_name ; }?>
            </td>
            <td><?= h($lead_notes->created) ?></td>
			<td class="actions">
			<?= $this->Html->link('<i class="fa fa-eye"></i>', ['controller' => 'LeadNotes', 'action' => 'view', $lead_notes->id],['escape'=>false, 'title' => 'View']) ?>
            <?php if($lead_notes->created_by == $activeUser['id'] || $activeUser['role_id'] == SUPER_ADMIN) { ?>
			<?= $this->Html->link('<i class="fa fa-pencil"></i>', ['controller' => 'LeadNotes', 'action' => 'edit', $lead_notes->id],['escape'=>false, 'title' => 'Edit']) ?>			
			<?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['controller' => 'LeadNotes', 'action' => 'delete', $lead_notes->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # {0}?', $lead_notes->id)]) ?>
			<?php } ?>
			</td>
		</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
	<?php endif; ?>
	</div>
</div>
</div>
</div>