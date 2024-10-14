<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <strong class="card-title"><?= __('Landing Page Links') ?></strong>
            </div>
            <div class="card-body table-responsive">
                <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th scope="col"><?= h('Client Id') ?></th>
                        <th scope="col"><?= h('Client Name') ?></th>
                        <th scope="col"><?= h('Landing Page Link') ?></th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($data as $row){
                        echo '<tr>';
                        echo '<td>' .$row[0]. '</td>';
                        echo '<td>' .$row[1]. '</td>';
                        echo '<td><a target="_blank" href="'.$row[2]. '">' .$row[2]. '</a></td>';
                        echo '</tr>';
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

