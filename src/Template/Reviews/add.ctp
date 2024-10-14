<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Review $review
 */
use Cake\Core\Configure;
$uploaded_path = Configure::read('uploaded_path');
echo $this->Html->css('review.css');
echo $this->Html->script('review.js'); 
?>

<div class="row reviews">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong>Add New</strong> Reviews
	</div>
	<div class="card-body card-block">
	<?= $this->Form->create($review) ?>

	<div class="form-group">
		<?php echo $this->Form->control('rating', ['type'=>'hidden','id'=>'rating']); ?>
		<section class='rating-widget'>
		<div class='rating-stars text-center'>
			<ul id='stars'>
			  <li class='star' title='Poor' data-value='1'><i class='fa fa-star fa-fw'></i></li>
			  <li class='star' title='Fair' data-value='2'><i class='fa fa-star fa-fw'></i></li>
			  <li class='star' title='Good' data-value='3'><i class='fa fa-star fa-fw'></i></li>
			  <li class='star' title='Excellent' data-value='4'><i class='fa fa-star fa-fw'></i></li>
			  <li class='star' title='WOW!!!' data-value='5'><i class='fa fa-star fa-fw'></i></li>
			</ul>
		</div>
		<!--<div class='success-box'>
		 <div class='clearfix'></div>
			<img alt='tick image' width='32' src='data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeD0iMHB4IiB5PSIwcHgiIHZpZXdCb3g9IjAgMCA0MjYuNjY3IDQyNi42NjciIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDQyNi42NjcgNDI2LjY2NzsiIHhtbDpzcGFjZT0icHJlc2VydmUiIHdpZHRoPSI1MTJweCIgaGVpZ2h0PSI1MTJweCI+CjxwYXRoIHN0eWxlPSJmaWxsOiM2QUMyNTk7IiBkPSJNMjEzLjMzMywwQzk1LjUxOCwwLDAsOTUuNTE0LDAsMjEzLjMzM3M5NS41MTgsMjEzLjMzMywyMTMuMzMzLDIxMy4zMzMgIGMxMTcuODI4LDAsMjEzLjMzMy05NS41MTQsMjEzLjMzMy0yMTMuMzMzUzMzMS4xNTcsMCwyMTMuMzMzLDB6IE0xNzQuMTk5LDMyMi45MThsLTkzLjkzNS05My45MzFsMzEuMzA5LTMxLjMwOWw2Mi42MjYsNjIuNjIyICBsMTQwLjg5NC0xNDAuODk4bDMxLjMwOSwzMS4zMDlMMTc0LjE5OSwzMjIuOTE4eiIvPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K'/>
			<div class='text-message'></div>
		  <div class='clearfix'></div>
		</div>-->
		</section>
	</div>
	<div class="form-group">
		<?= $this->Form->label('Review', null, ['class'=>'']); ?>
		<?= $this->Form->control('reviewtxt', ['class'=>'form-control','label'=>false]) ?>
	</div>
	 
	<div class="row form-group">
	   <div class="col-sm-4">
       <?= $this->Form->label('Image (Optional)'); ?>
	   </div>
	   <div class="col-sm-4">
       <?= $this->Form->label('Image (Optional)'); ?>
	   </div>
	   <div class="col-sm-4">
       <?= $this->Form->label('Image (Optional)'); ?>
	   </div>
	</div>  
    <div class="row form-group">	
       <div class="col-sm-4 uploadWraper">
       <?php echo $this->Form->control('doc_1', ['label'=>false, 'type'=>'hidden', 'class'=>'documentName']); ?>
       <?php echo $this->Form->file('uploadFile', ['label'=>false ]); ?>
       <div class="uploadResponse"></div>
       </div>
       
       <div class="col-sm-4 uploadWraper">
       <?php echo $this->Form->control('doc_2', ['label'=>false, 'type'=>'hidden', 'class'=>'documentName']); ?>
       <?php echo $this->Form->file('uploadFile', ['label'=>false ]); ?>
       <div class="uploadResponse"></div>
       </div>
      
       <div class="col-sm-4 uploadWraper">
       <?php echo $this->Form->control('doc_3', ['label'=>false, 'type'=>'hidden', 'class'=>'documentName']); ?>
       <?php echo $this->Form->file('uploadFile', ['label'=>false ]); ?>
       <div class="uploadResponse"></div>
       </div>
    </div>
	</br>
	<div class="form-actions form-group">
		<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-primary btn-sm']); ?>
	</div>
	<?= $this->Form->end() ?>
	</div>
</div>
</div>
</div>
