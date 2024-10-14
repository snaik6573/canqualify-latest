<div class="row employees">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header clearfix">
                <strong class="card-title pull-left"><?= __('Redundant Employees') ?></strong>
            </div>
            <div class="card-body table-responsive">
            <?php
            if(!empty($empList)){
                ?>

                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                <thead>
	            <tr>
		           <th scope="col"><?= h('Username') ?></th>
		           <th scope="col"><?= h('Role') ?></th>
                <th scope="col" class="noExport actions"><?= __('Actions') ?></th>
                </tr>
                </thead>
            <?php
                foreach ($empList as $r_emp){
                    echo '<tr>';
                        echo '<td>';
                        echo !empty($r_emp['username']) ? $r_emp['username'] : '';
                        echo '</td>';
                        echo '<td>';
                        if(!empty($r_emp['role_id']) && $r_emp['role_id'] > 0)
                            echo !empty($roles[$r_emp['role_id']]) ? $roles[$r_emp['role_id']] : '';
                        echo '</td>';
                        echo '<td>'.$this->Form->postLink('<i class="fa fa-trash-o"></i>', ['action' => 'deleteUser', $r_emp['user_id']], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # {0}?', $r_emp['user_id'])]).'</td>';
                    echo '</tr>';
                }
                echo '</table>';
            }
            ?>
            </div>
        </div>
    </div>
</div>
