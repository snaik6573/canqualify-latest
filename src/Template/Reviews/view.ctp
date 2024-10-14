<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Review $review
 */
?>
<div class="row reviews">
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<?= h($review->id) ?>
	</div>
	<div class="card-body card-block">
	<table class="table">
	    <tr>
		<th scope="row"><?= __('Client') ?></th>
		<td><?= $review->has('client') ? $this->Html->link($review->client->company_name, ['controller' => 'Clients', 'action' => 'view', $review->client->id]) : '' ?></td>
	    </tr>
        <tr>
            <th scope="row"><?= __('Contractor') ?></th>
            <td><?= $review->has('contractor') ? $this->Html->link($review->contractor->company_name, ['controller' => 'Contractors', 'action' => 'view', $review->contractor->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($review->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Rating') ?></th>
            <td><?= $this->Number->format($review->rating) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created By') ?></th>
            <td><?= $this->Number->format($review->created_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified By') ?></th>
            <td><?= $this->Number->format($review->modified_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($review->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($review->modified) ?></td>
        </tr>
    </table>
   </div>
</div>
</div>

<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<?= __('Reviewtxt') ?>
	</div>
	<div class="card-body card-block">
		<?= $this->Text->autoParagraph(h($review->reviewtxt)); ?>
	</div>
</div>
</div>
</div>


