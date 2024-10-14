<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Client[]|\Cake\Collection\CollectionInterface $clients
 */
use Cake\Core\Configure;
?>
<div class="row clients">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <strong class="card-title"><?= __('Suppliers Pending for Review') ?></strong>
            </div>
            <div class="card-body table-responsive">
                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th scope="col"><?= h('Supplier') ?></th>
                        <th scope="col"><?= h('Client') ?></th>
                        <th scope="col"><?= h('Waiting On') ?></th>
                        <th scope="col" class="actions"><?= __('Actions') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($pendingContractors as $pendingContractor){ ?>
                        <tr>
                                <td><?php echo !empty($pendingContractor['company_name']) ? $pendingContractor['company_name'] : ''; ?></td>
                                <td><?php echo !empty($pendingContractor['client_company_name']) ? $pendingContractor['client_company_name'] : ''; ?></td>
                                <td><?php echo !empty($waiting_on[$pendingContractor['waiting_on']]) ? $waiting_on[$pendingContractor['waiting_on']] : ''; ?></td>
                                <td><?php
                                    if(!empty($pendingContractor['waiting_on']) && $pendingContractor['waiting_on'] == 2)
                                    {
                                        echo $this->Html->link(__('Review'), ['controller'=>'OverallIcons', 'action'=>'forceChangeAdmin', $pendingContractor['client_id'], $pendingContractor['contractor_id'], 1,1], ['title'=>'Review']);
                                    }
                                    ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
