<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<div class="alert with-close alert-success alert-dismissible fade show" role="alert">
	<!--<span class="badge badge-pill badge-success">Success</span>--> <?= $message ?>
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">×</span>
	</button>
</div>
<!--<div class="message success" onclick="this.classList.add('hidden')"><?= $message ?></div>-->
