	<?php
	$trainings = $this->Training->getTrainings($activeUser);
	if(!empty($trainings)){
	?>
	<h3 class="menu-title">Online Orientations</h3>
	<?php
	foreach($trainings as $tId => $train) {
	if(!empty($train['child'])) { ?>	
	<li class="menu-item-has-children dropdown <?=$tId?>">
	<!--<a href="#" class="dropdown-toggle" data-toggle="dropdown"	aria-haspopup="true" aria-expanded="false"><?= $train['name'] . ' <b>(' . $train['getPerc'] . ')</b>' ?></a>-->
        <?= $this->Html->link(__($train['name'] . ' <b>(' . $train['getPerc'] . ')</b>'), ['controller'=>'training-answers', 'action'=>'addAnswers', 4, $tId], ['escape'=>false, 'title'=>'trainings']) ?>
		    <ul class="sub-menu children dropdown-menu1">
		        <?php foreach ($train['child'] as $cId=>$value) { ?>
		            <li><?= $this->Html->link(__($value['name'] . ' <b>(' . $value['getPerc'] . ')</b>'), ['controller'=>'training-answers', 'action'=>'addAnswers', 4, $cId], ['escape'=>false, 'title'=>'trainings']) ?></li>
		            </li>
		        <?php } ?>
		    </ul>
		</li>		
	<?php }else{
	?>
	<li><?= $this->Html->link(__($train['name'] . ' <b>(' . $train['getPerc'] . ')</b>'), ['controller'=>'training-answers', 'action'=>'addAnswers', 4, $tId], ['escape'=>false, 'title'=>'trainings']) ?></li>
	<?php  }} }?>
