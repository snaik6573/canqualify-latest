<?php
//debug($notes);
?>

<div class="row">
    <div class="col-12">
        <h6>Notes on Your Suppliers</h6>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <?php if($activeUser['role_id']==SUPER_ADMIN || $activeUser['role_id']==ADMIN || $activeUser['role_id']==CLIENT || $activeUser['role_id']==CLIENT_ADMIN) { ?>
                        <span class="pull-right"><?= $this->Html->link(__('Add New'), ['controller' => 'Notes', 'action' => 'add'],['class'=>'btn btn-success btn-sm']) ?> </span>
                    <?php }
                    if (!in_array($activeUser['role_id'], array(CLIENT, CLIENT_BASIC, CLIENT_VIEW, CLIENT_ADMIN))){
                        ?>
                        <span class="pull-right"><?= $this->Html->link(__('Completed Follow Ups'), ['controller' => 'Notes', 'action' => 'ContractorNotes', 1],['class'=>'btn btn-default btn-sm']) ?></span>
                        <?php
                    } ?>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="clientNotes">
                        <thead>
                        <tr>
                            <th>Supplier</th>
                            <th>Subject</th>
                            <th>Note By</th>
                            <th>Action</th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        //debug($recentMessages);
                        if (!empty($notes) && count($notes) > 0){
                            foreach ($notes as $note)
                            {
                                ?>
                                <tr>
                                    <td class="col-3">
                                        <div class="d-flex">
                                            <div class="overall-status <?= !empty($note['icon']) ? 'overall-status-' . $note['icon'] : '' ?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                     fill="currentColor" class="bi bi-circle-fill"
                                                     viewBox="0 0 16 16">
                                                    <circle cx="8" cy="8" r="8"/>
                                                </svg>

                                            </div>
                                            <p class="font-bold ms-3 mb-0">
                                                <?= $this->Html->link($note['company_name'], ['controller'=>'Contractors', 'action'=>'dashboard', $note['contractor_id']]); ?>
                                            </p>
                                        </div>
                                    </td>
                                    <td class="col-auto">
                                        <p class=" mb-0"><?= $note['subject'] ?></p>
                                    </td>
                                    <td class="col-auto">
                                        <p class=" mb-0">
                                            <?php
                                            if(!in_array($note['role_id'], array(1,4,9,11)))
                                                echo $note['first_name'].' '.$note['last_name']."<br />";
                                            echo $note['user_company_name'];
                                            ?>
                                        </p>
                                    </td>
                                    <td>
                                        <?= $this->Html->link('View', ['action' => 'view', $note->id],['escape'=>false, 'title' => 'View']) ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        else{
                            echo '<tr><td colspan="2">No messages found.</td></tr>';
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </section>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('#clientNotes').DataTable();

    });
</script>