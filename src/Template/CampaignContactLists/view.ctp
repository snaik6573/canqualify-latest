<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CampaignContactList $campaignContactList
 */
?>
<div class="row campaignContactList">
<div class="col-lg-9">
<div class="card shadow  bg-white rounded">
    <div class="card-header">
     <?= h($campaignContactList->name) ?>
    </div>
    <div class="card-body card-block">
    <table class="table">
    <tr>
        <th scope="row"><?= __('Contact List Name') ?></th>
        <td><?= h($campaignContactList->name) ?></td>
    </tr>
    <tr>
        <th scope="row"><?= __('Suppliers List Ids') ?></th>
        <td style="word-wrap: break-word;min-width: 160px;max-width: 160px;">
        <?= h(implode(",",$campaignContactList['suppliers_ids']['supplier_ids'] ))  ?> </td>
    </tr>
  
  
    </table>
    </div>
</div>
</div>

</div>
