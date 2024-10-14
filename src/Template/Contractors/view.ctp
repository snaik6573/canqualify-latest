<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Contractor $contractor
 */
?>
<div class="row contractors">
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<?= h($contractor->id) ?>
	</div>
	<div class="card-body card-block">
	<table class="table">
	<tr>
	    <th scope="row"><?= __('Username') ?></th>
	    <td><?= $contractor->has('user') ? h($contractor->user->username): '' ?></td>
	</tr>
	<tr>
	    <th scope="row"><?= __('Company Name') ?></th>
	    <td><?= h($contractor->company_name) ?></td>
	</tr>
    <tr>
	    <th scope="row"><?= __('Company Logo') ?></th>
	    <td><?= h($contractor->company_logo) ?></td>
	</tr>
    <tr>
	    <th scope="row"><?= __('Company TIN') ?></th>
	    <td><?= h($contractor->company_tin) ?></td>
	</tr>
	<tr>
	    <th scope="row"><?= __('Addressline 1') ?></th>
	    <td><?= h($contractor->addressline_1) ?></td>
	</tr>
	<tr>
	    <th scope="row"><?= __('Addressline 2') ?></th>
	    <td><?= h($contractor->addressline_2) ?></td>
	</tr>
	<tr>
	    <th scope="row"><?= __('City') ?></th>
	    <td><?= h($contractor->city) ?></td>
	</tr>
	<tr>
	    <th scope="row"><?= __('State') ?></th>
	    <td><?= $contractor->has('state') ? $contractor->state->name : '' ?></td>
	</tr>
	<tr>
	    <th scope="row"><?= __('Country') ?></th>
	    <td><?= $contractor->has('country') ? $contractor->country->name : '' ?></td>
	</tr>
	<tr>
	    <th scope="row"><?= __('Zip') ?></th>
	    <td><?= $this->Number->format($contractor->zip) ?></td>
	</tr>
	<tr>
	    <th scope="row"><?= __('Latitude') ?></th>
	    <td><?= $this->Number->format($contractor->latitude) ?></td>
	</tr>
	<tr>
	    <th scope="row"><?= __('Longitude') ?></th>
	    <td><?= $this->Number->format($contractor->longitude) ?></td>
	</tr>
	<tr>
	    <th scope="row"><?= __('First Name') ?></th>
	    <td><?= h($contractor->pri_contact_fn) ?></td>
	</tr>
	<tr>
	    <th scope="row"><?= __('Last Name') ?></th>
	    <td><?= h($contractor->pri_contact_ln) ?></td>
	</tr>
	<tr>
	    <th scope="row"><?= __('Phone No.') ?></th>
	    <td><?= h($contractor->pri_contact_pn) ?></td>
	</tr>
	<tr>
	    <th scope="row"><?= __('Registration Status') ?></th>
	    <td><?= $this->Number->format($contractor->registration_status) ?></td>
	</tr>
	<tr>
	    <th scope="row"><?= __('Is Safety Sensitive') ?></th>
	    <td><?= $contractor->is_safety_sensitive ? __('Yes') : __('No'); ?></td>
	</tr>
	<tr>
	    <th scope="row"><?= __('Payment Status') ?></th>
	    <td><?= $contractor->payment_status ? __('Yes') : __('No'); ?></td>
	</tr>
	<tr>
	    <th scope="row"><?= __('Is Locked') ?></th>
	    <td><?= $contractor->is_locked ? __('Yes') : __('No'); ?></td>
	</tr>
	<tr>
	    <th scope="row"><?= __('Is Active') ?></th>
	    <td><?= $contractor->user->active ? __('Yes') : __('No'); ?></td>
	</tr>
	<tr>
	    <th scope="row"><?= __('Created') ?></th>
	    <td><?= h($contractor->created) ?></td>
	</tr>
	<tr>
	    <th scope="row"><?= __('Modified') ?></th>
	    <td><?= h($contractor->modified) ?></td>
	</tr>
	</table>
	</div>
</div>
</div>
</div>
