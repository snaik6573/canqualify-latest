<style>
    .incorrect-tin{
        background: #FFCCCB !important;
    }
    .box-incorrect-pin{
        background: #FFCCCB !important;
        width: 20px;
        height: 20px;
        display: inline-block;
    }
</style>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <strong class="card-title">
                    <?= __('Report: Suppliers with No TIN or incorrect TIN') ?></strong>
                <span class="pull-right">&nbsp;|&nbsp;
                    <?= $this->Html->link(__('View All Suppliers'), ['controller' => 'Reports', 'action' => 'noTin/1'],['class'=>'mr-2']) ?> </span>
                <span class="pull-right">
                    <?= $this->Html->link(__('No TIN or incorrect TIN'), ['controller' => 'Reports', 'action' => 'noTin/0'],['class'=>'mr-2']) ?> </span>
            </div>
            <?php
                if(!empty($showAll) && $showAll == 1){
                    echo '<div class="card-header">';
                        echo '<div class="box-incorrect-pin"></div> Suppliers with No Tin or Incorrect Tin';
                    echo '</div>';
                }
            ?>
            <div class="card-body table-responsive">
<?php
if(!empty($noTinSuppliers) && count($noTinSuppliers)){
    echo '<table id="bootstrap-data-table" class="table table-striped table-bordered" data-order="[[ 1, &quot;asc&quot; ]]">';
        echo '<thead>';
            echo '<tr><th>Supplier ID</th>';
            echo '<th>Supplier Name</th>';
            echo '<th>Supplier TIN</th></tr>';
        echo '</thead>';
        echo '<tbody>';

        foreach ($noTinSuppliers as $supplier){
            if($showAll){
                if($supplier['company_tin'] == '' || $supplier['company_tin'] == NULL || $supplier['company_tin'] <= 0 || strlen($supplier['company_tin']) != 9){
                    echo '<tr class="incorrect-tin">';
                }else{
                    echo '<tr>';
                }
            }else{
                echo '<tr>';
            }

                echo '<td>'.$supplier['id'].'</td>';
                echo '<td>'.$supplier['company_name'].'</td>';
                echo '<td>'.$supplier['company_tin'].'</td>';
            echo '</tr>';
        }

        echo '</tbody>';
    echo '</table>';
}
else{
    echo '<div>No Suppliers to display.</div>';
}
?>
            </div>
        </div>
    </div>
</div>
