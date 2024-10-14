<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Contractor $contractor
 */
?>
<div class="row roles contractors">
<div class="col-lg-12">
<div class="card">
	<div class="card-header clearfix">
		<strong>Update Location</strong>
	</div>
	<div class="card-body card-block">
	<?php if(isset($contractor->state->name) && isset($contractor->country->name)){
	$addr = $contractor->addressline_1.' '.$contractor->addressline_2.' '.$contractor->city.' '.$contractor->state->name.' '.$contractor->country->name;
	}
	?>
	<?= $this->Form->create($contractor) ?>
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
			<?php $contractor->latitude!=null && $contractor->longitude!=null ? $searchAddr='' : $searchAddr=((!empty($addr)) ? $addr : ""); ?>
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
