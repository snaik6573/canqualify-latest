<?php
$users = array(SUPER_ADMIN,CONTRACTOR,CONTRACTOR_ADMIN,ADMIN, CR);
if($service_id == 2){
    $categories = $this->Category->getInsCategories($activeUser, $service_id, false);
}else{
	$categories = $this->Category->getCategories($activeUser, $service_id, false);
}
if(!empty($categories)) { ?>
	<h3 class="menu-title">Supplier</h3>
	<?php
	foreach($categories as $cat) {
	    $display_percentage_1 = '';
	    if($cat['getPerc'] >= 0){
            $display_percentage_1 = ' <b>('. $cat['getPerc'] .')</b>';
        }
		if(!empty($cat['childrens'])) { ?>
		<li class="category-link add-answers-<?= $cat['id'] ?>">
		    <a href="#"><?= $cat['name'] . ' <b>' . $display_percentage_1 . '</b>' ?></a>
		    <ul>
			<?php
            foreach ($cat['childrens'] as $key=>$value) {
                $display_percentage_2 = '';
                if($value['getPerc'] >= 0){
                    $display_percentage_2 = ' <b>('. $value['getPerc'] .')</b>';
                }
			    ?>
			<li class="menu-item-has-children dropdown category-link add-answers-<?= $key ?>">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $key . $display_percentage_2 ?></a>
				<ul class="sub-menu children dropdown-menu">
				<?php foreach ($value['cat'] as $childcats) {
                    $display_percentage_3 = '';
                    if($childcats['getPerc'] >= 0){
                        $display_percentage_3 = ' <b>('. $childcats['getPerc'] .')</b>';
                    }

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
							<li><?= $this->Html->link(__($childcats['name'] . $display_percentage_3), ['controller'=>'contractor-answers', 'action'=>'addAnswers', $service_id, $childcats['id'], $key], ['escape'=>false, 'title'=>'categories']) ?></li>
						<?php
						}
					}else{
						if($ansDate <= $todayDate ||$childcats['getPerc'] != '0%' ) {
						?>
							<li><?= $this->Html->link(__($childcats['name'] . $display_percentage_3), ['controller'=>'contractor-answers', 'action'=>'addAnswers', $service_id, $childcats['id'], $key], ['escape'=>false, 'title'=>'categories']) ?></li>
						<?php
						}
					}
					}else{
					?>
						<li><?= $this->Html->link(__($childcats['name'] . $display_percentage_3), ['controller'=>'contractor-answers', 'action'=>'addAnswers', $service_id, $childcats['id'], $key], ['escape'=>false, 'title'=>'categories']) ?></li>
					<?php
					}	
						
					}else{				
				?>
					<li><?= $this->Html->link(__($childcats['name'] . $display_percentage_3), ['controller'=>'contractor-answers', 'action'=>'addAnswers', $service_id, $childcats['id'], $key], ['escape'=>false, 'title'=>'categories']) ?></li>
				<?php }} ?>
				</ul>
			</li>
			<?php } ?>
		    </ul>
		</li>
		<?php
		} 		
		else {
		if(!empty($cat['child'])) { 
			$client = $this->User->getClients($activeUser['contractor_id']);
			$quesCount = $this->Category->getParentQuesCount($cat['id'],$client);?>
		<li class="category-link menu-item-has-children dropdown contractor-answers-<?= $cat['id'] ?>">
		<?php if(empty($quesCount)) { ?>
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $cat['name'] . $display_percentage_1  ?></a>
		<?php }else{ ?>
            <?= $this->Html->link(__($cat['name'] . $display_percentage_1), ['controller'=>'contractor-answers', 'action'=>'addAnswers', $service_id, $cat['id']], ['escape'=>false, 'title'=>'categories']) ?>
        <?php } ?>    
		    <ul class="sub-menu children dropdown-menu1">
			<?php foreach ($cat['child'] as $key=>$value) { ?>
			    <li class="category-link contractor-answers-<?= $value['id'] ?>"><?= $this->Html->link(__($value['name'] . '('.$value['getPerc'].')'), ['controller'=>'contractor-answers', 'action'=>'addAnswers', $service_id, $value['id']], ['escape'=>false, 'title'=>'categories']) ?></li>
			<?php } ?>
		    </ul>
		</li>
		<?php }
		else {
        if($cat['id'] == 2) { // if  General Information
		?>
			<li class="category-link contractor-answers-<?= $cat['id'] ?>"><?= $this->Html->link(__($cat['name'] . $display_percentage_1), ['controller'=>'contractor-answers', 'action'=>'addAnswers', $service_id, $cat['id']], ['escape'=>false, 'title'=>'categories']) ?></li>
		<?php 
         if($service_id==1  && in_array($activeUser['role_id'], $users)) {
            $getNextcat = $this->Category->getNextcat($categories, $cat['id'], $service_id);
            $nextcatId = explode('/',$getNextcat);
        ?>
        	<li class="category-link contractor-users-<?= $nextcatId[1] ?>"><?= $this->Html->link(__('Contractor Contacts'), ['controller'=>'ContractorUsers', 'action'=>'add/'.$getNextcat]) ?></li>
    <?php } 
		}
        else
        { ?>
			<li class="category-link contractor-answers-<?= $cat['id'] ?>"><?= $this->Html->link(__($cat['name'] . $display_percentage_1), ['controller'=>'contractor-answers', 'action'=>'addAnswers', $service_id, $cat['id']], ['escape'=>false, 'title'=>'categories']) ?></li>
       <?php }
        }
		}
	} // foreach $categories
} ?>

