<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CustomerRepresentative $customerRepresentative
 */
use Cake\Routing\Router;
$login_url = "users/login";
$url = Router::Url($login_url, true). '/' . $contractor->user->login_secret_key .'?'.'redirect=/payments/checkout/1'; 
?>
<div class="row users">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong>Company Name :</strong> <?= $contractor->company_name; ?>
	</div>
	<div class="card-body card-block">
	<table class="table">
	<tr>
		<th scope="row"><?= __('Contractor Name') ?></th>
		<td><?= h($contractor['pri_contact_fn'].' '.$contractor['pri_contact_ln']); ?></td>
	</tr>
	<tr>
		<th scope="row"><?= __('Username') ?></th>
		<td><?= h($contractor->user->username); ?></td>
	</tr>		
	<tr>
		<th scope="row"><?= __('Login URL') ?></th>
		<td id="login_url" class="login_url"><?=	h($url); ?>
		<!--<button id="copyButton" class="btn btn-secondary btn-sm " style="margin-left: 10px;">Copy URL</button></td>	-->	
	</tr>
	</table>
	</div>
</div>
</div>
</div>
