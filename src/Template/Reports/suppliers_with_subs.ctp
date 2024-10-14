<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Client[]|\Cake\Collection\CollectionInterface $clients
 */ 
use Cake\Core\Configure;
$iconList = Configure::read('icons'); //, array('0'=>'Grey','1'=>'Red','2'=>'Yellow','3'=>'Green')
$users = array(CLIENT_VIEW, CLIENT_BASIC);
$uploaded_path = Configure::read('uploaded_path');
?>
<div class="row clients">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong class="card-title"><?= __('Suppliers Subcontractors Report') ?></strong>
		<span class="pull-right"><?= $this->Html->link(__('Export to Excel'), ['controller' => 'Reports', 'action' => 'suppliersWithSubs/excel/'.$client_id],['class'=>'mr-2']) ?> </span>
		<span class="pull-right"><?= $this->Html->link(__('Export to CSV'), ['controller' => 'Reports', 'action' => 'suppliersWithSubs/csv/'.$client_id],['class'=>'mr-2']) ?>&nbsp;&nbsp;|&nbsp;&nbsp;</span>

	</div>
	<div class="card-body table-responsive">
	<table id="bootstrap-data-table" class="table table-striped table-bordered" data-order="[[ 1, &quot;asc&quot; ]]">
	<thead>
	<tr>
		<th scope="col"><?= h('Status') ?></th>
		<th scope="col"><?= h('Contractor Name') ?></th>
		<th scope="col"><?= h('Active') ?></th>
		<th scope="col"><?= h('Primary Contact') ?></th>
		<th scope="col"><?= h('Phone') ?></th>
		<th scope="col"><?= h('Email') ?></th>
		<th scope="col"><?= h('Using Subs?') ?></th>
		<th scope="col"><?= h('Total Subs') ?></th>
		<th scope="col"><?= h('List of Subs') ?></th>
	</tr>
	</thead>
	<tbody>
	<?php
	foreach ($supplierList as $contractor):

	?>
	<tr>
		<?php
		$iconStatus = '';
		if(isset($contractor['icon'])) {
			$iconStatus = '<span style="display:none;">'.$contractor['icon'].'</span><i class="fa fa-circle color-'.$contractor['icon'].'"></i><span style="display:block;">'.$iconList[$contractor['icon']].'</span>';
		}
		?>
		<td class="text-center"><?= $iconStatus; ?></td>
		<td><?= $this->Html->link($contractor['company_name'], ['controller' => 'Contractors','action' => 'dashboard', $contractor['contractor_id']],['escape'=>false, 'title' => 'View']) ?></td>
		<td><?= h($contractor['active']) == 1 ? 'Yes' : ''; ?></td>
		<td><?= h($contractor['pri_contact_fn'].' '.$contractor['pri_contact_ln']); ?></td>
		<td><?= h($contractor['pri_contact_pn']) ?></td>
		<td><?= h($contractor['username']); ?></td>
		<td><?= h($contractor['using_subs']); ?></td>
		<td><?= h($contractor['total_subs']); ?></td>
        <td>
            <?php
                if(!empty($contractor['subs_file'])){
                    echo '<a href="'.$uploaded_path.$contractor['subs_file'].'" target="_Blank">'.$contractor['subs_file'].'</a>';
                }
            ?>
        </td>
    </tr>
	<?php endforeach; ?>
	</tbody>
	</table>
	</div>
</div>
</div>
</div>