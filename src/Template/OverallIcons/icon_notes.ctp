<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Payment $payment
 */
?>
<div class="row OverallIcons">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<?= __('Notes') ?>
	</div>
	<div class="card-body card-block">
		<?= $this->Text->autoParagraph($overallIcon->notes); ?>
	</div>
</div>
</div>
</div>
