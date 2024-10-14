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
<style type="text/css">
  .que .radio{
   display: block;
}

</style>
<div class="row reviews">
<div class="col-lg-9">
<div class="card">
    <div class="card-header">
        <strong>Your feedback is valuable and helps us improve</strong> 
    </div>
    <div class="card-body card-block">
    <?= $this->Form->create($contractorFeedback) ?>

    <div class="form-group" style="padding-left: 15px;">
        <label for="How would you rate your overall experience with Canqualify">How would you rate your overall experience with CanQualify?</label>
         <!-- <?= $this->Form->label('How would you rate your overall experience with Canqualify?', null, ['class'=>'']); ?>-->
        <?php echo $this->Form->control('rating', ['type'=>'hidden','id'=>'rating']); ?>
        <section class='rating-widget'>
        <div class='rating-stars'>
            <ul id='stars'>
              <li class='star' title='Poor' data-value='1'><i class='fa fa-star fa-fw'></i></li>
              <li class='star' title='Fair' data-value='2'><i class='fa fa-star fa-fw'></i></li>
              <li class='star' title='Good' data-value='3'><i class='fa fa-star fa-fw'></i></li>
              <li class='star' title='Excellent' data-value='4'><i class='fa fa-star fa-fw'></i></li>
              <li class='star' title='WOW!!!' data-value='5'><i class='fa fa-star fa-fw'></i></li>
            </ul>
        </div>     
        </section>  
        <hr/>      
    </div>

    <!--<div class="thanksMsgDiv form-group alert with-close alert-success alert-dismissible fade show" style="display: none;">              
        <p class="text-dark text-center">Thank you for registering for our Company.We value your feedback that could help us improve our services.</p>
    </div>-->

    <div class="form-group questionDiv">
    <?php 
    $answer[0] = null;
    foreach($questions as $key => $question){
        $question_options = json_decode($question['question_options']);
        $question_options = array_combine(array_values($question_options), $question_options);
     ?> 
    <div class="col-sm-12 que<?php if($question->id == 4){ ?> parantQue" <?php }elseif($question->id==5 || $question->id==6){ ?> depQue" <?php } ?>  style="display: <?php if($question->id == 5 || $question->id==6){ ?> none;" <?php }else  ?> " >
        <label class="form-control-label"> <?= htmlspecialchars_decode(h($question->question)) ?> </label>   

       <div class="col-sm-12" style="padding-left:0px !important;">
        <?php if($question->question_type == 'radio'){  ?>
          <?= $this->Form->radio('feedback_answers.'.$key.'.answer', $question_options, ['label'=>['class'=>'radio'], 'class'=>'feedback_ans']) ?>
          <?php } elseif($question->question_type =='checkbox') { ?>
            <?= $this->Form->select('feedback_answers.'.$key.'.answer', $question_options, ['label'=>['class'=>'checkbox'], 'class'=>'feedback_ans','multiple'=>'checkbox'])?>
          <?php } elseif($question->question_type =='textarea') { ?>
          <?= $this->Form->textarea('feedback_answers.'.$key.'.answer', ['class'=>"form-control col-sm-9", 'empty'=>true, 'label'=>false]) ?>
          <?php } ?>
          <div class="answer_others" style="display: none;">
          <?= $this->Form->control('feedback_answers.'.$key.'.answer_other', ['class'=>"form-control col-sm-6", 'empty'=>true, 'label'=>false]) ?>
          </div>
           <hr/>
          <?= $this->Form->control('feedback_answers.'.$key.'.question_id', ['type'=>'hidden', 'value'=>$question->id]); ?>
        </div>

    </div>

    <?php } ?>
     
    <div class="form-group commentDiv" style="padding: 15px;">
        <?= $this->Form->label('Additional Feedback', null, ['class'=>'']); ?>
        <?= $this->Form->textarea('comment', ['class'=>'form-control col-sm-9','label'=>false]) ?>
    </div> 
    <!--<div class="form-group">
      <?= $this->Form->checkbox('testimonial',['id'=>'testimonial']); ?>
      <?= $this->Form->label('testimonial', 'CanQualify can use this feedback/review as testimonial on their website canqualify.com'); ?>
    </div>-->  

    </br>
    <div class="form-actions form-group" style="padding-left: 15px;">
        <?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-success btn-sm']); ?>
         <!--<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Skip', ['type' => 'skip', 'class'=>'btn btn-primary btn-sm']); ?>-->
    </div>
    <?= $this->Form->end() ?>
    </div>
</div>
</div>
</div>
