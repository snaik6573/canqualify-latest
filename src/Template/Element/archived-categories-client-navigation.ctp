<?php
if($service_id == 6) {
$categories = $this->Category->getCategories($activeUser, $service_id, true);
if(!empty($categories)) {

	foreach($categories as $cat) {
		if(!empty($cat['childrens'])) { ?>
		<li>		    
		   
			<?php foreach ($cat['childrens'] as $key=>$value) { ?>			
			<li class="sidebar-item has-sub <?= $key ?>">
				<a href="#" class="sidebar-link" ><?= $key . ' <b>(' . $value['getPerc'] . ')</b>' ?></a>
				<ul class="submenu">
				<?php foreach ($value['cat'] as $childcats) { ?>
					<li class="submenu-item"><?= $this->Html->link(__($childcats['name'] . ' <b>(' . $childcats['getPerc'] . ')</b>'), ['controller'=>'contractor-answers', 'action'=>'addAnswers', $service_id, $childcats['id'], $key], ['escape'=>false, 'title'=>'categories','class'=>'sidebar-link']) ?></li>
				<?php } ?>
				</ul>
			</li>
			<?php } ?>
		    
		</li>
		<?php
		} 	
		/*else {
		?>
			<li><?= $this->Html->link(__($cat['name'] . ' <b>(' . $cat['getPerc'] . ')</b>'), ['controller'=>'contractor-answers', 'action'=>'addAnswers', $service_id, $cat['id']], ['escape'=>false, 'title'=>'categories']) ?></li>
		<?php 
		}*/
	} // foreach $categories
}
}
