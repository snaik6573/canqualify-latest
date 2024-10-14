<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Review $review
 */
echo $this->Html->css('review.css');
echo $this->Html->script('review.js'); 
?>
<div class="row reviews">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<?= __('Review') ?>
	</div>
	<div class="card-body card-block">
		<?= $this->Text->autoParagraph($review->reviewtxt); ?>
	</div>
</div>
</div>
</div>


