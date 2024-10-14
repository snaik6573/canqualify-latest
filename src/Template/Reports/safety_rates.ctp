<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <strong class="card-title">
                    <?= __('Report: Safety Rates') ?></strong>
                <span class="pull-right">&nbsp;|&nbsp;
                    <?= $this->Html->link(__('Export to Excel'), ['controller' => 'Reports', 'action' => 'safetyRates/'.$client_id.'/excel'],['class'=>'mr-2']) ?> </span>
                <span class="pull-right">
                    <?= $this->Html->link(__('Export to CSV'), ['controller' => 'Reports', 'action' => 'safetyRates/'.$client_id.'/csv'],['class'=>'mr-2']) ?> </span>
            </div>
            <div class="card-body table-responsive">
                <table id="bootstrap-data-table" class="table table-striped table-bordered" data-order="[[ 1, &quot;asc&quot; ]]">
                    <thead>
                    <tr>
                        <th>Supplier ID</th>
                        <th>Company Name</th>
                        <th>NAICS Code</th>
                        <th>TRIR</th>
                        <th>LWCR</th>
                        <th>DART</th>
                        <th>EMR</th>
                        <th>Fatalities</th>
                        <th>Citation</th>
                        <th>SR</th>
                        <th>Year</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(!empty($safetyRatesFormated)){
                        foreach ($safetyRatesFormated as $row){
                            echo '<tr>';
                            ?>
                            <td><?php echo empty($row['contractor_id']) ? '' : $row['contractor_id']?></td>
                            <td><?php echo empty($row['company_name']) ? '' : $row['company_name']?></td>
                            <td><?php echo empty($row['naics_code']) ? '' : $row['naics_code']?></td>
                            <td><?php echo empty($row['TRIR']) ? '' : $row['TRIR']?></td>
                            <td><?php echo empty($row['LWCR']) ? '' : $row['LWCR']?></td>
                            <td><?php echo empty($row['DART']) ? '' : $row['DART']?></td>
                            <td><?php echo empty($row['EMR']) ? '' : $row['EMR']?></td>
                            <td><?php echo empty($row['fatalities']) ? '' : $row['fatalities']?></td>
                            <td><?php echo empty($row['citation']) ? '' : $row['citation']?></td>
                            <td><?php echo empty($row['SR']) ? '' : $row['SR']?></td>
                            <td><?php echo empty($row['year']) ? '' : $row['year']?></td>
                            <?php
                            echo '</tr>';
                        }
                    }
                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Supplier ID</th>
                        <th>Company Name</th>
                        <th>NAICS Code</th>
                        <th>TRIR</th>
                        <th>LWCR</th>
                        <th>DART</th>
                        <th>EMR</th>
                        <th>Fatalities</th>
                        <th>Citation</th>
                        <th>SR</th>
                        <th>Year</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
