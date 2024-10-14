<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BenchmarkType $benchmarkType
 */
?>
<div class="row benchmarkTypes">
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<?= h($benchmarkType->name) ?>
	</div>
	<div class="card-body card-block">
   <table class="table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($benchmarkType->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($benchmarkType->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created By') ?></th>
            <td><?= $this->Number->format($benchmarkType->created_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified By') ?></th>
            <td><?= $this->Number->format($benchmarkType->modified_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($benchmarkType->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($benchmarkType->modified) ?></td>
        </tr>
    </table>
	</div>
</div>
</div>
</div>
