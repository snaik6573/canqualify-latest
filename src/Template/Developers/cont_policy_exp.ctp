<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Role $role
 */
if(isset($result) || ($result1)){
?>
<div class="row roles">
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<strong>Policy Certificate</strong> Date
	</div>
	<div class="card-body card-block">
	<table class="table">
		<tr>
			<th scope="row"><?= __('Current Date') ?></th>
			<td><?= h($newDate) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Expire soon Date(+15 days)') ?></th>
			<td><?= h($nextDate) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('Expired Date(-1 day)') ?></th>
			<td><?= h($previousDate) ?></td>
		</tr>		
	</table>
	</div>
</div>
</div>
</div>
<?php } ?>