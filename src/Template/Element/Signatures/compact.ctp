<?php
use Cake\Core\Configure;
$uploaded_path = Configure::read('uploaded_path');
?>
<div class="col-lg-8">
<div class="card shadow  bg-white rounded">
    <div class="card-header">
        <strong>Signature</strong>  Preview
    </div>
    <div class="card-body message-body" id="signature_container">
<table class="main_html" style="box-sizing: inherit; color: rgb(25, 28, 43); font-family: Mulish, sans-serif; font-size: 16px; direction: ltr; border-radius: 0px;">
    <tbody style="box-sizing: inherit;">
        <tr style="box-sizing: inherit;">
            <td style="box-sizing: inherit;">
                <table cellpadding="0" cellspacing="0" class="ws-tpl" style="box-sizing: inherit; font-family: Arial; line-height: 1.15; padding-bottom: 10px; color: rgb(0, 0, 0);">
                    <tbody style="box-sizing: inherit;">
                        <tr style="box-sizing: inherit;">
                            <td valign="top" style="box-sizing: inherit; vertical-align: top; padding-right: 16px; line-height: 0px;">
                                <table cellpadding="0" cellspacing="0" class="ws-tpl-photo" style="box-sizing: inherit; line-height: 1.2;">
                                    <tbody style="box-sizing: inherit;">
                                        <tr style="box-sizing: inherit;">
                                            <td style="box-sizing: inherit; width: 65px; padding: 0px;"><img src="<?= $uploaded_path.$emailSignature->profile_photo ?>" height="68.68884540117416" alt="photo" width="65" style="box-sizing: inherit; width: 65px; vertical-align: initial; border-radius: 50%; display: block; height: 68.6888px;"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td valign="top" style="box-sizing: inherit; vertical-align: top; line-height: 0px;">
                                <table cellpadding="0" cellspacing="0" style="box-sizing: inherit; line-height: 1.2;">
                                    <tbody style="box-sizing: inherit;">
                                        <tr style="box-sizing: inherit;">
                                            <td valign="top" style="box-sizing: inherit; vertical-align: top; padding-right: 45px; line-height: 1.2;"><span class="sign-name" data-acs="name" style="box-sizing: inherit; color: rgb(69, 102, 142); text-transform: initial; font-weight: bold;">
                                                    Amit Kumbhar</span><br style="box-sizing: inherit;"><span class="title" data-acs="title" style="box-sizing: inherit; font-size: 12px; letter-spacing: 0px; text-transform: initial; color: rgb(51, 51, 51);">
                                                    Software Developer</span><br style="box-sizing: inherit;"><span class="company_name"data-acs="company" style="box-sizing: inherit; font-size: 12px; letter-spacing: 0px; text-transform: initial; font-weight: bold; color: rgb(68, 68, 68);">
                                                   Mascot Software Technology Pvt. Ltd.</span></td>
                                            <td valign="top" style="box-sizing: inherit; vertical-align: top; line-height: 0px;">
                                                <table cellpadding="0" cellspacing="0" style="box-sizing: inherit; font-size: 12px; line-height: 1.2;">
                                                    <tbody style="box-sizing: inherit;">
                                                        <tr style="box-sizing: inherit;">
                                                            <td style="box-sizing: inherit; line-height: 0;">
                                                                <table cellpadding="0" cellspacing="0" style="box-sizing: inherit;">
                                                                    <tbody style="box-sizing: inherit;">
                                                                        <tr style="box-sizing: inherit;">
                                                                            <td style="box-sizing: inherit; line-height: 0px; padding-bottom: 6px;">
                                                                                <table class="ws-tpl-phone" cellpadding="0" cellspacing="0" style="box-sizing: inherit; line-height: 14px;">
                                                                                    <tbody style="box-sizing: inherit;">
                                                                                        <tr style="box-sizing: inherit;">
                                                                                            <td style="box-sizing: inherit; color-scheme: light only; font-weight: bold; color: rgb(69, 102, 142);"><img src="https://cdn.gifo.wisestamp.com/social/phone/45668E/13/trans.png" style="box-sizing: inherit; vertical-align: -2px; line-height: 1.2;"></td>
                                                                                            <td width="5" style="box-sizing: inherit; width: 5px; font-size: 1pt; line-height: 0;">&nbsp;</td>
                                                                                            <td style="box-sizing: inherit; color-scheme: light only;"><a href="tel:<?= h($emailSignature->phone) ?>" target="_blank" style="box-sizing: inherit; color-scheme: light only; text-decoration-line: none;"><span class="txtPhone" data-acs="phone" style="box-sizing: inherit; line-height: 1.2; color-scheme: light only; color: rgb(33, 33, 33); white-space: nowrap;">
                                                                                                        231-2562422</span></a></td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        <tr style="box-sizing: inherit;">
                                                                            <td style="box-sizing: inherit; line-height: 0px; padding-bottom: 6px;">
                                                                                <table class="ws-tpl-mobile" cellpadding="0" cellspacing="0" style="box-sizing: inherit; line-height: 14px;">
                                                                                    <tbody style="box-sizing: inherit;">
                                                                                        <tr style="box-sizing: inherit;">
                                                                                            <td style="box-sizing: inherit; color-scheme: light only; font-weight: bold; color: rgb(69, 102, 142);"><img src="https://cdn.gifo.wisestamp.com/social/mobile/45668E/13/trans.png" style="box-sizing: inherit; vertical-align: -2px; line-height: 1.2;"></td>
                                                                                            <td width="5" style="box-sizing: inherit; width: 5px; font-size: 1pt; line-height: 0;">&nbsp;</td>
                                                                                            <td style="box-sizing: inherit; color-scheme: light only;"><a href="tel:<?= h($emailSignature->mobile) ?>" target="_blank" style="box-sizing: inherit; color-scheme: light only; text-decoration-line: none;"><span class="mobile"  data-acs="mobile" style="box-sizing: inherit; line-height: 1.2; color-scheme: light only; color: rgb(33, 33, 33); white-space: nowrap;">
                                                                                                        +91-9762318510</span></a></td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        <tr style="box-sizing: inherit;">
                                                                            <td style="box-sizing: inherit; line-height: 0px; padding-bottom: 6px;">
                                                                                <table class="ws-tpl-email" cellpadding="0" cellspacing="0" style="box-sizing: inherit; line-height: 14px;">
                                                                                    <tbody style="box-sizing: inherit;">
                                                                                        <tr style="box-sizing: inherit;">
                                                                                            <td style="box-sizing: inherit; color-scheme: light only; font-weight: bold; color: rgb(69, 102, 142);"><img src="https://cdn.gifo.wisestamp.com/social/envelope/45668E/13/trans.png" style="box-sizing: inherit; vertical-align: -2px; line-height: 1.2;"></td>
                                                                                            <td width="5" style="box-sizing: inherit; width: 5px; font-size: 1pt; line-height: 0;">&nbsp;</td>
                                                                                            <td style="box-sizing: inherit; color-scheme: light only;"><a href="mailto:<?= h($emailSignature->email) ?>" target="_blank" style="box-sizing: inherit; color-scheme: light only; text-decoration-line: none;"><span class="signature_email" data-acs="email" style="box-sizing: inherit; line-height: 1.2; color-scheme: light only; color: rgb(33, 33, 33); white-space: nowrap;">
                                                                                                        arundhati.lambore@canqualify.com</span></a></td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        <tr style="box-sizing: inherit;">
                                                                            <td style="box-sizing: inherit; line-height: 0px; padding-bottom: 6px;">
                                                                                <table class="ws-tpl-website" cellpadding="0" cellspacing="0" style="box-sizing: inherit; line-height: 14px;">
                                                                                    <tbody style="box-sizing: inherit;">
                                                                                        <tr style="box-sizing: inherit;">
                                                                                            <td style="box-sizing: inherit; color-scheme: light only; font-weight: bold; color: rgb(69, 102, 142);"><img src="https://cdn.gifo.wisestamp.com/social/browser/45668E/13/trans.png" style="box-sizing: inherit; vertical-align: -2px; line-height: 1.2;"></td>
                                                                                            <td width="5" style="box-sizing: inherit; width: 5px; font-size: 1pt; line-height: 0;">&nbsp;</td>
                                                                                            <td style="box-sizing: inherit; color-scheme: light only;"><a href="www.canqualify.com" target="_blank" style="box-sizing: inherit; color-scheme: light only; text-decoration-line: none;"><span class="website" data-acs="website" style="box-sizing: inherit; line-height: 1.2; color-scheme: light only; color: rgb(33, 33, 33); white-space: nowrap;">www.canqualify.com</span></a></td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        <tr style="box-sizing: inherit;">
                                                                            <td style="box-sizing: inherit; line-height: 0px; padding-bottom: 6px;">
                                                                                <table class="ws-tpl-address" cellpadding="0" cellspacing="0" style="box-sizing: inherit; line-height: 14px;">
                                                                                    <tbody style="box-sizing: inherit;">
                                                                                        <tr style="box-sizing: inherit;">
                                                                                            <td style="box-sizing: inherit; color-scheme: light only; font-weight: bold; color: rgb(69, 102, 142);"><img src="https://cdn.gifo.wisestamp.com/social/map/45668E/13/trans.png" style="box-sizing: inherit; vertical-align: -2px; line-height: 1.2;"></td>
                                                                                            <td width="5" style="box-sizing: inherit; width: 5px; font-size: 1pt; line-height: 0;">&nbsp;</td>
                                                                                            <td style="box-sizing: inherit; color-scheme: light only;"><a href="https://maps.google.com/?q=199/1,%20west%20coast%20Join%20Harber,%20New%20Wells" target="_blank" style="box-sizing: inherit; color-scheme: light only; text-decoration-line: none;"><span class="address" data-acs="address" style="box-sizing: inherit; line-height: 1.2; color-scheme: light only; color: rgb(33, 33, 33); white-space: nowrap;">
                                                                                                        199/1, west coast Join Harber, New Wells</span></a></td>
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
                                                            <td style="box-sizing: inherit; padding-top: 8px; line-height: 0px;">
                                                                <table class="ws-tpl-social" cellpadding="0" cellspacing="0" style="box-sizing: inherit; width: 240px; line-height: 1.2;">
                                                                    <tbody style="box-sizing: inherit;">
                                                                        <tr style="box-sizing: inherit;">
                                                                            <td style="box-sizing: inherit;"><br>
                                                                                <div style="box-sizing: inherit; height: 1px !important;"></div>
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
                <table cellpadding="0" cellspacing="0" border="0" style="box-sizing: inherit;">
                    <tbody style="box-sizing: inherit;">
                        <tr style="box-sizing: inherit;">
                            <td style="box-sizing: inherit; line-height: 0;"></td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
<table style="box-sizing: inherit; color: rgb(25, 28, 43); font-family: Mulish, sans-serif; font-size: 16px; opacity: 0 !important;">
    <tbody style="box-sizing: inherit;">
        <tr style="box-sizing: inherit;">
            <td height="1" width="1" style="box-sizing: inherit; height: 1px !important; width: 1px !important;">‌<br><br></td>
        </tr>
    </tbody>
</table>
</div>
</div>
</div>