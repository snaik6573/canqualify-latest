<?php
/* template: reset password */
?>
<html>
<link href="https://fonts.googleapis.com/css?family=Montserrat:100,400,600,700&display=swap" rel="stylesheet">  
<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&display=swap" rel="stylesheet"> 
<div style =" width :85%;  border-radius:5px;border:2px  #e5e8e8 solid ; background-color:  #f2f4f4 ;  " >
    <table width="100%" cellspacing="0" cellpadding="0">
        <tr>
            <header>
                <div style =" width: 100%;top: 0;padding: 15px ;">
                <img style="float: right ; margin: 5px 30px  ;" src="https://canqualifier.com/img/logo.png" class="navbar-brand mb-3" alt="CanQualify" width="200px">
                </div>
             </header>
        </tr>      
        <tr>
            <div style ="padding: 0px 30px 15px;">
                <p style="font-family: 'Roboto', sans-serif;font-weight: 700;font-size:52px;margin: 0px;">Hello</p>  
                <a href="#"style="font-family: 'Roboto', sans-serif;text-decoration: none;font-weight: 500;font-size: 20px;color: #2fb62f   ;"><?= $useremail ?></a>
                <p style="font-family: 'Roboto', sans-serif; font-size: 18px;font-weight: 500;"> 
                    Welcome to CanQualify.com<br>
                    Please click the link below to reset your password:<br>   
                </p>
                    <table cellspacing="0" cellpadding="0">             
                        <td  style ="border-radius: 2px; padding:0px 20px;" bgcolor="  #f4d03f  ";>
                                      <a  style="font-family: 'Roboto', sans-serif; font-size: 14px;color: #000000 ; font-weight: 500 ;display: inline-block;text-decoration: none;padding:5px;letter-spacing: 2px;text-align: center;" href="<?= $reseturl ?>" > RESET PASSWORD </a>
                        </td>
                    </table>                
                <h3 style="font-family: 'Roboto', sans-serif;font-weight: 100;font-size: 15px;padding: 5px;color:#4d4d4d;">
                    We hope you enjoy our services.
                </h3>
            </div> 
        </tr>        
        </div>
    </table>
</html>