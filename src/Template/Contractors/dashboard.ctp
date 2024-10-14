<?php
use Cake\Core\Configure;
$uploaded_path = Configure::read('uploaded_path');
$users = array(SUPER_ADMIN, CONTRACTOR, ADMIN,CONTRACTOR_ADMIN);
$clients = array(CLIENT,CLIENT_ADMIN,CLIENT_VIEW,CLIENT_BASIC);
$specialUser =  array(SUPER_ADMIN, ADMIN, CLIENT);
$assignManager =  array(SUPER_ADMIN,ADMIN,CR,CLIENT,CLIENT_ADMIN);
$allowConFnD = array_merge(array(SUPER_ADMIN, ADMIN, CR), $clients);
$this->assign('title', 'Dashboard');
$contClients =   $this->User->getClients($activeUser['contractor_id']);
$iconList = Configure::read('icons'); //, array('0'=>'Grey','1'=>'Red','2'=>'Yellow','3'=>'Green')
?>
<div class="row contractors">
        <!-- coloumn first bof -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <strong>Company Level Open Tasks</strong>
                </div>
                <div class="card-body card-block">
                    <?php
                    if(isset($activeUser) && in_array($activeUser['role_id'], $users)) {
                        if($greenIcon == true && empty($contFeedback)){
                            //echo '<p>'.$this->Html->link('Review', ['controller'=>'contractorFeedbacks', 'action'=>'feedback', $contractor->id], ['escape'=>false, 'title'=>'Submit Your Feedback']).'</p>';
                            echo '<p>'.$this->Html->link('How\'d we do?', 'https://servicegrade.co/canqualify', ['target' => '_blank', 'escape'=>false, 'title'=>'Submit Your Feedback']).'</p>';
                        }
                    }
                    $openTask = false;
                    if($contractor->payment_status && $contractor->subscription_date!=null) {
                        //pr($contractor);

                        $total_complete = true;

                        $subscription_date = date('Y-m-d', strtotime($contractor->subscription_date));
                        $dt = date('Y-m-d', strtotime("+90 days"));
                        $freeAccount = false;
                        if(!empty($matrix) && count($matrix) == 1){
                            if(isset($matrix[0]['is_gc']) && $matrix[0]['is_gc'] == true){
                                $freeAccount = true;
                            }
                        }
                        if((($subscription_date <= $dt) ||$contractor['forced_renew']==true) && $freeAccount == false ) {
                            // if(($subscription_date <= $dt && $is_client!=1) ||$contractor['forced_renew']==true ) {
                            echo '<p>'.$this->Html->link('Renew Your Subscription', ['controller'=>'payments', 'action'=>'checkout', 1], ['escape'=>false, 'title'=>'Renew Your Subscription']).'</p>';
                            $openTask = true;
                        }
                        /*if(empty($contractorSites)) {
                               echo '<p>'.$this->Html->link('Select your client locations', ['controller'=>'ContractorSites', 'action'=>'add'], ['escape'=>false, 'title'=>'Add Your Location']).'</p>';
                               $openTask = true;
                        }*/
                        if(!empty($locationOpenTask) && count($locationOpenTask) > 0){
                            foreach ($locationOpenTask as $key => $clientName){
                                if(isset($activeUser) && in_array($activeUser['role_id'], $clients)) {
                                    if($activeUser['client_id'] == $key){
                                        echo '<p>'.$this->Html->link('Select your Location for client: '.$clientName, ['controller'=>'ContractorSites', 'action'=>'add'], ['escape'=>false, 'title'=>'Select your Location for client: '.$clientName]).'</p>';
                                        $openTask = true;
                                    }

                                }else{
                                    echo '<p>'.$this->Html->link('Select your Location for client: '.$clientName, ['controller'=>'ContractorSites', 'action'=>'add'], ['escape'=>false, 'title'=>'Select your Location for client: '.$clientName]).'</p>';
                                    $openTask = true;
                                }

                            }
                        }
                        $services = $this->Category->getServices($activeUser['contractor_id']);

                        if(!empty($services)) {
                            $openTask = true;
                            ?>
                            <ul class="open_tasks nav navbar-nav">
                                <?php
                                foreach ($services as $service_id => $service_name) {
                                    if ($service_id == 4 || $service_id==3) {
                                        continue;
                                    }

                                    $final_submit = true;
                                    if($service_id == 2){
                                        $categories = $this->Category->getInsCategories($activeUser, $service_id, false);
                                    }else{
                                        $categories = $this->Category->getCategories($activeUser, $service_id, false);
                                    }

                                    if(!empty($categories)) {
                                        foreach($categories as $cat) {
                                            if($cat['getPerc'] !='100%') {
                                                $catIncomplete = $cat['id'];
                                                $final_submit = false;
                                                $total_complete = false;
                                                break;
                                            }
                                        }
                                        if($final_submit){
                                            continue; // continue services loop
                                        }
                                        ?>

                                        <li class="menu-item-has-children dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $service_name ?></a>
                                            <?php
                                            if($service_id==1 && !empty($categories)) { //'DocuQUAL'
                                                $firstCat = reset($categories);
                                                $firstCatId = $firstCat['id'];
                                                ?>
                                                <ul class="sub-menu children dropdown-menu">
                                                    <li><?= $is_client == 1 ? $this->Html->link(__('Complete Pre-Qualification Form'), ['controller'=>'contractor-answers', 'action'=>'addAnswers', $service_id,$catIncomplete], ['escape'=>false, 'title'=>'Complete Pre-Qualification Form']) : $this->Html->link(__('Complete Pre-Qualification Form'), ['controller'=>'contractor-answers', 'action'=>'addAnswers', $service_id,$catIncomplete], ['escape'=>false, 'title'=>'Complete Pre-Qualification Form']) ?></li>
                                                </ul>
                                                <?php
                                                continue; // continue services loop
                                            }
                                            ?>

                                            <ul class="sub-menu children dropdown-menu">
                                                <?php
                                                $i=0;
                                                $todayDate = array();
                                                foreach($categories as $cat) {
                                                    if(!empty($cat['childrens'])) { // year_based
                                                        foreach ($cat['childrens'] as $key=>$value) {
                                                            foreach ($value['cat'] as $childcats) { //pr($childcats);
                                                                if($service_id==2 && !empty($categories)) {
                                                                    $curYear = date('Y');
                                                                    $ansDate=array();
                                                                    if($childcats['name']=="General Liability") {
                                                                        $ansDate = $this->Category->checkAns(43,$contractor->id);
                                                                    }elseif($childcats['name']=="Automobile Liability"){
                                                                        $ansDate = $this->Category->checkAns(55,$contractor->id);
                                                                    }elseif($childcats['name']=="Excess/Umbrella Liability"){
                                                                        $ansDate = $this->Category->checkAns(65,$contractor->id);
                                                                    }elseif($childcats['name']=="Workers Compensation"){
                                                                        $ansDate = $this->Category->checkAns(456,$activeUser['contractor_id']);
                                                                    }

                                                                    if(!empty($ansDate)){
                                                                        $ansDate = max($ansDate);
                                                                        $todayDate = date('Y-m-d');
                                                                        $ansDate = date('Y-m-d', strtotime($ansDate. "-30 days"));
                                                                    }

                                                                    if($key >$curYear){
                                                                        if($childcats['getPerc'] == '100%')
                                                                        { continue; }
                                                                        // elseif($ansDate <= $todayDate || $childcats['name']== 'Workers Compensation' ||$childcats['getPerc'] != '0%' ) {
                                                                        elseif($ansDate <= $todayDate ||$childcats['getPerc'] != '0%' ) {
                                                                            ?>
                                                                            <li><?= $is_client == 1 ? "Complete ".$key." ".$childcats['name'] : $this->Html->link(__("Complete ".$key." ".$childcats['name']), ['controller'=>'contractor-answers', 'action'=>'addAnswers', $service_id, $childcats['id'], $key], ['escape'=>false, 'title'=>$childcats['name']]) ?></li>
                                                                            <?php
                                                                        }
                                                                    }else{
                                                                        if($childcats['getPerc'] == '100%')
                                                                        { continue; }
                                                                        else {
                                                                            ?>
                                                                            <li><?= $is_client == 1 ? "Complete ".$key." ".$childcats['name'] : $this->Html->link(__("Complete ".$key." ".$childcats['name']), ['controller'=>'contractor-answers', 'action'=>'addAnswers', $service_id, $childcats['id'], $key], ['escape'=>false, 'title'=>$childcats['name']]) ?></li>
                                                                            <?php
                                                                        }
                                                                    }
                                                                }else{
                                                                    if($childcats['getPerc'] == '100%')
                                                                    { continue; }
                                                                    else {
                                                                        ?>
                                                                        <li><?= $is_client == 1 ? "Complete ".$key." ".$childcats['name'] : $this->Html->link(__("Complete ".$key." ".$childcats['name']), ['controller'=>'contractor-answers', 'action'=>'addAnswers', $service_id, $childcats['id'], $key], ['escape'=>false, 'title'=>$childcats['name']]) ?></li>
                                                                        <?php
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                    elseif(!empty($cat['child'])) { // sub_cat
                                                        foreach ($cat['child'] as $key=>$value) {
                                                            if($value['getPerc'] == '100%')
                                                            { continue; }
                                                            else {
                                                                ?>
                                                                <li><?= $is_client == 1 ? "Complete ".$value['name'] : $this->Html->link(__('Complete '.$value['name']), ['controller'=>'contractor-answers', 'action'=>'addAnswers', $service_id, $value['id']], ['escape'=>false, 'title'=>$value['name']]) ?></li>
                                                                <?php
                                                            } }
                                                    }
                                                    else {
                                                        if($cat['getPerc'] == '100%')
                                                        { continue; }
                                                        else {
                                                            ?>
                                                            <li><?= $is_client == 1 ? $cat['name'] : $this->Html->link(__($cat['name']), ['controller'=>'contractor-answers', 'action'=>'addAnswers', $service_id, $cat['id']], ['escape'=>false, 'title'=>$cat['name']]) ?></li>
                                                            <?php
                                                        }
                                                    }
                                                }
                                                ?>
                                            </ul><!-- sub-menu -->
                                        </li><!-- menu-item-has-children -->
                                        <?php
                                    }
                                    else { // service doesn't have category
                                        $total_complete = false;
                                    }
                                } // foreach $services
                                ?>
                            </ul>
                            <?php
                            if($total_complete) {
                                $openTask =false;
                            }
                            /*Function of Suggested Icon Generation: Call on 'Please Submit Your Data' to  'Review' link click */
                            if($total_complete && $is_client!=1 && $showFinalSubmitData) {
                                //echo $this->Html->link(__('Please Submit Your Data'), ['controller'=>'contractor-answers', 'action'=>'final-submit', 6], ['escape'=>false, 'title'=>'Final submit']);
                                echo $this->Html->link('Please Submit Your Data', ['controller' => 'OverallIcons', 'action' => 'setIcons', 1], ['escape'=>false, 'title'=>'Please Submit Your Data']);
                                $openTask =true;
                            }
                        } // if waiting_on = Contractor
                    }
                    if(isset($matrix) && count($matrix) <= 0){
                        echo '<p>'.$this->Html->link('Select Client', ['controller'=>'contractor-clients', 'action'=>'add'], ['escape'=>false, 'title'=>'Site Add']).'</p>';
                        $openTask =true;
                    }
                    if(!$openTask) {
                        echo '<span style="">No Open Tasks!</span>';
                    }
                    ?>
                </div>
            </div>
            <!-- EmployeeQual open task  -->

            <?php $clients =   $this->User->getClients($activeUser['contractor_id']);
            if(!empty($services)){
                foreach ($services as $service_id => $service_name) {
                    if ($service_id == 4) { echo $this->element('empqual_opentask',['service_id'=>$service_id]); } } } //}  ?>
            <?php
            if($enable_clientManager > 0 && isset($clientManagers)) {
                foreach ($clientManagers as $clientManager) {

                    if( empty($clientManager['selected_manager'])){
                        continue;
                    }
                    $client_user = null;
                    $client_managers_list = $clientManager['client_users'];
                    $client_user = $clientManager['selected_manager'];

                    if(!empty($client_managers_list) ){
                        ?>
                        <div class="card">
                            <div class="card-header">
                                <?php if(isset($activeUser) && in_array($activeUser['role_id'], $assignManager)) {?>
                                    <strong>Assign Manager</strong>
                                <?php }else { ?>
                                    <strong><?= $clientManager['client_company_name']?> Manager</strong>
                                <?php } ?>
                            </div>
                            <div class="card-body card-block">
                                <table class="table table-responsive">
                                    <?php if(isset($activeUser) && in_array($activeUser['role_id'], $assignManager)) {?>
                                        <tr><td colspan="3">
                                                <div><b>Client Name : </b> <?= $clientManager['client_company_name'] ?></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row"><?= __('Manager : ') ?></th>
                                            <td colspan="2">
                                                <?= $this->Form->create($contractor) ?>
                                                <?php echo $this->Form->control('client_manager', ['options'=>$client_managers_list,'label'=>false,'value'=>$client_user['id'], 'empty'=>true, 'onchange'=>"this.form.submit();"]); ?>
                                                <?php echo $this->Form->control('client_id', ['type'=>'hidden','value' =>$clientManager['client_id']]); ?>
                                                <?= $this->Form->end() ?>
                                            </td></tr>
                                    <?php }
                                    else {
                                        if(!empty($client_user)){
                                            ?>
                                            <tr><td style="border-top:none;">
                                                    <div><b><?php echo $client_user->pri_contact_fn .' '.$client_user->pri_contact_ln;?></b></div>
                                                    <div><b>Phone : </b><?= $client_user->pri_contact_pn ?> </div>
                                                    <b>Email : </b><a href="mailto:<?= $client_user->user->username ?>" target="_top"><?= $client_user->user->username ?></a>
                                                </td></tr>
                                        <?php }}?>
                                </table>
                            </div>
                        </div><!-- card -->
                    <?php }}}?>
        </div>
        <!-- coloumn first eof-->

        <!-- coloumn second bof -->
        <div class="col-lg-8">
            <div class="row">
                <div class="col-6">
                    <!-- ccontractor status bof -->
                    <div class="card">
                            <div class="card-header">
                                <strong>Contractor Status</strong>
                            </div>
                            <div class="card-body card-block">
                                <table class="table table-responsive">
                                    <tr>
                                        <th scope="row"><?= __('Safety Sensitive') ?></th>
                                        <td>
                                            <?php if(isset($activeUser) && $activeUser['role_id'] == SUPER_ADMIN || $activeUser['role_id'] == ADMIN) {
                                                echo $this->Form->create($contractor);
                                                echo $this->Form->control('is_safety_sensitive', ['onclick'=>"this.form.submit();"]);
                                                echo $this->Form->end();
                                            } else {
                                                echo $contractor->is_safety_sensitive ? __('Yes') : __('No');
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <!--<tr>
			                    <th scope="row"><?= __('NAICS (Primary) ') ?></th>
                                    <td><?= h($contractor->pri_contact_pn) ?></td>
                                </tr>-->
                                    <!--<tr>
                                    <th scope="row"><?= __('Last Login') ?></th>
                                    <td><?php echo $activeUser['last_login']; ?></td>
                                </tr>-->
                                    <tr>
                                        <th scope="row"><?= __('Member Since') ?></th>
                                        <td><?= !empty($contractor->created) ? date('n/d/Y', strtotime($contractor->created)) : '' ?></td>
                                    </tr>

                                    <?php
                                    echo '<tr>';
                                    echo '<th scope="row">'. __('Next Renewal').'</th>';
                                    echo '<td>';
                                    if(isset($activeUser) && $activeUser['role_id'] == SUPER_ADMIN || $activeUser['role_id'] == ADMIN) {
                                        $s_date = '';
                                        if(!empty($contractor->subscription_date)){
                                            $s_date = date('m/d/Y', strtotime($contractor->subscription_date));
                                        }
                                        echo $this->Form->create($contractor);
                                        echo $this->Form->control('subscription_date', ['type' => 'text', 'id' =>'datepicker', 'label' => false,'value' =>$s_date]);
                                        echo $this->Form->control('Update', ['type' => 'submit','onclick'=>"this.form.submit();"]);
                                        echo $this->Form->end();
                                    }else{
                                        echo !empty($contractor->subscription_date) ? date('n/d/Y', strtotime($contractor->subscription_date)) : '';
                                    }
                                    echo '</td>';
                                    echo '</tr>';
                                    ?>
                                    <?php
                                    if(isset($activeUser) && $activeUser['role_id'] == SUPER_ADMIN || $activeUser['role_id'] == ADMIN) {?>
                                        <tr>
                                            <th scope="row"><?= __('Account') ?></th>
                                            <td>
                                                <?= $this->Form->create($contractor) ?>
                                                <?php echo $this->Form->control('is_locked', ['onclick'=>"this.form.submit();"]); ?>
                                                <?= $this->Form->end() ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row"><?= __('Status') ?></th>
                                            <td>
                                                <?= $this->Form->create($contractor) ?>
                                                <?php echo $this->Form->control('user.active', ['required'=>false, 'onclick'=>"this.form.submit();"]); ?>
                                                <?php echo $this->Form->control('user.username', ['type'=>'hidden']); ?>
                                                <?= $this->Form->end() ?>
                                            </td>
                                        </tr>
                                    <?php } else { ?>
                                        <tr>
                                            <th scope="row"><?= __('Status') ?></th>
                                            <td><?= $contractor->user->active ? __('Active') : __('Inactive'); ?></td>
                                        </tr>

                                        <tr>
                                            <th scope="row"><?= __('Account') ?></th>
                                            <td><?= $contractor->is_locked ? __('Locked') : __('Unlocked'); ?></td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </div>
                        </div>
                    <!-- ccontractor status eof -->

                    <!-- Membership Certificate & Badge bof -->
                    <?php if($contractor->payment_status && $enable_membershipBlock) { ?>
                        <div class="card">
                            <div class="card-header">
                                <strong>Membership Certificate & Badge</strong>
                            </div>
                            <div class="card-body card-block">
                                <ul>
                                    <!-- <li><a href="" onclick="lendica.ibranch.open();">Lendica</a></li>-->
                                    <li>
                                        <span data-container="body" data-toggle="popover" data-placement="top" data-content="Your company has authorization to use this certificate on all company marketing materials, website, proposals and more" data-original-title="" title=""><i class="fa fa-info-circle"></i></span>
                                        <?= $this->Html->link('CanQualify Certificate',['controller'=>'Contractors','action'=>'toCertify',$contractor->id]) ?>

                                    </li>
                                    <li>
                                        <span data-container="body" data-toggle="popover" data-placement="top" data-content="Your company has authorization to use this badge on all company marketing materials, website, proposals and more" data-original-title="" title=""><i class="fa fa-info-circle"></i></span>
                                        <a href="<?= $uploaded_path.'canqualify_badge.jpg' ?>" target="_Blank">CanQualify Badge</a>
                                    </li>
                                </ul>
                            </div>
                        </div><!-- card -->
                    <?php } ?>
                    <!-- Membership Certificate & Badge eof -->

                    <?php
                    if(!empty($activeUser['role_id']) && !in_array($activeUser['role_id'], $clients)){
                    ?>
                        <!-- Partner & Affiliate Programs bof -->
                        <div class="card">
                            <div class="card-header">
                                <strong>Partner & Affiliate Programs</strong>
                            </div>
                            <div class="card-body card-block">
                                <ul>
                                    <li>
                                        <span data-container="body" data-toggle="popover" data-placement="top" data-content="Membership Rewards & Discounts" data-original-title="" title=""><i class="fa fa-star"></i></span>
                                        <?= $this->Html->link('Use Promo Code CanQualify to Get More Clients','https://www.merchynt.com/',['target'=>'_blank']) ?>
                                    </li>
                                    <li>
                                        <i class="fa fa-star"></i>
                                        <?= $this->Html->link('WorkerSafety Pro solution - Book a Demo for a 15-day free trial','https://becklar.com/workforce-safety/manufacturing-canqualify/',['target'=>'_blank']) ?>
                                    </li>
                                    <li>
                                        <i class="fa fa-star"></i>
                                        <?= $this->Html->link('Accounting Services - Your Numbers, Our Expertise!','https://www.quickprosaccounting.com/bizservices.php',['target'=>'_blank']) ?>
                                    </li>
                                    <li>
                                        <i class="fa fa-star"></i>
                                        <?= $this->Html->link('Tech Solutions, Human Touch','https://qualtech.biz/services/',['target'=>'_blank']) ?>
                                    </li>

                                </ul>
                            </div>
                        </div>
                        <!-- Partner & Affiliate Programs eof -->
                    <?php
                    }
                    ?>
                    <?php
                    if(!empty($contractor['gc_client_id'])){
                        ?>
                        <!-- GC bof -->
                        <div class="card">
                            <div class="card-header">
                                <strong>General Contractor</strong>
                            </div>
                            <div class="card-body card-block">
                                To view supplier list of General Contractor, please <?php echo $this->Html->link(__('Click Here'), ['controller'=>'Contractors', 'action'=>'contractorList', $contractor['gc_client_id']], ['escape'=>false, 'title'=>'Client Locations']) ?>.
                            </div>
                        </div>
                        <!-- GC eof -->
                        <?php
                    }
                    ?>

                    <!-- locationwise contacts bof -->
                    <div class="card">
                        <div class="card-header">
                            <strong>Client Location Contacts</strong>
                        </div>
                        <div class="card-body card-block">
                            To view your client location's <b>SHE and Facility Contacts</b>, please <?= $this->Html->link(__('Click Here'), ['controller'=>'ContractorSites', 'action'=>'manageSites'], ['escape'=>false, 'title'=>'Client Locations']) ?></li>.
                        </div>
                    </div>
                    <!-- locationwise contacts eof -->
                </div>
                <div class="col-6">
                    <!-- contractor info bof-->
                    <div class="card">
                            <div class="card-header">
                                <strong>Contractor Info</strong>
                            </div>
                            <div class="card-body card-block" >
                                <table class="table table-responsive">
                                    <tr>
                                        <th scope="row"><?= __('Company') ?></th>
                                        <td><?= h($contractor->company_name) ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?= __('Primary Contact') ?></th>
                                        <td><?= h($contractor->pri_contact_fn).' '.h($contractor->pri_contact_ln) ?>

                                            <?php if(isset($activeUser) && in_array($activeUser['role_id'], $clients)) { ?>
                                                <div><?= $this->Html->link('View Additional Contacts', ['controller'=>'ContractorUsers', 'action'=>'index', 1], ['escape'=>false, 'title'=>'Contacts', 'class'=>'']) ?></div>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?= __('Email') ?></th>
                                        <td style="word-wrap: anywhere;"><?= h($contractor->user->username) ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?= __('Phone') ?></th>
                                        <td><?= h($contractor->pri_contact_pn) ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    <!-- contractor info eof-->

                    <!-- customer representative bof -->
                    <div class="card">
                        <div class="card-header">
                            <strong>Customer Service</strong>
                        </div>
                        <div class="card-body card-block">
                            <table class="table table-responsive">
                                <?php foreach ($customer_rep as $key =>$crp) : ?>
                                    <?php
                                    if(!empty($crp->user->username) && $crp->user->username == 'mark.buettner@canqualify.com')
                                    {continue;}
                                    ?>
                                    <?php if($key == 0) { ?>
                                        <tr>
                                            <td>
                                                <b>Primary CR : </b>
                                                <div><?= $crp->pri_contact_fn .' '.$crp->pri_contact_ln  ?></div>
                                                <div><b>Phone : </b><?= $crp->pri_contact_pn ?> &nbsp;&nbsp;&nbsp;<b>Ext. : </b><?= $crp->extension ?></div>
                                                <b>Email : </b><a href="mailto:<?= $crp->user->username ?>" target="_top"><?= $crp->user->username ?></a>
                                            </td>
                                        </tr>
                                    <?php } else { ?>
                                        <tr>
                                            <td>
                                                <b>Secondary CR : </b>
                                                <div><?= $crp->pri_contact_fn .' '.$crp->pri_contact_ln  ?></div>
                                                <div><b>Phone : </b><?= $crp->pri_contact_pn ?> &nbsp;&nbsp;&nbsp;<b>Ext. : </b><?= $crp->extension ?></div>
                                                <b>Email : </b><a href="mailto:<?= $crp->user->username ?>" target="_top"><?= $crp->user->username ?></a>
                                            </td>
                                        </tr>
                                    <?php } endforeach;?>
                                <tr>
                                    <td>
                                        <div>General Customer Service</div>
                                        <div><b>Phone :</b> <?= Configure::read('customer_service.phone_no');?></div>
                                    </td>
                                </tr>
                            </table>
                        </div>


                    </div>
                    <!-- customer representative eof -->
                </div>
            </div>

            <!-- client matrix  bof -->
            <div class="row">
                    <div class="card">
                        <div class="card-header">
                            <strong>Client Matrix</strong>
                        </div>
                        <div class="card-body card-block">
                            <table class="table table-responsive">
                                <tr>
                                    <th><?= __('Client') ?></th>
                                    <th><?= __('Status') ?></th>
                                    <th><?= __('Waiting On') ?></th>
                                    <?php if(!empty($allowForceChange)) { ?><th><?= __('Force Change') ?></th><?php } ?>
                                    <?php
                                    if(in_array($activeUser['role_id'], array(SUPER_ADMIN, ADMIN))){
                                        echo '<th>Review</th>';
                                    }
                                    ?>
                                    <th><?= __('Download Data') ?></th>
                                    <th><?= __('Completion Certificate') ?></th>
                                    <?php
                                    if(in_array($activeUser['role_id'], array(SUPER_ADMIN, ADMIN))){
                                        echo '<th>Remove Client</th>';
                                    }
                                    ?>
                                </tr>
                                <?php
                                foreach ($matrix as $val) { ?>
                                    <tr>
                                        <td><?= (!empty($val['company_name'])) ? $val['company_name'] : ''; ?></td>
                                        <td class="text-center">
                                            <?php
                                            $iconNow = 0;
                                            if(!empty($val['icon'])){
                                                $iconNow = $val['icon'];
                                            }
                                            ?>
                                            <i class="fa fa-circle color-<?= $iconNow; ?>"></i>
                                            <span style="display: block;"><?php echo !empty($iconList[$val['icon']]) ? $iconList[$val['icon']] : 'Gray';?></span>
                                        </td>
                                        <td>
                                            <?php
                                            if(in_array($activeUser['role_id'], array(SUPER_ADMIN, ADMIN))){
                                                echo $this->Form->create(null,['id'=>'frm-waiting-on','url' => ['controller'=>'ContractorClients','action' => 'updateWaitingOn']]);
                                                echo $this->Form->control('waiting_on', ['options'=>$waiting_on,'label'=>false,'value'=>$val['waiting_on'], 'empty'=>false, 'onchange'=>"this.form.submit();"]);
                                                echo $this->Form->control('client_id', ['type'=>'hidden','value' =>$val['client_id']]);
                                                echo $this->Form->control('contractor_id', ['type'=>'hidden','value' =>$val['contractor_id']]);
                                                echo $this->Form->end();
                                            }else{
                                                echo $waiting_on[$val['waiting_on']];
                                            }
                                            ?>
                                        </td>
                                        <?php if(!empty($allowForceChange)) { ?>
                                            <td class="text-center"><?= $this->Html->link(__('<i class="fa fa-pencil"></i>'), ['controller'=>'OverallIcons', 'action'=>'force-change', $val['client_id'], $val['contractor_id']], ['class'=>'ajaxmodal', 'data-toggle'=>'modal', 'data-target'=>'#scrollmodal', 'escape'=>false, 'title'=>'Safety Report']) ?></td>
                                        <?php } ?>
                                        <?php
                                        if(in_array($activeUser['role_id'], array(SUPER_ADMIN, ADMIN))){
                                            echo '<td>';
                                            if($val['waiting_on'] == 2){
                                                echo $this->Html->link(__('Review Now'), ['controller'=>'OverallIcons', 'action'=>'review-supplier', $val['contractor_id'], $val['client_id']]);
                                            }

                                            echo '</td>';
                                        }
                                        ?>
                                        <td>
                                            <?= $this->Form->create('',['url'=>['controller'=>'ContractorAnswers','action'=>'downloadPqf/'.$val['client_id']]]) ?>
                                            <?php
                                            $services = $this->Category->getServices($activeUser['contractor_id']);
                                            $sdata = array();
                                            foreach ($services as $service_id => $service_name) {
                                                if($service_id ==2){
                                                    $categories = $this->Category->getInsCategories($activeUser, $service_id);
                                                } else{
                                                    $categories = $this->Category->getCategories($activeUser,$service_id);}
                                                //pr($categories);
                                                $catids = array();
                                                foreach($categories as $cat) {
                                                    if(!empty($cat['childrens'])) {
                                                        foreach ($cat['childrens'] as $year=>$cat) {
                                                            foreach ($cat['cat'] as $c) {
                                                                $catids['year'][$year][$c['id']] = $c['name'];
                                                            }
                                                        }
                                                    }
                                                    else {
                                                        $catids['categories'][$cat['id']] = $cat['name'];
                                                    }
                                                }
                                                $sdata[$service_id] = $catids;
                                                $sdata[$service_id]['name'] = $service_name;
                                            }

                                            ?>
                                            <?php echo $this->Form->control('services', ['type' => 'hidden','value' => json_encode($sdata)]); ?>
                                            <?= $this->Form->button('', ['type' => 'submit',  'class'=>'btn btn-primary btn-sm fa fa-download']) ?>
                                            <?= $this->Form->end() ?>
                                        </td>
                                        <td>
                                            <?php
                                                if (date('m')<3) {
                                                    if(in_array($val['icon'], array(2, 3))){
                                                        echo $this->Html->link(__('<i class="fa fa-download"></i>'), ['controller'=>'Contractors', 'action'=>'certify-completion', $val['contractor_id'], $val['client_id']], ['escape'=>false,'title'=>'Completion Certificate']);
                                                    }
                                                }else{
                                                    if(in_array($val['icon'], array(2, 3)) && $val['waiting_on'] == 4){
                                                        echo $this->Html->link(__('<i class="fa fa-download"></i>'), ['controller'=>'Contractors', 'action'=>'certify-completion', $val['contractor_id'], $val['client_id']], ['escape'=>false,'title'=>'Completion Certificate']);
                                                    }
                                                }
                                            ?>
                                        </td>
                                        <?php
                                        if(in_array($activeUser['role_id'], array(SUPER_ADMIN, ADMIN))){
                                            echo '<td class="text-center">';
                                            echo $this->Html->link(__('<i class="fa fa-trash"></i>'), ['controller'=>'Clients', 'action'=>'remove-client', $val['contractor_id'], $val['client_id']], ['escape'=>false,'title'=>'Remove Clients']);
                                            echo '</td>';
                                        }
                                        ?>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
            <!-- client matrix  eof -->
            <!-- Contractors Forms & Docs bof -->
            <?php
            if(isset($enable_conFND) && $enable_conFND){
                ?>
                <div class="row">
                    <div class="card">
                        <div class="card-header">
                            <strong>Contractor Forms & Docs</strong>
                        </div>
                        <div class="card-body card-block">
                            <table class="table">
                                <tr>
                                    <td colspan="3" style="text-align: right;border-top:0;">
                                        <?php
                                        if(isset($activeUser) && in_array($activeUser['role_id'], $allowConFnD)) {
                                            echo $this->Html->link(__('Upload Document'), ['controller'=>'FormsNDocs', 'action'=>'addContractorDocs'], ['class' => 'btn btn-success']);
                                        } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"><?= __('Document Name') ?></th>
                                    <th scope="row"><?= __('Type') ?></th>
                                    <th scope="row" class="text-center"><?= __('Download') ?></th>
                                </tr>
                                <?php
                                if(!empty($formsNDocsContractor)) {
                                    foreach ($formsNDocsContractor as $val) { ?>
                                        <tr>
                                            <td><a href="<?php echo $uploaded_path.$val->document;?>" target="_Blank"><?= $val->name ?></a></td>
                                            <td>
                                                <?php echo (isset($val->document_type) && isset(CONTRACTOR_DOC_TYPES[$val->document_type])) ? CONTRACTOR_DOC_TYPES[$val->document_type] : ''; ?>
                                            </td>
                                            <td class="text-center"><a href="<?php echo $uploaded_path.$val->document;?>" target="_Blank"><i class="fa fa-download"></i></a></td>
                                        </tr>
                                        <?php
                                    } }else{ ?>
                                    <tr>
                                        <td colspan="4" style="text-align:center;">No Records available</td>
                                    </tr>
                                <?php }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>

                <?php
            }
            ?>
            <!-- Contractor Forms & Docs eof -->

            <!-- signed docs bof -->
            <?php
                if($enable_signedDoc > 0 && isset($documents)) {
                    $cls='';
                    if (in_array($activeUser['role_id'], $users) && empty($documents)){
                        $cls = 'style="display:none;"';
                    }
            ?>
            <div class="row" <?= $cls ?>>
                        <div class="card">
                            <div class="card-header">
                                <strong>Signed Documents</strong>
                                <?php if($is_client == 1){
                                    echo $this->Html->link(__('Add New'), ['controller'=>'Documents', 'action'=>'add'], ['class'=>'ajaxmodal btn btn-sm btn-success pull-right', 'data-toggle'=>'modal', 'data-target'=>'#scrollmodal', 'escape'=>false, 'title'=>'Documents']);
                                } ?>
                                <!--<div class="pull-right">
                                    <span class="badge badge-success">Contractor</span> &nbsp;
                                    <span class="badge badge-primary">Client</span> &nbsp;
                                </div>-->
                            </div>
                            <div class="card-body card-block">
                                <?php
                                foreach ($documents as $client) { ?>
                                    <div style="margin:10px 5px"><strong>Client:</strong> <?= $client['company_name'] ?></div>
                                    <table class="table">
                                        <tr>
                                            <th scope="row"><?= __('Document Name') ?></th>
                                            <th scope="row"><?= __('version / Accepted By') ?></th>
                                            <th scope="row"><?= __('Reject') ?></th>
                                            <th scope="row"><?= __('Accept') ?></th>
                                            <th scope="row"><?= __('Uploaded By') ?></th>
                                        </tr>
                                        <?php
                                        if(!empty($client['documents'])) {
                                            foreach ($client['documents'] as $document) {
                                                ?>
                                                <tr>
                                                    <td><a href="<?php echo $uploaded_path.$document['document']?>" target="_Blank"><?php echo $document['name']?></a></td>
                                                    <td><?php echo $document['doc_version']!='' ? $document['doc_version']: '' ?> </td>
                                                    <td><?= empty($document['childrens']) && $document['status']==0 ? $this->Html->link(__('<i class="fa fa-upload"></i> Reject'), ['controller'=>'Documents', 'action'=>'add', $document['id'], $client['id']],['escape'=>false, 'class'=>'ajaxmodal btn btn-sm btn-warning', 'data-toggle'=>'modal', 'data-target'=>'#scrollmodal']) : '' ?></td>
                                                    <td>
                                                        <?php
                                                        if($document['status']==2) {
                                                            echo '<strong>Accepted</strong>';
                                                        }
                                                        elseif(empty($document['childrens'])) { // not childrens and not accepted
                                                            if($activeUser['role_id'] == CLIENT && $document['user']['role_id'] != CLIENT) {
                                                                echo $this->Html->link(__('<i class="fa fa-upload"></i> Accept'), ['controller'=>'Documents', 'action'=>'approve', $document['id'], $client['id']],['escape'=>false, 'class'=>'ajaxmodal btn btn-sm btn-info', 'data-toggle'=>'modal', 'data-target'=>'#scrollmodal']);
                                                            }
                                                            if($activeUser['role_id'] == CONTRACTOR) {
                                                                echo $this->Html->link(__('<i class="fa fa-upload"></i> Accept'), ['controller'=>'Documents', 'action'=>'approve', $document['id'], $client['id']],['escape'=>false, 'class'=>'ajaxmodal btn btn-sm btn-success', 'data-toggle'=>'modal', 'data-target'=>'#scrollmodal']);
                                                            }
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?= $document['user']['client_user']['client']['company_name'] ?></td>
                                                </tr>
                                                <?php
                                                if(isset($document['childrens'])){
                                                    $last = array_keys($document['childrens']);
                                                    $last = end($last);
                                                    foreach ($document['childrens'] as $k => $child) {
                                                        ?>
                                                        <tr>
                                                            <td><a href="<?= $uploaded_path.$child['document']?>" target="_Blank"><?= $document['name'] ?></a></td>
                                                            <td>
                                                                <?php
                                                                if($child['doc_version']=='' && ($child['status']==1 || $child['status'] == 2)) {
                                                                    echo $child['user']['role']['role_title'];
                                                                }
                                                                else {
                                                                    echo $child['doc_version'];
                                                                }
                                                                ?>
                                                            </td>
                                                            <td><?= $last==$k && $child['status']==0 ? $this->Html->link(__('<i class="fa fa-upload"></i> Reject'), ['controller'=>'Documents', 'action'=>'add', $document['id'], $client['id']],['escape'=>false, 'class'=>'ajaxmodal btn btn-sm btn-warning', 'data-toggle'=>'modal', 'data-target'=>'#scrollmodal']) : '' ?></td>
                                                            <td>
                                                                <?php
                                                                if($child['status']==2) {
                                                                    echo '<strong>Accepted</strong>';
                                                                }
                                                                elseif($last==$k) { //echo 'last vesion and not accepted';
                                                                    if($activeUser['role_id'] == CLIENT && $child['user']['role_id'] != CLIENT) {
                                                                        echo $this->Html->link(__('<i class="fa fa-upload"></i> Approve'), ['controller'=>'Documents', 'action'=>'approve', $document['id'], $client['id']],['escape'=>false, 'class'=>'ajaxmodal btn btn-sm btn-info', 'data-toggle'=>'modal', 'data-target'=>'#scrollmodal']);
                                                                    }
                                                                    if($activeUser['role_id'] == CONTRACTOR && $child['user']['role_id'] != CONTRACTOR) {
                                                                        echo $this->Html->link(__('<i class="fa fa-upload"></i> Accept'), ['controller'=>'Documents', 'action'=>'approve', $document['id'], $client['id']],['escape'=>false, 'class'=>'ajaxmodal btn btn-sm btn-success', 'data-toggle'=>'modal', 'data-target'=>'#scrollmodal']);
                                                                    }
                                                                }
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php if(!empty($child['user']['client_user']['client'])) {
                                                                    echo $child['user']['client_user']['client']['company_name'];
                                                                }
                                                                else {
                                                                    echo $child['user']['contractor']['company_name'];
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }} // isset($document['childrens']
                                            } }else{ ?>
                                            <tr>
                                                <td colspan="5" style="text-align:center;">No Records available</td>
                                            </tr>
                                        <?php } // !empty($client['documents']
                                        ?>
                                    </table>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php
            }
            ?>
            <!-- signed docs eof -->

            <!-- client forms and docs  bof -->
            <div class="row">
                    <div class="card">
                        <div class="card-header">
                            <strong>Client Forms & Docs</strong>
                        </div>
                        <div class="card-body card-block">
                            <?php
                            if(isset($acceptedDocuments) && count($acceptedDocuments) > 0){
                                foreach ($acceptedDocuments as $client) {
                                    if(empty($client['documents'])) { continue; }
                                    ?>
                                    <div style="margin:10px 5px">
                                        <strong>Client:</strong> <?= $client['company_name'] ?>
                                    </div>
                                    <table class="table">
                                        <tr>
                                            <th scope="row"><?= __('Document Name') ?></th>
                                            <th scope="row"><?= __('Status') ?></th>
                                            <th scope="row"><?= __('Uploaded By') ?></th>
                                        </tr>
                                        <?php
                                        if(!empty($client['documents'])) {
                                            foreach ($client['documents'] as $document) {
                                                if(isset($document['accepted'])){
                                                    foreach ($document['accepted'] as $k => $child) { ?>
                                                        <tr>
                                                            <td><a href="<?= $uploaded_path . $child['document'] ?>" target="_Blank"><?= $document['name'] ?></a></td>
                                                            <td><strong>Final</strong></td>
                                                            <td>
                                                                <?php if(!empty($child['user']['client'])) {
                                                                    echo $child['user']['client']['company_name'];
                                                                } else {
                                                                    echo $child['user']['contractor']['company_name'];
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }}
                                            } }else{ ?>
                                            <tr>
                                                <td colspan="3" style="text-align:center;">No documents available.</td>
                                            </tr>
                                        <?php }	?>
                                    </table>
                                    <?php
                                }
                            }else{
                                echo 'No documents available';
                            }

                            ?>
                        </div>
                    </div>
                </div>
            <!-- client forms and docs  eof -->

            <!-- Forms & Docs bof -->
            <div class="row">
                    <div class="card">
                        <div class="card-header">
                            <strong>Forms & Docs</strong>
                        </div>
                        <div class="card-body card-block">
                            <table class="table">
                                <tr>
                                    <th scope="row"><?= __('Client Name') ?></th>
                                    <th scope="row"><?= __('Document Name') ?></th>
                                    <th scope="row" class="text-center"><?= __('Download') ?></th>
                                    <?php if(isset($activeUser) && ($activeUser['role_id'] == SUPER_ADMIN || $activeUser['role_id'] == ADMIN)) { ?>
                                        <th scope="row" class="text-center"><?= __('Upload') ?></th>
                                    <?php } ?>
                                </tr>
                                <?php
                                if(!empty($formsNDocs)) {
                                    foreach ($formsNDocs as $val) { ?>
                                        <tr>
                                            <td><?= $val->has('client') ? $val->client->company_name : '' ?></td>
                                            <td><a href="<?php echo $uploaded_path.$val->document;?>" target="_Blank"><?= $val->name ?></a></td>
                                            <td class="text-center"><a href="<?php echo $uploaded_path.$val->document;?>" target="_Blank"><i class="fa fa-download"></i></a></td>
                                            <?php if(isset($activeUser) && ($activeUser['role_id'] == SUPER_ADMIN || $activeUser['role_id'] == ADMIN)) {?>
                                                <td class="text-center"><?= $this->Html->link(__('<i class="fa fa-upload"></i>'), ['controller'=>'ContractorDocs', 'action'=>'add', $val->client_id, $val->id],['escape'=>false, 'class'=>'ajaxmodal', 'data-toggle'=>'modal', 'data-target'=>'#scrollmodal']) ?></td>
                                            <?php } ?>
                                        </tr>
                                        <?php
                                    } }else{ ?>
                                    <tr>
                                        <td colspan="4" style="text-align:center;">No Records available</td>
                                    </tr>
                                <?php }
                                ?>
                            </table>
                        </div>
                    </div>
            </div>
            <!-- Forms & Docs eof -->

            <!-- reviews bof -->
            <?php if($activeUser['role_id'] == SUPER_ADMIN || $activeUser['role_id'] == ADMIN) { ?>
            <div class="row">
                            <div class="card">
                                <div class="card-header">
                                    <strong>Reviews</strong>
                                </div>
                                <div class="card-body card-block">
                                    <table class="table">
                                        <tr>
                                            <th scope="row"><?= __('Client') ?></th>
                                            <th scope="row"><?= __('Category') ?></th>
                                            <th scope="row"><?= __('Status') ?></th>
                                        </tr>
                                        <?php
                                        if(!empty($reviews)) {
                                            foreach ($reviews as $review) { ?>
                                                <tr>
                                                    <td><?= $review->has('client') ? $review->client->company_name : '' ?></td>
                                                    <td><?= $review->has('benchmark_category') ? $review->benchmark_category->name : $review->category ?></td>
                                                    <td><i class="fa fa-circle color-<?= $review->icon ?>"></i></td>
                                                </tr>
                                            <?php } }else{ ?>
                                            <tr>
                                                <td colspan="3" style="text-align:center;">No Records available</td>
                                            </tr>
                                        <?php } ?>
                                    </table>
                                </div>
                            </div>
                        </div>
            <?php } ?>
            <!-- reviews eof -->

            <?php if($activeUser['role_id'] == SUPER_ADMIN || $activeUser['role_id'] == CLIENT ||$activeUser['role_id'] == ADMIN) { ?>
            <!--Rate and Write a Review-->
            <div class="row">
                            <div class="card">
                                <div class="card-header">
                                    <strong>Rate and Write a Review</strong>
                                    <?= $reviewRatearr[1] > 3 ?  $this->Html->link(__('View All'), ['controller'=>'Reviews', 'action'=>'index'], ['class'=>'ajaxmodal pull-right', 'data-toggle'=>'modal', 'data-target'=>'#scrollmodal', 'escape'=>false, 'title'=>'Review']) : '' ?>
                                </div>
                                <?php
                                if($reviewRatearr[1]!=null)
                                { ?>
                                    <div class="card-header">
                                        <?php
                                        $avg=($overallReview / $reviewRatearr[1]);
                                        echo "Overall Rating : ";
                                        $starNumber = $avg;
                                        for ($x = 1; $x <= $starNumber; $x++) { echo '<i class="fa fa-star glow"></i>';}
                                        if (strpos($starNumber, '.')) { echo '<i class="fa fa-star-half-o glow"></i>'; $x++;}
                                        while ($x <= 5) { echo '<i class="fa fa-star-o"></i>'; $x++; }
                                        ?>
                                    </div>
                                    <?php
                                }
                                ?>

                                <div class="card-body card-block">
                                    <?php if($client_id!=null && $reviewRatearr[0] == 0) {
                                        echo '<p>'.$this->Html->link(__('Rate and Write a Review'), ['controller'=>'Reviews', 'action'=>'add'], ['class'=>'ajaxmodal', 'data-toggle'=>'modal', 'data-target'=>'#scrollmodal', 'title'=>'Rate and Write a Review']).'</p>';
                                    }else { ?>
                                        <table class="table">
                                        <tr>
                                            <th scope="row" width="100"><?= __('Rating') ?></th>
                                            <th scope="row"><?= __('Review') ?></th>
                                            <th scope="row"><?= __('Author') ?></th>
                                        </tr>
                                        <?php if(!empty($reviewRatearr[2])) {
                                            foreach ($reviewRatearr[2] as $review) { ?>
                                                <tr>
                                                    <td>
                                                        <?php
                                                        $id =$review->id;
                                                        $rate =$review->rating;
                                                        $starNumber = $rate;
                                                        for ($x = 1; $x <= $starNumber; $x++) { echo '<i class="fa fa-star glow"></i>';}
                                                        if (strpos($starNumber, '.')) { echo '<i class="fa fa-star-half-o glow"></i>'; $x++;}
                                                        while ($x <= 5) { echo '<i class="fa fa-star-o"></i>'; $x++; }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $string = $review->reviewtxt;
                                                        if (strlen($string) > 60) {
                                                            $trimstring = substr($string, 0, 60).$this->Html->link(__(' Read More..'), ['controller'=>'Reviews', 'action'=>'review',$review->id], ['class'=>'ajaxmodal', 'data-toggle'=>'modal', 'data-target'=>'#scrollmodal', 'escape'=>false, 'title'=>'Review']);
                                                        } else {
                                                            $trimstring = $string;
                                                        }
                                                        echo $trimstring;
                                                        ?>
                                                    </td>
                                                    <td><i><?= $review->has('client') ? $review->client->company_name : '' ?></i></td>
                                                </tr>
                                                <?php
                                            } }else{ ?>
                                            <tr>
                                                <td colspan="3" style="text-align:center;">No Records available</td>
                                            </tr>
                                        <?php }	?>
                                        </table><?php } ?>
                                </div>
                            </div><!-- card -->
                        </div>
            <?php
            }
            ?>

        </div>
        <!-- coloumn second bof -->
</div>


<div class="modal fade" id="scrollmodal" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scrollmodalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>
<style>
    .submit input{
        margin-top: 10px;
    }
</style>
<!-- CDN script production environment -->
<script src="https://static.golendica.com/v2/lendica.js"></script>
<script>
    jQuery( function() {
        jQuery( "#datepicker" ).datepicker();

        credentials = {
            partner_name: "canqualify",
            partner_company_uuid: "<?php echo (isset($contractor->id)) ? $contractor->id : '';?>",
            company_name: "<?php echo (isset($contractor->company_name)) ? $contractor->company_name : '';?>"
        };

        lendica.init(credentials).then(() => {
            lendica.ibranch.render();
        });

    } );
</script>
