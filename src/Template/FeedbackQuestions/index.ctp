<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\FeedbackQuestion[]|\Cake\Collection\CollectionInterface $feedbackQuestions
 */
?>
<!--<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Feedback Question'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Feedback Answers'), ['controller' => 'FeedbackAnswers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Feedback Answer'), ['controller' => 'FeedbackAnswers', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="feedbackQuestions index large-9 medium-8 columns content">
    <h3><?= __('Feedback Questions') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($feedbackQuestions as $feedbackQuestion): ?>
            <tr>
                <td><?= $this->Number->format($feedbackQuestion->id) ?></td>
                <td><?= h($feedbackQuestion->created) ?></td>
                <td><?= h($feedbackQuestion->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $feedbackQuestion->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $feedbackQuestion->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $feedbackQuestion->id], ['confirm' => __('Are you sure you want to delete # {0}?', $feedbackQuestion->id)]) ?>
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
</div>-->

<div class="row feedbackQuestions">
<div class="col-lg-12">
<div class="card">
    <div class="card-header">
        <strong class="card-title"><?= __('Feedback Questions') ?></strong>
        <span class="pull-right"><?= $this->Html->link(__('Add New'), ['action' => 'add'],['class'=>'btn btn-success btn-sm']) ?> </span>
    </div>
    <div class="card-body table-responsive">
    <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
    <thead>
    <tr>
        <th scope="col"><?= h('Id') ?></th>
        <th scope="col"><?= h('Question') ?></th>       
        <th scope="col" class="actions"><?= __('Actions') ?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($feedbackQuestions as $feedbackQuestion): ?>
    <tr>
        <td><?= $this->Number->format($feedbackQuestion->id) ?></td>
        <td><?= htmlspecialchars_decode(h($feedbackQuestion->question)) ?></td>       
        <td class="actions">
        <?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $feedbackQuestion->id],['escape'=>false, 'title' => 'View']) ?>
        <?= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'edit', $feedbackQuestion->id],['escape'=>false, 'title' => 'Edit']) ?>
        <?php if($activeUser['role_id'] == SUPER_ADMIN) { ?>
        <?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['action' => 'delete', $feedbackQuestion->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # {0}?', $feedbackQuestion->id)]) ?>
        <?php } ?>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
    </table>
    </div>
</div>
</div>
</div>
