	<?php
	$trainings = $this->Training->getTrainings($activeUser);
	if(!empty($trainings)){
	?>
	<hr>
	<h3 class="sidebar-title">Online Orientations</h3>
	<hr>
	<?php
	foreach($trainings as $tId => $train) {
	if(!empty($train['child'])) { ?>	
	<li class="sidebar-item <?=$tId?>">
	<!--<a href="#" class="dropdown-toggle" data-toggle="dropdown"	aria-haspopup="true" aria-expanded="false"><?= $train['name'] . ' <b>(' . $train['getPerc'] . ')</b>' ?></a>-->
        <?= $this->Html->link(__($train['name'] . ' <b>(' . $train['getPerc'] . ')</b>'), ['controller'=>'training-answers', 'action'=>'addAnswers', 4, $tId], ['escape'=>false, 'title'=>'trainings','class'=>'sidebar-link']) ?>
		    <ul class="submenu-item">
		        <?php foreach ($train['child'] as $cId=>$value) { ?>
		            <li class="sidebar-item"><?= $this->Html->link(__($value['name'] . ' <b>(' . $value['getPerc'] . ')</b>'), ['controller'=>'training-answers', 'action'=>'addAnswers', 4, $cId], ['escape'=>false, 'title'=>'trainings','class'=>'sidebar-link']) ?></li>
		            </li>
		        <?php } ?>
		    </ul>
		</li>		
	<?php }else{
	?>
	<li class="sidebar-item"><?= $this->Html->link(__($train['name'] . ' <b>(' . $train['getPerc'] . ')</b>'), ['controller'=>'training-answers', 'action'=>'addAnswers', 4, $tId], ['escape'=>false, 'title'=>'trainings','class'=>'sidebar-link']) ?></li>
	<?php  }} }?>
