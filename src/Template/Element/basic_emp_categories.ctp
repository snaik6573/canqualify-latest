<?php
$categories = $this->EmpBasicCategory->getCategories();
if(!empty($categories)) { ?>
	<h3 class="menu-title"></h3>
	<?php
	foreach($categories as $cat) {
		if(!empty($cat['child'])) { ?>
		<li class="category-link menu-item-has-children dropdown employee-answers-<?= $cat['id'] ?>"><!--<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $cat['name'] . ' <b>(' . $cat['getPerc'] . ')</b>' ?></a>-->
            <?= $this->Html->link(__($cat['name'] . ' <b>(' . $cat['getPerc'] . ')</b>'), ['controller'=>'EmployeeAnswers', 'action'=>'add_basic_answer', $cat['id']], ['escape'=>false, 'title'=>'categories']) ?>
		    <ul class="sub-menu children dropdown-menu1">
			<?php foreach ($cat['child'] as $key=>$value) { ?>
			    <li class="category-link employee-answers-<?= $value['id'] ?>"><?= $this->Html->link(__($value['name'] . ' <b>(' . $value['getPerc'] . ')</b>'), ['controller'=>'EmployeeAnswers', 'action'=>'add_basic_answer', $value['id']], ['escape'=>false, 'title'=>'categories']) ?></li>
			<?php } ?>
		    </ul>
		</li>
		<?php }
		else {
		?>
			<li class="category-link employee-answers-<?= $cat['id'] ?>"><?= $this->Html->link(__($cat['name'] . ' <b>(' . $cat['getPerc'] . ')</b>'), ['controller'=>'EmployeeAnswers', 'action'=>'add_basic_answer', $cat['id']], ['escape'=>false, 'title'=>'categories']) ?></li>
       <?php
        }
	} // foreach $categories
} ?>
<?php
