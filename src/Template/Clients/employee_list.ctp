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
			<?= $this->Html->link(__('Export to Excel'), ['controller' => 'Clients', 'action' => 'employeeList/excel'],['class'=>'mr-2']) ?> </span>
		<span class="pull-right"><?= $this->Html->link(__('Export to CSV'), ['controller' => 'Clients', 'action' => 'employeeList/csv'],['class'=>'mr-2']) ?> </span>

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
        <th scope="col"><?= h('Training Type') ?></th>
        <!--<th scope="col"><?= h('Work Locations') ?></th>-->
        <th scope="col"><?= h('Status') ?></th>
        <th scope="col"><?= h('Completion Date') ?></th>
        <th scope="col"><?= h('Expiration Date') ?></th>
	</tr>	
	</thead>
	<tbody>
	<?php 
	foreach ($employeeList as $emp): ?>	
			<?php
			$iconStatus = ''; 
			
			if(!empty($emp['icon'])) {
				$iconStatus = '<span style="display:none;">'.$emp['icon'].' - '.$iconList[$emp['icon']].'</span><i class="fa fa-circle color-'.$emp['icon'].'"></i>';
			}
			?>
        	<tr class="filter <?= empty($emp['percentage'])? "" : $emp['percentage']; ?>">
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
                <td><?= empty($emp['training']) ? "" : $emp['training']; ?></td>
                <!--<td><?= empty($emp['employee_sites']) ? "" : $emp['employee_sites']; ?></td>-->
                <td><?= empty($emp['percentage'])? "" : $emp['percentage']; ?></td>
                <td><?= ( !empty($emp['completed_on'])) ? $emp['completed_on'] : ''; ?></td>
                <td><?=  ( !empty($emp['expires_on']))  ? $emp['expires_on']  : '';  ?></td>
       		</tr>
	<?php
	endforeach; ?>
	</tbody>
	</table>
	</div>
</div>
</div>
</div>

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
