<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContractorFeedback[]|\Cake\Collection\CollectionInterface $contractorFeedbacks
 */
?>
<div class="row contractorFeedbacks">
<div class="col-lg-12">
<div class="card">
    <div class="card-header">
        <strong class="card-title"><?= __('Contractor Feedbacks') ?></strong>
       <!-- <span class="pull-right"><?= $this->Html->link(__('Add New'), ['controller' => 'ContractorFeedbacks', 'action' => 'add'],['class'=>'btn btn-success btn-sm']) ?> </span>-->
    </div>
    <div class="card-body table-responsive">
    <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
    <thead>
    <tr>
        <th scope="col"><?= h('id') ?></th>
        <th scope="col"><?= h('Contractor Name') ?></th>
        <th scope="col"><?= h('Rating') ?></th>
        <th scope="col"><?= h('Feedback') ?></th>
        <!--<th scope="col"><?= h('Contractor Testimonial') ?></th>-->
        <th scope="col" class="actions"><?= __('Actions') ?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($contractorFeedbacks as $contractorFeedback): ?>
        <?php
        $starNumber =$contractorFeedback->rating;
        ?>
    <tr>
        <td><?= $this->Number->format($contractorFeedback->id) ?></td>
        <td><?= $contractorFeedback->has('contractor') ? $this->Html->link($contractorFeedback->contractor->company_name, ['controller' => 'Contractors', 'action' => 'view', $contractorFeedback->contractor->id]) : '' ?></td>
        <td data-sort="<?= (!empty($starNumber)) ? $starNumber : 0;?>">
            <?php           
            $starNumber =$contractorFeedback->rating;           

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
        <td>
         <?php
            $string = $contractorFeedback->comment;
            if (strlen($string) > 40) {
            $trimstring = substr($string, 0, 40).$this->Html->link(__(' Read More..'), ['controller'=>'ContractorFeedbacks', 'action'=>'review',$contractorFeedback->id], ['class'=>'ajaxmodal', 'data-toggle'=>'modal', 'data-target'=>'#scrollmodal', 'escape'=>false, 'title'=>'Review']);
            } else {
            $trimstring = $string;
            }
            echo $trimstring;
            ?>
          </td>
       <!-- <td><?= $contractorFeedback->testimonial ? __('Yes') : __('No'); ?></td>-->
        <td><?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $contractorFeedback->id],['escape'=>false, 'title' => 'View']) ?></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
    </table>
    </div>  
</div>
</div>
</div>

<div class="modal fade" id="scrollmodal" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="scrollmodalLabel"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
        </div>
    </div>
    </div>
</div>