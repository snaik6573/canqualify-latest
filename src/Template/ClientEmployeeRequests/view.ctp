<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ClientEmployeeRequest $clientEmployeeRequest
 */
?>
<div class="row clientEmployeeRequest">
<div class="col-lg-6">
<div class="card">
    <div class="card-header">
        <?= h('Client Request') ?>
    </div>
    <div class="card-body card-block">
    <table class="table">
    <tr>
        <th scope="row"><?= __('Client') ?></th>
        <td><?= $clientEmployeeRequest->has('client') ? $clientEmployeeRequest->client->company_name : '' ?></td>
    </tr>
    <tr>
        <th scope="row"><?= __('Status') ?></th>
        <td><?= $this->Number->format($clientEmployeeRequest->status) ?></td>
    </tr>
    <tr>
        <th scope="row"><?= __('Created By') ?></th>
        <td><?= $this->Number->format($clientEmployeeRequest->created_by) ?></td>
    </tr>
    <tr>
        <th scope="row"><?= __('Modified By') ?></th>
        <td><?= $this->Number->format($clientEmployeeRequest->modified_by) ?></td>
    </tr>
    <tr>
        <th scope="row"><?= __('Created') ?></th>
        <td><?= h($clientEmployeeRequest->created) ?></td>
    </tr>
    <tr>
        <th scope="row"><?= __('Modified') ?></th>
        <td><?= h($clientEmployeeRequest->modified) ?></td>
    </tr>
    </table>
    </div>
</div>
</div>

<div class="col-lg-6">
<div class="card">
    <div class="card-header">
        <?= __('Subject') ?>
    </div>
    <div class="card-body card-block">
        <?= h($clientEmployeeRequest->subject) ?>
    </div>

    <div class="card-header">
        <?= __('Message') ?>
    </div>
    <div class="card-body card-block">
        <?= h($clientEmployeeRequest->message) ?>
    </div>
</div>
</div>

</div>
