<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EmailCampaign $emailCampaign
 */
use Cake\Core\Configure;
$uploaded_path = Configure::read('uploaded_path');
?>
<div class="row EmailCampaign">
    <div class="col-lg-12">
        <div class="card shadow  bg-white rounded">
            <div class="card-header">
                <strong>Edit Email</strong> campaign
            </div>
            <div class="card-body">
                <?= $this->Form->create($emailCampaign, array('type' => 'file')) ?>
                <div class="form-group">
                    <?= $this->Form->label('campaign_name', 'Campaign Name', ['class' => 'font-weight-bold']); ?>
                    <?= $this->Form->control('campaign_name', ['class'=>'form-control', 'required'=>true,'label'=>false]); ?>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <?= $this->Form->label('to_mail', 'To', ['class' => 'font-weight-bold']); ?>
                            <select multiple="multiple" class="form-control siteAddchk" name="to_mail[]" onchange="getID()" id="select-id">
                           <?php 
                            foreach($supplierList as $ky=>$vl){
                                $selected = '';
                                  if(in_array($ky, $emailCampaign->to_mail['to_mail_ids'])){ $selected = 'selected="selected"';}
                                echo '<option value="'.$ky.'" '.$selected.'>'.$vl.'</option>';
                            }
                            ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <?= $this->Form->label('from_mail', 'From', ['class' => 'font-weight-bold']); ?>
                            <select multiple="multiple" class="form-control siteAddchk" name="from_mail[]">
                            <?php 
                            foreach($canq_mails as $ky=>$vl){
                                $selected = '';
                                  if(in_array($ky, $emailCampaign->from_mail['from_mails'])){ $selected = 'selected="selected"';}
                                echo '<option value="'.$ky.'" '.$selected.'>'.$vl.'</option>';
                            }
                            ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <?= $this->Form->label('cc_mail', 'Cc', ['class' => 'font-weight-bold']); ?>
                            <select multiple="multiple" class="form-control siteAddchk" name="cc_mail[]">
                            <?php 
                            foreach($canq_cr as $ky=>$vl){
                                $selected = '';
                                  if( isset($emailCampaign->cc_mail['cc_mails']) && in_array($vl, $emailCampaign->cc_mail['cc_mails'])){ $selected = 'selected="selected"';}
                                echo '<option value="'.$ky.'" '.$selected.'>'.$vl.'</option>';
                            }
                            ?>
                            </select>
                        </div>
                    </div>
                      <div class="col-lg-6">
                        <div class="form-group">
                            <?= $this->Form->label('bcc_mail', 'Bcc', ['class' => 'font-weight-bold']); ?>
                            <select multiple="multiple" class="form-control siteAddchk" name="bcc_mail[]">
                            <?php 
                            foreach($supplierList as $ky=>$vl){
                                $selected = '';
                                  if(in_array($ky, $emailCampaign->to_mail['to_mail_ids'])){ $selected = 'selected="selected"';}
                                echo '<option value="'.$ky.'" '.$selected.'>'.$vl.'</option>';
                            }
                            ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <?= $this->Form->label('subject', 'Subject', ['class' => 'font-weight-bold']); ?>
                    <?= $this->Form->control('subject', ['class'=>'form-control', 'required'=>false,'label'=>false]); ?>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                <div class="form-group">
                    <?= $this->Form->label('template_type', 'Template Type', ['class' => 'font-weight-bold']); ?>
                    <?php echo $this->Form->control('template_type', ['options'=>$templateTypes, 'class'=>'form-control form-select', 'empty' =>true, 'required' => false,'label'=>false,'id'=>'selectTemplate']); ?>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                     <?= $this->Form->label('email_signature_id', 'Email Signature', ['class' => 'font-weight-bold']); ?>
                     <?php echo $this->Form->control('email_signature_content', ['options'=>$emailSignatures, 'class'=>'form-control form-select', 'empty' => true, 'required' => false,'label'=>false,'id'=>'selectSignature']); ?>
                </div>
            </div>
                </div>
                <div class="form-group">
                    <?= $this->Form->label('template_contents', 'Mail Content', ['class' => 'font-weight-bold']); ?>
                    <div id="toolbar">
                        <span class="ql-formats">
                            <select class="ql-header" defaultValue="">
                                <option value="1"></option>
                                <option value="2"></option>
                                <option value="3"></option>
                                <option value=""></option>
                            </select>
                            <select class="ql-font" defaultValue=""></select>
                            <select class="ql-size" defaultValue="">
                                <option value="small"></option>
                                <option value=""></option>
                                <option value="large"></option>
                                <option value="huge"></option>
                            </select>
                        </span>
                        <span class="ql-formats">
                            <button class="ql-bold"></button>
                            <button class="ql-italic"></button>
                            <button class="ql-underline"></button>
                            <button class="ql-strike"></button>
                            <button class="ql-blockquote"></button>
                        </span>
                        <span class="ql-formats">
                            <select class="ql-placeholder">
                                <option value="pri_contact_fname">Primary First Name</option>
                                <option value="pri_contact_lname">Primary Last Name</option>
                                <option value="supplier_name">Suppiler Name</option>
                                <option value="client_company_name">Client Company Name</option>
                            </select>
                        </span>
                        <span class="pull-right">
                            <input type="checkbox" id="save-temp" class="mt-1" name="saveTemplate">
                            <label for="saveTemplate"> Save template</label>
                        </span>
                    </div>
                    <div id="editor"></div>
                </div>
                <div class="row">
                    <div class="col-sm-3 appendDiv">
                        <div class="form-group uploadWraper">
                            <?= $this->Form->label('Attachments', null, ['class'=>'font-weight-bold']); ?><br />
                            <?= $this->Form->control('id', ['type'=>'hidden','class'=>'emailCampaignID','id'=>'email-campaign-id']); ?>
                            <?php  $colloseShow = 'collapse';
                            if(array_values($emailCampaign['attachments']['mail_attach']) != null){  $colloseShow ='collapse show';    }  ?>
                            <?php echo $this->Form->file('mail-attachment.0.uploadFile', ['class'=>'newFile','label'=>false, 'accept'=>'.images/*, .pdf,.xls, .xlsx, .doc', 'required'=>'false']); ?>
                            <div class="uploadResponse <?= $colloseShow ?>">
                                 <?php 
                                     foreach ($emailCampaign['attachments']['mail_attach'] as $v) {
                                echo $this->Form->control('mail-attachment.0.document', ['label'=>false, 'type'=>'hidden', 'class'=>'documentName','value'=>$v]); 
                                echo '<a href="'.$uploaded_path.$v.'" class="uploadUrl" data-file="'.$v.'" target="_Blank">'.$v.'</a>';
                                echo $this->Html->link('<i class="fa fa-times-circle"></i>', ['controller'=>'Uploads', 'action' => 'deleteFile', $v],['escape'=>false, 'title' => 'Remove', 'class'=>'ajaxfileDelete del-btn btn btn-sm']);
                                    }
                            ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <?= $this->Form->button('<em><i class="fa fa-plus-square"></i></em> Add More', ['type' => 'button', 'class'=>'addAttachBox btn btn-success btn-sm','style'=>'margin:30px 0 0 0;', 'data-fieldname'=>'mail-attachment']); ?>
                    </div>
                </div>
                <div class="form-group">
                    <?= $this->Form->control('template_content', ['type'=>'hidden','class'=>'template-content','id'=>'template-content']); ?>
                    <?= $this->Form->control('email_signature_content', ['type'=>'hidden','class'=>'sign-content','id'=>'sign-content']); ?>
                    <?= $this->Form->control('to_mail_name', ['type'=>'hidden','class'=>'to_mail_content','id'=>'to-mail-content']); ?>
                    <?= $this->Form->control('quill_delta', ['type'=>'hidden','class'=>'template-code','id'=>'delta-code']); ?>
                </div>
                <div class="form-group">
                    <?= $this->Form->button('<em><i class="fa fa-inbox"></i></em> Save ', ['type' => 'Submit', 'class'=>'btn btn-success']); ?>
                    <?= $this->Form->button('<em><i class="fa fa-envelope-open-o" aria-hidden="true"></i></em> Email Preview ', ['type' => 'button', 'class'=>'btn btn btn-danger','id'=>'btn-preview', 'data-toggle'=>'modal' ,'data-target'=>'#exampleModalCenter']); ?>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Email Preview</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="m_-5182915800725953308body_style" style="background-color:#f7f7f7;">
                    <table width="100%" bgcolor="#f1f2f7" cellpadding="0" cellspacing="0" border="0" style="text-align:center">
                        <tbody>
                            <tr>
                                <td>
                                    <table bgcolor="#F7F7F7" cellpadding="0" cellspacing="0" border="0" width="750" align="center" style="margin:0px auto" style="">
                                        <tbody style=" width: 250px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);text-align: center;">
                                            <tr>
                                                <td bgcolor="#fed03d" align="center">
                                                    <table width="100%" align="center" cellspacing="0" cellpadding="0" border="0">
                                                        <tbody>
                                                            <tr>
                                                                <td width="100%" align="center" height="1" style="font-size:1px;line-height:1px">
                                                                    <div id="m_-5182915800725953308Preview-Text" style="display:none;font-size:1px;color:#f7f7f7;line-height:1px;max-height:0px;max-width:0px;opacity:0;overflow:hidden">
                                                                        &nbsp;
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td bgcolor="#FFFFFF" align="center" valign="top">
                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                                                        <tbody>
                                                            <tr>
                                                                <td valign="top" width="100%">
                                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td align="center" id="m_-5182915800725953308footer_image" style="font-size:1px;line-height:0.8px">
                                                                                    <div>
                                                                                        <a href="https://canqualify.com/" target="_blank" data-saferedirecturl=""><img width="100%" border="0" alt="" style="display:block;border:none;outline:none;text-decoration:none;width:311px" src="https://canqualifier.com/img/logo.png" class="CanQualify-logo"></a>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td bgcolor="#fed03d" align="center" valign="top">
                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                                                        <tbody>
                                                            <tr>
                                                                <td valign="top" width="100%">
                                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td align="center" id="m_-5182915800725953308headline_image" style="font-size:1px;line-height:1px">
                                                                                    <div>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td height="10" style="font-size:1px;line-height:1px">&nbsp;</td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td bgcolor="#FFFFFF" align="center" valign="top">
                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                                                        <tbody>
                                                            <tr>
                                                                <td valign="top" width="100%">
                                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td align="center" id="m_-5182915800725953308headline_image" style="font-size:1px;line-height:1px">
                                                                                    <div>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td height="30" style="font-size:1px;line-height:1px">&nbsp;</td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!--- Insert the Mail snippet -->
                                            <tr>
                                                <td bgcolor="#FFFFFF" align="center">
                                                    <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
                                                        <tbody>
                                                            <tr>
                                                                <td width="41" style="font-size:1px;line-height:1px">&nbsp;</td>
                                                                <td class="m_-4817871311969497422content" id="mail-content-td" style="font-family:'Proxima Nova',Calibri,Helvetica,sans-serif;font-size:16px;color:#505050;text-align:left;line-height:25.6px;font-weight:normal;text-transform:none">
                                                                    <div id="mail-content">
                                                                        <p>Hey there, <br><br>As a participant that completed the <span class="il">Computer Contest</span> challenge you are eligible to receive a gifts <span class="il">Hackthon</span> completion gifts, the global community where programmers of all backgrounds and experience levels reflect on software development, share technical questions and insights, and learn in public! <br><br> Whether you’re an existing member or are completely new to the DEV community, click the button below for quick and easy instructions on how to claim this awesome prize. </p>
                                                                        <p>Congratulations on completing <span class="il">Hackthon</span> and earning this unique gift. <br><br> Happy to help you,<br> </p>
                                                                    </div>
                                                                    <!--- Add Signature Here ---->
                                                                    <div id="signature-content">
                                                                        <table cellpadding="0" cellspacing="0" style="box-sizing: inherit; font-family: Arial; font-size: 16px;">
                                                                            <tbody style="box-sizing: inherit;">
                                                                                <tr style="box-sizing: inherit;">
                                                                                    <td style="box-sizing: inherit; line-height: 1.2; padding-bottom: 12px;">
                                                                                        <font color="#646464"><span style="font-size: 15.6px;"><b>Amit Kumbhar</b></span></font><br style="box-sizing: inherit;"><span class="ws-tpl-title" data-acs="title" style="box-sizing: inherit; font-size: 13.2px; letter-spacing: 0px; text-transform: initial; font-weight: bold; color: rgb(100, 100, 100);">Software Engineer, Mascot Software Technology</span>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr style="box-sizing: inherit;">
                                                                                    <td style="box-sizing: inherit; line-height: 0;">
                                                                                        <table cellpadding="0" cellspacing="0" style="box-sizing: inherit;">
                                                                                            <tbody style="box-sizing: inherit;">
                                                                                                <tr style="box-sizing: inherit;">
                                                                                                    <td style="box-sizing: inherit;">
                                                                                                        <table cellpadding="0" cellspacing="0" style="box-sizing: inherit;">
                                                                                                            <tbody style="box-sizing: inherit;">
                                                                                                                <tr style="box-sizing: inherit;">
                                                                                                                    <td style="box-sizing: inherit; line-height: 0px; padding-bottom: 6px;">
                                                                                                                        <table class="ws-tpl-phone" cellpadding="0" cellspacing="0" style="box-sizing: inherit; width: 85px; line-height: 14px; font-size: 12px;">
                                                                                                                            <tbody style="box-sizing: inherit;">
                                                                                                                                <tr style="box-sizing: inherit;">
                                                                                                                                    <td style="box-sizing: inherit; color-scheme: light only; font-weight: bold; color: rgb(69, 102, 142);"><span style="box-sizing: inherit; line-height: 1.2;">P</span></td>
                                                                                                                                    <td width="5" style="box-sizing: inherit; width: 5px; font-size: 1pt; line-height: 0;">&nbsp;</td>
                                                                                                                                    <td style="box-sizing: inherit; color-scheme: light only;"><a href="tel:213-8797978" target="_blank" style="box-sizing: inherit; color-scheme: light only; text-decoration-line: none;"><span data-acs="phone" style="box-sizing: inherit; line-height: 1.2; color-scheme: light only; color: rgb(33, 33, 33); white-space: nowrap;">213-8797978</span></a></td>
                                                                                                                                </tr>
                                                                                                                            </tbody>
                                                                                                                        </table>
                                                                                                                    </td>
                                                                                                                    <td style="box-sizing: inherit; line-height: 0px; padding-bottom: 6px;">
                                                                                                                        <table class="ws-tpl-mobile" cellpadding="0" cellspacing="0" style="box-sizing: inherit; width: 112px; line-height: 14px; font-size: 12px;">
                                                                                                                            <tbody style="box-sizing: inherit;">
                                                                                                                                <tr style="box-sizing: inherit;">
                                                                                                                                    <td style="box-sizing: inherit; padding: 0px 6px;"><span style="box-sizing: inherit; color-scheme: light only; font-weight: bold; color: rgb(33, 33, 33);"></span></td>
                                                                                                                                    <td style="box-sizing: inherit; color-scheme: light only; font-weight: bold; color: rgb(69, 102, 142);"><span style="box-sizing: inherit; line-height: 1.2;">M</span></td>
                                                                                                                                    <td width="5" style="box-sizing: inherit; width: 5px; font-size: 1pt; line-height: 0;">&nbsp;</td>
                                                                                                                                    <td style="box-sizing: inherit; color-scheme: light only;"><a href="tel:91-8979879879" target="_blank" style="box-sizing: inherit; color-scheme: light only; text-decoration-line: none;"><span data-acs="mobile" style="box-sizing: inherit; line-height: 1.2; color-scheme: light only; color: rgb(33, 33, 33); white-space: nowrap;">91-8979879879</span></a></td>
                                                                                                                                </tr>
                                                                                                                            </tbody>
                                                                                                                        </table>
                                                                                                                    </td>
                                                                                                                    <td style="box-sizing: inherit; line-height: 0px; padding-bottom: 6px;">
                                                                                                                        <table class="ws-tpl-email" cellpadding="0" cellspacing="0" style="box-sizing: inherit; width: 158px; line-height: 14px; font-size: 12px;">
                                                                                                                            <tbody style="box-sizing: inherit;">
                                                                                                                                <tr style="box-sizing: inherit;">
                                                                                                                                    <td style="box-sizing: inherit; padding: 0px 6px;"><span style="box-sizing: inherit; color-scheme: light only; font-weight: bold; color: rgb(33, 33, 33);"></span></td>
                                                                                                                                    <td style="box-sizing: inherit; color-scheme: light only; font-weight: bold; color: rgb(69, 102, 142);"><span style="box-sizing: inherit; line-height: 1.2;">E</span></td>
                                                                                                                                    <td width="5" style="box-sizing: inherit; width: 5px; font-size: 1pt; line-height: 0;">&nbsp;</td>
                                                                                                                                    <td style="box-sizing: inherit; color-scheme: light only;"><span data-acs="email" style="box-sizing: inherit; color-scheme: light only; text-decoration-line: none; line-height: 1.2; color: rgb(33, 33, 33); white-space: nowrap;">amit.t@mascot.com</span></td>
                                                                                                                                </tr>
                                                                                                                            </tbody>
                                                                                                                        </table>
                                                                                                                    </td>
                                                                                                                </tr>
                                                                                                            </tbody>
                                                                                                        </table>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr style="box-sizing: inherit;">
                                                                                                    <td style="box-sizing: inherit;">
                                                                                                        <table cellpadding="0" cellspacing="0" style="box-sizing: inherit;">
                                                                                                            <tbody style="box-sizing: inherit;">
                                                                                                                <tr style="box-sizing: inherit;">
                                                                                                                    <td style="box-sizing: inherit; line-height: 0px; padding-bottom: 6px;">
                                                                                                                        <table class="ws-tpl-website" cellpadding="0" cellspacing="0" style="box-sizing: inherit; width: 114px; line-height: 14px; font-size: 12px;">
                                                                                                                            <tbody style="box-sizing: inherit;">
                                                                                                                                <tr style="box-sizing: inherit;">
                                                                                                                                    <td style="box-sizing: inherit; color-scheme: light only; font-weight: bold; color: rgb(69, 102, 142);"><span style="box-sizing: inherit; line-height: 1.2;">W</span></td>
                                                                                                                                    <td width="5" style="box-sizing: inherit; width: 5px; font-size: 1pt; line-height: 0;">&nbsp;</td>
                                                                                                                                    <td style="box-sizing: inherit; color-scheme: light only;"><span data-acs="website" style="box-sizing: inherit; color-scheme: light only; text-decoration-line: none; line-height: 1.2; color: rgb(33, 33, 33); white-space: nowrap;">www.mascot.com</span></td>
                                                                                                                                </tr>
                                                                                                                            </tbody>
                                                                                                                        </table>
                                                                                                                    </td>
                                                                                                                </tr>
                                                                                                            </tbody>
                                                                                                        </table>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <tr style="box-sizing: inherit;">
                                                                                                    <td style="box-sizing: inherit;">
                                                                                                        <table cellpadding="0" cellspacing="0" style="box-sizing: inherit;">
                                                                                                            <tbody style="box-sizing: inherit;">
                                                                                                                <tr style="box-sizing: inherit;">
                                                                                                                    <td style="box-sizing: inherit; line-height: 0px; padding-bottom: 6px;">
                                                                                                                        <table class="ws-tpl-address" cellpadding="0" cellspacing="0" style="box-sizing: inherit; width: 236px; line-height: 14px; font-size: 12px;">
                                                                                                                            <tbody style="box-sizing: inherit;">
                                                                                                                                <tr style="box-sizing: inherit;">
                                                                                                                                    <td style="box-sizing: inherit; color-scheme: light only; font-weight: bold; color: rgb(69, 102, 142);"><span style="box-sizing: inherit; line-height: 1.2;">A</span></td>
                                                                                                                                    <td width="5" style="box-sizing: inherit; width: 5px; font-size: 1pt; line-height: 0;">&nbsp;</td>
                                                                                                                                    <td style="box-sizing: inherit; color-scheme: light only;"><span data-acs="address" style="box-sizing: inherit; color-scheme: light only; text-decoration-line: none; line-height: 1.2; color: rgb(33, 33, 33); white-space: nowrap;">199/1, west coast Join Harber, New Wells</span></td>
                                                                                                                                </tr>
                                                                                                                            </tbody>
                                                                                                                        </table>
                                                                                                                    </td>
                                                                                                                </tr>
                                                                                                            </tbody>
                                                                                                        </table>
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </tbody>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <!---  End here    ----------->
                                                                </td>
                                                                <td width="41" style="font-size:1px;line-height:1px">&nbsp;</td>
                                                            </tr>
                                                            <tr>
                                                                <td width="41" style="font-size:1px;line-height:1px">&nbsp;</td>
                                                                <td height="30" style="font-size:1px;line-height:1px">&nbsp;</td>
                                                                <td width="41" style="font-size:1px;line-height:1px">&nbsp;</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!--- Insert the Mail snippet -->
                                            <tr>
                                                <td bgcolor="#fed03d" align="center" valign="top">
                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                                                        <tbody>
                                                            <tr>
                                                                <td valign="top" width="100%">
                                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td align="center" id="m_-5182915800725953308headline_image" style="font-size:1px;line-height:1px">
                                                                                    <div>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td height="10" style="font-size:1px;line-height:1px">&nbsp;</td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td bgcolor="#FFFFFF" align="center" id="m_-5182915800725953308edit_cta_button">
                                                    <div></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td bgcolor="#4CAF50" align="center" valign="top" height="70px">
                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                                                        <tbody>
                                                            <tr>
                                                                <td valign="top" width="100%">
                                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                                                                        <tbody>
                                                                            <footer>
                                                                                <div style="width: 100%;background: #61B329; bottom: 0;padding: 10px 0;">
                                                                                    <p style="text-align:center;color: #ffffff;margin:0px;"> Corporate Office : CanQualify, 3450 Triumph Blvd, STE-102, Lehi, UT 84043</p>
                                                                                    <p style="text-align:center;color: #ffffff;margin:0px;"> Phone: (801) 851-1810</p>
                                                                                    <p style="text-align:center;color: #ffffff;margin:0px;"> Email: support@canqualify.com </p>
                                                                                </div>
                                                                            </footer>
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td bgcolor="#F7F7F7" align="center">
                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                                                        <tbody>
                                                            <tr>
                                                                <td id="m_-5182915800725953308edit_text_3" align="center">
                                                                    <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td width="41" style="font-size:1px;line-height:1px">&nbsp;</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td width="25" style="font-size:1px;line-height:1px">&nbsp;</td>
                                                                                <td style="font-family:'Proxima Nova',Calibri,Helvetica,sans-serif;font-size:12px;color:#808080;font-weight:normal;text-align:center;line-height:150%">
                                                                                    <div>
                                                                                        <span align="center">Update Email | Privacy Policy | Contact Us</span>
                                                                                    </div>
                                                                                </td>
                                                                                <td width="25" style="font-size:1px;line-height:1px">&nbsp;</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td width="41" style="font-size:1px;line-height:1px">&nbsp;</td>
                                                                                <td height="20" style="font-size:1px;line-height:1px">&nbsp;</td>
                                                                                <td width="41" style="font-size:1px;line-height:1px">&nbsp;</td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                </div>
                </table>
                </td>
                </tr>
                </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>
</div>
