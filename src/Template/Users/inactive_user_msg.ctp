<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="text-center">
	<h5>
		Your account has been deactivated for account activation and more details </br>please contact : 
		<?php if(!empty($contractor)){ ?>
		<?= $contractor['pri_contact_fn'].' '.$contractor['pri_contact_ln'] ?>
		<?php }elseif(!empty($clientUser)){ ?>
		<?= $clientUser['pri_contact_fn'].' '.$clientUser['pri_contact_ln'] ?>		
		<?php } else{ ?>		
	<br />	
	<h6>Email: info@CanQualify.com</h6>
	<h6>Phone: (801)851-1810</h6>
	<?php } ?>	
	</h5>
	</br>
</div>

