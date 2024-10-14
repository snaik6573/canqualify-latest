<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContractorAnswer $contractorAnswer
 */
?>
<div class="row contractorAnswers">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong><?=$company_name->company_name ?></strong> 

	</div>
	<div class="card-body card-block">
	<table class="table table-bordered">
	<thead>
	<tr>
		<th scope="col">Categories</th>
		<?php foreach($year_range as $year){ ?>
		<th scope="col"><?= $year; ?></th>
		<?php } ?>
		<th scope="col">Avg.</th>
	</tr>
	</thead>
	<tbody>
		<?php foreach($safetyreport as $categories => $val) { ?>
		<tr>
			<th><?= $categories ?></th>
			<?php foreach($val['year'] as $v) { //$v==''?'':$v  ?>
				<td><?= $v=='' ? ' ' : $v ?></td>
			<?php } ?>
			<td><?= $val['avg'] ?></td>
		</tr>
		<?php } ?>
	</tbody>
	</table>
	</div>
	</div>
</div>
</div>
</div>
