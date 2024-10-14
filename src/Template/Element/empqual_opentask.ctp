<div class="card">
  <div class="card-header">
    <strong>Employee Level Open Tasks</strong>
  </div>
  <div class="card-body card-block">
    <?php if(empty($employees)){ 
        echo '<p>'.$this->Html->link('Add Employees', ['controller'=>'employees', 'action'=>'index',$service_id], ['escape'=>false, 'title'=>'Add Employees']).'</p>';
     }    
        /*Hotfix for EmployeeQual CraftCertifications enable only for Hunton Group*/
      $getCraftCertCount = $this->User->getCraftCertificate($activeUser['contractor_id']);
      $clients =   $this->User->getClients($activeUser['contractor_id']);
      /*if($getCraftCertCount < 1 && in_array(6, $clients)){
        echo '<p>'.$this->Html->link('Add Craft Certifications and/or Safety Training Records', ['controller'=>'EmployeeExplanations', 'action'=>'expList',$activeUser['contractor_id']], ['escape'=>false, 'title'=>'Add Craft Certifications and/or Safety Training Records']).'<a href="javascript:void();" data-toggle="popover" title="" data-content="If a license is required by law, upload license, i.e. plumbing, electrical, etc. If a license is not required by law, then upload OSHA 30 hr for supervisors and OSHA 10 hr for subordinates, or upload all relevant certificates and training documentation to validate competencies for the work being performed" style="margin-left: 15px;"><i class="fa fa-info-circle"></i></a>'.'</p>';

      }*/
   if(!empty($employees)){
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
    $craftCert = false;
    ?>
    <ul class="open_tasks nav navbar-nav">
    <ul class="sub-menu children dropdown2-menu">
        <?php $i = 0; 
        if(!empty($employees)){        
           $empCount = count($employees); 
            foreach ($employees as $key => $employee) {  
                
              $getCraftCertCount = $this->User->getCraftCertificate(null,$employee['id']);             
              $clients =   $this->User->getClients($activeUser['contractor_id']);

              $trainings = $this->Training->getTrainings($activeUser,$employee['id']);
              $trainingShow = false;
             // $trainingsSites = $this->Training->getTrainingSites($employee['id']);
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
                $categories = $this->EmployeeCategory->getCategories($activeUser['contractor_id'],$employee['id']);
                if(!empty($categories)){
                  $catShow = false;
                  foreach ($categories as $cat) {
                    if($cat['getPerc'] != '100%') {
                    $catShow = true;
                    continue;
                  }
               }}
    
              //$trainingStatus = $this->Training->checkTrainings($employee['id']);
              //$catStatus = $this->EmployeeCategory->checkCatogories($employee['id']);
            // if($trainingShow ==false && $catShow==false &&  !empty($employees) && $craftCert == false ){
            //       echo '<span style="">No Open Tasks!</span>'; 
            //     }else
              if($trainingShow == true || $catShow == true || ( $getCraftCertCount < 1 && in_array(6, $clients))){
              $emp_name =  $employee['pri_contact_fn']." ".$employee['pri_contact_ln'];
                $i++; ?>
                <h5><?=  h($emp_name) ?></h5>
             
              <?php if($getCraftCertCount < 1 && in_array(6, $clients)){ ?>
               <?php  $craftCert = true;
                 echo '<li class="menu-item-has-children dropdown">'.$this->Html->link('Add Craft Certifications and/or Safety Training Records', ['controller'=>'EmployeeExplanations', 'action'=>'add',$employee['id']], ['escape'=>false, 'title'=>'Add Craft Certifications and/or Safety Training Records']).'<a href="javascript:void();" data-toggle="popover" title="" data-content="If a license is required by law, upload license, i.e. plumbing, electrical, etc. If a license is not required by law, then upload OSHA 30 hr for supervisors and OSHA 10 hr for subordinates, or upload all relevant certificates and training documentation to validate competencies for the work being performed" style="margin-left: 15px;"><i class="fa fa-info-circle"></i></a>'.'</li>'; ?>
               <?php  } ?>
             
              <?php if($trainingShow == true) {      ?>    
              <li class="menu-item-has-children dropdown">
              <a href="#" class="dropdown-toggle " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Complete Orientations:</a>
              <ul class="sub-menu children dropdown-menu">
              <?php if(!empty($trainings_sites)){ 
                foreach ($trainings_sites as $emp_id => $training_site) {
                  if($employee['id'] == $emp_id){
                    // $training_site = array_shift($training_site);
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
           <?php } 
          $i++;}         
            if($i ==2 && $i < $empCount ){
                echo $this->Html->link('More Open Tasks', ['controller'=>'Employees', 'action'=>'openTasks',$activeUser['contractor_id']], ['escape'=>false, 'title'=>'More Open Tasks', 'class'=>'']); 
              break;
            }
              ?>
              <?php    } }
             // pr($i); pr($empCount);die;
              if($trainingShow ==false && $catShow==false &&  !empty($employees) && $craftCert == false ){
                  echo '<span style="">No Open Tasks!</span>'; 
                }
              //die; ?> 
            </ul>
    </ul>
  
  </div>
</div>

