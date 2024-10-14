<?php
/* template: Send request to contractor */
use Cake\Core\Configure;
$uploaded_path = Configure::read('uploaded_path');
?>
<style>
    .email-wrap{
        width: 100%;
        border: 1px solid #000;
        background: #8b939b;
    }
</style>
<div id="email-wrap" style="width: 50%; margin: 0; padding: 0%; float: left; border: 1px solid #D6D6D6; font-size:16px; font-family:nunito">
    <div id="email-header" style="width: 100%; min-height: 65px; background:#D6D6D6; margin:0; padding:0%; float: left;">
        <div id="supplier-logo" style="width: 20%; float: left; padding-top:10px;">
            <?php
            if(isset($contractor->company_logo) && $contractor->company_logo!==''){
                echo $this->Html->image($uploaded_path.$contractor->company_logo,['class'=>'']);
            }else{
				echo $this->Html->image('user-icon2.png', ['alt' => 'Profile Photo',]);
                /*put user profile icon here*/
            }
            ?>
        </div>
        <div id="supplier-name" style="width: 60%; float: left; font-weight:bold">
            <?php
            echo (isset($contractor->pri_contact_fn)) ? $contractor->pri_contact_fn : '';
           
            echo  (isset($contractor->pri_contact_ln)) ? $contractor->pri_contact_ln : '';
            ?>
        </div>
        <div id="canq-logo"  style="width: 20%; float: left; text-align: right; margin:0; padding:0">
            <img src="https://canqualifier.com/img/logo.png" class="navbar-brand mb-3" alt="CanQualify" width="160px" height="40px">
        </div>
    </div>
    <div id="email-body" style="width: 100%; margin:0; padding:5px;">
        <div id="email-summary" style="width: 100%; float: left; padding-top:5px">
            <?= ($mailInfo['message']) ? : "" ?>
        </div>
        <div id="email-main-body" style="width: 100%; float: left;">
            <div id="client-logo" style="width: 30%; float: left;" >
                <?php
                    if(isset($client->company_logo) && $client->company_logo!==''){
                        echo $this->Html->image($uploaded_path.$client->company_logo,['class'=>'']);
                    }else{
                        /*user icon here*/
                    }
                ?>
            </div>
            <div id="client-info" style="width: 70%; float: left;" >
                <div id="client-name" style="width: 100%; float: left;padding-top:5px;font-weight:bold">
                    <?= (isset($client->company_name)) ? $client->company_name : ''; ?>
                </div>
                <div id="client-address" style="width: 100%; float: left;padding-top:5px;padding-bottom:5px">client address will go here</div>
                <div id="client-actions" style="width: 100%; float: left; padding-bottom:5px; font-family: Nunito; font-size:16px">
                    <div id="client-view-profile" style="width: 50%; float: left;">
                        <a href="#"><button style="padding: 4px 8px; border: 1px solid transparent;">View Profile</button></a>
                    </div>
                    <div id="client-accept-request" style="width: 50%; float: left;">
                        <a href="https://canqualifier.com/client-requests"><button style="background-color:#28A745;  width:70px; border: 1px solid transparent;color:#fff; border-color:#28A745;padding: 4px 8px;">Accept</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
