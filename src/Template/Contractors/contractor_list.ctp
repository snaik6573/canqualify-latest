<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Client[]|\Cake\Collection\CollectionInterface $clients
 */ 
use Cake\Core\Configure;
$iconList = Configure::read('icons'); //, array('0'=>'Grey','1'=>'Red','2'=>'Yellow','3'=>'Green')
$users = array(CLIENT_VIEW, CLIENT_BASIC);
?>
<div class="row clients">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <strong class="card-title">
                    <h3><?= __('Contractor List') ?></h3>
                </strong>
                    <div class="pull-right">
                        <?php
                        echo  $this->Form->create('Contractors', ['url'=> ['controller' => 'Contractors','action'=>'contractor-list'], 'class'=>'hidden-form', 'id' => 'fusionchart-compliance-site-frm']);
                        echo $this->Form->button('<em><i class="fa fa-file-text-o"></i></em> Export to CSV', ['type' => 'submit', 'name' => 'csv', 'value'=>'csv', 'class' => 'btn btn-outline-primary btn-sm mx-1 c-list']);
                        echo $this->Form->button('<em><i class="fa fa-file-excel-o"></i></em> Export to Excel', ['type' => 'submit', 'name' =>'excel', 'value'=>'excel', 'class' => 'btn btn-outline-primary btn-sm mx-1 c-list']);
                        echo $this->Form->hidden('formID', ['value' => 'contractor_list']);
                        ?>
                    </div>
            </div>
            <?php
            if(isset($showFilters) && $showFilters){
            ?>
                <div class="card-body bg-light" style="margin: 15px; padding:20px;">
                    <h6>Filter By</h6>
                    <?php
                    $site_id = -1;
                    $icon_value = -1;
                    if(isset($formData)){
                        if(isset($formData['site_id'])){
                            $site_id = $formData['site_id'];
                        }
                        if(isset($formData['icon_value'])){
                            $icon_value = $formData['icon_value'];
                        }
                    }
                    echo '<div class="row">';
                    echo '<div class="col-3">'.$this->Form->control('site_id', ['options'=>$clientSites, 'value' => $site_id, 'class'=>'form-select multiSelect', 'required' => false, 'multiple' => 'multiple']).'</div>';
                    echo '<div class="col-2">'.$this->Form->control('icon_value', ['options'=>$iconList, 'value' => $icon_value, 'empty'=>true, 'class'=>'form-select', 'required' => false, 'label' => 'Status']).'</div>';
                    //echo '<div class="col-2 pt-4">'.$this->Form->checkbox('watch_list', ['value'=> 1, 'checked'=> true]).'<label for="watch_list" class="pt-2">Watch List Only</label></div>';
                    echo '<div class="col-1 pt-4 pull-left">'. $this->Form->submit('Submit', ['class' => 'btn btn-success btn-sm']) .'</div>';
                    echo '<div class="col-1 pt-4 pull-left">'. $this->Html->link(__('View All'), ['controller' => 'Contractors', 'action' => 'contractorList'],['class'=>'btn btn-outline-success btn-sm ms-1 c-list']) .'</div>';
                    echo '</div>';
                    echo $this->Form->end();
                    ?>
                </div>
            <?php
            }
            ?>

            <div class="card-body table-responsive">
              
                <table id="bootstrap-data-table" class="table table-striped table-bordered" data-order="[[ 1, &quot;asc&quot; ]]">
                    <thead>
                        <tr>
                            <th scope="col">
                                <?= h('Status') ?>
                            </th>
                            <th scope="col">
                                <?= h('Contractor Name') ?>
                            </th>
                            <th scope="col">
                                <?= h('TIN') ?>
                            </th>
                            <th scope="col">
                                <?= h('NAICS Code') ?>
                            </th>
                            <th scope="col">
                                <?= h('Primary Contact') ?>
                            </th>
                            <th scope="col">
                                <?= h('View Subs') ?>
                            </th>
                            <th scope="col">
                                <?= h('Safety') ?>
                            </th>
                            <?php if($hasEmployeeQual) { ?>
                            <th scope="col">
                                <?= h('Employee Qual') ?>
                            </th>
                            <?php } ?>
                            <th scope="col">
                                <?= h('Active Subscription') ?>
                            </th>
                             <th scope="col">
                                <?= h('Member Since') ?>
                            </th>
                             <th scope="col">
                                <?= h('Risk Level') ?>
                            </th>
                            <?php if (!in_array($activeUser['role_id'], $users)) { ?>
                            <th scope="col" class="noExport">
                                <?= h('Actions') ?>
                            </th>
                            <?php }?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $cnt = 0;
	                        foreach ($contList as $contractor){
	                            //debug($contList);die;
                        ?>
                                <tr>
                                    <?php
		                            $iconStatus = '';
                            		if(!empty($contractor['final_overall_icons'])) {
			                            $iconStatus = '<span style="display:none;">'.$contractor['final_overall_icons'][0]->icon.' - '.$iconList[$contractor['final_overall_icons'][0]->icon].'</span><i class="fa fa-circle color-'.$contractor['final_overall_icons'][0]->icon.'"></i><span style="display:block;">'.$iconList[$contractor['final_overall_icons'][0]->icon].'</span>';
		                            }
		                            ?>
                                    <td data-order="<?php if(isset($contractor['final_overall_icons'][0]->icon)) echo $contractor['final_overall_icons'][0]->icon;?>" class="text-center">
                                        <?php echo $iconStatus;?>
                                        <?php //echo $this->Html->link(__($iconStatus), ['controller'=>'Contractors', 'action'=>'icon_report', $contractor->id], ['class'=>'ajaxmodal', 'data-toggle'=>'modal', 'data-target'=>'#icon_report', 'escape'=>false, 'title'=>'Icon Report']) ?>
                                    </td>
                                    <td>
                                        <?= $this->Html->link($contractor->company_name, ['controller' => 'Contractors','action' => 'dashboard', $contractor->id],['escape'=>false, 'title' => 'View']) ?>
                                    </td>
                                    <td>
                                        <?= (!empty($contractor->contractor_tins[0]->tin)) ? $contractor->contractor_tins[0]->tin : ''; ?>
                                    </td>
                                    <td>
                                        <?= (!empty($contractor->naisc_views[0]->naisc_code)) ? $contractor->naisc_views[0]->naisc_code : ''; ?>
                                        <br />
                                        <?= (!empty($contractor->naisc_views[0]->title)) ? ' '.$contractor->naisc_views[0]->title : ''; ?>
                                    </td>
                                    <td>
                                        <?= h($contractor->pri_contact_fn.' '.$contractor->pri_contact_ln); ?>
                                        <br />
                                        <?= h($contractor->pri_contact_pn) ?>
                                        <br />
                                        <?= h($contractor->user->username); ?>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                        if(!empty($contractor->gc_client_id)){
                                            echo $this->Html->link(__('<span style="display:none;">'.$contractor->gc_client_id.'</span><i class="fa fa-eye"></i>'), ['controller'=>'Contractors', 'action'=>'contractorList', $contractor->gc_client_id], ['target'=>'_blank', 'escape'=>false, 'title'=>'Safety Report']);
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <?= $this->Html->link(__('<i class="fa fa-eye"></i>'), ['controller'=>'ContractorAnswers', 'action'=>'safety_report/', 0, $contractor->id], ['class'=>'ajaxmodal', 'data-toggle'=>'modal', 'data-target'=>'#scrollmodal', 'escape'=>false, 'title'=>'Safety Report']) ?>
                                    </td>
                                    <?php if($hasEmployeeQual) { ?>
                                    <td class="text-center">
                                        <?= $this->Html->link(__('<i class="fa fa-eye"></i>'), ['controller'=>'Employees', 'action'=>'index/', 0, $contractor->id], ['escape'=>false, 'title'=>'Employees']) ?>
                                    </td>
                                    <?php } ?>
                                    <td>
                                        <?php
                                        $now = time();
                                        if(strtotime($contractor->subscription_date) > $now) {
                                           echo "Active";
                                        }else{
                                            echo "Expired";
                                        }
                                        ?>
                                    </td>
                                    <td data-order="<?= !empty($contractor->created) ? date('Ymd', strtotime($contractor->created))  : '' ?>">
                                        <?= !empty($contractor->created) ? date('m/d/Y', strtotime($contractor->created))  : '' ?>
                                    </td>
                                    <td><?= ($contractor->is_safety_sensitive ==  true) ? 'Safety Sensitive' : 'Non Safety Sensitive' ?></td>
                                    <?php if (!in_array($activeUser['role_id'], $users)) { ?>
                                    <td>
                                        <?php
                                        if($activeUser['role_id'] == SUPER_ADMIN) {
			                                    echo $this->Form->postLink(__('Un-asign'), ['controller'=>'ContractorSites','action'=>'unasign', $contractor->id], ['class'=>'', 'confirm'=>__('Are you sure you want to un-asign # {0}?', $contractor->company_name)]).' | ';
		                                }
		                                if(isset($allowForceChange)) {
			                                    echo $this->Html->link(__('Force Icon'), ['controller'=>'OverallIcons', 'action'=>'force-change', $client_id, $contractor->id], ['class'=>'ajaxmodal', 'data-toggle'=>'modal', 'data-target'=>'#scrollmodal2']);
		                                }
		                                if(isset($suppliersOnWatch) && in_array($contractor->id, $suppliersOnWatch)){
                                            $watchListLabel = 'Remove from Watch List';
                                        }else{
                                            $watchListLabel = 'Add to Watch List';
                                        }
                                        echo ' | ';
                                        echo $this->Html->link($watchListLabel, ['controller'=>'Contractors','action' => 'add-watch-list',$client_id, $contractor->id],['escape'=>false, 'title' => 'Watch List']);
		                                ?>
                                    </td>
                                    <?php }?>
                                </tr>
                        <?php } ?>
                        <?php
                        /*if($activeUser['role_id'] != CLIENT_VIEW) {
                            echo '<div class="form-actions form-group">';
                            echo $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Create List', ['type' => 'button', 'class' => 'btn btn-success mb-2 c-list']);
                            echo '</div>';
                        }*/
                        ?>
                    </tbody>
                </table>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>
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
<div class="modal fade" id="scrollmodal1" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Review</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>
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
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Save Campaign Contact List</h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                <i data-feather="x"></i>
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


<script>
    $(function(){

        $("[data-toggle=popover]").popover({
            html : true,
            content: function() {
                var content = $(this).attr("data-popover-content");
                return $(content).children(".popover-body").html();
            },
            title: function() {
                var title = $(this).attr("data-popover-content");
                return $(title).children(".popover-heading").html();
            }
        });

        if (jQuery(".multiSelect").length) {
            jQuery(".multiSelect").multiselect({
                /*click: function(event, ui){
                    jQuery(this).val(ui.value);
                    //var data = ui.value;
                    jQuery(this).parents('form').submit();
                }   */
            });
        }

    });
</script>