<?php
 if(isset($users)) {
        $output = array(
            "draw" => intval($_GET['draw']),
            "recordsTotal" => $totalCount,
            "recordsFiltered" => $totalCount,
            "data" => array()
        );
		
	foreach ($users as $user):
		$row = []; 
		$row[0] = $this->Number->format($user->id);
		
		if($user->role_id == CLIENT && $user->has('client')) {
		$row[1] = $this->Html->link($user->username, ['controller' => 'Clients', 'action' => 'view', $user->client->id]);
		//$row[2] = h($user->client->company_name);
		//$row[3] = h($user->client->pri_contact_fn . ' ' .$user->client->pri_contact_ln);
		}
		elseif($user->role_id == CONTRACTOR && $user->has('contractor')) {
		$row[1] = $this->Html->link($user->username, ['controller' => 'Contractors', 'action' => 'view', $user->contractor->id]);
		//$row[2] =  h($user->contractor->company_name);
		//$row[3] =  h($user->contractor->pri_contact_fn . ' ' .$user->contractor->pri_contact_ln);
		}
		elseif($user->role_id == EMPLOYEE && $user->has('employee')) {
		$row[1] = $this->Html->link($user->username, ['controller' => 'Employees', 'action' => 'view', $user->employee->id]);
		//$row[2] =  h($user->employee->contractor->company_name);
		//$row[3] =  h($user->employee->pri_contact_fn . ' ' .$user->employee->pri_contact_ln);	
		}
		elseif(in_array($user->role_id, CLIENT_USERS) && $user->has('client_user')) {
		$row[1] = $this->Html->link($user->username, ['controller' => 'ClientUsers', 'action' => 'view', $user->client_user->id]);
		//$row[2] =  h($user->client_user->client->company_name);
		//$row[3] =  h($user->client_user->pri_contact_fn . ' ' .$user->client_user->pri_contact_ln);
		}
		elseif(in_array($user->role_id, CONTRACTOR_USERS) && $user->has('contractor_user')) {
		$row[1] = $this->Html->link($user->username, ['controller' => 'ContractorUsers', 'action' => 'view', $user->contractor_user->id]);
		//$row[2] =  h($user->contractor_user->contractor->company_name);
		//$row[3] =  h($user->contractor_user->pri_contact_fn . ' ' .$user->contractor_user->pri_contact_ln);
		}
		elseif($user->role_id == CR && $user->has('customer_representative')) {
		$row[1] = $this->Html->link($user->username, ['controller' => 'CustomerRepresentative', 'action' => 'view', $user->customer_representative->id]);
		//$row[2] = 'Canqualify';
		//$row[3] =  h($user->customer_representative->pri_contact_fn . ' ' .$user->customer_representative->pri_contact_ln);
		}
		else {
		$row[1] = h($user->username);
		//$row[2] = in_array($user->role_id, ADMIN_ALL) ? 'Canqualify' : '';
		//$row[3] = '';
		}
	
		$row[2] = h($user->role->role_title);
		
        //$activeForm = '<span style="display:none;">'.$user->active ? '1' : '0'.'</span>';
		$activeForm = '';
		$activeForm .= $this->Form->create($user,['class'=>'saveAjax', 'data-responce'=>'.alert-wrap', 'id'=>false]);
		$activeForm .= $this->Form->control('active', ['required' => false, 'label'=> false, 'class'=>'ajaxClick', 'id'=>false]);
		$activeForm .= $this->Form->control('id', ['type'=>'hidden', 'id'=>false]);
		$activeForm .= $this->Form->end();
		$row[3] = $activeForm;
		
		$actionLinks = $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $user->id],['escape'=>false, 'title' => 'View']).' ';
		$actionLinks .= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'edit', $user->id],['escape'=>false, 'title' => 'Edit']).' ';
		if($activeUser['role_id'] == SUPER_ADMIN) {
			$actionLinks .= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['action' => 'delete', $user->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # {0}?', $user->id)]);
		}
		$row[4] = $actionLinks;
		
		$output['data'][] = $row;
		
	endforeach;
	
	echo json_encode($output);
 }
?>