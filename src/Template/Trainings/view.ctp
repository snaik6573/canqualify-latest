<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Training $training
 */
use Cake\Core\Configure;
$uploaded_path = Configure::read('uploaded_path');
$users = array(SUPER_ADMIN,CLIENT,CLIENT_ADMIN);
?>
<div class="row trainings">
<div class="col-lg-6">
<div class="card">
    <div class="card-header">
        <?= h($training->name) ?>
    </div>  
    <div class="card-body card-block">
    <table class="table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($training->name) ?></td>
        </tr>
        <!--<tr>
            <th scope="row"><?= __('Category') ?></th>
            <td><?= $training->has('category') ? $this->Html->link($training->category->name, ['controller' => 'Categories', 'action' => 'view', $training->category->id]) : '' ?></td>
        </tr>-->
        <!--<tr>
            <th scope="row"><?= __('Is Training') ?></th>
            <td><?= $training->is_training ? __('Yes') : __('No'); ?></td>
        </tr>-->
        <tr>
            <th scope="row"><?= __('Client') ?></th>
            <td><?= $training->has('client') ? $this->Html->link($training->client->company_name, ['controller' => 'Clients', 'action' => 'view', $training->client->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($training->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created By') ?></th>
            <td><?= $this->Number->format($training->created_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified By') ?></th>
            <td><?= $this->Number->format($training->modified_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Category Order') ?></th>
            <td><?= $this->Number->format($training->category_order) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($training->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($training->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Active') ?></th>
            <td><?= $training->active ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    </div>
</div>
</div>
<div class="col-lg-6 trainings">
<div class="card">
    <div class="card-header">
        <?= __('Description') ?>
    </div>
    <div class="card-body card-block">
        <?= $this->Text->autoParagraph(h($training->description)); ?>
    </div>
    <div class="card-header">
        <?= __('Sites') ?>
    </div>
    <div class="card-body card-block">
        <?php foreach($sitesAssigned as $site) {
            echo $this->Text->autoParagraph(h($site));
        } ?>
    </div>
    <?php //if($training->is_training) { ?>
    <?php if($training->traning_video != ""){ ?>
    <div class="card-header">
        <?= __('Training Video') ?>
    </div>
    <div class="card-body card-block">  
    <?php if($training->traning_video !=''){ ?>
        <video width="480" height="300" controls>           
            <source src="<?php echo $uploaded_path.$training->traning_video; ?>" type="video/mp4">
        </video>        
    <?php } ?>
    </div>
    <?php }else{ ?>
    <div class="card-header">
        <?= __('Your Training Video link') ?>
    </div>
    <div class="card-body card-block">  
    <?php if($training->traning_video_link !=''){ ?>
      <?= h($training->traning_video_link) ?>
    <?php } ?>
    </div>
    <?php } ?>
</div>
</div>
</div>

<div class="row related">
<div class="col-lg-12">
<div class="card">
    <div class="card-header">
        <?= __('Related Questions') ?>
<span class="pull-right"><?= $this->Html->link(__('Add New'), ['controller' => 'TrainingQuestions', 'action' => 'add', $training->id, $training->client_id],['class'=>'btn btn-success btn-sm']) ?> </span>
    </div>
    <div class="card-body card-block">
    <?php if (!empty($training->training_questions)): ?>
    <table class="bootstrap-data-table-export table table-striped table-bordered">
    <thead>
        <tr>
            <th scope="col"><?= __('Id') ?></th>
            <th scope="col"><?= __('Question') ?></th>
            <th scope="col"><?= __('Category') ?></th>          
            <th scope="col"><?= __('Active') ?></th>            
            <th scope="col" class="actions"><?= __('Actions') ?></th>
        </tr>
        </thead>
        <tbody>
            <?php foreach ($training->training_questions as $trainingQuestions):
             $videoQuestion = "Are you sure, watched your training video complete ? (Need to watch video complete this Question)";
                if(strcmp($videoQuestion, $trainingQuestions->question) !== 0){
             ?>
            <tr>
                <td><?= h($trainingQuestions->id) ?></td>
                <td><?= h($trainingQuestions->question) ?></td>
                <td><?= h($training->name) ?></td>                
                <td><?= h($trainingQuestions->active) ?></td>
                <td class="actions">
                <?= $this->Html->link('<i class="fa fa-lightbulb-o"></i>', ['controller' => 'trainingQuestions', 'action' => 'questionHelper', $trainingQuestions->id, $training->id, $training->client_id],['escape'=>false, 'title' => 'QuestionHelper']) ?>
                <?= $this->Html->link('<i class="fa fa-eye"></i>', ['controller' => 'trainingQuestions', 'action' => 'view', $trainingQuestions->id],['escape'=>false, 'title' => 'View']) ?>
                <?php if($trainingQuestions->created_by == $activeUser['id'] || $activeUser['role_id'] == SUPER_ADMIN || $activeUser['role_id'] == ADMIN) { ?>
				<?= $this->Html->link('<i class="fa fa-pencil"></i>', ['controller' => 'trainingQuestions', 'action' => 'edit', $trainingQuestions->id, $training->id, $training->client_id],['escape'=>false, 'title' => 'Edit']) ?>
                <?php if (in_array($activeUser['role_id'], $users)) { ?>
                <?= $this->Form->postLink('<i class="fa fa-trash-o"></i>', ['controller' => 'trainingQuestions','action' => 'delete', $trainingQuestions->id], ['escape'=>false, 'title' => 'Delete', 'confirm' => __('Are you sure you want to delete # {0}?', $trainingQuestions->id)]) ?>
                <?php }} ?>
                </td>
            </tr>
            <?php } ?>          
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</div>
</div>
</div>
