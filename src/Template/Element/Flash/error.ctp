<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show" role="alert">
	<!--<span class="badge badge-pill badge-danger">Success</span>--> <?= $message ?>
	<?php  if (isset($params['errors']) && !empty($params['errors'])){ ?>
	<br>
	 <div style="background-color: white;height: 40px;padding:10px 10px 1px;margin-top: 5px;">
		<ul><li class=""><i class="fa fa-exclamation-circle"></i>&nbsp; &nbsp;<?= h($params['errors']) ?> </li> </ul>
     </div>
	<?php } ?>   

	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">×</span>
	</button>
</div>

<!--<div class="message error" onclick="this.classList.add('hidden');"><?= $message ?></div>-->
