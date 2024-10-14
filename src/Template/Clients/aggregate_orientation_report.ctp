<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Employee[]|\Cake\Collection\CollectionInterface $employees
 */
use Cake\Core\Configure;
$iconList = Configure::read('icons');
?>
<div class="row employees">
<div class="col-lg-12">
<div class="card">
	<div class="card-header clearfix">
		<strong class="card-title pull-left"><?= __('Employees Orientation Status') ?></strong>
		<span class="pull-right">&nbsp;|&nbsp;
			<?= $this->Html->link(__('Export to Excel'), ['controller' => 'Clients', 'action' => 'aggregateOrientationReport/excel'],['class'=>'mr-2']) ?> </span>
		<span class="pull-right"><?= $this->Html->link(__('Export to CSV'), ['controller' => 'Clients', 'action' => 'aggregateOrientationReport/csv'],['class'=>'mr-2']) ?> </span>

	</div>
	<div class="card-body table-responsive">
	<table id="bootstrap-data-table" class="table table-striped table-bordered">		
	<thead>
    <!--<tr>
        <td colspan="6">
            <div>Show:
                <select id="status">
                    <option value="All">All</option>
                    <option value="Complete">Complete</option>
                    <option value="Incomplete">Incomplete</option>
                </select>
            </div>
        </td>
    </tr>-->
	<tr>
        <th scope="col"><?= h('Supplier Name') ?></th>
        <th scope="col"><?= h('Employee') ?></th>
        <th scope="col"><?= h('Status') ?></th>
	</tr>
	</thead>
	<tbody>
	<?php 
	foreach ($employeeList as $emp): ?>
        	<tr class="filter">
                <td><?= isset($emp['contractor_name']) ? $emp['contractor_name'] : ' '; ?></td>
                <td>
                    <?php
                    if(isset($emp['emp_name'])){
                        if(isset($emp['employee_id']) && isset($emp['contractor_id'])){
                            echo $this->Html->link(h($emp['emp_name']), ['controller'=>'Employees', 'action' => 'dashboard', $emp['employee_id'],$emp['contractor_id']],['escape'=>false, 'title' => '']);
                        }else{
                            echo $emp['emp_name'];
                            }
                    }
                    ?>
                </td>
                <td class="<?= empty($emp['percentage'])? "" : $emp['percentage']; ?>"><?= empty($emp['percentage'])? "" : $emp['percentage']; ?></td>
       		</tr>
	<?php
	endforeach; ?>
	</tbody>
	</table>
	</div>
</div>
</div>
</div>
<style>
    .Complete{
        color: #01A535;
    }
    .Incomplete{
        color: #F75431;
    }
</style>
<script>


   /* $(document).ready(function () {
        jQuery('.Incomplete').hide();
        jQuery('#status').val('Complete');

        jQuery('#status').change(function(){
            var filter = jQuery('#status').val();

            jQuery('.filter').hide();
            switch(filter){
                case 'Complete':
                case 'Incomplete': jQuery('.' + filter).show();break;
                case 'All': jQuery('.filter').show();
            }

        });
    });*/
</script>
