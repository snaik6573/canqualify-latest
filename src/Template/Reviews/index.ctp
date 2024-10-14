<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Review[]|\Cake\Collection\CollectionInterface $reviews
 */
echo $this->Html->css('review.css');
echo $this->Html->script('review.js'); 
?>
<div class="row reviews">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong class="card-title"><?= __('Reviews') ?></strong>
		<!--<span class="pull-right"><?= $this->Html->link(__('Add New'), ['controller' => 'Reviews', 'action' => 'add'],['class'=>'btn btn-success btn-sm']) ?> </span>-->
	</div>
	<div class="card-body table-responsive">
	<table id="bootstrap-data-table-export" class="table table-striped table-bordered">
	<thead>
	<tr>
		<th scope="col"><?= h('Rating') ?></th>
		<th scope="col"><?= h('Review') ?></th>
		<th scope="col"><?= h('Author') ?></th>			
	</tr>
	</thead>
	  <tbody>
            <?php foreach ($reviews as $review): ?>
            <tr>
            <td>
	        <?php 
		    $id =$review->id;
		    $rate =$review->rating;
		    $starNumber = $rate;

		    for ($x = 1; $x <= $starNumber; $x++) {
			  echo '<i class="fa fa-star glow"></i>';
		    }
		    if (strpos($starNumber, '.')) {
			  echo '<i class="fa fa-star-half-o"></i>';
			  $x++;
		    }
		    while ($x <= 5) {
			  echo '<i class="fa fa-star-o"></i>';
			  $x++;
		    }
		    ?>
	</td>
	<td><?= $review->reviewtxt ?></td>
	<td><i><?= $review->has('client') ? $this->Html->link($review->client->company_name, ['controller' => 'Clients', 'action' => 'view', $review->client->id]) : '' ?></i></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
	</table>
	</div>
</div>
</div>
</div>
