<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EmailWizards[]|\Cake\Collection\CollectionInterface $EmailWizards
 */ 
use Cake\Core\Configure;
$iconList = Configure::read('icons'); //, array('0'=>'Grey','1'=>'Red','2'=>'Yellow','3'=>'Green')
?>
<div class="row Contractors">
    <div class="col-lg-12">
        <div class="bs-example">
        <div class="accordion" id="accordionExample">
        <div class="card">
            <div class="card-header" data-toggle="collapse" data-target="#collapseOne">
                 <h2 class="mb-0">
                    <button type="button" class="btn btn-link" data-toggle="collapse" data-target="#collapseOne"><i class="fa fa-angle-right"></i> SEARCH</button>                                    
                </h2>
            
            </div>
            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
            <div class="card-body">
                <?= $this->Form->create() ?>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <?php echo $this->Form->control('company_name', ['class'=>'form-control','label'=>'Company Name', 'empty' => true, 'required' => false]); ?>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <?php echo $this->Form->control('contact_name', ['class'=>'form-control','label'=>'Contact Name', 'empty' => true, 'required' => false]); ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <?php echo $this->Form->control('username', ['class'=>'form-control','label' => 'Email','required' => false]); ?>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <?php echo $this->Form->label('Industry Type / NAICS code', null, ['class'=>'']); ?>
                            <?php echo $this->Form->control('naics_codes', ['options'=>$naisccodes, 'empty'=>false, 'class'=>'form-control searchSelect', 'multiple'=>true, 'required' => false, 'label'=>false,'style'=>'width:453px !important']); ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <?php echo $this->Form->control('policy_type', ['options'=>$policyTypes, 'class'=>'form-control form-select','label'=>'Policy Types', 'empty' => true, 'required' => false]); ?>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <?php echo $this->Form->control('start_date', [ 'empty'=>true, 'class'=>'form-control datepicker', 'required' => false]); ?>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <?php echo $this->Form->control('end_date', ['empty'=>true, 'class'=>'form-control datepicker', 'required' => false]); ?>
                        </div>
                    </div>
                </div>
                <div class="form-actions form-group">
                    <?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Search', ['type' => 'submit', 'class'=>'btn btn-success pull-right mb-2']); ?>
                </div>
            </div>
        </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
</div>
</div>
<div class="row">
<div class="col-lg-12">
    <div class="card">
        <div class="card-header">Supplier List </div>
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
                        <th scope="col">
                            <?= h('Subscription End Date') ?>
                        </th>
                        <th scope="col">
                            <?= h('Subscription') ?>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($contList as $contractor):   ?>
                    <tr>
                        <td><?php echo $this->Form->checkbox('contractor_id', ['type'=>'hidden','required'=>false, 'label'=>false,'id'=>'cont-id','value'=>$contractor['id']]); ?></td>
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
                        <td>
                            <?= !empty($contractor['subscription_date']) ? date('m/d/Y', strtotime($contractor['subscription_date']))  : '' ?>
                        </td>
                        <?php if( isset($contractor['subscription_date']) && strtotime($contractor['subscription_date']) <  strtotime($todaydate)) {?>
                        <td>
                            <?php echo "Expired"; ?>
                        </td>
                        <?php }else{ ?>
                        <td></td>
                        <?php } ?>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                    <div class="form-actions form-group">
                    <?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Create List', ['type' => 'button', 'class'=>'btn btn-success mb-2 c-list']); ?>
                </div>
            </table>
        <?php } ?>
        <?php if(!empty($ExpriedDate)){ ?>
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
                       <td><?php echo $this->Form->checkbox('contractor_id', ['type'=>'hidden','required'=>false, 'label'=>false,'id'=>'cont-id','value'=>$v['contractor']->id]); ?></td>
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
                    <?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Create List', ['type' => 'button', 'class'=>'btn btn-success mb-2 c-list']); ?>
                </div>
                </table>
        <?php } ?>
        </div>
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
        <?= $this->Form->create(null, ['id'=>'createList','url' => ['controller'=>'CampaignContactLists','action' => 'add']]) ?>
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