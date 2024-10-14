<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Client[]|\Cake\Collection\CollectionInterface $clients
 */
?>
<div class="row clients">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong class="card-title"><?= __('Safety Statistics Report') ?></strong>
		
	</div>
	<div class="card-body table-responsive">
	<?= $this->Form->create('', ['class'=> 'searchAjax1']) ?>
	<div class="row">
		<div class="col-lg-4">
		<div class="form-group">
			<?php echo $this->Form->control('contractor_id', ['options'=> $contractors, 'empty'=>"All", 'class'=>'form-control','label'=>'Company Name']); ?>
		</div>	
		</div>

		<div class="col-lg-4">
		<div class="form-group">
			<?php echo $this->Form->control('year', ['options'=> $year_range, 'multiple'=>true, 'required'=>true, 'class'=>'form-control','label'=>'Year']); ?>
		</div>
		</div>

		<div class="col-lg-4">
		<div class="form-group">
			<?php echo $this->Form->control('category', ['options'=> $categories, 'multiple'=>true, 'required'=>true, 'class'=>'form-control','label'=>'Category']); ?>
		</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-6">
		<div class="form-actions form-group">
			<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-primary pull-right']); ?>
		</div>
		</div>
	</div>
	<?= $this->Form->end() ?>			 
	</div>
</div>
</div>

<?php if(!empty($report)) { ?>
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong class="card-title"><?= __('Chart') ?></strong>		
	</div>
	<div class="card-body table-responsive">	
		<div id="linechart_material"></div>
		<div id='chart_div'><img id="chart_image"  style="display:none;" /></div>
	</div>
</div>
</div>
<?php } ?>

<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong class="card-title"><?= __('Result') ?></strong>	
	</div>
	<div class="card-body table-responsive">
		<table id="bootstrap-data-table-export" class="table table-striped table-bordered">
		<thead>
		<tr>
			<th scope="col"><?= h('Contractor name') ?></th>
			<th scope="col"><?= h('Category') ?></th>
			<?php foreach ($yearSelected as $y): ?>
			<th scope="col"><?= h($y) ?></th>
			<?php endforeach; ?>
		</tr>
		</thead>
		<tbody>
		<?php 
		$arr = array();
		if(!empty($report)) {
			foreach ($report as $cId => $r) {
			foreach ($r['categories'] as $cat => $years) { ?>
			<tr>
				<td><?= $this->Html->link($r['company_name'], ['controller'=>'Contractors', 'action'=>'dashboard', $cId]); ?></td>
				<td><?= $cat; ?></td>
				<?php 
				foreach ($years as $year=>$value) {
					$arr[$year][$cat][] = $value;
					echo '<td>' .$value. '</td>';
				}
				?>
			</tr>
			<?php 
			}
			}
		}
		?>
		</tbody>
		</table>
	</div>

	<?php
	$lineChartData = array();
	$i = 0;
	foreach ($arr as $year=>$data) {
		$lineChartData[$i][] = "$year";
		foreach ($data as $cat=>$val) {
			$lineChartData[$i][] = array_sum($val) / count($val);
		}
	$i++;
	}
	array_unshift($lineChartData, array('Year'));
	foreach ($categoriesSelected as $c) {
		array_push($lineChartData[0], $c);
	}
	?>	
	<script>
		var lineChartData = <?= json_encode($lineChartData) ?>;
		var imgsrc =  $('#chart_image').attr('src');			
	</script>
</div>
</div>
</div>
