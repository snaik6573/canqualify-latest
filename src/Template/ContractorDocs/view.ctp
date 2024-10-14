<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContractorDoc $contractorDoc
 */
?>
<div class="contractorDocs view large-9 medium-8 columns content">
    <h3><?= h($contractorDoc->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Forms N Doc') ?></th>
            <td><?= $contractorDoc->has('forms_n_doc') ? $this->Html->link($contractorDoc->forms_n_doc->name, ['controller' => 'FormsNDocs', 'action' => 'view', $contractorDoc->forms_n_doc->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Client') ?></th>
            <td><?= $contractorDoc->has('client') ? $this->Html->link($contractorDoc->client->id, ['controller' => 'Clients', 'action' => 'view', $contractorDoc->client->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Contractor') ?></th>
            <td><?= $contractorDoc->has('contractor') ? $this->Html->link($contractorDoc->contractor->id, ['controller' => 'Contractors', 'action' => 'view', $contractorDoc->contractor->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($contractorDoc->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created By') ?></th>
            <td><?= $this->Number->format($contractorDoc->created_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified By') ?></th>
            <td><?= $this->Number->format($contractorDoc->modified_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($contractorDoc->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($contractorDoc->modified) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Document') ?></h4>
        <?= $this->Text->autoParagraph(h($contractorDoc->document)); ?>
    </div>
</div>
