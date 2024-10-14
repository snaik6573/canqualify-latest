<!-- <?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContractorClient[]|\Cake\Collection\CollectionInterface $contractorClients
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Contractor Client'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Contractors'), ['controller' => 'Contractors', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Contractor'), ['controller' => 'Contractors', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Clients'), ['controller' => 'Clients', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Client'), ['controller' => 'Clients', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="contractorClients index large-9 medium-8 columns content">
    <h3><?= __('Contractor Clients') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('contractor_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('client_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created_by') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified_by') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contractorClients as $contractorClient): ?>
            <tr>
                <td><?= $this->Number->format($contractorClient->id) ?></td>
                <td><?= $contractorClient->has('contractor') ? $this->Html->link($contractorClient->contractor->id, ['controller' => 'Contractors', 'action' => 'view', $contractorClient->contractor->id]) : '' ?></td>
                <td><?= $contractorClient->has('client') ? $this->Html->link($contractorClient->client->id, ['controller' => 'Clients', 'action' => 'view', $contractorClient->client->id]) : '' ?></td>
                <td><?= h($contractorClient->created) ?></td>
                <td><?= h($contractorClient->modified) ?></td>
                <td><?= $this->Number->format($contractorClient->created_by) ?></td>
                <td><?= $this->Number->format($contractorClient->modified_by) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $contractorClient->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $contractorClient->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $contractorClient->id], ['confirm' => __('Are you sure you want to delete # {0}?', $contractorClient->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
 -->