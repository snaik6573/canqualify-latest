<div class="col-lg-6">
<div class="card">
	<div class="card-header">
		<strong>Employee Level Open Tasks</strong>
	</div>
	<div class="card-body card-block">
	<?php if(!empty($employees)){
			$trainings_sites = array();
			$openTask = false;
			
			$i=0;
			foreach ($employees as $key => $emp) {
				if(!empty($emp['id'])) {
				$trainings_sites[$emp['id']] = $this->Training->getTrainingSites($emp['id']);
				$i++;
				}  
			}
		} 
		$trainingShow = '';
		$catShow = '';
		?>
		<ul class="open_tasks nav navbar-nav">
		<ul class="sub-menu children dropdown2-menu">
        <?php $i = 0; 
      		  foreach ($employees as $key => $employee) { 
      		  $getCraftCertCount = $this->User->getCraftCertificate(null,$employee['id']);   
            $clients =   $this->User->getClients($activeUser['contractor_id']);
            $trainings = $this->Training->getTrainings($activeUser,$employee['id']);
            // $trainingsSites = $this->Training->getTrainingSites($employee['id']);
             $trainingShow = false;
              if(!empty($trainings)){
                  // $trainingShow = false;
                 // foreach($trainingsSites as $key => $trainings) {  
                  foreach($trainings as $training) {                  
                    if($training['getPerc'] != '100%') { 
                                $trainingShow = true;
                                continue;
                    }
                  }
                //}
              }
               
                $categories = $this->EmployeeCategory->getCategories(null,$employee['id']);
                if(!empty($categories)){
                  $catShow = false;
                  foreach ($categories as $cat) { 
                    if($cat['getPerc'] != '100%') {
                    $catShow = true;
                    continue;
                  }
               }}              
              if($trainingShow == true || $catShow == true || ($getCraftCertCount < 1 && in_array(6, $clients))){
              $emp_name =  $employee['pri_contact_fn']." ".$employee['pri_contact_ln'] ?>
              <h5><span class="badge badge-light"><?=  h($emp_name) ?></span></h5>
              
              <?php if($getCraftCertCount < 1 && in_array(6, $clients)){ ?>             
               <?php  $craftCert = true;
                 echo '<li class="menu-item-has-children dropdown">'.$this->Html->link('Add Craft Certifications', ['controller'=>'EmployeeExplanations', 'action'=>'add',$employee['id']], ['escape'=>false, 'title'=>'Add Craft Certifications']).'</li>'; ?>            
               <?php  } ?>

              <?php if($trainingShow == true) {      ?>
              <li class="menu-item-has-children dropdown">
              <a href="#" class="dropdown-toggle " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Complete Orientations:</a>
            <ul class="sub-menu children dropdown-menu">
            <?php if(!empty($trainings_sites)){
            	foreach ($trainings_sites as $emp_id => $training_site) {
            		if($employee['id'] == $emp_id){
            	   $trainings = $this->Training->getTrainings($activeUser,$emp_id);
                   foreach ($trainings as $key => $training) { 
	            	 	if($training['getPerc'] != '100%') { 
	            		echo '<li>'. $this->Html->link(__($training['name'].' '.$training['getPerc']), ['controller'=>'training-answers', 'action'=>'addAnswers', 4, $training['id'],$employee['id']], ['escape'=>false, 'title'=>$training['name']]).'</li>'; 
				    	} 
	            	 }
            	    }
            	}
    	     }
			?> 
			 </ul>
            </li>
        <?php } ?>
        </ul>
         <ul class="sub-menu children dropdown2-menu">
         <?php if($catShow == true) {  ?>
           <li class="menu-item-has-children dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Complete Categories:</a>
           <ul class="sub-menu children dropdown-menu">
           <?php //$categories = $this->EmployeeCategory->getCategories(null,$employee['id']); 
            foreach($categories as $cat) { 
		    if($cat['getPerc'] != '100%') { 
			  echo '<li>'. $this->Html->link(__($cat['name'].' '.$cat['getPerc']), ['controller'=>'employee-answers', 'action'=>'add', $cat['id'],$employee['id']], ['escape'=>false, 'title'=>$cat['name']]).'</li>';
				} 
		 	} ?>
           </ul>
           </li>
            <?php } }  } 
				 // if($trainingShow ==false && $catShow==false){
				 //                 echo '<span style="">No Open Tasks!</span>'; 
     //      			  }
            
             	 ?>	
            </ul>
		</ul>
	
	</div>
</div>
</div>