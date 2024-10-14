
    <div class="card">
        <div class="card-header">
            <h4>Supplier Registration</h4>
        </div>
        <div class="card-body">
            <div id="chart-supplier-registration"></div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4>Reports</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <div class="d-flex align-items-center">
                        <h5 class="mb-0 ms-3"><?= $this->Html->link(__('Compliance'), ['controller' => 'Clients', 'action' => 'complianceReport']) ?></h5>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="d-flex align-items-center">
                        <h5 class="mb-0 ms-3"><?= $this->Html->link(__('Supplier'), ['controller' => 'Clients', 'action' => 'supplierReport']) ?></h5>
                    </div>
                </div>
            </div>
        </div>

    </div>
    
    <div class="card watch-list">
    <div class="card-header">
        <h4>My Watch List</h4>
    </div>
    <div class="card-content pb-4">
        <?php
        if(!empty($watchList) && count($watchList) > 0) {
            foreach ($watchList as $supplier){
                ?>
                <div class="recent-message d-flex px-4 py-3">
                   <div class="overall-status <?= !empty($supplier->icon) ? 'overall-status-'.$supplier->icon : ''?>">
                    <?php
                    //if(!empty($supplier->company_logo))
                        //echo $this->Html->image($uploaded_path.$supplier->company_logo);
                    ?>
                       <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-circle-fill" viewBox="0 0 16 16">
                           <circle cx="8" cy="8" r="8"/>
                       </svg>

                   </div>
                    <div class="name ms-4">
                        <h5 class="mb-1">
                            <?= $this->Html->link(!empty($supplier->company_name) ? $supplier->company_name : '', ['controller'=>'Contractors', 'action'=>'dashboard', $supplier->contractor_id]); ?>
                        </h5>
                        <div class="watch-list-waitingon">Waiting On: <h6 class="text-muted mb-0"><?= !empty($waiting_on[$supplier->waiting_on]) ? $waiting_on[$supplier->waiting_on] : ''?></h6></div>
                    </div>
                </div>
                <?php
            }
        }else{
            echo '<span>No Suppliers on watch list.</span>';
        }
        if(!empty($watchListCount) && $watchListCount > 3){
            ?>
            <div class="px-4">
                <?= $this->Form->create(null,['id'=>'frm-watch-list','url' => ['controller'=>'Contractors','action' => 'contractorList']]) ?>
                <?= $this->Form->control('watch_list', ['type'=>'hidden', 'value'=>1]); ?>

                <button class='btn btn-block btn-xl btn-light-primary font-bold mt-3'>View More</button>
                <?= $this->Form->end() ?>
            </div>
            <?php
        }
        ?>

    </div>
</div>



