<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContractorFeedback $contractorFeedback
 */
?>
<div class="row contractorFeedbacks">
<div class="col-lg-6">
<div class="card">
    <div class="card-header">
        <?= ('Contractor Feedback') ?>
    </div>
    <div class="card-body card-block">
    <table class="table">
        <tr>
            <th scope="row"><?= __('Contractor') ?></th>
            <td><?= $contractorFeedback->has('contractor') ? $this->Html->link($contractorFeedback->contractor->company_name, ['controller' => 'Contractors', 'action' => 'view', $contractorFeedback->contractor->id]) : '' ?></td>
        </tr>
        </tr>
       <!-- <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($contractorFeedback->id) ?></td>
        </tr>-->
        <tr>
            <th scope="row"><?= __('Rating') ?></th>
            <td>
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
            ?></td>

        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($contractorFeedback->created) ?></td>
        </tr>
       <!-- <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($contractorFeedback->modified) ?></td>
        </tr>-->
        <tr>
        </tr>
        <tr>
            
        </tr>
        <tr>
           
        </tr>
    </table>
    </div>
</div>
</div>

<div class="col-lg-6">
<div class="card">
    <div class="card-header">
        <?= __('Feedback') ?>
    </div>
    <div class="card-body card-block">
       <?= $this->Text->autoParagraph(h($contractorFeedback->comment)); ?>
    </div>
</div>
</div>
</div>
</div>

<!--<?php if($contractorFeedback->rating > 3){ ?>-->
<div class="row FeedbackAnswers">
<div class="col-lg-12">
<div class="card">    
    <div class="card-body card-block">
    <?php foreach($questions as $key => $question): 
    if(!empty($question->feedback_answers)){
       ?>
    <div class="card">
        <div class="card-header">
            <?= htmlspecialchars_decode(h($question->question)) ?></td>
        </div>
        <div class="card-body card-block">
            <?php
            $feedback_answers = $question->feedback_answers; 
                foreach($feedback_answers as $answer) {
                    echo $this->Text->autoParagraph(h($answer->answer));
                }           
            ?>
        </div>
    </div>
    <?php } endforeach; ?>
    </div>
</div>
</div>
<!--<?php } ?>-->
</div>