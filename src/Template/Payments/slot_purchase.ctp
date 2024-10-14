<?php
?>
<div >
<div class="row payments">
<div class="col-lg-7">
<div class="card">

	<div class="card-header">
		<strong>Payment</strong>  Now		
	</div>
		<div id="overlay" onclick="off()" style="display: none;">
		<div class="text"><br>
		<div class="row justify-content-center" style="margin-top: 250px;">
			<?php echo $this->Html->image('loader.gif',['style'=>'width:100px;display:block']); ?>
		</div>
		<span style="font-size:25px; font-weight:8px;color:Black" class="row justify-content-center">Please wait...</span>
	</div>
		</div>
	<div  class="card-body card-block">
        <div id="blankform" class="<?php //echo $colloseShow; ?>">
		<?= $this->Form->create($payment,['url'=> ['action' => 'slotPurchase']]);?>
			<div class="form-group">
				<?= $this->Form->control('firstname', ['class'=>'form-control']); ?>
			</div>
			<div class="form-group">
				<?= $this->Form->control('lastname', ['class'=>'form-control']); ?>
			</div>		
			<div class="form-group">
				<?= $this->Form->control('email', ['class'=>'form-control','label' => 'Email','required' => false]); ?>
			</div>		
			 <h4 class="mb-3">Billing address</h4>
			<div class="form-group">
				<?= $this->Form->control('address1', ['class'=>'form-control']); ?>
			</div>		
			<div class="form-group">
				<?= $this->Form->control('address2', ['class'=>'form-control']); ?>
			</div>		
			<div class="form-group">
				<?= $this->Form->control('city', ['class'=>'form-control']); ?>
			</div>		
			<div class="form-group">
			<?= $this->Form->label('Country'); ?>
			<div class="form-group">
			<?php echo $this->Form->control('country_id',['class'=>'form-control ajaxChange otherCountrySelection searchSelect','id'=>'otherCountrySelection', 'options' =>$countries , 'empty' => 'Please select country', 'data-url'=>'/countries/getStates/false', 'data-responce'=>'.ajax-responce','label'=>false, 'required'=>false,'value'=>'']); ?>
		    </div>
			</div>
		    <div class="form-group ajax-responce statelist">
			<?= $this->Form->label('State'); ?>
	        <?php if(!empty($stateOptions)) { 
	        	     echo $this->Form->control('state_id', ['class'=>'form-control searchSelect', 'options' => $stateOptions, 'label'=>false,'required' => false]);
	             }else{ 
	                 echo $this->Form->control('state_id', ['class'=>'form-control searchSelect', 'options' => [], 'label'=>false, 'required' => false]);
	            } ?>
	         <small id="countryHelp" class="form-text text-muted">States will be auto populated on country selection.</small>
			</div>	
			<div class="form-group">
				<?= $this->Form->control('zip', ['class'=>'form-control']); ?>
			</div>
			<h4 class="mb-3">Payment</h4>			
			<div class="form-group">
			 <label for="cc-name">Credit Card Type</label>
				<select class="form-control" name="cctype" id="cc-type">
				    <option value="">Please Select</option>
				    <option value="Visa">Visa</option>
				    <option value="MasterCard">MasterCard</option>
				    <option value="Discover">Discover</option>
				    <option value="Amex">Amex</option>
				    <option value="JCB">JCB</option>
				</select>
			</div>
			<div class="form-group">
				<?= $this->Form->control('ccname', ['class'=>'form-control','label'=>'Name on card','required' => false]); ?>
			</div>
			<div class="form-group">
				<?= $this->Form->control('ccnumber', ['class'=>'form-control','label'=>'Credit Card Number' ,'required' => false,'maxlength'=>16]); ?>
			</div>
			<div class="form-group">
				 <label for="cc-expiration">Expiration Month</label>
				<?= $this->Form->month('ccexpirationmonth', array('class'=>'form-control', 'empty'=>'Please select month','required' => "false")); ?>
			</div>
			<div class="form-group">
			<label for="ccexpirationyear">Expiration Year</label>
			<?= $this->Form->year('ccexpirationyear', array('class'=>'form-control', 'empty'=>'Please select year','required' => false , 'minYear'=>date('Y'), 'maxYear'=>date('Y')+20));?>
			</div>
			<div class="form-group">
				<?= $this->Form->control('cccvv', ['class'=>'form-control','label'=>'CVV','required' => false]); ?>
			</div>
			<!--<div class="form-group">
				<?= $this->Form->checkbox('savecard', ['hiddenField' => false, 'class' => 'set-padding'] ); ?> 
				<?= $this->Form->label( 'Save this card for future payments' ) ?>
			</div>-->
			<div class="form-actions form-group">
				<?= $this->Form->control('contractor_id', ['class'=>'form-control','type'=>'hidden','value'=>$activeUser['contractor_id']]); ?>
				<?= $this->Form->control('secret_link', ['class'=>'form-control','type'=>'hidden','value'=>$secret_link]); ?>
				<?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Pay Now', ['type' => 'submit', 'class'=>'btn btn-success nextBtn pull-right mr-3 overlayChange']); ?>
				<?= $this->Form->end() ?>
			</div>
		</div>
	</div>
</div>
</div>

<div class="col-lg-5">
<div class="card">
	<div class="card-header clearfix">
		<strong>Invoice </strong>		
	</div>
	<div class="card-body">
	<table class="table table-bordered">
	<thead>
	<tr>
		<th scope="col">Employee Slot</th>
		<th scope="col">Pricing</th>
	</tr>
	</thead>
	<tbody>
		<tr>
			<td><?= $slot['slot'] ?></td>
			<td>$ <?= $slot['price'] ?> </td>
		</tr>
		<?php if(isset($slot['canqualify_discount'])? $slot['price'] = $slot['price']-$slot['canqualify_discount']:$slot['price']) { ?>
	    <tr>
			<th>Canqualify Discount :</th>
			<td>$ <?= $slot['canqualify_discount'] ; ?> </td>
		</tr>	
		<?php } ?>
		<tr>
			<th>Total :</th>
			<td>$ <?= $slot['price'] ?> </td>
		</tr>	
	</tbody>
	</table>
	</div>
</div>
</div>
</div>
</div>
