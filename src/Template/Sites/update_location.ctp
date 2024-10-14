<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\site $site
 */
?>
<div class="row roles sites">
<div class="col-lg-12">
<div class="card">
	<div class="card-header clearfix">
		<strong>Update Location</strong>
	</div>
	<div class="card-body card-block">
	<?php if(isset($site->state->name) && isset($site->country->name)){
	$addr = $site->addressline_1.' '.$site->addressline_2.' '.$site->city.' '.$site->state->name.' '.$site->country->name;
	} ?>
	<?= $this->Form->create($site) ?>
		<div class="form-group row">
			<?= $this->Form->label('Address', null, ['class' => 'col-sm-2 col-form-label']); ?>
			<div class="col-sm-8"><?= (!empty($addr)) ? $addr : "" ?></div>
		</div>
		<div class="form-group row">
			<?= $this->Form->label('Latitude', null, ['class' => 'col-sm-2 col-form-label']); ?>
			<div class="col-sm-3"><?php echo $this->Form->control('latitude', ["id"=>"latitude", 'class'=>'form-control', 'label'=>false]); ?></div>
			<?= $this->Form->label('Longitude', null, ['class' => 'col-sm-2 col-form-label']); ?>
			<div class="col-sm-3"><?php echo $this->Form->control('longitude', ["id"=>"longitude", 'class'=>'form-control', 'label'=>false]); ?></div>
		<?= $this->Html->link('Search', '#', ['id'=>'updateMap', 'title' => 'Search', 'onClick'=>'initializeMap()', 'class'=>'btn btn-primary btn-sm']) ?>
		</div>
		<div class="form-actions form-group">
			<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type'=>'submit', 'class'=>'btn btn-primary btn-sm']); ?>
		</div>
	<?= $this->Form->end() ?>
		<div class="form-group row">
			<?php $site->latitude!=null && $site->longitude!=null ? $searchAddr='' : $searchAddr=((!empty($addr)) ? $addr : ""); ?>
			<?= $this->Form->label('Search Location', null, ['class' => 'col-sm-2 col-form-label']); ?>
			<div class="col-sm-8"><?php echo $this->Form->control('search', ['id'=>'searchInput', 'class'=>'form-control', 'label'=>false, 'value'=>$searchAddr]); ?></div>
		</div>
		<div class="form-group">
			<div class="map" id="map" style="width: 100%;"></div>
		</div>
	</div>
</div>
</div>
</div>
