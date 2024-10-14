<?php
$categories = $this->EmpBasicCategory->getCategories();
if(!empty($categories)) { ?>
	<h3 class="sidebar-title"></h3>
	<?php
	foreach($categories as $cat) {
		if(!empty($cat['child'])) { ?>
		<li class="sidebar-item employee-answers-<?= $cat['id'] ?>"><!--<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $cat['name'] . ' <b>(' . $cat['getPerc'] . ')</b>' ?></a>-->
            <?= $this->Html->link(__($cat['name'] . ' <b>(' . $cat['getPerc'] . ')</b>'), ['controller'=>'EmployeeAnswers', 'action'=>'add_basic_answer', $cat['id']], ['escape'=>false, 'title'=>'categories','class'=>'sidebar-link']) ?>
		    <ul class="">
			<?php foreach ($cat['child'] as $key=>$value) { ?>
			    <li class="sidebar-item employee-answers-<?= $value['id'] ?>"><?= $this->Html->link(__($value['name'] . ' <b>(' . $value['getPerc'] . ')</b>'), ['controller'=>'EmployeeAnswers', 'action'=>'add_basic_answer', $value['id']], ['escape'=>false, 'title'=>'categories','class'=>'sidebar-link']) ?></li>
			<?php } ?>
		    </ul>
		</li>
		<?php }
		else {
		?>
			<li class="sidebar-item employee-answers-<?= $cat['id'] ?>"><?= $this->Html->link(__($cat['name'] . ' <b>(' . $cat['getPerc'] . ')</b>'), ['controller'=>'EmployeeAnswers', 'action'=>'add_basic_answer', $cat['id']], ['escape'=>false, 'title'=>'categories','class'=>'sidebar-link']) ?></li>
       <?php
        }
	} // foreach $categories
} ?>
<?php
