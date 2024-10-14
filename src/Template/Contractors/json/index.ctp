<?php
 if(isset($contractors)) {
        $output = array(
            "draw" => intval($_GET['draw']),
            "recordsTotal" => $totalCount,
            "recordsFiltered" => $totalCount,
            "data" => array()
        );
		
	foreach ($contractors as $contractor): 
		$row = []; 
		$row[0] = $this->Html->link($contractor->company_name, ['controller'=>'Contractors', 'action'=>'dashboard', $contractor->id]);

		$getClients = $this->User->getClients($contractor->id);
	    $clients = [];
	    foreach ($getClients as $cid) {
	        $clients[] = $allClients[$cid];
	    }

		$row[1] =  $this->Html->link(count($clients),'',["data-placement"=>"top", "title"=>implode(',', $clients)]); 
		$contractor->user->active ? '1' : '0';

		/* Contractor Active or deactive ajax Submit */
	    $activeForm = '';
	    $activeForm .= $this->Form->create($contractor,['class'=>'saveAjax', 'data-responce'=>'.alert-wrap']);
	    $activeForm .= $this->Form->control('user.active', ['required'=>false, 'label'=>false, 'class'=>'ajaxClick']);
	    $activeForm .= $this->Form->control('user.username', ['type'=>'hidden']);
	    $activeForm .= $this->Form->control('user.id', ['type'=>'hidden']);
	    $activeForm .= $this->Form->end();
	    /* End form*/

		$row[2] = $activeForm;
		$row[3] = $contractor->payment_status ? __('Yes') : __('No'); 
		$row[4]	= $contractor->waiting_on=='CanQualify' && $activeUser['role_id'] == SUPER_ADMIN ? $this->Html->link(__($contractor->waiting_on), ['controller'=>'OverallIcons', 'action'=>'force-change-admin', 0, $contractor->id, 1], []) : h($contractor->waiting_on);
		$row[5] = $contractor->data_submit ? 'Submitted' : '';
		$row[6] = $contractor->data_submit ? $contractor->data_read ? 'Yes' : 'No' : '';
		$row[7] = $this->Html->link(__('Generate Discount'), ['controller'=>'PaymentDiscounts', 'action'=>'generate_discount',$contractor->id], ['class'=>'ajaxmodal pull-right', 'data-toggle'=>'modal', 'data-target'=>'#scrollmodal', 'escape'=>false, 'title'=>'Generate Discount']);
		$row[8] = h(date('Y/m/d', strtotime($contractor['created'])));
		$row[9] = !empty($contractor->payments) ? date('Y/m/d', strtotime($contractor->payments[0]->created))  : '';
		$row[10]= date('Y/m/d', strtotime($contractor->modified ));

		$actionLinks = $this->Html->link('<i class="fa fa-eye"></i>', ['action'=>'view', $contractor->id],['escape'=>false, 'title'=>'View']).' '; 
		$actionLinks .= $this->Html->link('<i class="fa fa-pencil"></i>', ['action'=>'edit', $contractor->id],['escape'=>false, 'title'=>'Edit']).' '; 
		$contractor->longitude==null && $contractor->latitude==null ? $locCls='noLocation' : $locCls='updateLocation';
		$actionLinks .= $this->Html->link('<i class="fa fa-location-arrow"></i>', ['action'=>'update-location', $contractor->id],['escape'=>false, 'title'=>'Update Location', 'class'=>$locCls]).' '; 
		if($activeUser['role_id'] == SUPER_ADMIN) {
		$actionLinks .= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['action'=>'delete', $contractor->id], ['escape'=>false, 'title'=>'Delete', 'confirm'=>__('Are you sure you want to delete # {0}?', $contractor->id)]);
		}
		$row[11]= $actionLinks;
		
	
	    $output['data'][] = $row;
	endforeach;
	
	echo json_encode($output);
 }
?>