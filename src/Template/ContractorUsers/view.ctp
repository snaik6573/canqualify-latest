<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContractorUser $contractorUser
 */
//$cont_users = array(CONTRACTOR,CONTRACTOR_ADMIN);pr($cont_users);
?>
<div class="row contractorUsers">
<?php if(!empty($service_id && $cat_id)){?>
<div class="col-lg-12">
<?php }else{ ?>
<div class="col-lg-6">
<?php } ?>
<div class="card">
	<div class="card-header">
		 <h3><?= h($contractorUser->id) ?></h3>
	</div>
	<div class="card-body card-block">
	<table class="table">
         <tr>
            <th scope="row"><?= __('Title') ?></th>
            <td><?= h($contractorUser->title) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Pri Contact Fn') ?></th>
            <td><?= h($contractorUser->pri_contact_fn) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Pri Contact Ln') ?></th>
            <td><?= h($contractorUser->pri_contact_ln) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Pri Contact Pn') ?></th>
            <td><?= h($contractorUser->pri_contact_pn) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $contractorUser->has('user') ? $this->Html->link($contractorUser->user->id, ['controller' => 'Users', 'action' => 'view', $contractorUser->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Contractor') ?></th>
            <td><?= $contractorUser->has('contractor') ? $this->Html->link($contractorUser->contractor->id, ['controller' => 'Contractors', 'action' => 'view', $contractorUser->contractor->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($contractorUser->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($contractorUser->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($contractorUser->modified) ?></td>
        </tr>
	</table>
	</div>
</div>
</div>
</div>
