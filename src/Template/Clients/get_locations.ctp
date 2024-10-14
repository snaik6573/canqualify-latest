
<?php 
if(strcmp($label, "false") !== 0){
echo $this->Form->control('locations', ['class'=>'form-control locationSelect i-store', 'options' => $locationOptions,'label'=>false]);
}else{
echo $this->Form->control('locations', ['class'=>'form-control locationSelect i-store', 'options' => $locationOptions]);
}

 ?>
 <small id="countryHelp" class="form-text text-muted">Locations will be auto populated on clients selection.</small>

<script type="text/javascript">
	if ( jQuery( ".locationSelect" ).length ) {
		jQuery(".locationSelect").select2();
	}
</script>