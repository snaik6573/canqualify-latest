<!--    Customer  Representive    --> 

<div class="row customerRepresentative">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong class="card-title"><?= __('Contractor Customer Representative') ?></strong>
	
	</div>

	<div class="card-body table-responsive">
<div class="container mt-2">
  <div class="row">
     <div class="col-lg-5">
            <?= $this->Form->create(null) ?>
            <label for="client-id">Select Client : </label>
            <?= $this->Form->control('client_id', ['options'=>$clients,'empty'=>true,'class'=>'form-control', 'label'=>false, 'required'=>true]) ?>
        </div>
     <div class="col-lg-7">
            <label for="Customer-Representative">Select Contractor CR : </label>
            <?= $this->Form->control('id', ['options'=>$cr,'empty'=>true,'class'=>'form-control', 'label'=>false, 'required'=>true]) ?>
            <?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Submit', ['type' => 'submit', 'class'=>'btn btn-primary pull-right mt-2']); ?>
            <?= $this->Form->end() ?>       
      </div>
  </div>
</div>
	
	</div>

</div>
</div>
</div>


<div class="row customerRepresentative">
<div class="col-lg-12">
<div class="card">
  <div class="card-body table-responsive">
  <table id="bootstrap-data-table" class="table table-striped table-bordered">
  <thead>
  <tr>
    <th scope="col"><?= h('Clients') ?></th>
   <!--<th scope="col"><?= h('CR') ?></th>-->
    <th scope="col"><?= h('Contractor CR') ?></th>
    
  </tr>
  </thead>
  <tbody>
  <?php  foreach ($clientList as $client): ?>
  <tr>
    <td><?= $client->company_name ?></td>
    <!--<td><?= isset($cr[$client->customer_representative_id]) ? $cr[$client->customer_representative_id] : ''  ?></td>-->
    <td><?= isset($cr[$client->contractor_custrep_id]) ? $cr[$client->contractor_custrep_id] : '' ?></td>
  
  </tr>
  <?php endforeach; ?>
  </tbody>
  </table>
  </div>
</div>
</div>
</div>