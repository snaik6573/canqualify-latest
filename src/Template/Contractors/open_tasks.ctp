<?php
/**

 */
use Cake\Core\Configure;

$this->assign('title', 'Dashboard');

?>
<div class="row contractors">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong>Open Tasks </strong>
	</div>
	<div class="card-body card-block">	
	<ul class="cat_hirarchy">
	<?php
	$final_submit = true;
	$services = $this->Category->getServices($activeUser['contractor_id']);
        foreach ($services as $service) {
        if(!empty($service['categories'])) {
            $firstCatId = $service['categories'][0]['id'];
            $categories = $this->Category->getCategories($activeUser, $service['id'],false);						
			foreach($categories as $cat) {
				if($cat['getPerc'] !='100%')	{ $final_submit = false; }		
			}
			if($final_submit){ ?>		
				<li>
					<?= $this->Html->link(__('Please Submit Your Data'), ['controller'=>'contractor-answers', 'action'=>'final-submit', $service['id']], ['escape'=>false, 'title'=>'Final submit']) ?>
				</li>
			<?php } else{
			$catname='';
			?>						
			<li class="menu-item-has-children dropdown">
				<!--<span style="">Please complete</span>
				<?= $this->Html->link(__($service['name']), ['controller'=>'ContractorAnswers', 'action'=>'addAnswers', $service['id'], $firstCatId], ['title'=>'Categories']) ?>-->							
				<ul>
				<?php foreach($categories as $cat) { 
					if(!empty($cat['childrens'])) { ?>					
							<?php foreach ($cat['childrens'] as $key=>$value) { ?>			
							<li>						
								<ul class="">
								<?php foreach ($value['cat'] as $childcats) { ?>
									<li><?= $this->Html->link(__("Upload ".$key." ".$childcats['name']), ['controller'=>'contractor-answers', 'action'=>'addAnswers', $service['id'], $childcats['id'], $key], ['escape'=>false, 'title'=>'categories']) ?></li>
								<?php } ?>
								</ul>
							</li>
							<?php } 
					}else {
					if(!empty($cat['child'])) { ?>
					<li class="menu-item-has-children dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $cat['name'] . ' <b>(' . $cat['getPerc'] . ')</b>' ?></a>
						<ul class="sub-menu children dropdown-menu">
							<?php foreach ($cat['child'] as $key=>$value) { ?>
							<li><?= $this->Html->link(__('Upload '.$value['name']), ['controller'=>'contractor-answers', 'action'=>'addAnswers', $service['id'], $value['id']], ['escape'=>false, 'title'=>'categories']) ?></li>
							</li>
							<?php } ?>
						</ul>
					</li>
					<?php }
					else {						
						if ($cat['name'] == 'General Information') { $catname = 'Complete Pre-Qualification Form'; } 
						else { $catname = 'Upload '.$cat['name'];}
					?>
					<li><?= $this->Html->link(__($catname), ['controller'=>'contractor-answers', 'action'=>'addAnswers', $service['id'], $cat['id']], ['escape'=>false, 'title'=>'categories']) ?></li>
					<?php 
					}
					} } ?>				
				</ul>			
			</li>			
			<?php }
			  }// services categories loop
			}//services loop    
			?>
	</ul>
	</div>
</div>
</div>
</div>

