<?php
$users = array(SUPER_ADMIN,CONTRACTOR,CONTRACTOR_ADMIN,ADMIN);
if($service_id == 2){
    $categories = $this->Category->getInsCategories($activeUser, $service_id, false);
}else{
	$categories = $this->Category->getCategories($activeUser, $service_id, false);
}
if(!empty($categories)) { ?>
<h3 class="sidebar-title">Supplier</h3>
<hr>
<?php
	foreach($categories as $cat) {
		if(!empty($cat['childrens'])) { ?>
<li class="sidebar-item  add-answers-<?= $cat['id'] ?>">
    <a href="#" class="sidebar-link">
        <?= $cat['name'] . ' <b>(' . $cat['getPerc'] . ')</b>' ?></a>
    <?php foreach ($cat['childrens'] as $key=>$value) { ?>
<li class="sidebar-item has-sub add-answers-<?= $key ?>">
    <a href="#" class="sidebar-link">
        <?= $key . ' <b>(' . $value['getPerc'] . ')</b>' ?></a>
    <ul class="submenu <?= (!empty($parentPage) && $parentPage == '<?= $cat[" name"] ?>') ? 'active' :'' ?>">
        <?php foreach ($value['cat'] as $childcats) { 
				$todayDate =array();
				if($service_id==2) { //InsureQual Service
					$curYear = date('Y');						
					$ansDate=array();
					if($childcats['name']=="General Liability") {
						$ansDate = $this->Category->checkAns(43,$activeUser['contractor_id'],$curYear);
					}elseif($childcats['name']=="Automobile Liability"){
						$ansDate = $this->Category->checkAns(55,$activeUser['contractor_id'],$curYear);	
					}elseif($childcats['name']=="Excess/Umbrella Liability"){
						$ansDate = $this->Category->checkAns(65,$activeUser['contractor_id'],$curYear);	
					}elseif($childcats['name']=="Workers Compensation"){
						$ansDate = $this->Category->checkAns(456,$activeUser['contractor_id'],$curYear);	
					}
				
					if(!empty($ansDate)){
						$ansDate = max($ansDate);
						$ansDate = date('Y-m-d', strtotime($ansDate. "-60 days"));
						$todayDate = date('Y-m-d');						
					}						
					if($key >$curYear){
					 if(empty($ansDate && $ansDate <= $todayDate)){ continue;
						// if($ansDate <= $todayDate || $childcats['name']== 'Workers Compensation'||$childcats['getPerc'] != '0%' ) {
						if($ansDate <= $todayDate ||$childcats['getPerc'] != '0%' ) {
						?>
        <li class="submenu-item <?= (!empty($currentPage) && $currentPage == 'categories') ? 'active' :'' ?>">
            <?= $this->Html->link(__($childcats['name'] . ' <b>(' . $childcats['getPerc'] . ')</b>'), ['controller'=>'contractor-answers', 'action'=>'addAnswers', $service_id, $childcats['id'], $key], ['escape'=>false, 'title'=>'categories','class'=>'sidebar-link']) ?>
        </li>
        <?php
						}
					}else{
						if($ansDate <= $todayDate ||$childcats['getPerc'] != '0%' ) {
						?>
        <li class="submenu-item <?= (!empty($currentPage) && $currentPage == 'categories') ? 'active' :'' ?>">
            <?= $this->Html->link(__($childcats['name'] . ' <b>(' . $childcats['getPerc'] . ')</b>'), ['controller'=>'contractor-answers', 'action'=>'addAnswers', $service_id, $childcats['id'], $key], ['escape'=>false, 'title'=>'categories','class'=>'sidebar-link']) ?>
        </li>
        <?php
						}
					}
					}else{
					?>
        <li class="submenu-item <?= (!empty($currentPage) && $currentPage == 'categories') ? 'active' :'' ?>">
            <?= $this->Html->link(__($childcats['name'] . ' <b>(' . $childcats['getPerc'] . ')</b>'), ['controller'=>'contractor-answers', 'action'=>'addAnswers', $service_id, $childcats['id'], $key], ['escape'=>false, 'title'=>'categories','class'=>'sidebar-link']) ?>
        </li>
        <?php
					}	
						
					}else{				
				?>
        <li class="submenu-item <?= (!empty($currentPage) && $currentPage == 'categories') ? 'active' :'' ?>">
            <?= $this->Html->link(__($childcats['name'] . ' <b>(' . $childcats['getPerc'] . ')</b>'), ['controller'=>'contractor-answers', 'action'=>'addAnswers', $service_id, $childcats['id'], $key], ['escape'=>false, 'title'=>'categories','class'=>'sidebar-link']) ?>
        </li>
        <?php }} ?>
    </ul>
</li>
<?php } ?>
</li>
<?php
		} 		
		else {
		if(!empty($cat['child'])) { 
			$client = $this->User->getClients($activeUser['contractor_id']);
			$quesCount = $this->Category->getParentQuesCount($cat['id'],$client);?>
<li class="sidebar-item contractor-answers-<?= $cat['id'] ?>">
    <?php if(empty($quesCount)) { ?>
    <a href="#" class="sidebar-link">
        <?= $cat['name'] . ' <b>(' . $cat['getPerc'] . ')</b>' ?></a>
    <?php }else{ ?>
    <?= $this->Html->link(__($cat['name'] . ' <b>(' . $cat['getPerc'] . ')</b>'), ['controller'=>'contractor-answers', 'action'=>'addAnswers', $service_id, $cat['id']], ['escape'=>false, 'title'=>'categories','class'=>'sidebar-link']) ?>
    <?php } ?>
    <ul class="submenu-item  children dropdown-menu1">
        <?php foreach ($cat['child'] as $key=>$value) { ?>
        <li class="sidebar-item contractor-answers-<?= $value['id'] ?>">
            <?= $this->Html->link(__($value['name'] . ' <b>(' . $value['getPerc'] . ')</b>'), ['controller'=>'contractor-answers', 'action'=>'addAnswers', $service_id, $value['id']], ['escape'=>false, 'title'=>'categories','class'=>'sidebar-link']) ?>
        </li>
        <?php } ?>
    </ul>
</li>
<?php }
		else {
        if($cat['id'] == 2) { // if  General Information
		?>
<li class="sidebar-item  contractor-answers-<?= $cat['id'] ?>">
    <?= $this->Html->link(__($cat['name'] . ' <b>(' . $cat['getPerc'] . ')</b>'), ['controller'=>'contractor-answers', 'action'=>'addAnswers', $service_id, $cat['id']], ['escape'=>false, 'title'=>'categories','class'=>'sidebar-link']) ?>
</li>
<?php 
         if($service_id==1  && in_array($activeUser['role_id'], $users)) {
            $getNextcat = $this->Category->getNextcat($categories, $cat['id'], $service_id);
            $nextcatId = explode('/',$getNextcat);
        ?>
<li class="sidebar-item  contractor-users-<?= $nextcatId[1] ?>">
    <?= $this->Html->link(__('Contractor Contacts'), ['controller'=>'ContractorUsers', 'action'=>'add/'.$getNextcat,'class'=>'sidebar-link']) ?>
</li>
<?php } 
		}
        else
        { ?>
<li class="sidebar-item  contractor-answers-<?= $cat['id'] ?>">
    <?= $this->Html->link(__($cat['name'] . ' <b>(' . $cat['getPerc'] . ')</b>'), ['controller'=>'contractor-answers', 'action'=>'addAnswers', $service_id, $cat['id']], ['escape'=>false, 'title'=>'categories','class'=>'sidebar-link']) ?>
</li>
<?php }
        }
		}
	} // foreach $categories
} ?>
