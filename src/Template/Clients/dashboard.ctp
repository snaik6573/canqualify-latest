<?php
use Cake\Core\Configure;
require_once(ROOT . DS . 'vendor' . DS . "fusion-charts" . DS . "fusioncharts.php");
$iconList = Configure::read('icons'); //, array('0'=>'Grey','1'=>'Red','2'=>'Yellow','3'=>'Green')
?>
<style>
    .hidden-form{
        display: none;
    }
</style>
<div class="page-content">
    <section class="row">
        <div class="col-12 col-lg-9">
            <div class="row">
                <?= $this->element('client-elements/widget-area-1');?>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!--<div class="card-header">
                            <h4>Overall Complience</h4>
                        </div>
                        <div class="card-body">
                            <div ></div>
                        </div>-->
                        <div class="card">
                            <div class="card-header">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active" id="chart-overall-compliance-tab" data-bs-toggle="tab" href="#chart-overall-compliance"
                                           role="tab" aria-controls="home" aria-selected="true">Overall Compliance </a>
                                    </li>
                                    <?php
                                    if(isset($clientSites) && count($clientSites) > 1){
                                        ?>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" id="chart-site-compliance-tab" data-bs-toggle="tab" href="#chart-site-compliance"
                                               role="tab" aria-controls="profile" aria-selected="false">Compliance By Site</a>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="chart-overall-compliance" role="tabpanel"
                                         aria-labelledby="chart-overall-compliance-tab">
                                    </div>
                                    <?php
                                    if(isset($clientSites) && count($clientSites) > 1){
                                        ?>
                                        <div class="tab-pane fade" id="chart-site-compliance" role="tabpanel"
                                             aria-labelledby="chart-site-compliance-tab">

                                        </div>
                                    <?php
                                    }
                                    ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Recent Messages</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-lg">
                                    <thead>
                                    <tr>
                                        <th>Supplier</th>
                                        <th>Subject</th>
                                        <th>Note By</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    //debug($recentMessages);
                                     if (!empty($recentMessages) && count($recentMessages) > 0){
                                        foreach ($recentMessages as $note)
                                        {
                                        ?>
                                        <tr>
                                            <td class="col-3">
                                                <div class="d-flex">
                                                    <div class="overall-status <?= !empty($note['icon']) ? 'overall-status-' . $note['icon'] : '' ?>">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                             fill="currentColor" class="bi bi-circle-fill"
                                                             viewBox="0 0 16 16">
                                                            <circle cx="8" cy="8" r="8"/>
                                                        </svg>
                                                        <span style="display: block;color: black;padding-top:5px;"><?php echo $iconList[$note['icon']];?></span>
                                                    </div>
                                                    <p class="font-bold ms-3 mb-0">
                                                        <?= $this->Html->link($note['company_name'], ['controller'=>'Contractors', 'action'=>'dashboard', $note['contractor_id']]); ?>
                                                    </p>
                                                </div>
                                            </td>
                                            <td class="col-auto">
                                                <p class=" mb-0"><?= $note['subject'] ?></p>
                                            </td>
                                            <td><?php
                                                if(!in_array($note['role_id'], array(1,4,9,11)))
                                                 echo $note['first_name'].' '.$note['last_name']."<br />";
                                                echo $note['user_company_name'] ;
                                                ?></td>
                                        </tr>
                                        <?php
                                        }
                                    }
                                    else{
                                        echo '<tr><td colspan="2">No recent messages.</td></tr>';
                                    }
                                    ?>
                                    <tr>
                                        <td colspan="2">
                                            <?= $this->Html->link(__('View All'), ['controller' => 'Notes', 'action' => 'clientNotes'],['class'=>'btn btn-info']) ?>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-3">
            <?= $this->element('client-elements/widget-area-right');?>
        </div>
    </section>
</div>
<?php
/*overall compliance*/
$donutoverallCompliance = new FusionCharts("doughnut2d", "overall-compliance", "100%", 400, "chart-overall-compliance", "json", $overallCompliance );
$donutoverallCompliance->render();

/*compliance by site*/
$donutSiteCompliance = new FusionCharts("scrollstackedcolumn2d", "site-compliance", "100%", 350, "chart-site-compliance", "json", $siteCompliance);
$donutSiteCompliance->render();

/*supplier registration*/
$donutSupplierRegistration = new FusionCharts("doughnut2d", "supplier-registration", "100%", 220, "chart-supplier-registration", "json", $supplierRegistration );
$donutSupplierRegistration->render();

?>
<?=  $this->Form->create('Contractors', ['url'=> ['controller' => 'Contractors','action'=>'contractor-list'], 'class'=>'hidden-form', 'id' => 'fusionchart-compliance-site-frm', 'target' => '_blank']);?>
<?= $this->Form->control('site', ['type'=>'hidden','id'=>'site','value' => '']); ?>
<?= $this->Form->control('icon', ['type'=>'hidden','id'=>'icon','value' => '']); ?>
<?= $this->Form->control('count', ['type'=>'hidden','id'=>'count','value' => '']); ?>
<?= $this->Form->end() ?>

<?=  $this->Form->create('Contractors', ['url'=> ['controller' => 'Contractors','action'=>'contractor-list'], 'class'=>'hidden-form', 'id' => 'fusionchart-compliance-frm', 'target' => '_blank']);?>
<?= $this->Form->control('filter1', ['type'=>'hidden','id'=>'filter1','value' => '']); ?>
<?= $this->Form->control('filter2', ['type'=>'hidden','id'=>'filter2','value' => '']); ?>
<?= $this->Form->end() ?>

<?=  $this->Form->create('Leads', ['url'=> ['controller' => 'Leads','action'=>'pending-leads'], 'class'=>'hidden-form', 'id' => 'fusionchart-registration-frm', 'target' => '_blank']);?>
<?= $this->Form->control('leadsfilter1', ['type'=>'hidden','id'=>'leadsfilter1']); ?>
<?= $this->Form->end() ?>
    <script>
        $(document).ready(function(){
            FusionCharts.addEventListener("dataplotclick", clickHandler);
        });

        clickHandler = function(e){
            console.log(e.sender.id);
                if(e.sender.id){
                    if(e.sender.id == 'site-compliance'){
                        $('#site').val('');
                        $('#icon').val('');
                        /*alert( e.data.categoryLabel);
                        alert( e.data.datasetName);
                        alert( e.data.value);*/
                        if(e.data.categoryLabel){
                            $('#site').val(e.data.categoryLabel);
                        }
                        if(e.data.datasetName){
                            $('#icon').val(e.data.datasetName);
                        }
                        if(e.data.value){
                            $('#count').val(e.data.value);
                        }
                        $('#fusionchart-compliance-site-frm').submit();
                    }
                    else if(e.sender.id == 'overall-compliance'){
                        $('#filter1').val('');
                        $('#filter2').val('');
                        if(e.data.categoryLabel){
                            //alert( e.data.categoryLabel);
                            $('#filter1').val(e.data.categoryLabel);
                        }
                        if(e.data.datasetName){
                            //alert( e.data.datasetName);
                            $('#filter2').val(e.data.value);
                        }
                        $('#fusionchart-compliance-frm').submit();
                    }
                    else if(e.sender.id == 'supplier-registration'){
                        if(e.data.categoryLabel){
                            //alert( e.data.categoryLabel);
                            $('#leadsfilter1').val(e.data.categoryLabel);
                        }
                        $('#fusionchart-registration-frm').submit();
                    }
                }
        };

    </script>
