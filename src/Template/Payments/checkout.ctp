<?php
$startDate =  date('Y/m/d');	
$endDate = date('Y/m/d', strtotime($contractor['subscription_date']));
if($endDate < $startDate) {	
	$subscription_date=strtotime($contractor['subscription_date']);
	$endDate = date('Y/m/d', strtotime('+ 1 year', $subscription_date));
}
?>
<div class="row payments">
<div class="col-lg-6 no-print">
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
	<div class="card-body card-block">
	<?php if($totalprice == 0)
    {
    ?>
    <p>Your Invoice Amount is 0,Please Press following button to continue..</p>
	    <?= $this->Form->create($payment,['url'=> ['action' => 'checkout', $renew_subscription]]);?>
	    <?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Continue', ['type' => 'submit', 'class'=>'btn btn-success nextBtn']); ?>
	    <?= $this->Form->end() ?>
	<?php
    }
    else {
    ?>	
		<?php $colloseShow = 'collapse';
		//if(empty($card_details)){ $colloseShow ='collapse show'; }
       	?>
        <div id="blankform" class="<?php //echo $colloseShow; ?>">
		<?= $this->Form->create($payment,['url'=> ['action' => 'checkout', $renew_subscription]]);?>
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
				<?= $this->Form->month('ccexpirationmonth', array('class'=>'form-control', 'empty'=>'Please select month')); ?>
			</div>
			<div class="form-group">
			<label for="ccexpirationyear">Expiration Year</label>
			<?= $this->Form->year('ccexpirationyear', array('class'=>'form-control', 'empty'=>'Please select year', 'minYear'=>date('Y'), 'maxYear'=>date('Y')+20));?>
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

			<!-- old card sections -->
			
			<!--<div id="card-details">
				<br>
				<?php /*if(!empty($card_details)) { ?>
				<div class="container mb-6">
					<?= $this->Form->create('existing_cards');?>
					<div class="form-group"><strong><?= $this->Form->label('Saved Cards'); ?></strong></div>
					<?php $i=0; ?>
					<?php foreach ($card_details as $id => $card) { ?>
						<div class="row card-row">
						  <div class="col-md-1">
						  <input name="card_details" value="<?= $id ?>" id="card_details-<?= $i ?>" type="radio" class="card_details" required>
						  </div>
						  <div class="col-md-4">
						  <?= $this->Form->control('cctype', ['class'=>'form-control','disabled','value'=>$card['card_type'],'label'=>false]); ?>
						  </div>
						  <div class="col-md-5"><?= $this->Form->control('ccnumber', ['class'=>'form-control','required' => false,'disabled','value'=>substr_replace($card['card_number'],"-XXXX-XXXX-",4,-4),'label'=>false ]); ?>
						  </div>
						  <div class="col-md-2"><?= $this->Form->control('cccvv', ['class'=>'select_cccvv form-control','label'=>false,'placeholder'=>'CVV','id'=>"card_details-".$i ,'disabled']); ?>
						  </div>
						</div><br />
						<?php $i++; } ?>
						  <div class="form-actions form-group">
						  <?= $this->Form->button('<em><i class="fa "></i></em> Make New Payment', ['type' => 'submit', 'class'=>'btn btn-success nextBtn pull-right ml-2',"data-toggle"=>"collapse", "data-target"=>"#blankform"]); ?>	
						  <?= $this->Form->button('<em><i class="fa fa-dot-circle-o"></i></em> Pay Now', ['type' => 'submit', 'class'=>'btn btn-success nextBtn pull-right']); ?>		   
						  </div>
						 <?= $this->Form->end(); ?>
				</div>
				<?php }*/ ?>
			</div>-->
	<?php } ?>
	</div>
</div>
</div>

<div class="col-lg-6">
<?php
if(isset($calculatePayment['services'])) { ?>
<div class="card">
	<div class="pull-right text-right no-print">		
		<a href="#" onclick="window.print();" class="nav-link btn btn-success mr-2"  style="display:inline:block;"><i class="fa fa-print"></i> Print</a>					
	</div>	
	<div class="card-header clearfix invoice">		
		 <div class="row">
           <div class="col-lg-7 print_show"> 
              <h3>INVOICE</h3>                
                <div class="pull-left"><span>DATE</span><br><p><?= $startDate ?></p></div>                
            </div>
        <div class="col-lg-5 print_show">                
		        <?= $this->Html->image('logo.png', ['url'=>['controller'=>'Contractors', 'action'=>'dashboard'], 'class'=>'navbar-brand mb-3', 'alt'=>'CanQualify', 'width'=>'200px'])?>
        </div>
        </div>			
         <div class="row">
                 <div class="col-lg-7 print_show pull-left ">
                    <span class="mb-0">Billed to</span>
                    <p><?= h($contractor->company_name) ?></p>
                    <p><?= h($contractor->addressline_1) ?></p>
                    <p><?= h($contractor->addressline_2) ?></p>
                    <p><?= h($contractor->city).','.h($contractor->state['name']).','.h($contractor->country['name']) ?></p>
                    <p><?= h($contractor->zip) ?></p>
                 </div>
                 <div class="col-lg-5 print_show pull-right">
                   <span>CanQualify</span>
                   <p>3450 Triumph Blvd, STE-102, Lehi, UT 84043</p>
                   <p>Phone: (801) 851-1810</p>
                   <p>Email: info@CanQualify.com</p>
                </div>
        </div>		
	</div>
	<div class="card-body">
	<table class="table table-bordered invoice">
	<thead>
	<tr>
		<th scope="col">Service</th>
		<th scope="col">Qty.</th>
		<th scope="col">Unit Price</th>
		<th scope="col">Discount</th>
		<th scope="col">Total
		<?php if(($calculatePayment['new_client']||$calculatePayment['new_service'] ||$calculatePayment['reactivation_fee']==LATE_FEE) && count($contClients) >1){?>
		<p>Charges for the Period </br>( <?= h($startDate); ?> to <?= h($endDate); ?> )</p>
		<?php } ?>	
		</th>
	</tr>
	</thead>
	<tbody>
		<?php 
		$totalDiscount = 0;
		foreach ($calculatePayment['services'] as $payment): 		
		if(!isset($payment['price'])) { continue; }
		$totalDiscount = $totalDiscount + $payment['discount'];
		?>
		<tr>		
			<td><?= $payment['name']; ?>
            <?= isset($payment['slot']) ? '<br/ ><b>Slot : </b>'.$payment['slot'] : '' ; ?>
            </td>
			<td><?= count($payment['client_ids']); ?></td>			
			<td><?= $payment['price'] !=null ? h('$ '.$payment['price']) : '$ 0'; ?></td>
	        <td><?= $payment['discount'] !=null ? h('$ '.$payment['discount']) : '$ 0'; ?></td>
	        <td><?= $payment['final_price'] !=null ? h('$ '.$payment['final_price']) : '$ 0'; ?></td>  
		</tr>
		<?php endforeach; ?>		
		<tr>
        <th colspan="4">Subtotal :</th>
        <td><?= '$ '.$calculatePayment['totalPrice']; ?></td>
	    </tr>
		<?php if(!empty($calculatePayment['reactivation_fee'])){ ?>
		<tr>
	        <th colspan="4">Reactivation Fee :</th>
			<td><?= '$ '.$calculatePayment['reactivation_fee']; ?></td>
	    </tr>
		<?php }?>
		<?php if(!empty($calculatePayment['canqualify_discount'])) { ?>
  		<tr>
        <th colspan="4">CanQualify Discount  :</th>
        <td><?= '$ '.$calculatePayment['canqualify_discount']; ?></td>
    	</tr>
    	<?php $totalDiscount = $totalDiscount + $calculatePayment['canqualify_discount'];?>
    	<?php } ?>
	    <tr>	    
        <th colspan="4">Total Discount  :</th>
        <td><?= '$ '.$totalDiscount; ?></td>
   	    </tr>		
	    <tr>
	        <th colspan="4">Total Price :</th>
	        <td><?= '$ '.$calculatePayment['final_price']; ?></td>
	    </tr>		
	</tbody>
	</table>
	</div>
</div>
<?php } ?>
</div>
</div>
