<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EmailWizard $emailWizard
 */
?>
<div class="row notes">
<div class="col-lg-9">
<div class="card shadow  bg-white rounded">
    <div class="card-header">
     <?= h($emailTemplates->name) ?>
    </div>
    <div class="card-body card-block">
    <table class="table">
    <tr>
        <th scope="row"><?= __('Template Name') ?></th>
        <td><?= h($emailTemplates->name) ?></td>
    </tr>
    <tr>
        <th scope="row"><?= __('Content') ?></th>
        <td><?= $emailTemplates->template_content ?></td>
    </tr>
  
  
    </table>
    </div>
</div>
</div>

</div>
