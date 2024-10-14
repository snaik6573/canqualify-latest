<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CampaignContactList $campaignContactList
 */
?>
<div class="row">
<div class="col-lg-12">
    <div class="card shadow  bg-white rounded">
        <div class="card-header ">Supplier List </div>
        <div class="card-body table-responsive">
            <?php if(!empty($contList)) { ?>
            <table id="bootstrap-data-table" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th></th>
                        <th scope="col">
                            <?= h('Status') ?>
                        </th>
                        <th scope="col">
                            <?= h('Supplier name') ?>
                        </th>
                        <th scope="col">
                            <?= h('Active') ?>
                        </th>
                        <th scope="col">
                            <?= h('primary Contact') ?>
                        </th>
                        <th scope="col">
                            <?= h('Phone') ?>
                        </th>
                        <th scope="col">
                            <?= h('Email') ?>
                        </th>
                        <th scope="col">
                            <?= h('EmployeeQual') ?>
                        </th>
                        <?php if($activeUser['role_id'] == SUPER_ADMIN) { ?>
                        <th scope="col">
                            <?= h('Paid') ?>
                        </th>
                        <?php } ?>

                        <th scope="col">
                            <?= h('Member Since') ?>
                        </th>
                     <!--    <th scope="col">
                            <?= h('Subscription End Date') ?>
                        </th>
                        <th scope="col">
                            <?= h('Subscription') ?>
                        </th> --> 
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($contList as $key => $contractor) {  ?>
                    <tr>
                        <td><?php echo $this->Form->checkbox('contractor_id', ['type'=>'hidden','required'=>false, 'label'=>false,'id'=>'cont-id','value'=>$contractor['id'],'checked']); ?></td>
                        <?php 
        $iconStatus = ''; 
        if(!empty($contractor['icons'])) {
            $iconStatus = '<span style="display:none;">'.$contractor['icons'].' - '.$iconList[$contractor['icons']].'</span><i class="fa fa-circle color-'.$contractor['icons'].'"></i>';
        }
        ?>
                        <td class="text-center">
                            <?= $iconStatus; ?>
                        </td>
                        <td>
                            <?= $this->Html->link($contractor['company_name'], ['controller' => 'Contractors','action' => 'dashboard', $contractor['id']],['escape'=>false, 'title' => 'View']) ?>
                        </td>
                        <td>
                            <?= h($contractor['active']) == 1 ? 'Yes' : ''; ?>
                        </td>
                        <td>
                            <?= h($contractor['pri_contact_fn'].' '.$contractor['pri_contact_ln']); ?>
                        </td>
                        <td>
                            <?= h($contractor['pri_contact_pn']) ?>
                        </td>
                        <td>
                            <?= h($contractor['username']); ?>
                        </td>
                        <td class="text-center">
                            <?= $this->Html->link(__('<i class="fa fa-eye"></i>'), ['controller'=>'ContractorAnswers', 'action'=>'safety_report/', 0, $contractor['id']], ['class'=>'ajaxmodal', 'data-toggle'=>'modal', 'data-target'=>'#scrollmodal', 'escape'=>false, 'title'=>'Safety Report']) ?>
                        </td>
                        <?php if($activeUser['role_id'] == SUPER_ADMIN) { ?>
                        <td>
                            <?= $contractor['payment_status'] ? __('Yes') : __('No'); ?>
                        </td>
                        <?php } ?>
                        <td>
                            <?= !empty($contractor['payment']) ? date('m/d/Y', strtotime($contractor['payment']))  : '' ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
                    <div class="form-actions form-group">
                    <?= $this->Form->control('name', ['type'=>'hidden','class'=>'list-name','id'=>'list-name','value'=>$name]); ?>
                     <?= $this->Form->control('id', ['type'=>'hidden','class'=>'list-id','id'=>'list-id','value'=>$camp_id]); ?>
                    <?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Create List', ['type' => 'button', 'class'=>'btn btn-success mb-2 c-list']); ?>
                </div>
            </table>
            <?= $this->Form->end() ?>
        <?php } ?>
        <?php if(!empty($ExpriedDate)){ ?>
            <?= $this->Form->create(null,['id'=>'frm-example','url' => ['controller'=>'CampaignContactLists','action' => 'add']]) ?>
                <table id="bootstrap-data-table" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th></th>
                        <th scope="col"><?= h('Supplier Company Name'); ?></th>
                        <th scope="col"><?= h('Policy Name'); ?></th>
                        <th scope="col"><?= h('Policy Expiration Date'); ?></th>
                        <th scope="col"><?= h('Year'); ?></th>
                        <th scope="col"><?= h('Status'); ?></th> 
                        <!-- <th scope="col"><?= h('Policy Effective Date'); ?></th>  -->
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ExpriedDate as  $v) {  ?>
                    <tr>
                         <td><?php echo $this->Form->checkbox('contractor_id', ['type'=>'hidden','required'=>false, 'label'=>false,'id'=>'cont-id','value'=>$v['contractor']->id,'checked']); ?>
                        <td><?= $this->Html->link($v['contractor']->company_name, ['controller' => 'Contractors', 'action' => 'dashboard',$v['contractor']->id]); ?></td>
                        <td><?= h($v['question']['category']->name); ?></td> 
                        <td><?=  h($v->answer); ?></td>
                         <td><?=  h($v->year); ?></td>
                        <td>
                        <?php 
                         if(in_array($v->answer,$expsoonDate)){ 
                             echo "Expiring soon in upcoming 15 day's";
                         }else{
                            if(in_array($v->answer,$AlreadyExpriredDate)){
                                echo "Expired"; 
                            }
                        }  ?>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
                   <div class="form-actions form-group">
                    <?= $this->Form->control('name', ['type'=>'hidden','class'=>'list-name','id'=>'list-name','value'=>$name]); ?>
                     <?= $this->Form->control('id', ['type'=>'hidden','class'=>'list-id','id'=>'list-id','value'=>$camp_id]); ?>
                    <?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Create List', ['type' => 'button', 'class'=>'btn btn-success mb-2 c-list']); ?>
                </div>
                </table>
        <?php } ?>
        </div>
    </div>
</div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Save Campaign Contact List</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?= $this->Form->create(null, ['id'=>'createList','url' => ['controller'=>'CampaignContactLists','action' => 'edit']]) ?>
          <div class="form-group">
            <?= $this->Form->label('name', 'Contact List Name', ['class' => 'font-weight-bold']); ?>
            <?= $this->Form->control('name', ['class'=>'form-control', 'required'=>true,'label'=>false]); ?>
         </div>
        <div class="modal-footer">
             <?php if($activeUser['role_id'] == SUPER_ADMIN) {  ?>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <?php }else{ ?>
            <button type="button" class="btn" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Close</span>
            </button>
            <?php } ?>
            <?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Save List', ['type' => 'submit', 'class'=>'btn btn-success']); ?>
        </div>
       <?= $this->Form->end(); ?>
      </div>
       </div>
  </div>
</div>
<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery('.c-list-edit').on('click', function() {
            var form = jQuery('#createList');
            var selected = new Array();
            var chks = jQuery("#bootstrap-data-table-edit,#bootstrap-data-table").find("input[name='contractor_id']");
            // console.log(chks);
            for (var i = 0; i < chks.length; i++) {
                //console.log("i",i);
                if (chks[i].checked) {
                    //console.log("chcked....");
                    selected.push(chks[i].value);
                }
            }
            for (var i = 0; i < selected.length; i++) {
                // console.log(selected[i]);
            }
            // Display the selected CheckBox values.
             if (selected.length == 0) {
                alert("Please check record atlest one.")
                return;
             }
            if (selected.length > 0) {
                console.log("Selected values: " + selected.join(","));
                jQuery(form).append(
                    jQuery("<input>")
                    .attr("type", "hidden")
                    .attr("name", "suppliers_ids[]")
                    .val(selected.join(","))
                );
                // if one or more checkbox checked then modal open 
                jQuery('#exampleModal').modal('toggle');
                   
                
            }
        });
     
         var nm = jQuery('#list-name').val();
         var id = jQuery('#list-id').val();
         var url =  '/campaign-contact-lists/edit/'+id;
         jQuery('#createList').attr('action',url);
         jQuery('input[type=text]').val(nm);
 
});
</script>