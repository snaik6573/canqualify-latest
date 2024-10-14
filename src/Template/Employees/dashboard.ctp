<?php
/*
 */
use Cake\Core\Configure;
$uploaded_path = Configure::read('uploaded_path');
$this->assign('title', 'Dashboard');
$trainings = $this->Training->getTrainings($activeUser);
$empContractors = $this->User->getEmpContractors($employee_id);
?>
<div class="row contractors">
<div class="col-lg-4">
<div class="card">
	<div class="card-header">
		<strong>Employee Info</strong>
	</div>
	<div class="card-body card-block">
	<table class="table">
		<tr>
			<th scope="row"><?= __('Primary Contact') ?></th>
			<td><?= h($employee->pri_contact_fn).' '.h($employee->pri_contact_ln) ?></td>
		</tr>
		<?php if($employee['user_entered_email']== true) { ?>
		<tr>
			<th scope="row"><?= __('Email') ?></th>
			<td style="word-wrap: anywhere;"><?= h($employee->user->username) ?></td>
		</tr>
		<?php } ?>

        <?php if($employee['user_entered_email']== false && $employee->user->login_username != '') { ?>
            <tr>
                <th scope="row"><?= __('Username') ?></th>
                <td style="word-wrap: anywhere;"><?= h($employee->user->login_username) ?></td>
            </tr>
        <?php } ?>

		<tr>
			<th scope="row"><?= __('Phone') ?></th>
			<td><?= h($employee->pri_contact_pn) ?></td>
		</tr>
	</table>
	</div>
</div>

<div class="card">
	<div class="card-header">
		<strong>Customer Service</strong>
	</div>
	<div class="card-body card-block">
	<table class="table">
	<?php /*foreach ($customer_rep as $crp) : ?>
	<tr>
	<td>
		<div><?= $crp->pri_contact_fn .' '.$crp->pri_contact_ln  ?></div>
		<div><b>Phone : </b><?= $crp->pri_contact_pn ?> &nbsp;&nbsp;&nbsp;<b>Ext. : </b><?= $crp->extension ?></div>
		<b>Email : </b><a href="mailto:<?= $crp->user->username ?>" target="_top"><?= $crp->user->username ?></a>
	</td>
	</tr>
	<?php endforeach; */ ?>
	<tr>
	<td>
		<div>General Customer Service</div>
		<div><b>Phone :</b> <?= Configure::read('customer_service.phone_no');?></div>
	</td>
	</tr>
	</table>
	</div>
</div>
</div>

<div class="col-lg-4">
<div class="card">
	<div class="card-header">
		<strong>Employee Status</strong>
	</div>
	<div class="card-body card-block">
	<table class="table">
		<tr>
			<th scope="row"><?= __('Last Login') ?></th>
			<td><?php echo $activeUser['last_login']; ?></td>
		</tr>
		<tr>
		    <th scope="row"><?= __('Status') ?></th>
		    <td><?= $employee->user->active ? __('Active') : __('Inactive'); ?></td>
		</tr>
	</table>
	</div>
</div>

</div>
    <?php if(!empty($empContractors)){ ?>
 <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <strong>Open Tasks </strong>
            </div>
            <div class="card-body card-block">
			<?php
			//$clients =   $this->User->getEmployeeClients($employee_id,$contractor_id);

			$getCraftCertCount = $this->User->getCraftCertificate(null,$employee_id);
            $clients =   $this->User->getClients($contractor_id);
		    if($getCraftCertCount < 1 && in_array(6, $clients) || in_array(19, $clients)){
		        echo '<p>'.$this->Html->link('Upload your Craft Certifications and/or Safety Training Records', ['controller'=>'EmployeeExplanations', 'action'=>'add',$employee_id], ['escape'=>false, 'title'=>'Upload your Craft Certifications']).'<a href="javascript:void();" data-toggle="popover" title="" data-content="If a license is required by law, upload license, i.e. plumbing, electrical, etc. If a license is not required by law, then upload OSHA 30 hr for supervisors and OSHA 10 hr for subordinates, or upload all relevant certificates and training documentation to validate competencies for the work being performed" style="margin-left: 15px;"><i class="fa fa-info-circle"></i></a>'.'</p>';
		    }

		    if(!empty($empContractors)){
		    $clients =   $this->User->getEmployeeClients($employee_id,$contractor_id);
			$total_complete = true;
			$final_submit = true;
			$categories = $this->EmployeeCategory->getCategories($contractor_id,$employee_id);
			$trainings_sites = $this->Training->getTrainingSites($employee_id);
			$trainingShow = false;
			$catShow = false;
           	if(!empty($categories)){
                  foreach ($categories as $cat) {
                    if($cat['getPerc'] != '100%') {
                    $catShow = true;
                    continue;
                  }
               }}

			foreach($trainings_sites as $key => $Trainings) {  ?>
				<?php foreach($Trainings as $training) {
				if($training['getPerc'] != '100%') {
                    $final_submit = false;
				    $total_complete = false;
				    $trainingShow = true;

				    break;
				}
				}
				if($final_submit){
			    	continue;
				}
			}

			if($trainingShow ==false && $catShow==false && $getCraftCertCount >= 1 && in_array(6, $clients)){
                  echo '<span style="">No Open Tasks!</span>';
            }elseif($trainingShow ==false && $catShow==false && (!in_array(6, $clients)) && (!in_array(19, $clients))) {
                  echo '<span style="">No Open Tasks!</span>';

             }else{ ?>
				<ul class="open_tasks nav navbar-nav">
				<?php  $colloseShow = 'collapse';
				foreach ($trainings as $training) {
					//($training) ?  $colloseShow = 'collapse show' : $colloseShow = 'collapse';
					if($training['getPerc'] != '100%') {  $colloseShow = 'collapse show'; break; }
				} ?>
			    <li class="menu-item-has-children dropdown">
				<a href="#" class="dropdown-toggle <?= $colloseShow;?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Complete Orientations:</a>
				<ul class="sub-menu children dropdown-menu">
				<?php
				foreach($trainings as $training) {
				if($training['getPerc'] != '100%') { ?>

				<?php	echo '<li>'. $this->Html->link(__($training['name'].' '.$training['getPerc']), ['controller'=>'training-answers', 'action'=>'addAnswers', 4, $training['id']], ['escape'=>false, 'title'=>$training['name']]).'</li>'; ?>

				<?php }
				}?>
				</ul>
			</li>
				<?php  $colloseShow = 'collapse';
				foreach ($categories as $cat) {
					//($cat) ?  $colloseShow = 'collapse show' : $colloseShow = 'collapse';
					if($cat['getPerc'] != '100%')   {  $colloseShow = 'collapse show'; break; }
				} ?>
				<li class="menu-item-has-children dropdown">
				<a href="#" class="dropdown-toggle <?= $colloseShow;?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Complete Categoires:</a>
				<ul class="sub-menu children dropdown-menu">
				<?php
				foreach($categories as $cat) {
				if($cat['getPerc'] != '100%') { ?>
				<?php	echo '<li>'. $this->Html->link(__($cat['name'].' '.$cat['getPerc']), ['controller'=>'employee-answers', 'action'=>'add', $cat['id']], ['escape'=>false, 'title'=>$cat['name']]).'</li>'; ?>

			<?php	}
				}?>
			  </ul>
			</li>
			</ul>
		<?php } }?>
            </div>
        </div>
    </div>
<?php } ?>
    
    <?php if(isset($formsNDocs)) { ?>
        <div class="col-lg-6">
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
            </div><!-- card -->
        </div>
        <?php
    }
    ?>


    <?php if(!empty($empContractors)){ ?>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <strong>Orientation Matrix</strong>
                </div>
                <div class="card-body card-block">
                    <table class="table">
                        <tr>
                            <th scope="row"><?= __('Orientations') ?></th>
                            <!--<th scope="row"><?= __('Sites') ?></th>-->
                            <th scope="row"><?= __('Status') ?></th>
                            <th scope="row"><?= __('Completion Date') ?></th>
                            <th scope="row"><?= __('Completion Certificate') ?></th>
                        </tr>
                        <?php
                        $rowspan = 0;
                        $rowspan = count($orientationMatrix);
                        if(isset($orientationMatrix) && count($orientationMatrix) > 0){
                            $onlyOnce = 0;
                            foreach ($orientationMatrix as $orientation) {
                                if(isset($orientation['training']->active) && $orientation['training']->active){
                                //debug($orientation->client_id);
                                echo '<tr>';
                                echo '<td>' . $orientation['training']->name . '</td>';
                                //echo '<td>'.$orientation['work_locations'].'</td>';
                                echo '<td>';
                                echo (isset($orientation['percentage']) && $orientation['percentage'] == 100) ? 'Complete' : 'Incomplete';
                                echo '</td>';
                                    echo '<td>';
                                    echo (isset($orientation['completion_date'])) ? date("m-d-Y", strtotime($orientation['completion_date'])) : '';
                                    echo '</td>';
                                if (isset($orientation['percentage']) && $orientation['percentage'] == 100) {
                                    $training_id = (isset($orientation['training_id'])) ? $orientation['training_id'] : 0;
                                    $employee_id = (isset($orientation['employee_id'])) ? $orientation['employee_id'] : 0;
                                    //client_id = 3 = BAE - ES
                                    //trainig_id = 19 = BAE Systems ES - Contractor Safety & Hazard Awareness Orientation
                                    if (isset($orientation->client_id) && $orientation->client_id == 3) {
                                        if (isset($orientationCompleteFlag) && $orientationCompleteFlag == 100 && $onlyOnce == 0) {
                                            echo '<td style="text-align: center;" rowspan="' . $rowspan . '">';
                                            echo $this->Html->link(__('<i class="fa fa-download"></i>'), ['controller' => 'Employees', 'action' => 'certify-completion', $training_id, $employee_id, $orientation->client_id], ['escape' => false, 'title' => 'Completion Certificate']);
                                            $onlyOnce++;
                                            echo '</td>';
                                        }
                                    } else {
                                        echo '<td style="text-align: center;">';
                                        echo $this->Html->link(__('<i class="fa fa-download"></i>'), ['controller' => 'Employees', 'action' => 'certify-completion', $training_id, $employee_id], ['escape' => false, 'title' => 'Completion Certificate']);
                                        echo '</td>';
                                    }
                                }

                                echo '</tr>';
                            }
                            }

                        }else{
                            echo '<tr><td colspan="3">No Orientations Found.</td></tr>';
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    <?php } ?>
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
