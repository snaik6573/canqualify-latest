<?php
//debug($activeUser);
use Cake\Core\Configure;
$uploaded_path = Configure::read('uploaded_path');
?>
    <div class="d-flex my-profile">

        <div class="ms-2 name">

            <div class="dropdown">
                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="avatar avatar-x1">
                        <?= (!empty($activeUser['profile_photo'])) ? $this->Html->image($uploaded_path.$activeUser['profile_photo'], ['alt'=>'User Profile']) : '<i class="bi bi-person-fill"></i>'; ?>
                    </div>
                    <?php
                    echo (!empty($activeUser['user_firstname'])? $activeUser['user_firstname'] : '');
                    echo (!empty($activeUser['user_lastname'])? ' '.$activeUser['user_lastname'] : '');
                    ?>
                </a>

                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <?php if($activeUser['role_id'] == CLIENT ){ ?>
                        <li><?= $this->Html->link('<i class="fa fa-user"></i>  My Profile', ['controller'=>'Clients','action'=>'myProfile'], ['escape'=>false, 'title'=>__('My Profile'), 'class'=>'dropdown-item']) ?></li>
                    <?php }	else { ?>
                        <li><?= $this->Html->link('<i class="fa fa-user"></i>  My Profile', ['controller'=>'ClientUsers','action'=>'myProfile'], ['escape'=>false, 'title'=>__('My Profile'), 'class'=>'dropdown-item']) ?></li>
                    <?php } ?>
                    <li><?= $this->Html->link(__('<i class="menu-icon fa fa-building-o"></i>  Locations'), ['controller'=>'Sites', 'action'=>'clientSites'], ['escape'=>false, 'title'=>'Locations', 'class'=>'dropdown-item']) ?></li>
                    <?php if($activeUser['role_id'] == CLIENT || $activeUser['role_id'] == CLIENT_ADMIN ){ ?>
                    <li><?= $this->Html->link(__('<i class="menu-icon fa fa-users"></i> Users'), ['controller'=>'ClientUsers', 'action'=>'index'], ['escape'=>false, 'title'=>'Users', 'class'=>'dropdown-item']) ?></li>
                    <?php } ?>
                    <li><?= $this->Html->link(__('<i class="menu-icon fa fa-check"></i> Benchmarks'), ['controller'=>'Benchmarks', 'action'=>'index'], ['title'=>__('Benchmarks'),'escape'=>false, 'class'=>'dropdown-item']) ?></li>
                    <li><?= $this->Html->link('<i class="fa fa-sign-out"></i> Logout', ['controller'=>'Users','action'=>'logout'], ['escape'=>false, 'title'=>__('Logout'), 'class'=>'dropdown-item']) ?></li>
                </ul>
            </div>
            <?php
            if(!empty($activeUser['company_name'])) {
               // echo '<span>@'.$activeUser['company_name'].'</span>';
            }
            ?>
        </div>
    </div>
