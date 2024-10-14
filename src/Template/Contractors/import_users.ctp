<br><br>
  <div class="col-md-6">
  	<?php echo $this->Flash->render();  ?>
      <div class="card card-default">
      	<div class="card-header fa fa-upload">
      		Document 
      	</div>
       <div class="card-body">
    	<?= $this->Form->create(null,['type' => 'file']); ?>		   
		
		<div class="form-group">
		
		<?= $this->Form->control('file', ['type' => 'file',"class"=>"form-control" ]);?>
		</div>
		<div class="form-group">
		<?=  $this->Form->button('Import',['class'=>'btn btn-success']); ?>
	    </div>
	    <?= $this->Form->end(); ?>
		
      </div>
  </div>
</div>

