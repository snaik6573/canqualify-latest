	<?php 		
	if(isset($regions)) {
	foreach ($regions as $r) { 
	if(!empty($r->sites)) { ?>
	<div class="card">
		<div class="card-header clearfix">
			<strong><?= h($r->name) ?></strong>		
		</div>
		<div class="card-body card-block">
		<table class="table table-responsive">
		  <tr>
			<th scope="col"><?= __('Name') ?></th>					
			<th scope="col"><?= __('City') ?></th>
			<?php if($activeUser['role_id'] == SUPER_ADMIN) { ?>
			<th scope="col" class="actions text-center"><?= __('Actions') ?></th>
			<?php } ?>
		  </tr>
		</thead>
		<?php foreach ($r->sites as $s): ?>
		<tr>				
			<td><?= h($s->name) ?></td>
			<td><?= h($s->city) ?></td>
			<?php if($activeUser['role_id'] == SUPER_ADMIN) { ?>
			<td class="actions text-right">
				<?= $this->Form->postLink(__('Delete'), ['controller'=>'Clients', 'action'=>'sitesdelete', $s->id], ['class'=>'btn btn-primary btn-sm ajaxDelete'],['confirm'=>__('Are you sure you want to delete # {0}?', $s->id)]) ?>
			</td>
			<?php } ?>
		</tr>
		<?php endforeach; ?>
		</table>
		</div>
	</div>
	<?php 
	}
	}
	}
	if(isset($sites)) { ?>
	<div class="card">
		<div class="card-header clearfix">
			<strong>Sites</strong>		
		</div>
		<div class="card-body card-block">
		<table class="table table-responsive">
		  <tr>
			<th scope="col"><?= __('Name') ?></th>					
			<th scope="col"><?= __('City') ?></th>	
			<?php if($activeUser['role_id'] == SUPER_ADMIN) { ?>
			<th scope="col" class="actions text-center"><?= __('Actions') ?></th>
			<?php }?>
		  </tr>
		</thead>	
		<?php 	
		foreach ($sites as $s): ?>
		<tr>					
			<td><?= h($s->name) ?></td>
			<td><?= h($s->city) ?></td>
			<?php if($activeUser['role_id'] == SUPER_ADMIN) { ?>
			<td class="actions text-right">			
			<?= $this->Form->postLink(__('Delete'), ['controller' => 'Clients', 'action' => 'sitesdelete', $s->id], ['class'=>'btn btn-primary btn-sm ajaxDelete'],['confirm' => __('Are you sure you want to delete # {0}?', $s->id)]) ?>
			</td>
			<?php } ?>
		</tr>
		<?php endforeach; ?>
		</table>
		</div>
	</div>
	<?php 
	}
	?>
