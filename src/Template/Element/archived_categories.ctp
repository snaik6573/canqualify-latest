<?php
if($service_id == 6) {
$categories = $this->Category->getCategories($activeUser, $service_id, true);
if(!empty($categories)) {

	foreach($categories as $cat) {
		if(!empty($cat['childrens'])) { ?>
		<li>		    
		    <ul>
			<?php foreach ($cat['childrens'] as $key=>$value) { ?>			
			<li class="menu-item-has-children dropdown <?= $key ?>">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $key . ' <b>(' . $value['getPerc'] . ')</b>' ?></a>
				<ul class="sub-menu children dropdown-menu">
				<?php foreach ($value['cat'] as $childcats) { ?>
					<li><?= $this->Html->link(__($childcats['name'] . ' <b>(' . $childcats['getPerc'] . ')</b>'), ['controller'=>'contractor-answers', 'action'=>'addAnswers', $service_id, $childcats['id'], $key], ['escape'=>false, 'title'=>'categories']) ?></li>
				<?php } ?>
				</ul>
			</li>
			<?php } ?>
		    </ul>
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
