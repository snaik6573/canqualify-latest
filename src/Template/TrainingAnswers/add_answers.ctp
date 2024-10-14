<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContractorAnswer $contractorAnswer
 */
use Cake\Core\Configure;
$uploaded_path = Configure::read('uploaded_path');
?>
<?php if($is_locked==0): ?>
<div class="row trainingAnswers">
<div class="col-lg-12">
<div class="card">
    <?php if($training->traning_video !=''){ ?>
	<div class="card-header">
		<strong><?= h($training->name) ?></strong> Video
	</div>
	<div class="card-body card-block">
		<div class="row">
		<div class="col-lg-6">
		<?php if($training->traning_video !=''){ ?>
			<video id="video" width="560" height="340" class="video-js vjs-default-skin" controls>
				<source src="<?php echo $uploaded_path.$training->traning_video; ?>" type="video/mp4">
			</video>
			<br>
			<?php $showComplete = "incomplete";
			foreach ($trainingQuestions as $training_q) {
			foreach ($training_q['training_answers'] as $training_ans){
			$videoQuestion = "Are you sure, watched your training video complete ? (Need to watch video complete this Question)";
			if(strcmp($videoQuestion, $training_q->question) == 0){			 
			$status = implode(',',json_decode($training_ans->answer));
		 	(strcmp($status,"complete") !== 0) ? $showComplete ="incomplete" : $showComplete="complete";
			} 
			} } ?>
			<div id="status" class="<?= $showComplete ?>">
				<span>Viewed: </span>
				<span class="status complete">Yes</span>
				<span class="status incomplete">No</span>
				<br>
				<span class="badge badge-secondary">*You must view complete video in order to complete this training.</span>

				<div style="display: none;">
				<span id="played">0</span> seconds out of 
				<span id="duration"></span> seconds. (only updates when the video pauses)
				</div>
			</div>
		<?php } ?>		
		</div>
		<?php if(!empty($training->description)){ ?>
		<div class="col-sm-9">
			<span class = "font-weight-bold">Note: </span>
			<?= $training->description; ?>
		</div>
		<?php } ?>
		</div>
	</div>
	<br><br>
   <?php }else{ ?>
		<div class="card-header">
		<strong><?= h($training->name) ?></strong> Video
	</div>
	<div class="card-body card-block">
		<div class="row">
		<div class="col-lg-6">
		<?php if($training->traning_video_link !=''){ ?>
		<?php echo $this->Html->link($training->traning_video_link,null,["target"=>"_Blank"]); ?>
		<?php } ?>
		</div>
		</div>
	</div>
	<?php } ?>
	<div class="card-header">
		<strong><?= h($training->name) ?></strong> Add Answers
	</div>
	<div class="card-body card-block">
	<?php
	if(!empty($ansPerc) && $ansPerc>0) {
	?>
	<?php // $client = $this->User->getClients($activeUser['contractor_id']);
	//if(in_array(3, $client)){  ?>
    <div class="progress mb-2">
		<div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: <?= $ansPerc.'%' ?>" aria-valuenow="<?= $ansPerc ?>" aria-valuemin="0" aria-valuemax="100"><?= $ansPerc ?>%</div>
	</div>
	<?php //}else{ ?>
	<!-- 	<div class="progress mb-2">
		<div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: <?= $ansPerc['total'].'%' ?>" aria-valuenow="<?= $ansPerc['total'] ?>" aria-valuemin="0" aria-valuemax="100"><?= $ansPerc['total'] ?>%</div>
	</div> -->
	 <?php //} ?>
	<!--<div class="progress mb-2">
		<div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: <?= $ansPerc['correctAns'].'%' ?>" aria-valuenow="<?= $ansPerc['correctAns'] ?>" aria-valuemin="0" aria-valuemax="100"><?= $ansPerc['correctAns'] ?>%</div>
		<div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: <?= $ansPerc['incorrectAns'].'%' ?>" aria-valuenow="<?= $ansPerc['incorrectAns'] ?>" aria-valuemin="0" aria-valuemax="100"><?= $ansPerc['incorrectAns'] ?>%</div>
	</div>-->
	<?php  } ?>
	<?= $this->Form->create($trainingAnswer) ?>
	<?php foreach($trainingQuestions as $key => $question):  //pr($question);
	$answer = array();
		$answer[] = !empty($question->training_answers) ? json_decode($question->training_answers[0]->answer) : '';
		$ansArray = array();
		$c_ans= array();
		$ansArray = json_decode($question->correct_answer);
		$q_optopns= (empty($question['question_options'])) ? array('','','','') :json_decode($question['question_options']);
		// pr($ansArray);
		// pr($q_optopns);
		if(!empty($ansArray)){
		foreach ($ansArray as $key1 => $value) { 
			if(strcmp($value, 'complete') != 0){ 
			$c_ans[] = array_search($value,$q_optopns);
			}			
		}
		}	
		$data_submitted = !empty($question->training_answers) && $question->training_answers[0]->answer != '' ? true  : false;
		$dataAtrributes = json_decode($question->data_attribute);

	?>

	<div class="form-group row ques-ans ques-ans-<?= $question->id;?>" data-submitted="<?= $data_submitted ?>" data-ans="<?= implode(',', $c_ans); ?>" data-qid="<?= $question->id;?>" option-attr="">
		<div class="col-sm-12">
			<?php if($question->question_type->name != 'checkbox_single') { 
			$videoQuestion = "Are you sure, watched your training video complete ? (Need to watch video complete this Question)";
			if(strcmp($videoQuestion, $question->question) !== 0){ ?>
			<strong><label class="form-control-label" style="display: inline-block;"><?= h($question->question) ?></label></strong>
			<ul class="data-attribute-section custom-bullets">
			<?php if(!empty($dataAtrributes)){
				foreach ($dataAtrributes as $key2 => $value) { ?>
				<li id ="<?= $key2 ?>" name="form-control-label-<?= $key2 ?>" style="display: none"><?= $value ?></li>	
			<?php	}			
			} ?>
		</ul>
		<?php }else{ }
	    } ?>
		<?php if($question->help){ echo '<a href="javascript:void();" data-toggle="popover" title="" data-toggle="popover" data-content="'.htmlentities($question->help).'" style="margin-left: 5px;"><i class="fa fa-info-circle"></i></a>'; } ?>	
		</div>
		<?= $this->element('Training/'.$question->question_type->name, ['class'=>'q-id',"key" => $key,"question" => $question, "answer" => $answer]) ?>
		
		<?php $videoQuestion = "Are you sure, watched your training video complete ? (Need to watch video complete this Question)";
			if(strcmp($videoQuestion, $question->question) !== 0){ ?>
		<div class="col-sm-9">
		<?= $this->Form->button('Evaluate', ['type' => 'button', 'class'=>'btn btn-success btn-sm m-2 sendData']) ?>
		<span class="chk-ans font-weight-bold"></span>
		</div>
		<?php } ?>
		
	</div>
	
	<hr/>
	<?php endforeach; ?>

	<?php 
	$trainings = $this->Training->getTrainings($activeUser); 
	$getNextcat = $this->Training->getNextcat($trainings, $training_id, 4);
	?>
	<div class="form-actions form-group">
	<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit All', ['type' => 'submit', 'class'=>'btn btn-primary btn-sm']) ?>
	<!-- <?= $this->Form->button('Evaluate All', ['type' => 'button', 'class'=>'btn btn-success btn-sm m-2 evaluate-all']) ?> -->
 	<?php 
	if($getNextcat != 'lastsubmit'){
	echo $this->Html->link('Continue', ['action' => 'addAnswers/'.$getNextcat], ['class'=>'btn btn-success btn-sm']); 
	} ?>
	</div>
	
	</div>
	<?= $this->Form->end() ?>
	</div>
</div>
</div>
<?php else: ?>
<div class="row trainingAnswers">
<div class="col-lg-12">
<div class="card">
    <?php 	
	if(!empty($training)) {
	if($training->traning_video !=''){ ?>
	<div class="card-header">
		<strong><?= h($training->name) ?></strong> Video
	</div>
	<div class="card-body card-block">
		<div class="row">
		<div class="col-lg-6">
		<?php if($training->traning_video !=''){ ?>
			<video id="video" width="560" height="340" class="video-js vjs-default-skin" controls>
				<source src="<?php echo $uploaded_path.$training->traning_video; ?>" type="video/mp4">
			</video>
			<div id="status" class="incomplete">
				<span>Play status: </span>
				<span class="status complete">COMPLETE</span>
				<span class="status incomplete">INCOMPLETE</span>
				 <br>
				 <div style="display: none;">
				 <span id="played">0</span> seconds out of 
				 <span id="duration"></span> seconds. (only updates when the video pauses)
				</div>
				<div class="result"></div>
			</div> 		
		<?php } ?>
		</div>
		</div>
	</div>
	<?php }else{ ?>
		<div class="card-header">
		<strong><?= h($training->name) ?></strong> Video
	</div>
	<div class="card-body card-block">
		<div class="row">
		<div class="col-lg-6">
		<?php if($training->traning_video_link !=''){ ?>
		<?php echo $this->Html->link($training->traning_video_link,null,["target"=>"_Blank"]); ?>
		<?php } ?>
		</div>
		</div>
	</div>
	<?php } ?>
	<div class="card-header">
		<strong><?= h($training->name) ?></strong> Add Answers
	</div>
	<div class="card-body card-block">	
	<?php foreach($trainingQuestions as $key => $question) : ?>	
		<div class="card">
			<div class="card-header">
				<?= h($question->question) ?><p class="hint"><?= $question->help ?></p>
			</div>
			<div class="card-body card-block">
			<?php 
			$question_type = $question->question_type->name;
			$training_answers = $question->training_answers;
			if($question_type == 'file') {
				foreach($training_answers as $answer) {
					$answer->answer = explode(',',$answer->answer);
					foreach($answer->answer as $answer) {
						echo '<a href="'.$uploaded_path.$answer.'" target="_Blank">'.$answer.'</a>';
					}
				}
			}
			elseif($question_type == 'select' || $question_type == 'checkbox') {
				foreach($training_answers as $answer) {
					$answer->answer = explode(',',$answer->answer);
					foreach($answer->answer as $answer) {
						echo $this->Text->autoParagraph(h($answer));
					}
				}
			}
            elseif($question_type == 'checkbox_single') {
			    foreach($training_answers as $answer) {
					echo $this->Text->autoParagraph(h($answer->answer));
				}
            }
            else {
			    foreach($training_answers as $answer) {
					echo $this->Text->autoParagraph(h($answer->answer));
				}
            }
				/*if($question->correct_answer==$answer->answer) {
					echo '<b>Correct: </b><span>'.$answer->answer.'</span>';
				} else { 
					echo '<b>Incorrect: </b><span style="color : red;">'.$answer->answer.'</span>';
					echo '<br/><br/><b>Correct Answer: </b>'.$question->correct_answer;
				}*/
			?>

			</div>
		</div>	
	<?php endforeach;?>		
	</div>
	<?php } ?>
</div>
</div>
</div>
<?php endif; ?>
