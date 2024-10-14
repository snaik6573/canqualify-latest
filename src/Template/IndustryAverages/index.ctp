<?php 
$year_range = ['2015','2016','2017','2018','2019'];
?>
<div class="row naiscCodes">
<div class="col-lg-12">
<div class="card"> 
        <div class="card-header">
		<strong class="card-title"><?= __('Industry Averages') ?></strong>		
	    </div>
      <div class="card-body table-responsive">
        <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
        <thead>
        <tr>
                <th scope="col" ><?= h('NAISC Code ID') ?></th>
                <th scope="col" ><?= h('Title') ?></th>
                <th scope="col" ><?= h('2015') ?></th>
                <th scope="col" ><?= h('2016') ?></th>
                <th scope="col" ><?= h('2017') ?></th>
                <th scope="col" ><?= h('2018') ?></th>
                <th scope="col" ><?= h('2019') ?></th>
        </tr>
    </thead>
     <tbody>
        <?php  foreach ($industryAverage as $naisc) {  ?>
        <tr>
            <td><?= h($naisc['id']) ?></td>        
            <td><?= h($naisc['title']) ?></td>
                    <?php  
                    $industryAverageYear =[];
                    foreach ($naisc['industry_averages'] as $industryAverage) { //pr($value);
                             $industryAverageYear[$industryAverage['year']] = $industryAverage['id'];
                    }                    
                  
                    foreach ($year_range as $year) { ?>
                    <td>
                        <?php if (array_key_exists($year, $industryAverageYear)){
                            echo $this->Html->link(__('Edit'), ['action'=>'edit', $industryAverageYear[$year]], ['class'=>'ajaxmodal', 'data-toggle'=>'modal', 'data-target'=>'#scrollmodal', 'escape'=>false, 'title'=>'industryAverages']); 
                        } else {                             
                            echo $this->Html->link(__('Add'),['action'=>'add'], ['class'=>'ajaxmodal', 'data-toggle'=>'modal', 'data-target'=>'#scrollmodal1', 'escape'=>false, 'title'=>'industryAverages']); 
                        }
                    ?>
                    </td>
                    <?php 
                    } 
               ?> 
    </tr>
    <?php } ?>
        </tbody>
</div>
</div>
</div>


<div class="modal fade" id="scrollmodal" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">Industry Average</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
    <div class="modal-body">
    </div>
</div>
</div>
</div>

<div class="modal fade" id="scrollmodal1" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">Industry Average</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
    <div class="modal-body">
    </div>
</div>
</div>
</div>
