<?php
use Cake\Core\Configure;
$uploaded_path = Configure::read('uploaded_path');
?>
<div class="col-lg-6">
<div class="card shadow  bg-white rounded">
    <div class="card-header">
        <strong>Signature</strong>  Preview
    </div>
    <div class="card-body message-body" id="signature_container">

<table cellpadding="0" cellspacing="0" class="ws-tpl" style="box-sizing: inherit; font-size: 16px; font-family: Arial; line-height: 1.25; padding-bottom: 10px;">
    <tbody style="box-sizing: inherit;">
        <tr style="box-sizing: inherit;">
            <td valign="top" style="box-sizing: inherit; vertical-align: top; padding-right: 20px;">
                <table cellpadding="0" cellspacing="0" class="ws-tpl-photo" style="box-sizing: inherit;">
                    <tbody style="box-sizing: inherit;">
                        <tr style="box-sizing: inherit;">
                            <td style="box-sizing: inherit; width: 65px; padding: 0px;"><img src="<?= $uploaded_path.$emailSignature->profile_photo ?>" height="68.68884540117416" alt="photo" width="65" style="box-sizing: inherit; width: 65px; vertical-align: initial; border-radius: 0px; display: block; height: 68.6888px;"></td>
                        </tr>
                    </tbody>
                </table>
            </td>
            <td valign="top" style="box-sizing: inherit;">
                <table cellpadding="0" cellspacing="0" style="box-sizing: inherit;">
                    <tbody style="box-sizing: inherit;">
                        <tr style="box-sizing: inherit;">
                            <td style="box-sizing: inherit; line-height: 1.2;"><span class="sign-name" data-acs="name" style="box-sizing: inherit; color-scheme: light only; color: rgb(69, 102, 142); font-size: 12px; font-weight: bold;">Amit Kumbhar</span><br style="box-sizing: inherit;"><span class="title" data-acs="title" style="box-sizing: inherit; color-scheme: light only; font-size: 12px; letter-spacing: 0px; text-transform: initial; color: rgb(69, 102, 142);">Software deleloper at&nbsp;</span><span class="company_name" data-acs="company" style="box-sizing: inherit; color-scheme: light only; font-size: 12px; letter-spacing: 0px; text-transform: initial; color: rgb(69, 102, 142);">Mascot Software Technology Pvt. Ltd.</span></td>
                        </tr>
                        <tr style="box-sizing: inherit;">
                            <td style="box-sizing: inherit; line-height: 0; padding-top: 12px; padding-bottom: 12px;">
                                <table sellspacing="0" cellpadding="0" style="box-sizing: inherit; width: 355px;">
                                    <tbody style="box-sizing: inherit;">
                                        <tr style="box-sizing: inherit;">
                                            <td class="ws-tpl-separator" style="box-sizing: inherit; line-height: 0; font-size: 1pt; border-bottom: 5px solid rgb(69, 102, 142);">&nbsp;</td>
                                        </tr>
                                    </tbody>
                                </table>
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
                                                                <table class="ws-tpl-phone" cellpadding="0" cellspacing="0" style="box-sizing: inherit; line-height: 14px; font-size: 12px;">
                                                                    <tbody style="box-sizing: inherit;">
                                                                        <tr style="box-sizing: inherit;">
                                                                            <td style="box-sizing: inherit; color-scheme: light only; font-weight: bold; color: rgb(69, 102, 142);"><span style="box-sizing: inherit; line-height: 1.2;">P</span></td>
                                                                            <td width="5" style="box-sizing: inherit; width: 5px; font-size: 1pt; line-height: 0;">&nbsp;</td>
                                                                            <td style="box-sizing: inherit; color-scheme: light only;"><a href="tel:<?= h($emailSignature->phone) ?>" target="_blank" style="box-sizing: inherit; color-scheme: light only; text-decoration-line: none;"><span class="txtPhone" data-acs="phone" style="box-sizing: inherit; line-height: 1.2; color-scheme: light only; color: rgb(33, 33, 33); white-space: nowrap;">231-2562422</span></a></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                            <td style="box-sizing: inherit; line-height: 0px; padding-bottom: 6px;">
                                                                <table class="ws-tpl-mobile" cellpadding="0" cellspacing="0" style="box-sizing: inherit; line-height: 14px; font-size: 12px;">
                                                                    <tbody style="box-sizing: inherit;">
                                                                        <tr style="box-sizing: inherit;">
                                                                            <td style="box-sizing: inherit; padding: 0px 6px;"><span style="box-sizing: inherit; color-scheme: light only; font-weight: bold; color: rgb(33, 33, 33);"></span></td>
                                                                            <td style="box-sizing: inherit; color-scheme: light only; font-weight: bold; color: rgb(69, 102, 142);"><span style="box-sizing: inherit; line-height: 1.2;">M</span></td>
                                                                            <td width="5" style="box-sizing: inherit; width: 5px; font-size: 1pt; line-height: 0;">&nbsp;</td>
                                                                            <td style="box-sizing: inherit; color-scheme: light only;"><a href="tel:<?= h($emailSignature->mobile) ?>" target="_blank" style="box-sizing: inherit; color-scheme: light only; text-decoration-line: none;"><span class="mobile" data-acs="mobile" style="box-sizing: inherit; line-height: 1.2; color-scheme: light only; color: rgb(33, 33, 33); white-space: nowrap;">
                                                                                        +91-9762318510</span></a></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                            <td style="box-sizing: inherit; line-height: 0px; padding-bottom: 6px;">
                                                                <table class="ws-tpl-email" cellpadding="0" cellspacing="0" style="box-sizing: inherit; line-height: 14px; font-size: 12px;">
                                                                    <tbody style="box-sizing: inherit;">
                                                                        <tr style="box-sizing: inherit;">
                                                                            <td style="box-sizing: inherit; padding: 0px 6px;"><span style="box-sizing: inherit; color-scheme: light only; font-weight: bold; color: rgb(33, 33, 33);"></span></td>
                                                                            <td style="box-sizing: inherit; color-scheme: light only; font-weight: bold; color: rgb(69, 102, 142);"><span style="box-sizing: inherit; line-height: 1.2;">E</span></td>
                                                                            <td width="5" style="box-sizing: inherit; width: 5px; font-size: 1pt; line-height: 0;">&nbsp;</td>
                                                                            <td style="box-sizing: inherit; color-scheme: light only;"><a href="mailto:#" target="_blank" style="box-sizing: inherit; color-scheme: light only; text-decoration-line: none;"><span class="signature_email"  data-acs="email" style="box-sizing: inherit; line-height: 1.2; color-scheme: light only; color: rgb(33, 33, 33); white-space: nowrap;">
                                                                                        arundhati.lambore@canqualify.com</span></a></td>
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
                                                                <table class="ws-tpl-website" cellpadding="0" cellspacing="0" style="box-sizing: inherit; line-height: 14px; font-size: 12px;">
                                                                    <tbody style="box-sizing: inherit;">
                                                                        <tr style="box-sizing: inherit;">
                                                                            <td style="box-sizing: inherit; color-scheme: light only; font-weight: bold; color: rgb(69, 102, 142);"><span style="box-sizing: inherit; line-height: 1.2;">W</span></td>
                                                                            <td width="5" style="box-sizing: inherit; width: 5px; font-size: 1pt; line-height: 0;">&nbsp;</td>
                                                                            <td style="box-sizing: inherit; color-scheme: light only;"><a href="#" target="_blank" style="box-sizing: inherit; color-scheme: light only; text-decoration-line: none;"><span class="website" data-acs="website" style="box-sizing: inherit; line-height: 1.2; color-scheme: light only; color: rgb(33, 33, 33); white-space: nowrap;"> www.canqualify.com</span></a></td>
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
                                                                <table class="ws-tpl-address" cellpadding="0" cellspacing="0" style="box-sizing: inherit; line-height: 14px; font-size: 12px;">
                                                                    <tbody style="box-sizing: inherit;">
                                                                        <tr style="box-sizing: inherit;">
                                                                            <td style="box-sizing: inherit; color-scheme: light only; font-weight: bold; color: rgb(69, 102, 142);"><span style="box-sizing: inherit; line-height: 1.2;">A</span></td>
                                                                            <td width="5" style="box-sizing: inherit; width: 5px; font-size: 1pt; line-height: 0;">&nbsp;</td>
                                                                            <td style="box-sizing: inherit; color-scheme: light only;"><span class="address" data-acs="address" style="box-sizing: inherit; color-scheme: light only; text-decoration-line: none; line-height: 1.2; color: rgb(33, 33, 33); white-space: nowrap;">
                                                                                    199/1, west coast Join Harber, New Wells</span></td>
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
            </td>
        </tr>
    </tbody>
</table>
</div>
</div>
</div>