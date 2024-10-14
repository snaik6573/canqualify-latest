<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Client $client
 */
?>
<div class="row clients">
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<?= h($clientUser->client->company_name) ?>
	</div>
	<div class="card-body card-block">
	<table class="table">
		<tr>
			<th scope="row"><?= __('Company Name') ?></th>
			<td><?= h($clientUser->client->company_name) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Account Type') ?></th>
			<td><?= $clientUser->client->has('account_type') ? $clientUser->client->account_type->name : '' ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Username') ?></th>
			<td><?= $clientUser->has('user') ? $clientUser->user->username : '' ?></td>
		</tr>		
		<tr>
			<th scope="row"><?= __('Addressline 1') ?></th>
			<td><?= h($clientUser->client->addressline_1) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Addressline 2') ?></th>
			<td><?= h($clientUser->client->addressline_2) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('City') ?></th>
			<td><?= h($clientUser->client->city) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('State') ?></th>
			<td><?= $clientUser->client->has('state') ? $clientUser->client->state->name : '' ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Country') ?></th>
			<td><?= $clientUser->client->has('country') ? $clientUser->client->country->name : '' ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Zip') ?></th>
			<td><?= $this->Number->format($clientUser->client->zip) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('First Name') ?></th>
			<td><?= h($clientUser->pri_contact_fn) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Last Name') ?></th>
			<td><?= h($clientUser->pri_contact_ln) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Phone No.') ?></th>
			<td><?= h($clientUser->pri_contact_pn) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Registration Status') ?></th>
			<td><?= h($clientUser->client->registration_status) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Client Services') ?></th>
			<td>
			<?php foreach($clientUser->client->client_services as $client_services) { 
				echo $client_services->service->name.' ';
			} ?>
			</td>
		</tr>
		<tr>
			<th scope="row"><?= __('Membership Startdate') ?></th>
			<td><?= h($clientUser->client->membership_startdate) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Membership Enddate') ?></th>
			<td><?= h($clientUser->client->membership_enddate) ?></td>
		</tr>
		<tr>
		    <th scope="row"><?= __('Is Active') ?></th>
		    <td><?= $clientUser->user->active ? __('Yes') : __('No'); ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Created') ?></th>
			<td><?= h($clientUser->client->created) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Modified') ?></th>
			<td><?= h($clientUser->client->modified) ?></td>
		</tr>
	</table>
	</div>
</div>
</div>

<div class="col-lg-6 ">
<div class="card sites">	
	<div class="card-header">
		<?= __('Locations') ?>
	</div>
	<div class="card-body card-block">
	<table class="table">
	<?php if($clientUser->client->account_type_id == 3) { ?>
		<tr>
			<th scope="row" width="70%"><?= __('Location') ?></th>
			<th scope="row"><?= __('Region') ?></th>
		</tr>			
		
		<?php 
		foreach($clientUser->client->sites as $sites) {
		echo '<tr>';			
			echo '<td>'. h($sites->name) .'</td>';
			echo '<td>'. h($sites->region['name']) .'</td>';
		echo '</tr>';
		}
	} else { ?>
		<?php 
		foreach($clientUser->client->sites as $sites) {
			echo '<tr><td>'. h($sites->name) .'</td></tr>';
		}
	} ?>
	</table>
	</div>
</div>
</div>
	
</div>
