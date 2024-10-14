<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Client[]|\Cake\Collection\CollectionInterface $clients
 */
use Cake\Core\Configure;
?>
<style>
    #bootstrap-data-table  tr td{
        text-align: center;
    }
    </style>
<div class="row clients">
    <div class="col-lg-12">
        <div class="card">

            <div class="card-body table-responsive">

                <table id="bootstrap-data-table" class="table table-striped table-bordered" data-order="[[ 1, &quot;asc&quot; ]]">
                    <thead>
                    <tr>
                        <th scope="col">
                            <?= h('Status') ?>
                        </th>
                        <th scope="col">
                            <?= h('Contractor name') ?>
                        </th>
                        <th scope="col">
                            <?= h('primary Contact') ?>
                        </th>
                        <th scope="col">
                            <?= h('Safety') ?>
                        </th>
                        <?php if($hasEmployeeQual) { ?>
                            <th scope="col">
                                <?= h('EmployeeQual') ?>
                            </th>
                        <?php } ?>
                        <th scope="col">
                            <?= h('Member Since') ?>
                        </th>
                        <th scope="col">
                            <?= h('Risk Level') ?>
                        </th>
                            <th scope="col" class="noExport">
                                <?= h('Actions') ?>
                            </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($contList as $contractor){
                     ?>
                        <tr>
                            <td scope="col" data-order="<?= (isset($contractor['icon'])) ? $contractor['icon'] : '';?>">
                                <?php
                                    $iconStatus = (isset($contractor['icon']))? '<i class="fa fa-circle color-'.$contractor['icon'].'"></i>' : '';
                                ?>
                                <?= $iconStatus; ?>
                            </td>
                            <td scope="col">
                                <?= $this->Html->link($contractor['company_name'], ['controller' => 'Contractors','action' => 'dashboard', $contractor['contractor_id']],['escape'=>false, 'title' => 'View']) ?>
                            </td>
                            <td scope="col">
                                <?= $contractor['pri_contact_fn']. ' ' . $contractor['pri_contact_ln']; ?>
                                <br />
                                <?= $contractor['pri_contact_pn']; ?>
                                <br />
                                <?= $contractor['username']; ?>
                            </td>
                            <td scope="col">
                                <?= $this->Html->link(__('<i class="fa fa-eye"></i>'), ['controller'=>'ContractorAnswers', 'action'=>'safety_report/', 0, $contractor['contractor_id']], ['class'=>'ajaxmodal', 'data-toggle'=>'modal', 'data-target'=>'#scrollmodal', 'escape'=>false, 'title'=>'Safety Report']) ?>
                            </td>
                            <td scope="col">
                                <?php if($hasEmployeeQual) { ?>
                                    <?= $this->Html->link(__('<i class="fa fa-eye"></i>'), ['controller'=>'Employees', 'action'=>'index/', 0, $contractor['contractor_id']], ['escape'=>false, 'title'=>'Employees']) ?>
                                <?php } ?>
                            </td>
                            <td data-order="<?= !empty($contractor['registration_date']) ? date('Ymd', strtotime($contractor['registration_date']))  : '' ?>">
                                <?= !empty($contractor['registration_date']) ? date('m/d/Y', strtotime($contractor['registration_date']))  : '' ?>
                            </td>
                            <td scope="col">
                                <?= $contractor['risk_level']; ?>
                            </td>
                            <td scope="col" class="noExport">
                                <?php
                                if(isset($allowForceChange)) {
                                    echo $this->Html->link(__('Force Icon'), ['controller'=>'OverallIcons', 'action'=>'force-change', $contractor['client_id'], $contractor['contractor_id']], ['class'=>'ajaxmodal', 'data-toggle'=>'modal', 'data-target'=>'#scrollmodal2']);
                                }
                                ?>
                            </td>
                    </tr>

                     <?php    } ?>

                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>

<!-- safety report popup-->
<div class="modal fade" id="scrollmodal" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Safety Report</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>

<!-- force icon popup-->
<div class="modal fade" id="scrollmodal2" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Force Change Icon Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>
