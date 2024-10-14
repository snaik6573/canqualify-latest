<?php
/* template: Send request to contractor */
$startDate = date('Y/m/d', strtotime($invoice['payment_start']));
$endDate = date('Y/m/d', strtotime($invoice['payment_end']));
?>
<link href="https://fonts.googleapis.com/css?family=Montserrat:100,400,600,700&display=swap" rel="stylesheet">  
<link href="https://fonts.googleapis.com/css?family=Roboto:100,400,500,700,900&display=swap" rel="stylesheet"> 
<div style =" width :85%;  border-radius:5px;border:2px  #e5e8e8 solid ; background-color:  #f2f4f4 ;  " >
    <table width="100%" cellspacing="0" cellpadding="0">
        <tr>
            <header>
                <div style =" width: 100%;top: 0;padding: 15px ;">
                <img style="float: right ; margin: 5px 30px  ;" src="https://canqualifier.com/img/logo.png" class="navbar-brand mb-3" alt="CanQualify" width="200px">
                </div>
             </header>
        </tr>
    <tr>
    <div style ="padding:30px 25px;">
        <p style="font-family: 'Roboto', sans-serif;font-weight: medium 500;font-size:50px;margin: 0px;">Thank You</p>
        <p style="font-family: 'Roboto', sans-serif;text-decoration: none; font-size: 18px;color: #27ae60;font-weight: 500;"> <?= $contractor->company_name ?> </p>
        <p style="font-family: 'Roboto', sans-serif; font-size: 15px;font-weight: 500;">We thank you for your continued relationship with Canqualify.<br> It is a privilege to have you as our valued customer.</p>
    </div>
   </tr>
    <tr>
    <div style="position: relative; min-width: 0; word-wrap: break-word; background-color: #fff;background-clip: border-box; border: 1px solid rgba(0,0,0,.125); padding:20px;margin:25px;">		   
    <div class="card-body">  
    <p style="font-family: 'Roboto', sans-serif;text-decoration: none; font-size: 20px;font-weight: bold;">Your Invoice Details are: </p>  

     <table  style="border-collapse: collapse;width:100%;">
        <thead>
        <tr style="font-family: 'Montserrat', sans-serif;padding: 0.5rem; text-align: left;  width:33%;font-size: 16px;font-weight: semi-bold 600;" scope="col"><h4>Paid Invoice</h4></tr>
        <tr>            
            <th style="font-family: 'Montserrat', sans-serif;border-top: 1px solid #cfd4d1;border-bottom: 1px solid #cfd4d1;padding: 0.5rem; text-align: left;vertical-align:top;width:30%; " scope="col">SERVICE</th>
            <th style="font-family: 'Montserrat', sans-serif;border-top: 1px solid #cfd4d1;border-bottom: 1px solid #cfd4d1;padding: 0.5rem; text-align: left;vertical-align:top; " scope="col">QTY.</th>
            <th style="font-family: 'Montserrat', sans-serif;border-top: 1px solid #cfd4d1;border-bottom: 1px solid #cfd4d1;padding: 0.5rem; text-align: left; text-align: right;vertical-align:top;" scope="col" class="text-right">UNIT PRICE</th>
            <th style="font-family: 'Montserrat', sans-serif;border-top: 1px solid #cfd4d1;border-bottom: 1px solid #cfd4d1;padding: 0.5rem; text-align: left; text-align: right;vertical-align:top;" scope="col" class="text-right">DISCOUNT</th>
            <th style="font-family: 'Montserrat', sans-serif;border-top: 1px solid #cfd4d1;border-bottom: 1px solid #cfd4d1;padding: 0.5rem; text-align: left;  text-align: right;vertical-align:top;" scope="col" class="text-right">TOTAL
			<?php if($invoice->payment_type == 3 || $invoice->payment_type == 4||$invoice->reactivation_fee == 99) { 
		    if(!empty($invoice['payment_start'])&& !empty($invoice['payment_end'])){		?>
			 <p>Charges for the Period &nbsp;(<?= h($startDate); ?> to <?= h($endDate); ?>)</p>
			<?php }} ?>
			</th>     
        </tr>
        </thead>
        <tbody>
            <?php 
            $totalDiscount = 0;
            $Subtotal = 0;
            foreach ($invoice->payment_details as $pdatails){ 
                $totalDiscount = $totalDiscount + $pdatails->discount;
                $Subtotal = $Subtotal + $pdatails->product_price;
            ?>
                <tr>        
                    <td style="font-family: 'Montserrat', sans-serif;padding: 0.5rem; text-align: left;width:33%; "><?= h($pdatails->service->name) ?></td>
                    <td style="font-family: 'Montserrat', sans-serif;padding: 0.5rem; text-align: left;"><?= count($pdatails->client_ids['c_ids']) ?></td>          
                    <td style="font-family: 'Montserrat', sans-serif;padding: 0.5rem; text-align: left;  text-align: right;" class="text-right"><?= $pdatails->product_price != null ? h("$ ".$pdatails->product_price) : '$ 0';?></td> 
                    <td style="font-family: 'Montserrat', sans-serif;padding: 0.5rem; text-align: left;  text-align: right;" class="text-right"><?= $pdatails->discount != null ?  h("$ ".$pdatails->discount) : '$ 0';?></td>
                    <td style="font-family: 'Montserrat', sans-serif;padding: 0.5rem; text-align: left;  text-align: right;" class="text-right"><?= $pdatails->price != null ? h("$ ".$pdatails->price) : '$ 0';?></td> 
                </tr>
            <?php } ?>
            <tr>
                <td style=" font-family: 'Roboto', sans-serif;text-decoration: none; font-size: 14px;font-weight: bold;border-top: 1px solid #999;border-bottom: 1px solid #999;padding: 0.5rem; text-align: left;width:33%; " colspan="1">TOTAL :
                <?= h("$".$invoice->totalprice); ?>
                </td>
                <td style="border-top: 1px solid #999;border-bottom: 1px solid #999;padding: 0.5rem; text-align: right;  width:30%;" colspan="5">
                   <p>Subtotal: &nbsp; <?= h("$ ".$Subtotal); ?></p>
				   <?php if(!empty($invoice['reactivation_fee'])){ ?>
				   <p>Reactivation Fee :
					<?= '$ '.$invoice['reactivation_fee']; ?>
				    </p><?php }?>
                    <?php if(!empty($invoice['canqualify_discount'])) { ?>
                    <p>CanQualify Discount:&nbsp;<?= '$ '.$invoice['canqualify_discount']; ?></p> 
                    <?php $totalDiscount = $totalDiscount + $invoice['canqualify_discount']; } ?>
                   <p>Total Discount: &nbsp;<?= h("$ ".$totalDiscount); ?></p>
                   <p>(Tax Rate): &nbsp; 0%</p>
                   <p>Tax: &nbsp; $ 0</p>
                   <p>Total Price: &nbsp; <?= h("$ ".$invoice->totalprice); ?></p>
                </td> 
            </tr>
        </tbody>
       </table>
    </div>	
    </div>
    </tr>
    <tr>
       <div style ="font-family: 'Roboto', sans-serif;font-size: 15px;font-weight: 100; padding:0px 25px 25px;color:#4d4d4d;">	
        <p>
	        We hope you enjoy our services.
        </p>
        </div>	
    </tr>                       
    </table>
</div>
