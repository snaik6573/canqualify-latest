<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Notification[]|\Cake\Collection\CollectionInterface $notifications
 */
?>
<div class="row Notification">
<div class="col-lg-12">
<div class="card">
	<div class="card-header">
		<strong class="card-title"><?= __('Notifications') ?></strong>		
	</div>
	<div class="card-body table-responsive">
	<table id="bootstrap-data-table" class="table table-striped table-bordered" data-order="[[ 3, &quot;desc&quot; ]]">
	<thead>
	<tr>		
		<th style="display:none;" scope="col"><?= h('id') ?></th>	
		<th scope="col"><?= h('Title') ?></th>	
		<th scope="col"><?= h('Description') ?></th>
		<!--<th scope="col"><?= h('Is Completed') ?></th>-->
		<th scope="col"><?= h('Notification Date') ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($notifications as $notification): ?>
	<tr class="all_notification">
		<td id="noti_id" style="display:none;"><?php echo $notification->id; ?></td>		
		<td class="data"><a class="subject" href ='/Notifications/view/<?=$notification->id?>'; onclick="window.open(this.href,'_self');return false;"><?php echo $notification->title; ?>
		</td>
		<td>
		<?php
			$string = $notification->description;
			if (strlen($string) > 70) {
			$trimstring = substr($string, 0, 70).$this->Html->link(__(' Read More..'), ['controller'=>'Notifications', 'action'=>'view',$notification->id], ['class'=>'subject','title'=>'Notification', 'onclick'=>"window.open(this.href,'_self')"]);
			} else {$trimstring = $string;}
			echo $trimstring;
			?>		
		</br>
		<?php if(!empty($notification['url'])) { ?>
		<a class="subject" href=<?= $notification['url'];?> onclick="window.open(this.href,'_self');return false;" >Pay Now</a></td>
		<?php } ?>
		<!--<td><?php if($notification->is_completed == true)
			{echo "Yes";}else{echo "No";}?></td>-->
		<td>
		<?php $Date = date("m/d/Y", strtotime($notification->created));?>
		<?= $Date; ?></td>			
	</tr>
	<?php endforeach; ?>
	</tbody>
	</table>
	</div>	
</div>
</div>
</div>
