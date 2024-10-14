<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\NaicCode $naicCode
 */
?>
<div class="row naicCodes">
<div class="col-lg-6">
<div class="card">
    <div class="card-header">
        <?= h($naicCode->title) ?>
    </div>
    <div class="card-body card-block">
    <table class="table">
        <tr>
            <th scope="row"><?= __('Title') ?></th>
            <td><?= h($naicCode->title) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($naicCode->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Naisc Code') ?></th>
            <td><?= $this->Number->format($naicCode->naic_code) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($naicCode->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($naicCode->modified) ?></td>
        </tr>
    </table>
    </div>
</div>
</div>
</div>

