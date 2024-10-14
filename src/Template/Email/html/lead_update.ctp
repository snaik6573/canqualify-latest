<?php
/* template: Update Lead status */
?>
<div style =" width :75%;  border:2px solid ;" >
    <table width="100%" cellspacing="0" cellpadding="0">
        <tr>
            <header>
                <div style =" width: 100%;top: 0;padding: 10px 15px ;">
                <img src="https://canqualifier.com/img/logo.png" class="navbar-brand mb-3" alt="CanQualify" width="200px">
                </div>
             </header>
        </tr>
        <tr>
             <div style ="padding:0px 20px 20px;">	
                <p>Dear &nbsp;<?= $full_name ?></p>
                <p><?= $updateBy ?> Updated Following Lead : <?= $lead->company_name ?></p>

	                 <table cellspacing="0" cellpadding="0">             
                        <td  style ="border-radius: 2px; padding:5px;" bgcolor="#1874CD">
                            <a  style ="font-size: 14px;color: #ffffff; font-weight: bold;display: inline-block;text-decoration: none;" href="<?= $leadurl ?>" > View Lead </a>
                        </td>
                    </table>
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
