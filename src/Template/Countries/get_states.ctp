
<?php 
if(strcmp($label, "false") !== 0){
echo $this->Form->control('state_id', ['class'=>'form-control searchSelect i-store', 'options' => $stateOptions,'label'=>false]);
}else{
echo $this->Form->control('state_id', ['class'=>'form-control searchSelect i-store', 'options' => $stateOptions]);
}

 ?>
 <small id="countryHelp" class="form-text text-muted">States will be auto populated on country selection.</small>

<script type="text/javascript">
	if ( jQuery( ".searchSelect" ).length ) {
		jQuery(".searchSelect").select2();
	}
</script>