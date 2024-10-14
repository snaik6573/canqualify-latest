<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LeadNote $leadNote
 */
use Cake\Core\Configure;
$note_type = Configure::read('note_type');
?>
<div class="row lead_notes">
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<?= h($leadNote->subject) ?>
	</div>
	<div class="card-body card-block">
	<table class="table">        
        <tr>
            <th scope="row"><?= __('Subject') ?></th>
            <td><?= h($leadNote->subject) ?></td>
        </tr>        
        <tr>
            <th scope="row"><?= __('Supplier') ?></th>
            <td><?= $leadNote->has('lead') ? $this->Html->link($leadNote->lead->company_name, ['controller' => 'Leads', 'action' => 'view', $leadNote->lead->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Note Type') ?></th>
            <td><?= h($note_type[$leadNote->note_type]) ?></td>
        </tr>       
        <!--<tr>
            <th scope="row"><?= __('Customer Representative') ?></th>
            <td><?= $leadNote->has('customer_representative') ? $this->Html->link($leadNote->customer_representative->pri_contact_fn.' '.$leadNote->customer_representative->pri_contact_ln, ['controller' => 'CustomerRepresentative', 'action' => 'view', $leadNote->customer_representative->id]) : '' ?></td>
        </tr>-->
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($leadNote->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created By') ?></th>
            <td><?php if($leadNote->role_id == SUPER_ADMIN || $leadNote->role_id == ADMIN) { 
                    echo 'CanQualify'; 
                    }elseif($leadNote->role_id== CR) {
                    echo '<b>CR</b> - '.$leadNote->customer_representative->pri_contact_fn.' '.$leadNote->customer_representative->pri_contact_ln;
                    }elseif($leadNote->role_id == CLIENT || $leadNote->role_id == CLIENT_ADMIN) { echo 'CanQualify'; }?>
            </td>
        </tr>
        
        <tr>
            <th scope="row"><?= __('Modified By') ?></th>
            <td><?= $this->Number->format($leadNote->modified_by) ?></td>
        </tr>
        <?php if($leadNote->note_type == 2) { ?>
        <tr>
            <th scope="row"><?= __('Feature Date') ?></th>
            <td><?= h($leadNote->feature_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Completed') ?></th>
            <td><?= $leadNote->is_completed ? __('Yes') : __('No'); ?></td>
        </tr>
        <?php } ?>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($leadNote->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($leadNote->modified) ?></td>
        </tr>              
        <tr>
            <th scope="row"><?= __('Show To Client') ?></th>
            <td><?= $leadNote->show_to_client ? __('Yes') : __('No'); ?></td>
        </tr>   
	</table>
	</div>
</div>
</div>
    <div class="col-lg-6">
    <div class="card">
	<div class="card-header">
		<?= __('Notes') ?>
	</div>
	<div class="card-body card-block" style="padding:15px 15px 15px 25px;">
	<?= html_entity_decode($leadNote->notes)?>		
	</div>
</div>
</div>
</div>
</div>
