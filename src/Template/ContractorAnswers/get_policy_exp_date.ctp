<div class="row PolicyExp">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong class="card-title"><?= __('Policy Expiration') ?></strong>
	</div>
	<div class="card-body table-responsive">
	<table id="bootstrap-data-table-export" class="table table-striped table-bordered">
	<thead>
		<tr>
			
			<th scope="col"><?= h('Contractor Company Name'); ?></th>
			<th scope="col"><?= h('Policy Name'); ?></th>
			<th scope="col"><?= h('Policy Expiration Date'); ?></th>
			<th scope="col"><?= h('Year'); ?></th>
			<th scope="col"><?= h('Expiration'); ?></th> 
			<!-- <th scope="col"><?= h('Policy Effective Date'); ?></th>  -->
		</tr>
	</thead>
	<tbody>
	<?php foreach ($ExpriedDate as  $v) {  ?>		
		<tr>
			<td><?= $this->Html->link($v['contractor']->company_name, ['controller' => 'Contractors', 'action' => 'dashboard',$v['contractor']->id]); ?></td>
		    <td><?= h($v['question']['category']->name); ?></td> 
		    <td><?=  h($v->answer); ?></td>
		     <td><?=  h($v->year); ?></td>
		    <td>
		    <?php 
		     if(in_array($v->answer,$expsoonDate)){ 
		    	 echo "Expiring Soon";
		     }else{
		     	echo "Expired"; 
		     }  ?>
		    </td>
		</tr>
	<?php } ?>
	</tbody>
	</table>
	</div>
</div>
</div>
</div>
