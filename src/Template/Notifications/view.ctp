<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Notification $notification
 */
?>
<div class="row notifications">
<div class="col-lg-9">
<div class="card">
	<div class="card-header">
		<strong class="card-title"><?= __('Notification') ?></strong>
	</div>
	<div class="card-body card-block">
	<table class="table">
		 <!--<tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $notification->has('user') ? $this->Html->link($notification->user->id, ['controller' => 'Users', 'action' => 'view', $notification->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Notification Type') ?></th>
            <td><?= $notification->has('notification_type') ? $this->Html->link($notification->notification_type->name, ['controller' => 'NotificationTypes', 'action' => 'view', $notification->notification_type->id]) : '' ?></td>
        </tr>-->
        <tr>
            <th scope="row"><?= __('Title') ?></th>
            <td><?= h($notification->title) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Description') ?></th>
            <td><?= strip_tags($notification->description) ?></br>
			<?php if(!empty($notification['url'])) { ?>
			<a href=<?= $notification['url'];?> >Pay Now</a>
			<?php } ?></td>
        </tr>
        <!--<tr>
            <th scope="row"><?= __('Url') ?></th>
            <td><?= h($notification->url) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($notification->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created By') ?></th>
            <td><?= $this->Number->format($notification->created_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified By') ?></th>
            <td><?= $this->Number->format($notification->modified_by) ?></td>
        </tr>-->
        <tr>
			<?php $Date = date("m/d/Y", strtotime($notification->created));?>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= $Date; ?></td>
        </tr>
        <!--<tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($notification->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('State') ?></th>
            <td><?= $notification->state ? __('Yes') : __('No'); ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Is Completed') ?></th>
            <td><?= $notification->is_completed ? __('Yes') : __('No'); ?></td>
        </tr>-->
	</table>
	</div>
</div>
</div>
</div>
