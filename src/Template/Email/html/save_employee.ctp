<?php
/* template: reset password */
?>
<div style =" width :75%;  border:2px solid ;" >
    <table width="100%" cellspacing="0" cellpadding="0">
        <!--<tr>
            <header>
                <div style =" width: 100%;top: 0;padding: 10px 15px ;">
                <img src="https://canqualifier.com/img/logo.png" class="navbar-brand mb-3" alt="CanQualify" width="200px">
                </div>
             </header>
        </tr>-->
        <tr>
		<div style ="padding:0px 20px 20px;">
		<strong>Welcome To CanQualify! </strong>
		</div>
            <div style ="padding:0px 20px 20px;">	                  
              <!--<p>Dear &nbsp; aaron@canqualify.com</p>-->
	            <p>New Employee Registration For <?= $company_name ;?></p>	            
              <p>Employee Name : <?= $employee['pri_contact_fn']." ".$employee['pri_contact_ln']?> </p> 
	            <ul>Employee Credentials:</ul>             
                <li>Id : <?= $employee['id'];?></li>
                <!--<li>First Name : <?= $employee['pri_contact_fn'];?></li>
                <li>Last name : <?= $employee['pri_contact_ln'];?></li>-->
               <!-- <li>Phone No. : <?= $employee['pri_contact_pn'];?></li>
                <?php if(!empty($employee['addressline_1'])){ ?>
                <li>Address. : <?= $employee['addressline_1'].','.$employee['addressline_2']?></li>
               <?php } ?>
                <?php if($employee['user_entered_email']==true){?>-->
                  <li>Email/Login: <?= $employee['user']['username'];?></li>
                <?php }?>
                <?php if(isset($employee['user']['login_username'])){ ?>
                  <li>Username : <?= $employee['user']['login_username'];?></li>
                <?php } ?>               
            </div>	
        </tr>
        <tr>
        <div style =" width: 100%;padding:20px;">
                <p style="margin:0px;"> Thanks & Regards, <br></p>
                <img src="https://canqualifier.com/img/logo.png" class="navbar-brand mb-3" alt="CanQualify" width="100px">
        </div>
        </tr>
        <tr>
           <footer>
                <div style ="width: 100%;background: #61B329; bottom: 0;padding: 10px 0;">
                     <p style ="text-align:center;color: #ffffff;margin:0px;"> Corporate Office : CanQualify, 3450 Triumph Blvd, STE-102, Lehi, UT 84043</p>
                     <p style ="text-align:center;color: #ffffff;margin:0px;">  Phone: (801) 851-1810</p>
                     <p style ="text-align:center;color: #ffffff;margin:0px;"> Email: support@canqualify.com </p>       
                </div>
           </footer>
        </tr>
    </table>
</div>
