<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CanqYear[]|\Cake\Collection\CollectionInterface $canqYears
 */
?>
<div class="row canqYears">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong class="card-title"><?= __('Years') ?></strong>
	</div>
	<div class="card-body table-responsive">
	<table id="bootstrap-data-table-export" class="table table-bordered">
	<thead>
	<tr>
	    <th scope="col"><?= h('id') ?></th>
	    <th scope="col"><?= h('year') ?></th>
	    <th scope="col"><?= h('status') ?></th>
	    <th scope="col" class="actions"><?= __('Actions') ?></th>
	</tr>
        </thead>
        <tbody>
	<?php foreach ($canqYears as $canqYear): ?>			
	<tr>			
	    <td><?= $this->Number->format($canqYear->id) ?></td>
	    <td><?= h($canqYear->year) ?></td>
	    <td><?= h($canqYear->status) ?></td>
	    <td class="actions">
			<div class="form-actions form-group">				
			<?= $this->Form->create($canqYear) ?>
			<?php if($canqYear->status == 'start') {
				echo $this->Form->control('year', ['type'=>'hidden','value'=>$canqYear->year]);
				echo $this->Form->control('status', ['type'=>'hidden','value'=>$canqYear->status]);
				echo $this->Form->button('Archive '.$canqYear->year, ['type' => 'submit', 'class'=>'btn btn-primary btn-sm']);
			}
			elseif($canqYear->status == 'end') {
				$rollOutYear = $canqYear->year + 1;
				echo $this->Form->control('current_year', ['type'=>'hidden','value'=>$canqYear->id]);
				echo $this->Form->control('year', ['type'=>'hidden','value'=>$rollOutYear]);
				echo $this->Form->control('status', ['type'=>'hidden','value'=>$canqYear->status]);
				echo $this->Form->button('Rollout '.$rollOutYear, ['type' => 'submit', 'class'=>'btn btn-primary btn-sm']);
			} ?>
			<?= $this->Form->end() ?>
			</div>
	        </td>			
	</tr>			
	<?php endforeach; ?>
        </tbody>
    	</table>	
	</div>
</div>
</div>   
</div>
