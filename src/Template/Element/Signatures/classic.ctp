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
<table cellpadding="0" cellspacing="0" class="ws-tpl" style="box-sizing: inherit; font-size: 16px; font-family: Arial; line-height: 1.15;">
    <tbody style="box-sizing: inherit;">
        <tr style="box-sizing: inherit;">
            <td style="box-sizing: inherit; vertical-align: top; padding-right: 14px;">
                <table cellpadding="0" cellspacing="0" class="ws-tpl-photo" style="box-sizing: inherit; width: 65px;">
                    <tbody style="box-sizing: inherit;">
                        <tr style="box-sizing: inherit;">
                            <td style="box-sizing: inherit;"><img class="profile_photo" src="<?= $uploaded_path.$emailSignature->profile_photo ?>" height="68.68884540117416" width="65" style="box-sizing: inherit; width: 65px; vertical-align: initial; border-radius: 0px; display: block; height: 68.6888px;"></td>
                        </tr>
                    </tbody>
                </table>
            </td>
            <td class="ws-tpl-separator" height="1" width="0" style="box-sizing: inherit; width: 0px; border-right: 2px solid rgb(189, 189, 189); height: 1px; font-size: 1pt;">&nbsp;</td>
            <td valign="top" style="box-sizing: inherit; padding-left: 14px; vertical-align: top;">
                <table cellpadding="0" cellspacing="0" style="box-sizing: inherit;">
                    <tbody style="box-sizing: inherit;">
                        <tr style="box-sizing: inherit;">
                            <td style="box-sizing: inherit; line-height: 1.2; padding-bottom: 12px;"><span class="ws-tpl-name" style="box-sizing: inherit; text-transform: initial; font-weight: bold;"><span class="sign-name" data-acs="name" style="box-sizing: inherit; color: rgb(100, 100, 100); font-size: 15.6px;">Amit Kumbhar</span></span><br style="box-sizing: inherit;"><span class="title" data-acs="title" style="box-sizing: inherit; font-size: 13.2px; letter-spacing: 0px; text-transform: initial; font-weight: bold; color: rgb(100, 100, 100);">Software Developer,&nbsp;</span><span class="company_name" data-acs="company" style="box-sizing: inherit; font-size: 13.2px; letter-spacing: 0px; text-transform: initial; font-weight: bold; color: rgb(100, 100, 100);">Mascot Software Technology Pvt. Ltd.</span></td>
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
                                                                <table class="ws-tpl-phone" cellpadding="0" cellspacing="0" style="box-sizing: inherit; width: 71px; line-height: 14px; font-size: 12px;">
                                                                    <tbody style="box-sizing: inherit;">
                                                                        <tr style="box-sizing: inherit;">
                                                                            <td style="box-sizing: inherit; color-scheme: light only;"><a href="#" target="_blank" style="box-sizing: inherit; color-scheme: light only; text-decoration-line: none;"><span class="txtPhone" data-acs="phone" style="box-sizing: inherit; line-height: 1.2; color-scheme: light only; color: rgb(33, 33, 33); white-space: nowrap;">231-2562422</span></a></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                            <td style="box-sizing: inherit; line-height: 0px; padding-bottom: 6px;">
                                                                <table class="ws-tpl-mobile" cellpadding="0" cellspacing="0" style="box-sizing: inherit; width: 101px; line-height: 14px; font-size: 12px;">
                                                                    <tbody style="box-sizing: inherit;">
                                                                        <tr style="box-sizing: inherit;">
                                                                            <td style="box-sizing: inherit; padding: 0px 6px;"><span style="box-sizing: inherit; color-scheme: light only; font-weight: bold; color: rgb(33, 33, 33); vertical-align: 2px;">|</span></td>
                                                                            <td style="box-sizing: inherit; color-scheme: light only;"><a href="#" target="_blank" style="box-sizing: inherit; color-scheme: light only; text-decoration-line: none;"><span class="mobile" data-acs="mobile" style="box-sizing: inherit; line-height: 1.2; color-scheme: light only; color: rgb(33, 33, 33); white-space: nowrap;">+91-9762318510</span></a></td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                            <td style="box-sizing: inherit; line-height: 0px; padding-bottom: 6px;">
                                                                <table class="ws-tpl-email" cellpadding="0" cellspacing="0" style="box-sizing: inherit; width: 148px; line-height: 14px; font-size: 12px;">
                                                                    <tbody style="box-sizing: inherit;">
                                                                        <tr style="box-sizing: inherit;">
                                                                            <td style="box-sizing: inherit; padding: 0px 6px;"><span style="box-sizing: inherit; color-scheme: light only; font-weight: bold; color: rgb(33, 33, 33); vertical-align: 2px;">|</span></td>
                                                                            <td style="box-sizing: inherit; color-scheme: light only;"><a href="mailto:#" target="_blank" style="box-sizing: inherit; color-scheme: light only; text-decoration-line: none;"><span class="signature_email" data-acs="email" style="box-sizing: inherit; line-height: 1.2; color-scheme: light only; color: rgb(33, 33, 33); white-space: nowrap;">arundhati.lambore@canqualify.com</span></a></td>
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
                                                                <table class="ws-tpl-website" cellpadding="0" cellspacing="0" style="box-sizing: inherit; width: 97px; line-height: 14px; font-size: 12px;">
                                                                    <tbody style="box-sizing: inherit;">
                                                                        <tr style="box-sizing: inherit;">
                                                                            <td style="box-sizing: inherit; color-scheme: light only;"><a href="www.canqualify.com" target="_blank" style="box-sizing: inherit; color-scheme: light only; text-decoration-line: none;"><span class="website" data-acs="website" style="box-sizing: inherit; line-height: 1.2; color-scheme: light only; color: rgb(33, 33, 33); white-space: nowrap;">www.canqualify.com</span></a></td>
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
                                                                <table class="ws-tpl-address" cellpadding="0" cellspacing="0" style="box-sizing: inherit; width: 222px; line-height: 14px; font-size: 12px;">
                                                                    <tbody style="box-sizing: inherit;">
                                                                        <tr style="box-sizing: inherit;">
                                                                            <td style="box-sizing: inherit; color-scheme: light only;"><a href="https://maps.google.com/?q=199/1,%20west%20coast%20Join%20Harber,%20New%20Wells" target="_blank" style="box-sizing: inherit; color-scheme: light only; text-decoration-line: none;"><span class="address" data-acs="address" style="box-sizing: inherit; line-height: 1.2; color-scheme: light only; color: rgb(33, 33, 33); white-space: nowrap;">199/1, west coast Join Harber, New Wells</span></a></td>
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
                        <tr style="box-sizing: inherit;">
                            <td style="box-sizing: inherit; padding-top: 12px;"><br></td>
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