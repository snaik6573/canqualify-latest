<div class="row contractors">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <strong class="card-title">
                <?php
                if(!empty($contractor->company_name)){
                    echo 'Review of '. $contractor->company_name;}
                if(!empty($client->company_name)){
                    echo ' for '. $client->company_name;}
                ?>
                </strong>
            </div>
            <div class="card-body table-responsive">
                <div class="wrapper center-block">
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default">
                            <div class="panel-heading active" role="tab" id="headingOne">
                                <h4 class="panel-title">
                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        <h6>Client Requirements are as follows: </h6>
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                <div class="panel-body">
                                    <?php
                                    if(!empty($CbenchmarkTypes))
                                    {
                                        $notes = array();
                                        ?>
                                        <div class="card-body table-fit">
                                            <table id="example" class="display"  style="width:100%">
                                                <thead>
                                                <th scope="col"><?= h('Bench Type') ?></th>
                                                <th scope="col"><?= h('Icon') ?></th>
                                                <th scope="col"><?= h('Range* (Any Year)') ?></th>
                                                <th scope="col"><?= h('Conclusion') ?></th>
                                                </thead>
                                                <?php
                                                foreach ($CbenchmarkTypes as $benchmarkType){
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $benchmarkType->benchmark_type->name; ?></td>
                                                        <td class="text-center"><?= '<span style="display:none;">'.$benchmarkType->icon.'</span><i class="fa fa-circle color-'.$benchmarkType->icon.'"></i></td>' ?>
                                                        <td class="text-center"><?= $benchmarkType->range_to==0 ? $benchmarkType->range_from .' +' : $benchmarkType->range_from .' < '. $benchmarkType->range_to ?></td>
                                                        <td><?= h($benchmarkType->conclusion) ?></td>
                                                        <?php
                                                        $notes[$benchmarkType->benchmark_type_id][$benchmarkType->icon] = $benchmarkType->conclusion;
                                                        ?>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                            </table>
                                        </div>
                                    <?php }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingTwo">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        <h6>Detailed System Review is as follows:</h6>
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                <div class="panel-body">
                                    <?php
                                    if(!empty($suggestedIcons)){
                                        foreach ($suggestedIcons as $key => $iconInfo){
                                            //debug($iconInfo);
                                            echo '<div  class="col-sm-6 table-responsive">';
                                            echo '<table class="table">';

                                            echo '<tr><td colspan="2"><i class="fa fa-circle color-'.$iconInfo['icon'].'"></i> <strong>'.$bNameList[$key].'</strong></td></tr>';
                                            if(!empty($iconInfo['info']['year'])){

                                                    foreach ($iconInfo['info']['year'] as $year => $val){
                                                        /*check if row is contributing to red icon*/
                                                        $class = '';
                                                        if(!empty($iconInfo['defaulters'])){
                                                            if(array_key_exists($year, $iconInfo['defaulters'])){
                                                               $class= $iconInfo['defaulters'][$year];
                                                            }
                                                        }
                                                        echo '<tr class="'.$class.'"><td>'.$year.'</td><td>'.$val.'</td></tr>';
                                                    }
                                                    if(!empty($iconInfo['info']['avg']))
                                                    {
                                                        echo '<tr><td>Average: </td><td>'.$iconInfo['info']['avg'].'</td></tr>';
                                                    }

                                            }
                                            echo '</table>';
                                            echo '</div>';
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- form -->

                <div class="card table-responsive">
                    <div class="card-header">
                        <strong>System Review At Glance: </strong>
                    </div>
                    <div class="card-body card-block">
                    <?php
                    $suggested_icon_array = array();
                    if(!empty($suggestedIcons)){
                        echo '<table class="table">';
                    foreach ($suggestedIcons as $key => $iconInfo){
                        array_push($suggested_icon_array, $iconInfo['icon']);
                        ?>
                        <tr>
                            <td><strong><?= $bNameList[$key]?></strong></td>
                            <td><i class="fa fa-circle color-<?= $iconInfo['icon']?>"></i> </td>
                        </tr>
                    <?php  }
                        if(!empty(min($suggested_icon_array))){
                            ?>
                            <tr>
                                <td><strong>Suggested Overall Icon</strong></td>
                                <td><i class="fa fa-circle color-<?= min($suggested_icon_array)?>"></i> </td>
                            </tr>
                            <?php
                        }
                        echo '</table>';
                    }?>
                    </div>
                </div>

            <div class="card-body card-block">
                <?= $this->Form->create('', ['url' => ['action' => 'saveReview'],'type' => 'file']) ?>
                <?php
                /*suggested icons*/
                echo $this->Form->hidden('suggested_overall_icon.contractor_id', ['value' => $contractor->id]);
                echo $this->Form->hidden('suggested_overall_icon.client_id', ['value' => $client->id]);
                echo $this->Form->hidden('suggested_overall_icon.icon', ['value' => min($suggested_icon_array)]);
                if(!empty($suggestedIcons)){
                    $counter = 0;
                    foreach ($suggestedIcons as $key => $iconInfo){

                        echo $this->Form->hidden('suggested_icon.'.$counter.'.icon', ['value' =>$iconInfo['icon']]);
                        echo $this->Form->hidden('suggested_icon.'.$counter.'.notes', ['value' =>$notes[$key][$iconInfo['icon']]]);
                        echo $this->Form->hidden('suggested_icon.'.$counter.'.bench_type', ['value' => $key]);
                        ?>
                <div class="row form-group">
                    <label class="col-sm-5">Update <?php echo $bNameList[$key]; ?> Status</label>
                    <div class="col-sm-4">
                <?php
                        echo $this->Form->control('icon.'.$counter.'.icon', ['options'=>$icons, 'type'=>'radio', 'required'=>true, 'label'=>false]);
                        echo $this->Form->hidden('icon.'.$counter.'.benchmark_type_id', ['value' => $key]);
                        ?>
                    </div>
                </div>
                        <?php
                        $counter++;
                    }
                }

                /*icons*/
                echo $this->Form->hidden('overall_icon.contractor_id', ['value' => $contractor->id]);
                echo $this->Form->hidden('overall_icon.client_id', ['value' => $client->id]);
                ?>


                <div class="row form-group">
                    <?= $this->Form->label('Document', null, ['class'=>'col-sm-5']); ?><br />
                    <div class="col-sm-7 uploadWraper">
                        <?php echo $this->Form->control('overall_icon.documents', ['label'=>false, 'type'=>'hidden', 'class'=>'documentName']); ?>
                        <?php echo $this->Form->file('overall_icon.uploadFile', ['label'=>false]); ?>
                        <div class="uploadResponse"></div>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-sm-5">Note</label>
                    <div class="col-sm-7"><?= $this->Form->control('overall_icon.notes', ['type' => 'textarea', 'class'=>'form-control', 'required'=>false, 'label'=>false]); ?></div>
                </div>
                <div class="row form-group">
                    <div class="col-sm-5"></div>
                    <div class="col-sm-4">
                        <?php echo $this->Form->control('overall_icon.show_to_contractor', ['type' => 'checkbox', 'label'=>'Show Note To Contractor']); ?>
                    </div>
                    <div class="col-sm-3">
                        <?php echo $this->Form->control('overall_icon.show_to_clients', ['type' => 'checkbox', 'label'=>'Show Note To Client']); ?>
                    </div>
                </div>
                <div class="form-actions form-group">
                    <?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type'=>'submit', 'class'=>'btn btn-primary btn-sm']) ?>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>

<style>
    .wrapper{
        width:100%;
    }
    @media(max-width:992px){
        .wrapper{
            width:100%;
        }
    }
    .panel-heading {
        padding: 0;
        border:0;
    }
    .panel-title>a, .panel-title>a:active{
        display:block;
        padding:15px;
        color:#555;
        font-size:16px;
        font-weight:bold;
        text-transform:uppercase;
        letter-spacing:1px;
        word-spacing:3px;
        text-decoration:none;
    }
    .panel-heading  a:before {
        font-family: 'Glyphicons Halflings';
        content: "\e114";
        float: right;
        transition: all 0.5s;
    }
    .panel-heading.active a:before {
        -webkit-transform: rotate(180deg);
        -moz-transform: rotate(180deg);
        transform: rotate(180deg);
    }
    .redBg{
        background: #FFBABA;
    }
</style>
<script>


    $(document).ready(function () {
        jQuery('#example').DataTable();
    });
</script>
