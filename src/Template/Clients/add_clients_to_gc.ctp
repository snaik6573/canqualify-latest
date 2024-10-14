<div class="row clients">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <strong>Associate client to GC</strong> Client
            </div>

            <div class="card-body card-block">
                <?php
                echo $this->Form->create(null, ['url'=> ['action'=>'addClientsToGc']]);
                echo $this->Form->control('gc_client_id', ['options'=>$GC_clients, 'empty'=>true, 'class'=>'form-control', 'label'=>'Select GC']);
                echo $this->Form->control('parent_client_id', ['options'=>$clients, 'empty'=>true, 'class'=>'form-control', 'label'=>'Select Parent Client']);
                echo $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Add', ['type'=>'submit', 'class'=>'btn btn-success mt-2']);
                echo $this->Form->end();
                //debug($GC_clients);
                //debug($clients);
                ?>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <strong>Existing Client-GC Associations</strong> Client
            </div>

            <div class="card-body card-block">
                <?php
                if(!empty($allAssoc)){
                    echo '<table class="table table-striped table-bordered">';
                        echo '<thead>';
                            echo '<tr>';
                                echo '<th>General Contractor</th>';
                                echo '<th>Client</th>';
                                echo '<th>Action/s</th>';
                            echo '</tr>';
                        echo '</thead>';
                        echo '<tbody>';
                        foreach ($allAssoc as $key => $association){
                            echo '<tr>';
                            echo '<td>'.$association['gc'].'</td>';
                            echo '<td>'.$association['parent'].'</td>';
                            echo '<td>'.$this->Html->link('Delete', ['controller' => 'Clients', 'action' => 'removeClientsToGc',$association['id']]).'</td>';
                            echo '</tr>';
                        }
                        echo '</tbody>';
                    echo '</table>';
                }else{
                    echo 'No Associations to list here';
                }
                ?>
            </div>
        </div>
    </div>
</div>