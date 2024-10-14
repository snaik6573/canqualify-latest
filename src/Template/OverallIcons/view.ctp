<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\OverallIcon $overallIcon
 */
?>
<div class="row overallIcons">
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<!--<?= h($overallIcon->id)  ?>-->
       <?php  if($overallIcon->review) {
			echo '<b>Review : </b>CanQualify';
		} else {
             if($overallIcon->has('client')) {
			    echo '<b>Force Changed : </b>'. $overallIcon->client->company_name;
            }
		}?>
	</div>
	<div class="card-body card-block">
	<table class="table">		
        <tr>
            <th scope="row"><?= __('Client') ?></th>
            <td><?= $overallIcon->has('client') ? $this->Html->link($overallIcon->client->company_name, ['controller' => 'Clients', 'action' => 'view', $overallIcon->client->id]) : '' ?></td>
        </tr>
		<tr>
            <th scope="row"><?= __('Contractor') ?></th>
            <td><?= $overallIcon->has('contractor') ? $this->Html->link($overallIcon->contractor->company_name, ['controller' => 'Contractors', 'action' => 'view', $overallIcon->contractor->id]) : '' ?></td>
        </tr>       
        <tr>
            <th scope="row"><?= __('Icon') ?></th>
            <td><?= h($overallIcon->icon) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Category') ?></th>
            <?php  ?>
            <td><?php if(!empty($overallIcon->benchmark_category)) {
                    echo h($overallIcon->benchmark_category->name); } ?>
            </td>           
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($overallIcon->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($overallIcon->created) ?></td>
        </tr>
       <!--
         <tr>
            <th scope="row"><?= __('Bench Type') ?></th>
            <td><?= h($overallIcon->bench_type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created By') ?></th>
            <td><?= $this->Number->format($overallIcon->created_by) ?></td>
        </tr>
         <tr>
            <th scope="row"><?= __('Modified By') ?></th>
            <td><?= $this->Number->format($overallIcon->modified_by) ?></td>
        </tr>        
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($overallIcon->modified) ?></td>
        </tr>-->
        <tr>
            <th scope="row"><?= __('Is Forced') ?></th>
            <td><?= $overallIcon->is_forced ? __('Yes') : __('No'); ?></td>
        </tr>
         <tr>
            <th scope="row"><?= __('Is Review') ?></th>
            <td><?= $overallIcon->review ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Show To Contractor') ?></th>
            <td><?= $overallIcon->show_to_contractor ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Show To Clients') ?></th>
            <td><?= $overallIcon->show_to_clients ? __('Yes') : __('No'); ?></td>
        </tr>
	</table>
    <!--<div class="row">
        <h4><?= __('Documents') ?></h4>
        <?= $this->Text->autoParagraph(h($overallIcon->documents)); ?>
    </div>
    <div class="row">
        <h4><?= __('Notes') ?></h4>
        <?= $this->Text->autoParagraph(h($overallIcon->notes)); ?>
    </div>-->
	</div>
</div>
</div>
<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<?= __('Notes') ?>
	</div>
	<div class="card-body card-block" style="padding:15px 15px 15px 25px;">
	<?= html_entity_decode($overallIcon->notes)?>		
	</div>
</div>
</div>
</div>
