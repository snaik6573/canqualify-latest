<div class="dropdown for-notification">
		<button class="btn btn-secondary dropdown-toggle" type="button" id="notification" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		<i class="fa fa-bell"></i>
		<span class="count bg-danger" id="noti_count">
		<?php $count=$this->Notification->getUnreadCount($activeUser['id'],$activeUser['role']);
		 echo $count;?></span>
		</button>		
		<div class="notification dropdown-menu dropdown-menu-right notify" aria-labelledby="notification">
		<div class="card">
		<div class="card-header">
		<strong>Notifications</strong>
		</div>
		<!--<div class="dropdown-item media" href="#">-->
		<input type="hidden" name="contractor_id" id="#contractor_id" value="<?= $activeUser['id'];?>">
 		<?php 
		$all_count=$this->Notification->getAllNotificationCount($activeUser['id'],$activeUser['role']);
		$notifications = $this->Notification->getNotification($activeUser['id'],$activeUser['role']); ?>		
			<!--<div class="details no-data" id="no_data"></div>-->
			<?php if($all_count == 0){?>
			<div class="details no-data">You don't have any notifications </div>
			<?php }else {
			$i=1;			
			foreach($notifications as $notification) { 
			if($i<=5){				
				if(($notification[$i]['state']=$notification['state'])) {					
			?>		
			<li class='lists dropdown-item media' data-id= "<?= $notification[$i]['id']=$notification['id'];?>">
			<div class="details">
			<i class="icon"></i>
			<a class="subject" data-value ="<?= $notification[$i]['id']=$notification['id'];?> "href ='/Notifications/view/<?=$notification[$i]['id']=$notification['id']?>'; onclick="window.open(this.href,'_self');return false;"><?php echo $notification[$i]['title']=$notification['title']; ?></a>
			</div>
			<!--<button type="button" class="button-default button-dismiss js-dismiss">×</button>-->
			</li>
			<?php }else { ?>
			<li class='lists dropdown-item media list-read' data-id= "<?= $notification[$i]['id']=$notification['id'];?>">
			<div class="details">
			<i class="icon"></i>
			<a class="subject" data-value ="<?= $notification[$i]['id']=$notification['id'];?>" href ='/Notifications/view/<?=$notification[$i]['id']=$notification['id']?>'; onclick="window.open(this.href,'_self');return false;"><?php echo $notification[$i]['title']=$notification['title']; ?>
			</a>
			</div>
			<!--<button type="button" class="button-default button-dismiss js-dismiss">×</button>-->
			</li>				
			<?php }}$i++;}} ?>
			<div class="view card-footer">
			<?= $this->Html->link('Show All Notifications', ['controller'=>'Notifications','action'=>'getAllNotification',$activeUser['id'],$activeUser['role']], ['escape'=>false, 'title'=>__('Show All Notifications'), 'class'=>'']) ?>
			</div>			
		</div>
		
		</div>
</div>
