<?php
/* template: contractor register */
use Cake\Routing\Router;
use Cake\Core\Configure;
$url = Router::Url(['controller' => 'users', 'action' => 'login'], true);
$uploaded_path = Configure::read('uploaded_path');
?>
<!-- <div style =" width :75%;  border:2px solid ; " > -->
<html>
<link href="https://fonts.googleapis.com/css?family=Montserrat:400,600,700&display=swap" rel="stylesheet"> 
<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&display=swap" rel="stylesheet"> 
<div style="background: url(<?= $uploaded_path.'CanQualify-Welcome-Email.jpg' ?>) no-repeat top left; max-width:600px; height:800px; background-size: contain;">
    <table width="100%" cellspacing="0" cellpadding="0">        
       <tr>
            <div style ="padding:160px 20px 2px;margin:65px 15px 0px">                
                <p style="font-family: 'Roboto', sans-serif;text-decoration: none; font-size: 18px;color: #27ae60;font-weight:700;">Hello <a href="#" style="font-family: 'Roboto', sans-serif;text-decoration: none; font-size: 18px;color: #27ae60;font-weight:700;"><?php echo  $name ?></a></p>
                <p style="font-family: 'Roboto', sans-serif;text-decoration: none; font-size: 18px;font-weight: 100;">                   
                    Please complete your account set up <br> by clicking the button below.
                </p>
                <table cellspacing="0" cellpadding="0">             
                  <td  style ="border-radius: 2px; padding:5px;" bgcolor="#f4d03f">
                       <a  style="font-family: 'Montserrat', sans-serif; font-size: 15px;color: #17202a ; font-weight:semi-bold 600 ;display: inline-block;text-decoration: none;padding:5px;letter-spacing: 2px;" href="<?= $url ?>" > PROCEED TO NEXT STEP </a>
                  </td>
                </table>
                <p style="font-family: 'Roboto', sans-serif;text-decoration: none; font-size: 18px;font-weight: 300;padding-top:25px;">
                    Thank You!                 
                </p>
                <h1 style="font-family: 'Roboto', sans-serif;font-size: 35px; line-height: 1; margin: 0;">Welcome to</h1>
                <div style="font-family: 'Roboto', sans-serif;font-size: 35px; font-weight: 300;">CanQualify</div>
                                           
            </div>  
        </tr>   
       <!-- <tr>
        <div style="font-family: 'Roboto', sans-serif;text-decoration: none; font-size: 15px;font-weight: 300;margin:0px 15px 55px;padding-left:15px;color:#4d4d4d;">
                <p style="margin:0px;"> Thanks ,</p>
                <p style="margin:0px;"> CanQualify Team <br></p>                
        </div>
        </tr>  -->     
    </table>
</div>
</html>
