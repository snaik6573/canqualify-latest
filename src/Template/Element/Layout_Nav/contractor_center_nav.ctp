<?php if(isset($contractorNav) && $contractorNav == true && isset($activeUser['contractor_id'])) { ?>
	<div class="contractorNav navbar-wraper mb-3 clearfix">
	<nav class="navbar navbar-expand-lg navbar-light bg-white">
	  <ul class="navbar-nav cat-nav">
		<li class="nav-item">
		  <?= $this->Html->link(__(!empty($activeUser['contractor_company_name']) ? $activeUser['contractor_company_name'] : 'Supplier'.' Dashboard'), ['controller'=>'Contractors', 'action'=>'dashboard', $activeUser['contractor_id']], ['class'=>'nav-link btn btn-secondary']) ?>
		</li>		
		<?php
		$services = $this->Category->getServices($activeUser['contractor_id']);
		$sites = $this->User->getContractorSites($activeUser['contractor_id']);
		
		if($activeUser['role_id'] == CLIENT){
			$client[] = $this->getRequest()->getSession()->read('Auth.User.client_id');	
		}else{
			$client = $this->User->getClients($activeUser['contractor_id']);
		}
		
		//$user = array(CLIENT);	
		/*if(in_array('', $client)){
		$client = $this->User->getClients($activeUser['contractor_id']);
		}*/	
		
		foreach ($services as $service_id => $service_name) {
		    $catNext = $service_id;	          
			$categories = $this->Category->getServiceCategories($activeUser, $service_id);
            if(!empty($categories)){	
			    $catNext = $this->Category->getNextcat($categories, 0, $service_id);
	        }

		if(!empty($service_id) && $service_id == 4) {
			/*if(count($client) == 1 && in_array(3, $client)) { // if only associates to BAE
				if($activeUser['role_id'] == CLIENT){
					if(count($sites) == 0 && !in_array(7, $sites) ) {
					continue; // do not show employeeQual service
				    }
				}
				else{
					if((count($sites) == 0) || (!in_array(7, $sites)) ) {
					continue; // do not show employeeQual service
				    }
				}
			}*/
		?>
		    <li class="nav-item"><?= $this->Html->link(__($service_name), ['controller'=>'employees', 'action'=>'index/'.$service_id], ['class'=>'nav-link btn btn-secondary']) ?></li>
		<?php
		}
		else {
		?>
		    <li class="nav-item"><?= $this->Html->link(__($service_name), ['controller'=>'ContractorAnswers', 'action'=>'addAnswers/'.$catNext], ['class'=>'nav-link btn btn-secondary']) ?></li>
		<?php
		}
		}
		?>
	  </ul>
     <!--   <ul class="text-right">
	  <li class="nav-item"><?= $this->Html->link(__('Contractor Contacts'), ['controller'=>'ContractorUsers', 'action'=>'contractorContacts'], ['class'=>'nav-link btn']) ?></li>
	  </ul> -->
	  <ul class="text-right">
	  <li class="nav-item"><?= $this->Html->link(__('Notes'), ['controller'=>'Notes', 'action'=>'contractorNotes'], ['class'=>'nav-link btn']) ?></li>
	  </ul>     
   	</nav>
	</div>
	<?php } ?>
