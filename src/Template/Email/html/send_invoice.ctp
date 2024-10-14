<?php
/* template: Send request to contractor */
?>
<div style =" width :90%;  border:2px solid ;" >
    <table width="100%" cellspacing="0" cellpadding="0">
        <tr>
            <header>
                <div style =" width: 100%;top: 0;padding: 10px 15px ;">
                <img src="https://canqualifier.com/img/logo.png" class="navbar-brand mb-3" alt="CanQualify" width="200px">
                </div>
             </header>
        </tr>
        <tr>
            <div style ="padding:0px 20px 20px;">
            <!-- <p>Dear &nbsp;<?= $useremail ?></p>-->	
             <p><?= $message;?></p>
            </div>	
        </tr>
        <tr>
            <div style =" width: 100%;padding:20px;">
                    <p style="margin:0px;"> Thanks & Regards, <br></p>
                    <img src="https://canqualifier.com/img/logo.png" class="navbar-brand mb-3" alt="CanQualify" width="100px">
            </div>
        </tr>
        <tr>
           <footer>
                <div style ="width: 100%;background: #61B329; bottom: 0;padding: 10px 0;">
                     <p style ="text-align:center;color: #ffffff;margin:0px;"> Corporate Office : CanQualify, 3450 Triumph Blvd, STE-102, Lehi, UT 84043</p>
                     <p style ="text-align:center;color: #ffffff;margin:0px;">  Phone: (801) 851-1810</p>
                     <p style ="text-align:center;color: #ffffff;margin:0px;"> Email: support@canqualify.com </p>       
                </div>
           </footer>
        </tr>
    </table>
</div>

<!--
use Cake\Routing\Router;
$url = Router::Url(['controller' => 'payments', 'action' => 'renew-subscription'], true);
?>
<p>Hello <?= $userename ?></p>

<p>We thank you for your continued relationship with Canqualify. It is a privilege to have you as our valued customer.</p>

<p>Your Subscription is going to expire on : <b><?= date('n/d/Y', strtotime($subscription_date)) ?></b></p>

<p>Your Invoice Details are: </p>

<table class="table table-bordered">
	<thead>
	<tr>
		<th scope="col">Service</th>
		<th scope="col">Qty.</th>
		<th scope="col">Price</th>
	</tr>
	</thead>
	<tbody>
		<?php 		
		foreach ($invoice['services'] as $payment): ?>
		<tr>
			<td><?= $payment['name']; ?></td>
			<td><?= $payment['qty']; ?></td>
			<td><?= $payment['pricing']; ?></td>
		</tr>
		<?php endforeach; ?>
		<tr>
			<th colspan="2">Total :</th>
			<td><?= $invoice['totalPrice']; ?></td>
		</tr>		
		
	</tbody>
</table>

<p>Renew your subscription by clicking the button below.</p>

<p><a class="btn" href="<?= $url ?>">Renew your subscription</a></p>

<p>Kindly ignore this email, if you have already renewed your subscription.</p>-->
<?php
//}
?>

