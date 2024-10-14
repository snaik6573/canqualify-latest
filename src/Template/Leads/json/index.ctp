<?php
 if(isset($leads)) {
        $output = array(
            "draw" => intval($_GET['draw']),
            "recordsTotal" => $totalCount,
            "recordsFiltered" => $totalCount,
            "data" => array()
        );
		
	foreach ($leads as $lead):
		$row = []; 
		$row[0] = h($lead->company_name);
		$row[1] = h($lead->contact_name_first).' '.h($lead->contact_name_last);
		$row[2] = h($lead->phone_no);
		$row[3] = h($lead->email);
		$row[4]	= $this->Html->link($lead->client->company_name, ['controller' => 'Clients', 'action' => 'view', $lead->client->id]);
        $row[5] = h(!empty($lead->site->name) ? $lead->site->name : '');
		$row[6] = h($lead->email_count);
		$row[7] = h($lead->phone_count);
		$row[8] = h($lead->lead_status->status);
		$row[9] = h($lead->created);
		
		
		$actionLinks = $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $lead->id],['escape'=>false, 'title' => 'View']).' '; 
		$actionLinks .= $this->Html->link('<i class="fa fa-pencil"></i>', ['action' => 'edit', $lead->id],['escape'=>false, 'title' => 'Edit']).' ';
		if($activeUser['role_id'] == SUPER_ADMIN) {
		$actionLinks .= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['action' => 'delete', $lead->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # {0}?', $lead->id)]);
		}
		$row[10] = $this->Html->link(__('Add'), ['controller' => 'LeadNotes','action'=>'CrLeadNote', $lead->id],['class'=>'btn btn btn-success', 'target'=>'_BLANK'])."<br>".$actionLinks;
	    $output['data'][] = $row;
	endforeach;
	
	echo json_encode($output);
 }
?>