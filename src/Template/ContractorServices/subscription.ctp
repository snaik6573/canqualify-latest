<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="row contractors">
<div class="col-lg-12">
<div class="card">
	<div class="card-header clearfix">
		<strong>Subscription</strong>
        <!--<div class="pull-right"><strong>Subscription Til:</strong> <?= $contractor->subscription_date ?></div>-->
	</div>
	<div class="card-body card-block">


	<table class="table">
	<tr>
		<th scope="row"><?= __('Service') ?></th>
		<th scope="row"><?= __('Clients - Locations') ?></th>
		<th scope="row"><?= __('Subscription') ?></th>
	</tr>

	<?php
    if(!empty($subscriptions)){
     foreach ($subscriptions as $subscription) { ?>
	    <tr>
		    <td><?= h($subscription['service']['name']) ?></td>
		    <td><table class="table-borderless">
            	<?php foreach($subscription['client_ids']['c_ids'] as $client_id)
                {
                    echo '<tr><td>'.$clients[$client_id].'</td>';
                    $sites = $this->User->getSitesbyClient($contractor->id, $client_id);                    
                    echo '<td>'.implode('<br>', $sites).'</td></tr>';                   
                } ?>           
            	
            </table>        
             </td>
		    <td>$ <?= h($subscription['price']) ?></td>		
	    <?php } }	?>
	</table>
	</div>
</div>
</div>
</div>
