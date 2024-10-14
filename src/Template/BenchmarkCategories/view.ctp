<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BenchmarkCategory $benchmarkCategory
 */
?>
<div class="row benchmarkCategories">
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<?= h($benchmarkCategory->name) ?>
	</div>
	<div class="card-body card-block">
   <table class="table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($benchmarkCategory->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Client') ?></th>
            <td><?= $benchmarkCategory->has('client') ? $this->Html->link($benchmarkCategory->client->id, ['controller' => 'Clients', 'action' => 'view', $benchmarkCategory->client->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($benchmarkCategory->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created By') ?></th>
            <td><?= $this->Number->format($benchmarkCategory->created_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified By') ?></th>
            <td><?= $this->Number->format($benchmarkCategory->modified_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($benchmarkCategory->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($benchmarkCategory->modified) ?></td>
        </tr>
    </table>
	</div>
</div>
</div>
</div>