<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Contractor[]|\Cake\Collection\CollectionInterface $contractors
 */
use Cake\Core\Configure;
?>
<div class="row contractors">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <strong class="card-title"><?= __('Contractors') ?></strong>
                <span
                    class="pull-right"><?= $this->Html->link(__('Add New'), ['controller'=>'Contractors', 'action'=>'add'],['class'=>'btn btn-success btn-sm']) ?>
                </span>
                <span
                    class="pull-right"><?= $this->Html->link(__('Export to Excel'), ['controller' => 'Contractors', 'action' => 'index/excel'],['class'=>'mr-2']) ?>
                </span>
                <span
                    class="pull-right"><?= $this->Html->link(__('Export to CSV'), ['controller' => 'Contractors', 'action' => 'index/csv'],['class'=>'mr-2']) ?>
                </span>
                <!--<span class="pull-right"><?= $this->Html->link(__('File Upload'), ['controller'=>'Contractors', 'action'=>'importUsers'], ['class'=>'btn btn-success btn-sm mr-2']) ?></span>-->
            </div>
            <div class="card-body table-responsive">
                <table id="bootstrap-data-table-export1" class="table table-striped table-bordered data-table-ajax" data-order="[[ 1, &quot;asc&quot; ]]">
                    <thead>
                        <tr>
                            <th scope="col"><?= h('Contractor Name') ?></th>
                            <th scope="col"><?= h('No. of Clients') ?></th>
                            <th scope="col"><?= h('Active') ?></th>
                            <th scope="col"><?= h('Paid') ?></th>
                            <th scope="col"><?= h('Waiting On') ?></th>
                            <th scope="col"><?= h('Data Submit') ?></th>
                            <th scope="col"><?= h('Data Read') ?></th>
                            <th scope="col"><?= h('Discount') ?></th>
                            <th scope="col"><?= h('Registration Date') ?></th>
                            <th scope="col"><?= h('Payment Date') ?></th>
                            <th scope="col"><?= h('Last Update') ?></th>
                            <th scope="col" class="actions"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="12" class="dataTables_empty">Loading data from server...</td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php $show_map = Configure::read('show_map'); 
if($show_map == true) { 
?>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <strong class="card-title"><?= __('Contractors Location') ?></strong>
            </div>
            <div class="card-body">
                <script>
                var contractor_markers = <?php echo json_encode($addr) ?>;
                </script>
                <div class="map" id="map" style="width: 100%;"></div>
            </div>
        </div>
    </div>
    <?php } ?>
</div>

<div class="modal fade" id="scrollmodal" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scrollmodalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>
<script>
var dtAjaxUrl = "<?= $this->request->getRequestTarget(); ?>";
</script>