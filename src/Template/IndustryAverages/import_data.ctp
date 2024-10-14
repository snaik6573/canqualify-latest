<?php
use Cake\Core\Configure;
$uploaded_path = Configure::read('uploaded_path');
?>
<div class="row leads">
<div class="col-lg-12">
<div class="card">
    <div class="card-header">
        <strong>Upload </strong> List
    </div>
    <div class="card-body card-block">

        <!--<label>Download template for uploading <span>
    <a href="<?= $uploaded_path ?>template_contractor_upload-1563945675.xlsx" target="_Blank">Click Here</a>
    <br /><br />-->

        <?= $this->Form->create(null,['type' => 'file']); ?>
        <div class="form-group">
        <?= $this->Form->label('Upload File', null, ['col-form-label']); ?>
            <?= $this->Form->control('file', ['type' => 'file', 'label'=>false ]);?>
        </div>

        <div class="form-group">
			<?= $this->Form->control('year', ['class'=>'form-control','required'=>false]); ?>
		</div>

        <div class="form-group">
        <?=  $this->Form->button('Import',['class'=>'btn btn-success']); ?>
        </div>
        <?= $this->Form->end(); ?>
    </div>

</div>
</div>
    <?php
    echo '<div class="col-lg-12">';
    if(!empty($recordsAdded) && $recordsAdded > 0){  echo 'Records Added: '. $recordsAdded;  }
    if(!empty($recordsUpdated) && $recordsUpdated > 0){  echo '<br/>Records Updated: '. $recordsAdded;  }
    if(!empty($matchNotFound)){  echo ' <br/>Records Returned: '. (intval(count($matchNotFound))-1);  }
    echo '</div>';
    if(!empty($matchNotFound)) {
        ?>
        <div class="col-lg-12">
            <div class="row">Match not found data:</div>
            <table id="bootstrap-data-table-export" class="table table-striped table-bordered correction">
                <tbody>
                <?php foreach ($matchNotFound as $row) {
                    echo '<tr>';
                    foreach ($row as $col) {
                        echo '<td>' . $col . '</td>';
                    }
                    echo '</tr>';
                } ?>
                </tbody>
            </table>
        </div>
        <?php
    }
    ?>
</div>
<style>
    table.correction{
        table-layout: fixed;
    }
    table.correction td{
        word-wrap:break-word;
    }
    </style>