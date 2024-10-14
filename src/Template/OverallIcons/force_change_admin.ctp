<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Icon $icon
 */
use Cake\Core\Configure;
$iconList = Configure::read('icons');
?>
<div class="row overallIcons">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
	<?= $review!=null ? '<strong>Review For</strong> '.$contractor->company_name : '<strong>Force Change Icon Status For</strong> '.$contractor->company_name ?>
	</div>
	<div class="card-body card-block">
	<?= $this->Form->create($overallIcon) ?>
	<?php $selectedClient = !empty($client) ? $client->id : reset($clients); ?>
	<div class="row form-group">
		<label class="col-sm-3">Select Client</label>
		<div class="col-sm-3"><?= $this->Form->control('current_client_id', ['options'=>$clients, 'default'=>$selectedClient, 'required'=>true, 'label'=>false, 'class'=>'form-control']); ?></div>
		<div class="col-sm-3"><?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type'=>'submit', 'class'=>'btn btn-primary btn-sm']) ?></div>
	</div>
	<?= $this->Form->end() ?>
	</div>

<?php if(!empty($client)) : ?>
	<div class="card-header">
		<strong>CanQualify Client: <?= $client->has('company_name') ? $client->company_name : ''; ?></strong>
	</div>
	<div class="card-body card-block">
	<?= $this->Form->create($overallIcon, ['type'=>'file']) ?>
	<?php
	if(isset($overallIconPrev) && $overallIconPrev != null) {
	?>
		<div class="row form-group">
		<div class="col-sm-12">
			<div class="row">
				<label class="col-sm-5">Current Overall Status :</label>
				<div class="col-sm-1"><i class="fa fa-circle color-<?= $overallIconPrev->icon ?>"></i></div>
				<?= isset($categories[$overallIconPrev->category]) ? '<div class="col-sm-6"><b>Category : </b>'.$categories[$overallIconPrev->category].'</div>' : '' ?>
			</div>
			<?php
			if(!empty($overallIconPrev->icons)) {
			$i=0;
			foreach($overallIconPrev->icons as $icn) { ?>
			<div class="row">
				<?php if(isset($icn->benchmark_type)) { ?>
				<label class="col-sm-5">Current <?= $icn->benchmark_type->name ?> Status :</label>
				<div class="col-sm-1"><i class="fa fa-circle color-<?= $icn->icon ?>"></i></div>
				<?php } ?>
				<?= isset($categories[$icn->category]) ? '<div class="col-sm-6"><b>Category : </b>'.$categories[$icn->category].'</div>' : '' ?>
			</div>
			<?php
			$i++; 
			}
			}
			?>
		</div>
		</div>
		<hr>
	<?php
	}
	elseif($suggestedOverallIcon != null) { 
	?>
		<div class="row form-group">
			<label class="col-sm-5"><b>No. of employees in given year:</b></label>
			<div class="col-sm-4">
				<table class="table">
					<tr>
						<th>Year</th>
						<th>No. of Employees</th>
					</tr>
					<?php foreach($noOfEmp as $year => $cnt) { ?>
					<tr>
						<td><?= $year ?></td>
						<th><?= $cnt ?></th>
					</tr>
					<?php }?>
				</table>
			</div>
		</div>
		<hr>

		<div class="row form-group">
		<div class="col-sm-12">
			<div class="row">
				<label class="col-sm-5">Suggested Overall Status :</label>
				<div class="col-sm-1"><i class="fa fa-circle color-<?= $suggestedOverallIcon->icon ?>"></i></div>
				<?= isset($categories[$suggestedOverallIcon->category]) ? '<div class="col-sm-6"><b>Category :</b>'.$categories[$suggestedOverallIcon->category]. '</div>' : '' ?>
			</div>
			<?php
			if(!empty($suggestedOverallIcon->suggested_icons)) { 
				$i=0;				
				foreach($suggestedOverallIcon->suggested_icons as $icn) {
				/*if($icn->client_id == 6 && ($icn->benchmark_type_id == 2 ||$icn->benchmark_type_id == 3 ||$icn->benchmark_type_id == 4) ) { ?>
					<div class="row">
					<?php if(isset($icn->benchmark_type)) { ?>
					<label class="col-sm-5">Suggested <?= $icn->benchmark_type->name ?> Status :</label>				
					<div class="col-sm-3"><?=$iconList[$icn->icon] ?></div>
					<?php }  ?>					
					</div>
					
				 }else{	*/ ?> 					
				<div class="row">
					<?php if(isset($icn->benchmark_type)) { ?>
					<label class="col-sm-5">Suggested <?= $icn->benchmark_type->name ?> Status :</label>				
					<div class="col-sm-1"><i class="fa fa-circle color-<?= $icn->icon ?>"></i></div>
					<?php }  ?>
					<?= isset($categories[$icn->category]) ? '<div class="col-sm-6"><b>Category :</b>'. $categories[$icn->category].'</div>' : '' ?>
				</div>
				<?php //}
				$i++; 
				}
			if(!empty($suggestedOverallIcon->msg)){ ?>
			<div class="row">
				<div class="col-sm-9"><?= $suggestedOverallIcon->msg; ?></div></div>
			<?php }
			}
			?>
		</div>
		</div>
		<hr>
		<?php
	}

	if($suggestedOverallIcon != null) {
		if($suggestedOverallIcon->client_id == 6 && $review!=null){ ?>
		<div class="row form-group">
		<label class="col-sm-5">Update Overall Status</label>			
			<div class="col-sm-4"> 
			<?= $this->Form->control('icons.overall_icon', ['options'=>$icons, 'type'=>'radio', 'required'=>true, 'label'=>false]); ?>
			</div>
		</div>
		<?php } ?>		
	<?php
		if(!empty($suggestedOverallIcon->suggested_icons)) { 		 		
		$i=0;
		foreach($suggestedOverallIcon->suggested_icons as $icn) { 
		//$benchCategories = $this->SafetyReport->getBenchmarkCategories($icn->client_id, $icn->bench_type);
		/*if($icn->client_id == 6 && ($icn->benchmark_type_id == 2 ||$icn->benchmark_type_id == 3 ||$icn->benchmark_type_id == 4) ) {
			continue;
		}*/		
		?>
		<div class="row form-group">			
			<?php if(isset($icn->benchmark_type)) { ?>
			<label class="col-sm-5">Update <?= $icn->benchmark_type->name ?> Status</label>
			<div class="col-sm-4">
			<?= $this->Form->control('icons.'.$i.'.icon', ['options'=>$icons, 'type'=>'radio', 'required'=>true, 'label'=>false]); ?>
			</div> 
			<?php } else {
			  if($review == null){ ?>
				<label class="col-sm-4">Update Overall Status</label>		
				<?= $this->Form->control('icons.'.$i.'.icon', ['options'=>$icons, 'type'=>'radio', 'required'=>true, 'label'=>false]); ?>
			<?php } } ?>
			<?php if($review!=null ) {
				if($icn->benchmark_type_id == 11) {  ?>
			    <div class="col-sm-9" style="padding-left: 0px;">
			    <?= $this->Html->link(__('View All Craft Certificates'), ['controller'=>'EmployeeExplanations', 'action'=>'exp_list', $icn->contractor_id,$review], ['escape'=>false, 'title'=>'Craft Certificates', 'class'=>'nav-link','target'=>'_BLANK']) ?>
			    </div>
			    <?php } 
                if(!empty($categories)) {  ?>
			    <div class="col-sm-3">
			    <?php echo $this->Form->control('icons.'.$i.'.category', ['options'=>$categories, 'empty'=>[''=>'Select Category'], 'class'=>'form-control', 'label'=>false]); ?> 
			    </div>
			    <?php } 
            } else { ?>
				<?= $this->Form->control('icons.'.$i.'.is_forced', ['type'=>'hidden', 'value'=>1]); ?>
			<?php }
			?>
			<?php if(isset($icn->benchmark_type)) { ?>
			<?= $this->Form->control('icons.'.$i.'.benchmark_type_id', ['type'=>'hidden', 'value'=>$icn->benchmark_type->id]); ?>
			<?php } ?>
			<?= $this->Form->control('icons.'.$i.'.client_id', ['type'=>'hidden', 'value'=>$icn->client_id]); ?>
			<?= $this->Form->control('icons.'.$i.'.contractor_id', ['type'=>'hidden', 'value'=>$icn->contractor_id]); ?>
			<?= $this->Form->control('icons.'.$i.'.created_by', ['type'=>'hidden', 'value'=>$userId]); ?>		
			<?php if(isset($overallIconPrev) && $overallIconPrev->icons != null) {?>
				<?= $this->Form->control('icons.'.$i.'.icon_from', ['type'=>'hidden', 'value'=>$overallIconPrev->icons[$i]->icon]); ?>
			<?php }
			?>
		</div>
		<?php
		$i++;
		}
            /*hardcoded for insurance iwatani*/
            if(isset($client_id) && $client_id == 19) {
                                                ?>
                                                <div class="row form-group">
                                                            <label class="col-sm-5">Update Insurance Status</label>
                                                            <div class="col-sm-4">
                                                                        <?php echo $this->Form->control('icons.' . $i . '.benchmark_type_id', ['type' => 'hidden', 'value' => 16]);
                                                                        echo $this->Form->control('icons.' . $i . '.client_id', ['type' => 'hidden', 'value' => 19]);
                        echo $this->Form->control('icons.' . $i . '.contractor_id', ['type' => 'hidden', 'value' => $contractor->id]);
                        echo $this->Form->control('icons.' . $i . '.created_by', ['type' => 'hidden', 'value' => $userId]);
                        echo $this->Form->control('icons.' . $i . '.icon', ['options' => $icons, 'type' => 'radio', 'required' => true, 'label' => false]);
                        ?>
                                                                    </div>
                                                        </div>
                                                <?php
            }
		}
	}
	else { ?>
		<div class="row form-group">
			<label class="col-sm-5">OVERALL Status</label>
			<div class="col-sm-4"><?php echo $this->Form->control('icon', ['options'=>$icons, 'type'=>'radio', 'required'=>true, 'label'=>false]); ?></div>
            <?php if(!empty($categories)) { ?>
			<div class="col-sm-3">
				<?php echo $this->Form->control('category', ['options'=>$categories, 'empty'=>[''=>'Select Category'], 'class'=>'form-control', 'label'=>false]); ?>
			</div>
            <?php } ?>			
		</div>
	<?php
	}
	if(isset($overallIconPrev) && $overallIconPrev != null) {
		echo $this->Form->control('icon_from', ['type'=>'hidden', 'value'=>$overallIconPrev->icon]);
	}

    if($review!=null) {
	    echo $this->Form->control('review', ['type'=>'hidden', 'value'=>$review]);
    }
    else {
        echo $this->Form->control('is_forced', ['type'=>'hidden', 'value'=>1]);
    }
    ?>

	<div class="row form-group">
		<?= $this->Form->label('Document', null, ['class'=>'col-sm-5']); ?><br />
		<div class="col-sm-7 uploadWraper">
			<?php echo $this->Form->control('documents', ['label'=>false, 'type'=>'hidden', 'class'=>'documentName']); ?>
			<?php echo $this->Form->file('uploadFile', ['label'=>false]); ?>
			<div class="uploadResponse"></div>
		</div>
	</div>
	<div class="row form-group">
		<label class="col-sm-5">Note</label>
		<div class="col-sm-7"><?= $this->Form->control('notes', ['class'=>'form-control', 'required'=>false, 'label'=>false]); ?></div>
	</div>
	<div class="row form-group">
        <div class="col-sm-5"></div>
		<div class="col-sm-4">
			<?php echo $this->Form->control('show_to_contractor', ['label'=>'Show Note To Contractor']); ?>
		</div>
		<div class="col-sm-3">
			<?php echo $this->Form->control('show_to_clients', ['label'=>'Show Note To Client']); ?>
		</div>
	</div>
	<div class="form-actions form-group">
		<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type'=>'submit', 'class'=>'btn btn-primary btn-sm']) ?>
	</div>
	<?= $this->Form->end() ?>
	</div>
<?php endif; ?>
</div>
</div>
</div>
