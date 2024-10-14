<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Review $review
 */
?>
<div class="row reviews">
<div class="col-lg-6">
<div class="card">
	<div class="card-header clearfix">
		<strong>Edit</strong> Reviews
		<?php if($activeUser['role_id'] == SUPER_ADMIN) { ?>
		<span class="pull-right"><?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $review->id], ['class'=>'btn btn-danger btn-sm', 'confirm' => __('Are you sure you want to delete # {0}?', $review->id)]) ?></span>
		<?php } ?>
	</div>
	<div class="card-body card-block">
	<?= $this->Form->create($review) ?>
		<div class="form-group">
			<!--<?php echo $this->Form->control('rating', ['class'=>'form-control', 'required'=>false]); ?>-->
			<section class='rating-widget'>
		  
		  <!-- Rating Stars Box -->
		<div class='rating-stars text-center'>
			<ul id='stars'>
			  <li class='star' title='Poor' data-value='1'>
				<i class='fa fa-star fa-fw'></i>
			  </li>
			  <li class='star' title='Fair' data-value='2'>
				<i class='fa fa-star fa-fw'></i>
			  </li>
			  <li class='star' title='Good' data-value='3'>
				<i class='fa fa-star fa-fw'></i>
			  </li>
			  <li class='star' title='Excellent' data-value='4'>
				<i class='fa fa-star fa-fw'></i>
			  </li>
			  <li class='star' title='WOW!!!' data-value='5'>
				<i class='fa fa-star fa-fw'></i>
			  </li>
			</ul>
		</div>
		  
		<div class='success-box'>
		 <div class='clearfix'></div>
			<img alt='tick image' width='32' src='data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeD0iMHB4IiB5PSIwcHgiIHZpZXdCb3g9IjAgMCA0MjYuNjY3IDQyNi42NjciIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDQyNi42NjcgNDI2LjY2NzsiIHhtbDpzcGFjZT0icHJlc2VydmUiIHdpZHRoPSI1MTJweCIgaGVpZ2h0PSI1MTJweCI+CjxwYXRoIHN0eWxlPSJmaWxsOiM2QUMyNTk7IiBkPSJNMjEzLjMzMywwQzk1LjUxOCwwLDAsOTUuNTE0LDAsMjEzLjMzM3M5NS41MTgsMjEzLjMzMywyMTMuMzMzLDIxMy4zMzMgIGMxMTcuODI4LDAsMjEzLjMzMy05NS41MTQsMjEzLjMzMy0yMTMuMzMzUzMzMS4xNTcsMCwyMTMuMzMzLDB6IE0xNzQuMTk5LDMyMi45MThsLTkzLjkzNS05My45MzFsMzEuMzA5LTMxLjMwOWw2Mi42MjYsNjIuNjIyICBsMTQwLjg5NC0xNDAuODk4bDMxLjMwOSwzMS4zMDlMMTc0LjE5OSwzMjIuOTE4eiIvPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K'/>
			<div class='text-message'></div>
		  <div class='clearfix'></div>
		</div>
		  
		</section>
		</div>
		
		<div class="form-group">
			<?php echo $this->Form->control('reviewtxt', ['class'=>'form-control']); ?>
		</div>
		<div class="form-group">
			<?php echo $this->Form->control('client_id', ['type'=>'hidden','class'=>'form-control', 'options' => $clients, 'empty' => true]); ?>
		</div>				
		<div class="form-group">
			<?php echo $this->Form->control('contractor_id', ['type'=>'hidden','class'=>'form-control', 'options' => $contractors, 'empty' => true]); ?>
		</div>		
		<div class="form-actions form-group">
			<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-primary btn-sm']); ?>
		</div>
	<?= $this->Form->end() ?>	
	</div>
</div>
</div>
</div>