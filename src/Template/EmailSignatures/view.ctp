<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EmailSignature $emailSignature
 */
use Cake\Core\Configure;
$uploaded_path = Configure::read('uploaded_path');

?>
<div class="row emailSignatures">
    <div class="col-lg-9">
        <div class="card shadow  bg-white rounded">
            <div class="card-header clearfix">
                <?= h($emailSignature->signature_name) ?>
            </div>
            <div class="card-body card-block">
                <?php if($emailSignature->template_id == 1){ ?>
                <table cellpadding="0" cellspacing="0" class="ws-tpl"
                    style="box-sizing: inherit; font-size: 16px; font-family: Arial; line-height: 1.15;">
                    <tbody style="box-sizing: inherit;">
                        <tr style="box-sizing: inherit;">
                            <td style="box-sizing: inherit; vertical-align: top; padding-right: 14px;">
                                <table cellpadding="0" cellspacing="0" class="ws-tpl-photo"
                                    style="box-sizing: inherit; width: 65px;">
                                    <tbody style="box-sizing: inherit;">
                                        <tr style="box-sizing: inherit;">
                                            <td style="box-sizing: inherit;"><img
                                                    src="<?= $uploaded_path.$emailSignature->profile_photo ?>"
                                                    height="68.68884540117416" width="65"
                                                    style="box-sizing: inherit; width: 65px; vertical-align: initial; border-radius: 0px; display: block; height: 68.6888px;">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td class="ws-tpl-separator" height="1" width="0"
                                style="box-sizing: inherit; width: 0px; border-right: 2px solid rgb(189, 189, 189); height: 1px; font-size: 1pt;">
                                &nbsp;</td>
                            <td valign="top" style="box-sizing: inherit; padding-left: 14px; vertical-align: top;">
                                <table cellpadding="0" cellspacing="0" style="box-sizing: inherit;">
                                    <tbody style="box-sizing: inherit;">
                                        <tr style="box-sizing: inherit;">
                                            <td style="box-sizing: inherit; line-height: 1.2; padding-bottom: 12px;">
                                                <span class="ws-tpl-name"
                                                    style="box-sizing: inherit; text-transform: initial; font-weight: bold;"><span
                                                        data-acs="name"
                                                        style="box-sizing: inherit; color: rgb(100, 100, 100); font-size: 15.6px;"><?= h($emailSignature->name) ?></span></span><br
                                                    style="box-sizing: inherit;"><span class="ws-tpl-title"
                                                    data-acs="title"
                                                    style="box-sizing: inherit; font-size: 13.2px; letter-spacing: 0px; text-transform: initial; font-weight: bold; color: rgb(100, 100, 100);"><?= h($emailSignature->title) ?>,&nbsp;</span><span
                                                    class="ws-tpl-company" data-acs="company"
                                                    style="box-sizing: inherit; font-size: 13.2px; letter-spacing: 0px; text-transform: initial; font-weight: bold; color: rgb(100, 100, 100);"><?= h($emailSignature->company_name) ?></span>
                                            </td>
                                        </tr>
                                        <tr style="box-sizing: inherit;">
                                            <td style="box-sizing: inherit; line-height: 0;">
                                                <table cellpadding="0" cellspacing="0" style="box-sizing: inherit;">
                                                    <tbody style="box-sizing: inherit;">
                                                        <tr style="box-sizing: inherit;">
                                                            <td style="box-sizing: inherit;">
                                                                <table cellpadding="0" cellspacing="0"
                                                                    style="box-sizing: inherit;">
                                                                    <tbody style="box-sizing: inherit;">
                                                                        <tr style="box-sizing: inherit;">
                                                                            <td
                                                                                style="box-sizing: inherit; line-height: 0px; padding-bottom: 6px;">
                                                                                <table class="ws-tpl-phone"
                                                                                    cellpadding="0" cellspacing="0"
                                                                                    style="box-sizing: inherit; width: 71px; line-height: 14px; font-size: 12px;">
                                                                                    <tbody style="box-sizing: inherit;">
                                                                                        <tr
                                                                                            style="box-sizing: inherit;">
                                                                                            <td
                                                                                                style="box-sizing: inherit; color-scheme: light only;">
                                                                                                <a href="tel:<?= h($emailSignature->phone) ?>"
                                                                                                    target="_blank"
                                                                                                    style="box-sizing: inherit; color-scheme: light only; text-decoration-line: none;"><span
                                                                                                        data-acs="phone"
                                                                                                        style="box-sizing: inherit; line-height: 1.2; color-scheme: light only; color: rgb(33, 33, 33); white-space: nowrap;"><?= h($emailSignature->phone) ?></span></a>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                            <td
                                                                                style="box-sizing: inherit; line-height: 0px; padding-bottom: 6px;">
                                                                                <table class="ws-tpl-mobile"
                                                                                    cellpadding="0" cellspacing="0"
                                                                                    style="box-sizing: inherit; width: 101px; line-height: 14px; font-size: 12px;">
                                                                                    <tbody style="box-sizing: inherit;">
                                                                                        <tr
                                                                                            style="box-sizing: inherit;">
                                                                                            <td
                                                                                                style="box-sizing: inherit; padding: 0px 6px;">
                                                                                                <span
                                                                                                    style="box-sizing: inherit; color-scheme: light only; font-weight: bold; color: rgb(33, 33, 33); vertical-align: 2px;">|</span>
                                                                                            </td>
                                                                                            <td
                                                                                                style="box-sizing: inherit; color-scheme: light only;">
                                                                                                <a href="tel:<?= h($emailSignature->mobile) ?>"
                                                                                                    target="_blank"
                                                                                                    style="box-sizing: inherit; color-scheme: light only; text-decoration-line: none;"><span
                                                                                                        data-acs="mobile"
                                                                                                        style="box-sizing: inherit; line-height: 1.2; color-scheme: light only; color: rgb(33, 33, 33); white-space: nowrap;"><?= h($emailSignature->mobile) ?></span></a>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                            <td
                                                                                style="box-sizing: inherit; line-height: 0px; padding-bottom: 6px;">
                                                                                <table class="ws-tpl-email"
                                                                                    cellpadding="0" cellspacing="0"
                                                                                    style="box-sizing: inherit; width: 148px; line-height: 14px; font-size: 12px;">
                                                                                    <tbody style="box-sizing: inherit;">
                                                                                        <tr
                                                                                            style="box-sizing: inherit;">
                                                                                            <td
                                                                                                style="box-sizing: inherit; padding: 0px 6px;">
                                                                                                <span
                                                                                                    style="box-sizing: inherit; color-scheme: light only; font-weight: bold; color: rgb(33, 33, 33); vertical-align: 2px;">|</span>
                                                                                            </td>
                                                                                            <td
                                                                                                style="box-sizing: inherit; color-scheme: light only;">
                                                                                                <a href="mailto:<?= h($emailSignature->email) ?>"
                                                                                                    target="_blank"
                                                                                                    style="box-sizing: inherit; color-scheme: light only; text-decoration-line: none;"><span
                                                                                                        data-acs="email"
                                                                                                        style="box-sizing: inherit; line-height: 1.2; color-scheme: light only; color: rgb(33, 33, 33); white-space: nowrap;"><?= h($emailSignature->email) ?></span></a>
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
                                                            <td style="box-sizing: inherit;">
                                                                <table cellpadding="0" cellspacing="0"
                                                                    style="box-sizing: inherit;">
                                                                    <tbody style="box-sizing: inherit;">
                                                                        <tr style="box-sizing: inherit;">
                                                                            <td
                                                                                style="box-sizing: inherit; line-height: 0px; padding-bottom: 6px;">
                                                                                <table class="ws-tpl-website"
                                                                                    cellpadding="0" cellspacing="0"
                                                                                    style="box-sizing: inherit; width: 97px; line-height: 14px; font-size: 12px;">
                                                                                    <tbody style="box-sizing: inherit;">
                                                                                        <tr
                                                                                            style="box-sizing: inherit;">
                                                                                            <td
                                                                                                style="box-sizing: inherit; color-scheme: light only;">
                                                                                                <a href="http://www.<?= h($emailSignature->company_name) ?>.co/"
                                                                                                    target="_blank"
                                                                                                    style="box-sizing: inherit; color-scheme: light only; text-decoration-line: none;"><span
                                                                                                        data-acs="website"
                                                                                                        style="box-sizing: inherit; line-height: 1.2; color-scheme: light only; color: rgb(33, 33, 33); white-space: nowrap;"><?= h($emailSignature->company_name) ?></span></a>
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
                                                            <td style="box-sizing: inherit;">
                                                                <table cellpadding="0" cellspacing="0"
                                                                    style="box-sizing: inherit;">
                                                                    <tbody style="box-sizing: inherit;">
                                                                        <tr style="box-sizing: inherit;">
                                                                            <td
                                                                                style="box-sizing: inherit; line-height: 0px; padding-bottom: 6px;">
                                                                                <table class="ws-tpl-address"
                                                                                    cellpadding="0" cellspacing="0"
                                                                                    style="box-sizing: inherit; width: 222px; line-height: 14px; font-size: 12px;">
                                                                                    <tbody style="box-sizing: inherit;">
                                                                                        <tr
                                                                                            style="box-sizing: inherit;">
                                                                                            <td
                                                                                                style="box-sizing: inherit; color-scheme: light only;">
                                                                                                <a href="https://maps.google.com/?q=199/1,%20west%20coast%20Join%20Harber,%20New%20Wells"
                                                                                                    target="_blank"
                                                                                                    style="box-sizing: inherit; color-scheme: light only; text-decoration-line: none;"><span
                                                                                                        data-acs="address"
                                                                                                        style="box-sizing: inherit; line-height: 1.2; color-scheme: light only; color: rgb(33, 33, 33); white-space: nowrap;"><?= h($emailSignature->address) ?></span></a>
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
                                        <tr style="box-sizing: inherit;">
                                            <td style="box-sizing: inherit; padding-top: 12px;"><br></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <?php }elseif($emailSignature->template_id == 2) {?>
                <table cellpadding="0" cellspacing="0" class="ws-tpl"
                    style="box-sizing: inherit; font-size: 16px; font-family: Arial; line-height: 1.25; padding-bottom: 10px;">
                    <tbody style="box-sizing: inherit;">
                        <tr style="box-sizing: inherit;">
                            <td valign="top" style="box-sizing: inherit; vertical-align: top; padding-right: 20px;">
                                <table cellpadding="0" cellspacing="0" class="ws-tpl-photo"
                                    style="box-sizing: inherit;">
                                    <tbody style="box-sizing: inherit;">
                                        <tr style="box-sizing: inherit;">
                                            <td style="box-sizing: inherit; width: 65px; padding: 0px;"><img
                                                    src="<?= $uploaded_path.$emailSignature->profile_photo ?>"
                                                    height="68.68884540117416" alt="photo" width="65"
                                                    style="box-sizing: inherit; width: 65px; vertical-align: initial; border-radius: 0px; display: block; height: 68.6888px;">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td valign="top" style="box-sizing: inherit;">
                                <table cellpadding="0" cellspacing="0" style="box-sizing: inherit;">
                                    <tbody style="box-sizing: inherit;">
                                        <tr style="box-sizing: inherit;">
                                            <td style="box-sizing: inherit; line-height: 1.2;"><span class="ws-tpl-name"
                                                    data-acs="name"
                                                    style="box-sizing: inherit; color-scheme: light only; color: rgb(69, 102, 142); font-size: 12px; font-weight: bold;"><?= h($emailSignature->name) ?></span><br
                                                    style="box-sizing: inherit;"><span class="ws-tpl-title"
                                                    data-acs="title"
                                                    style="box-sizing: inherit; color-scheme: light only; font-size: 12px; letter-spacing: 0px; text-transform: initial; color: rgb(69, 102, 142);"><?= h($emailSignature->title) ?>
                                                    at&nbsp;</span><span class="ws-tpl-company" data-acs="company"
                                                    style="box-sizing: inherit; color-scheme: light only; font-size: 12px; letter-spacing: 0px; text-transform: initial; color: rgb(69, 102, 142);"><?= h($emailSignature->company_name) ?></span>
                                            </td>
                                        </tr>
                                        <tr style="box-sizing: inherit;">
                                            <td
                                                style="box-sizing: inherit; line-height: 0; padding-top: 12px; padding-bottom: 12px;">
                                                <table sellspacing="0" cellpadding="0"
                                                    style="box-sizing: inherit; width: 355px;">
                                                    <tbody style="box-sizing: inherit;">
                                                        <tr style="box-sizing: inherit;">
                                                            <td class="ws-tpl-separator"
                                                                style="box-sizing: inherit; line-height: 0; font-size: 1pt; border-bottom: 5px solid rgb(69, 102, 142);">
                                                                &nbsp;</td>
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
                                                                <table cellpadding="0" cellspacing="0"
                                                                    style="box-sizing: inherit;">
                                                                    <tbody style="box-sizing: inherit;">
                                                                        <tr style="box-sizing: inherit;">
                                                                            <td
                                                                                style="box-sizing: inherit; line-height: 0px; padding-bottom: 6px;">
                                                                                <table class="ws-tpl-phone"
                                                                                    cellpadding="0" cellspacing="0"
                                                                                    style="box-sizing: inherit; line-height: 14px; font-size: 12px;">
                                                                                    <tbody style="box-sizing: inherit;">
                                                                                        <tr
                                                                                            style="box-sizing: inherit;">
                                                                                            <td
                                                                                                style="box-sizing: inherit; color-scheme: light only; font-weight: bold; color: rgb(69, 102, 142);">
                                                                                                <span
                                                                                                    style="box-sizing: inherit; line-height: 1.2;">P</span>
                                                                                            </td>
                                                                                            <td width="5"
                                                                                                style="box-sizing: inherit; width: 5px; font-size: 1pt; line-height: 0;">
                                                                                                &nbsp;</td>
                                                                                            <td
                                                                                                style="box-sizing: inherit; color-scheme: light only;">
                                                                                                <a href="tel:<?= h($emailSignature->phone) ?>"
                                                                                                    target="_blank"
                                                                                                    style="box-sizing: inherit; color-scheme: light only; text-decoration-line: none;"><span
                                                                                                        data-acs="phone"
                                                                                                        style="box-sizing: inherit; line-height: 1.2; color-scheme: light only; color: rgb(33, 33, 33); white-space: nowrap;"><?= h($emailSignature->phone) ?></span></a>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                            <td
                                                                                style="box-sizing: inherit; line-height: 0px; padding-bottom: 6px;">
                                                                                <table class="ws-tpl-mobile"
                                                                                    cellpadding="0" cellspacing="0"
                                                                                    style="box-sizing: inherit; line-height: 14px; font-size: 12px;">
                                                                                    <tbody style="box-sizing: inherit;">
                                                                                        <tr
                                                                                            style="box-sizing: inherit;">
                                                                                            <td
                                                                                                style="box-sizing: inherit; padding: 0px 6px;">
                                                                                                <span
                                                                                                    style="box-sizing: inherit; color-scheme: light only; font-weight: bold; color: rgb(33, 33, 33);"></span>
                                                                                            </td>
                                                                                            <td
                                                                                                style="box-sizing: inherit; color-scheme: light only; font-weight: bold; color: rgb(69, 102, 142);">
                                                                                                <span
                                                                                                    style="box-sizing: inherit; line-height: 1.2;">M</span>
                                                                                            </td>
                                                                                            <td width="5"
                                                                                                style="box-sizing: inherit; width: 5px; font-size: 1pt; line-height: 0;">
                                                                                                &nbsp;</td>
                                                                                            <td
                                                                                                style="box-sizing: inherit; color-scheme: light only;">
                                                                                                <a href="tel:<?= h($emailSignature->mobile) ?>"
                                                                                                    target="_blank"
                                                                                                    style="box-sizing: inherit; color-scheme: light only; text-decoration-line: none;"><span
                                                                                                        data-acs="mobile"
                                                                                                        style="box-sizing: inherit; line-height: 1.2; color-scheme: light only; color: rgb(33, 33, 33); white-space: nowrap;"><?= h($emailSignature->mobile) ?></span></a>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                            <td
                                                                                style="box-sizing: inherit; line-height: 0px; padding-bottom: 6px;">
                                                                                <table class="ws-tpl-email"
                                                                                    cellpadding="0" cellspacing="0"
                                                                                    style="box-sizing: inherit; line-height: 14px; font-size: 12px;">
                                                                                    <tbody style="box-sizing: inherit;">
                                                                                        <tr
                                                                                            style="box-sizing: inherit;">
                                                                                            <td
                                                                                                style="box-sizing: inherit; padding: 0px 6px;">
                                                                                                <span
                                                                                                    style="box-sizing: inherit; color-scheme: light only; font-weight: bold; color: rgb(33, 33, 33);"></span>
                                                                                            </td>
                                                                                            <td
                                                                                                style="box-sizing: inherit; color-scheme: light only; font-weight: bold; color: rgb(69, 102, 142);">
                                                                                                <span
                                                                                                    style="box-sizing: inherit; line-height: 1.2;">E</span>
                                                                                            </td>
                                                                                            <td width="5"
                                                                                                style="box-sizing: inherit; width: 5px; font-size: 1pt; line-height: 0;">
                                                                                                &nbsp;</td>
                                                                                            <td
                                                                                                style="box-sizing: inherit; color-scheme: light only;">
                                                                                                <a href="mailto:<?= h($emailSignature->email) ?>"
                                                                                                    target="_blank"
                                                                                                    style="box-sizing: inherit; color-scheme: light only; text-decoration-line: none;"><span
                                                                                                        data-acs="email"
                                                                                                        style="box-sizing: inherit; line-height: 1.2; color-scheme: light only; color: rgb(33, 33, 33); white-space: nowrap;"><?= h($emailSignature->email) ?></span></a>
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
                                                            <td style="box-sizing: inherit;">
                                                                <table cellpadding="0" cellspacing="0"
                                                                    style="box-sizing: inherit;">
                                                                    <tbody style="box-sizing: inherit;">
                                                                        <tr style="box-sizing: inherit;">
                                                                            <td
                                                                                style="box-sizing: inherit; line-height: 0px; padding-bottom: 6px;">
                                                                                <table class="ws-tpl-website"
                                                                                    cellpadding="0" cellspacing="0"
                                                                                    style="box-sizing: inherit; line-height: 14px; font-size: 12px;">
                                                                                    <tbody style="box-sizing: inherit;">
                                                                                        <tr
                                                                                            style="box-sizing: inherit;">
                                                                                            <td
                                                                                                style="box-sizing: inherit; color-scheme: light only; font-weight: bold; color: rgb(69, 102, 142);">
                                                                                                <span
                                                                                                    style="box-sizing: inherit; line-height: 1.2;">W</span>
                                                                                            </td>
                                                                                            <td width="5"
                                                                                                style="box-sizing: inherit; width: 5px; font-size: 1pt; line-height: 0;">
                                                                                                &nbsp;</td>
                                                                                            <td
                                                                                                style="box-sizing: inherit; color-scheme: light only;">
                                                                                                <a href="http://www.<?= h($emailSignature->company_name) ?>.co/"
                                                                                                    target="_blank"
                                                                                                    style="box-sizing: inherit; color-scheme: light only; text-decoration-line: none;"><span
                                                                                                        data-acs="website"
                                                                                                        style="box-sizing: inherit; line-height: 1.2; color-scheme: light only; color: rgb(33, 33, 33); white-space: nowrap;"><?= h($emailSignature->website) ?></span></a>
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
                                                            <td style="box-sizing: inherit;">
                                                                <table cellpadding="0" cellspacing="0"
                                                                    style="box-sizing: inherit;">
                                                                    <tbody style="box-sizing: inherit;">
                                                                        <tr style="box-sizing: inherit;">
                                                                            <td
                                                                                style="box-sizing: inherit; line-height: 0px; padding-bottom: 6px;">
                                                                                <table class="ws-tpl-address"
                                                                                    cellpadding="0" cellspacing="0"
                                                                                    style="box-sizing: inherit; line-height: 14px; font-size: 12px;">
                                                                                    <tbody style="box-sizing: inherit;">
                                                                                        <tr
                                                                                            style="box-sizing: inherit;">
                                                                                            <td
                                                                                                style="box-sizing: inherit; color-scheme: light only; font-weight: bold; color: rgb(69, 102, 142);">
                                                                                                <span
                                                                                                    style="box-sizing: inherit; line-height: 1.2;">A</span>
                                                                                            </td>
                                                                                            <td width="5"
                                                                                                style="box-sizing: inherit; width: 5px; font-size: 1pt; line-height: 0;">
                                                                                                &nbsp;</td>
                                                                                            <td
                                                                                                style="box-sizing: inherit; color-scheme: light only;">
                                                                                                <span data-acs="address"
                                                                                                    style="box-sizing: inherit; color-scheme: light only; text-decoration-line: none; line-height: 1.2; color: rgb(33, 33, 33); white-space: nowrap;"><?= h($emailSignature->address) ?></span>
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
                            </td>
                        </tr>
                    </tbody>
                </table>
                <?php }elseif($emailSignature->template_id == 3){ ?>

                <table class="main_html"
                    style="box-sizing: inherit; color: rgb(25, 28, 43); font-family: Mulish, sans-serif; font-size: 16px; direction: ltr; border-radius: 0px;">
                    <tbody style="box-sizing: inherit;">
                        <tr style="box-sizing: inherit;">
                            <td style="box-sizing: inherit;">
                                <table cellpadding="0" cellspacing="0" class="ws-tpl"
                                    style="box-sizing: inherit; font-family: Arial; line-height: 1.25; padding-bottom: 10px; color: rgb(0, 0, 0); width: 445px;">
                                    <tbody style="box-sizing: inherit;">
                                        <tr style="box-sizing: inherit;">
                                            <td valign="top"
                                                style="box-sizing: inherit; vertical-align: top; padding-right: 14px;">
                                                <table cellpadding="0" cellspacing="0" class="ws-tpl-photo"
                                                    style="box-sizing: inherit;">
                                                    <tbody style="box-sizing: inherit;">
                                                        <tr style="box-sizing: inherit;">
                                                            <td style="box-sizing: inherit; width: 65px; padding: 0px;">
                                                                <img src="<?= $uploaded_path.$emailSignature->profile_photo ?>"
                                                                    height="68.68884540117416" width="65"
                                                                    style="box-sizing: inherit; width: 65px; height: 68.6888px; vertical-align: initial; border-radius: 0px; display: block;">
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                            <td valign="top" style="box-sizing: inherit; width: 366px;">
                                                <table cellpadding="0" cellspacing="0"
                                                    style="box-sizing: inherit; width: 366px;">
                                                    <tbody style="box-sizing: inherit;">
                                                        <tr style="box-sizing: inherit;">
                                                            <td style="box-sizing: inherit; line-height: 0px;">
                                                                <table cellpadding="0" cellspacing="0"
                                                                    style="box-sizing: inherit; width: 366px;">
                                                                    <tbody style="box-sizing: inherit;">
                                                                        <tr style="box-sizing: inherit;">
                                                                            <td width="100%"
                                                                                style="box-sizing: inherit; width: 196px; line-height: 0px;">
                                                                                <table cellpadding="0" cellspacing="0"
                                                                                    style="box-sizing: inherit; width: 196px;">
                                                                                    <tbody style="box-sizing: inherit;">
                                                                                        <tr
                                                                                            style="box-sizing: inherit;">
                                                                                            <td
                                                                                                style="box-sizing: inherit; line-height: 16.8px;">
                                                                                                <p
                                                                                                    style="box-sizing: inherit; margin-right: 0px; margin-bottom: 0px; margin-left: 0px;">
                                                                                                    <span
                                                                                                        class="ws-tpl-name"
                                                                                                        data-acs="name"
                                                                                                        style="box-sizing: inherit; color-scheme: light only; color: rgb(69, 102, 142); font-size: 13.8px; font-weight: bold;"><?= h($emailSignature->name) ?></span><br
                                                                                                        style="box-sizing: inherit;"><span
                                                                                                        class="ws-tpl-title"
                                                                                                        data-acs="title"
                                                                                                        style="box-sizing: inherit; color-scheme: light only; font-size: 12px; letter-spacing: 0px; color: rgb(68, 68, 68); text-transform: initial;"><?= h($emailSignature->title) ?>,</span>&nbsp;<span
                                                                                                        class="ws-tpl-company"
                                                                                                        data-acs="company"
                                                                                                        style="box-sizing: inherit; color-scheme: light only; font-size: 12px; letter-spacing: 0px; color: rgb(68, 68, 68); text-transform: initial;"><?= h($emailSignature->company_name) ?></span>
                                                                                                </p>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                            <td valign="bottom"
                                                                                style="box-sizing: inherit; vertical-align: bottom; padding: 0px 0px 1px 50px; line-height: 0px;">
                                                                                <table class="ws-tpl-social"
                                                                                    cellpadding="0" cellspacing="0"
                                                                                    align="right"
                                                                                    style="box-sizing: inherit; float: right; width: 120px;">
                                                                                    <tbody style="box-sizing: inherit;">
                                                                                        <tr
                                                                                            style="box-sizing: inherit;">
                                                                                            <td
                                                                                                style="box-sizing: inherit;">
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
                                                            <td colspan="2" class="ws-tpl-separator"
                                                                style="box-sizing: inherit; line-height: 0;">
                                                                <table cellpadding="0" cellspacing="0" width="100%"
                                                                    style="box-sizing: inherit; width: 366px;">
                                                                    <tbody style="box-sizing: inherit;">
                                                                        <tr style="box-sizing: inherit;">
                                                                            <td
                                                                                style="box-sizing: inherit; height: 13px; font-size: 1pt; line-height: 0px;">
                                                                                &nbsp;</td>
                                                                        </tr>
                                                                        <tr style="box-sizing: inherit;">
                                                                            <td
                                                                                style="box-sizing: inherit; margin: 0px; height: 1px; border-top: 1px solid rgb(189, 189, 189); font-size: 1pt; line-height: 0px;">
                                                                                &nbsp;</td>
                                                                        </tr>
                                                                        <tr style="box-sizing: inherit;">
                                                                            <td
                                                                                style="box-sizing: inherit; height: 14px; font-size: 1pt; line-height: 0px;">
                                                                                &nbsp;</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr style="box-sizing: inherit;">
                                                            <td style="box-sizing: inherit; line-height: 0;">
                                                                <table cellpadding="0" cellspacing="0"
                                                                    style="box-sizing: inherit;">
                                                                    <tbody style="box-sizing: inherit;">
                                                                        <tr style="box-sizing: inherit;">
                                                                            <td style="box-sizing: inherit;">
                                                                                <table cellpadding="0" cellspacing="0"
                                                                                    style="box-sizing: inherit;">
                                                                                    <tbody style="box-sizing: inherit;">
                                                                                        <tr
                                                                                            style="box-sizing: inherit;">
                                                                                            <td
                                                                                                style="box-sizing: inherit; line-height: 0px; padding-bottom: 6px;">
                                                                                                <table
                                                                                                    class="ws-tpl-phone"
                                                                                                    cellpadding="0"
                                                                                                    cellspacing="0"
                                                                                                    style="box-sizing: inherit; line-height: 14px; font-size: 12px;">
                                                                                                    <tbody
                                                                                                        style="box-sizing: inherit;">
                                                                                                        <tr
                                                                                                            style="box-sizing: inherit;">
                                                                                                            <td
                                                                                                                style="box-sizing: inherit; color-scheme: light only; font-weight: bold; color: rgb(69, 102, 142);">
                                                                                                                <img src="https://cdn.gifo.wisestamp.com/social/phone/45668E/13/trans.png"
                                                                                                                    style="box-sizing: inherit; vertical-align: -2px; line-height: 1.2;">
                                                                                                            </td>
                                                                                                            <td width="5"
                                                                                                                style="box-sizing: inherit; width: 5px; font-size: 1pt; line-height: 0;">
                                                                                                                &nbsp;
                                                                                                            </td>
                                                                                                            <td
                                                                                                                style="box-sizing: inherit; color-scheme: light only;">
                                                                                                                <a href="tel:<?= h($emailSignature->phone) ?>"
                                                                                                                    target="_blank"
                                                                                                                    style="box-sizing: inherit; color-scheme: light only; text-decoration-line: none;"><span
                                                                                                                        data-acs="phone"
                                                                                                                        style="box-sizing: inherit; line-height: 1.2; color-scheme: light only; color: rgb(33, 33, 33); white-space: nowrap;"><?= h($emailSignature->phone) ?></span></a>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </td>
                                                                                            <td
                                                                                                style="box-sizing: inherit; line-height: 0px; padding-bottom: 6px;">
                                                                                                <table
                                                                                                    class="ws-tpl-mobile"
                                                                                                    cellpadding="0"
                                                                                                    cellspacing="0"
                                                                                                    style="box-sizing: inherit; line-height: 14px; font-size: 12px;">
                                                                                                    <tbody
                                                                                                        style="box-sizing: inherit;">
                                                                                                        <tr
                                                                                                            style="box-sizing: inherit;">
                                                                                                            <td
                                                                                                                style="box-sizing: inherit; padding: 0px 6px;">
                                                                                                                <span
                                                                                                                    style="box-sizing: inherit; color-scheme: light only; font-weight: bold; color: rgb(33, 33, 33);"></span>
                                                                                                            </td>
                                                                                                            <td
                                                                                                                style="box-sizing: inherit; color-scheme: light only; font-weight: bold; color: rgb(69, 102, 142);">
                                                                                                                <img src="https://cdn.gifo.wisestamp.com/social/mobile/45668E/13/trans.png"
                                                                                                                    style="box-sizing: inherit; vertical-align: -2px; line-height: 1.2;">
                                                                                                            </td>
                                                                                                            <td width="5"
                                                                                                                style="box-sizing: inherit; width: 5px; font-size: 1pt; line-height: 0;">
                                                                                                                &nbsp;
                                                                                                            </td>
                                                                                                            <td
                                                                                                                style="box-sizing: inherit; color-scheme: light only;">
                                                                                                                <a href="tel:<?= h($emailSignature->mobile) ?>"
                                                                                                                    target="_blank"
                                                                                                                    style="box-sizing: inherit; color-scheme: light only; text-decoration-line: none;"><span
                                                                                                                        data-acs="mobile"
                                                                                                                        style="box-sizing: inherit; line-height: 1.2; color-scheme: light only; color: rgb(33, 33, 33); white-space: nowrap;"><?= h($emailSignature->mobile) ?></span></a>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </td>
                                                                                            <td
                                                                                                style="box-sizing: inherit; line-height: 0px; padding-bottom: 6px;">
                                                                                                <table
                                                                                                    class="ws-tpl-email"
                                                                                                    cellpadding="0"
                                                                                                    cellspacing="0"
                                                                                                    style="box-sizing: inherit; line-height: 14px; font-size: 12px;">
                                                                                                    <tbody
                                                                                                        style="box-sizing: inherit;">
                                                                                                        <tr
                                                                                                            style="box-sizing: inherit;">
                                                                                                            <td
                                                                                                                style="box-sizing: inherit; padding: 0px 6px;">
                                                                                                                <span
                                                                                                                    style="box-sizing: inherit; color-scheme: light only; font-weight: bold; color: rgb(33, 33, 33);"></span>
                                                                                                            </td>
                                                                                                            <td
                                                                                                                style="box-sizing: inherit; color-scheme: light only; font-weight: bold; color: rgb(69, 102, 142);">
                                                                                                                <img src="https://cdn.gifo.wisestamp.com/social/envelope/45668E/13/trans.png"
                                                                                                                    style="box-sizing: inherit; vertical-align: -2px; line-height: 1.2;">
                                                                                                            </td>
                                                                                                            <td width="5"
                                                                                                                style="box-sizing: inherit; width: 5px; font-size: 1pt; line-height: 0;">
                                                                                                                &nbsp;
                                                                                                            </td>
                                                                                                            <td
                                                                                                                style="box-sizing: inherit; color-scheme: light only;">
                                                                                                                <a href="mailto:<?= h($emailSignature->signature_email) ?>"
                                                                                                                    target="_blank"
                                                                                                                    style="box-sizing: inherit; color-scheme: light only; text-decoration-line: none;"><span
                                                                                                                        data-acs="email"
                                                                                                                        style="box-sizing: inherit; line-height: 1.2; color-scheme: light only; color: rgb(33, 33, 33); white-space: nowrap;"><?= h($emailSignature->signature_email) ?></span></a>
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
                                                                            <td style="box-sizing: inherit;">
                                                                                <table cellpadding="0" cellspacing="0"
                                                                                    style="box-sizing: inherit;">
                                                                                    <tbody style="box-sizing: inherit;">
                                                                                        <tr
                                                                                            style="box-sizing: inherit;">
                                                                                            <td
                                                                                                style="box-sizing: inherit; line-height: 0px; padding-bottom: 6px;">
                                                                                                <table
                                                                                                    class="ws-tpl-website"
                                                                                                    cellpadding="0"
                                                                                                    cellspacing="0"
                                                                                                    style="box-sizing: inherit; line-height: 14px; font-size: 12px;">
                                                                                                    <tbody
                                                                                                        style="box-sizing: inherit;">
                                                                                                        <tr
                                                                                                            style="box-sizing: inherit;">
                                                                                                            <td
                                                                                                                style="box-sizing: inherit; color-scheme: light only; font-weight: bold; color: rgb(69, 102, 142);">
                                                                                                                <img src="https://cdn.gifo.wisestamp.com/social/browser/45668E/13/trans.png"
                                                                                                                    style="box-sizing: inherit; vertical-align: -2px; line-height: 1.2;">
                                                                                                            </td>
                                                                                                            <td width="5"
                                                                                                                style="box-sizing: inherit; width: 5px; font-size: 1pt; line-height: 0;">
                                                                                                                &nbsp;
                                                                                                            </td>
                                                                                                            <td
                                                                                                                style="box-sizing: inherit; color-scheme: light only;">
                                                                                                                <a href="http://www.<?= h($emailSignature->company_name) ?>.co/"
                                                                                                                    target="_blank"
                                                                                                                    style="box-sizing: inherit; color-scheme: light only; text-decoration-line: none;"><span
                                                                                                                        data-acs="website"
                                                                                                                        style="box-sizing: inherit; line-height: 1.2; color-scheme: light only; color: rgb(33, 33, 33); white-space: nowrap;"><?= h($emailSignature->website) ?></span></a>
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
                                                                            <td style="box-sizing: inherit;">
                                                                                <table cellpadding="0" cellspacing="0"
                                                                                    style="box-sizing: inherit;">
                                                                                    <tbody style="box-sizing: inherit;">
                                                                                        <tr
                                                                                            style="box-sizing: inherit;">
                                                                                            <td
                                                                                                style="box-sizing: inherit; line-height: 0px; padding-bottom: 6px;">
                                                                                                <table
                                                                                                    class="ws-tpl-address"
                                                                                                    cellpadding="0"
                                                                                                    cellspacing="0"
                                                                                                    style="box-sizing: inherit; line-height: 14px; font-size: 12px;">
                                                                                                    <tbody
                                                                                                        style="box-sizing: inherit;">
                                                                                                        <tr
                                                                                                            style="box-sizing: inherit;">
                                                                                                            <td
                                                                                                                style="box-sizing: inherit; color-scheme: light only; font-weight: bold; color: rgb(69, 102, 142);">
                                                                                                                <img src="https://cdn.gifo.wisestamp.com/social/map/45668E/13/trans.png"
                                                                                                                    style="box-sizing: inherit; vertical-align: -2px; line-height: 1.2;">
                                                                                                            </td>
                                                                                                            <td width="5"
                                                                                                                style="box-sizing: inherit; width: 5px; font-size: 1pt; line-height: 0;">
                                                                                                                &nbsp;
                                                                                                            </td>
                                                                                                            <td
                                                                                                                style="box-sizing: inherit; color-scheme: light only;">
                                                                                                                <a href="https://maps.google.com/?q=199/1,%20west%20coast%20Join%20Harber,%20New%20Wells"
                                                                                                                    target="_blank"
                                                                                                                    style="box-sizing: inherit; color-scheme: light only; text-decoration-line: none;"><span
                                                                                                                        data-acs="address"
                                                                                                                        style="box-sizing: inherit; line-height: 1.2; color-scheme: light only; color: rgb(33, 33, 33); white-space: nowrap;"><?= h($emailSignature->address) ?></span></a>
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
                                                        <tr style="box-sizing: inherit;">
                                                            <td colspan="2" class="ws-tpl-separator"
                                                                style="box-sizing: inherit; line-height: 0;">
                                                                <table cellpadding="0" cellspacing="0" width="100%"
                                                                    style="box-sizing: inherit; width: 366px;">
                                                                    <tbody style="box-sizing: inherit;">
                                                                        <tr style="box-sizing: inherit;">
                                                                            <td
                                                                                style="box-sizing: inherit; height: 8px; font-size: 1pt;">
                                                                                &nbsp;</td>
                                                                        </tr>
                                                                        <tr style="box-sizing: inherit;">
                                                                            <td
                                                                                style="box-sizing: inherit; margin: 0px; height: 1px; line-height: 0px; border-top: 1px solid rgb(189, 189, 189); font-size: 1pt;">
                                                                                &nbsp;</td>
                                                                        </tr>
                                                                        <tr style="box-sizing: inherit;">
                                                                            <td
                                                                                style="box-sizing: inherit; height: 8px; font-size: 1pt;">
                                                                                &nbsp;</td>
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
                <table
                    style="box-sizing: inherit; color: rgb(25, 28, 43); font-family: Mulish, sans-serif; font-size: 16px; opacity: 0 !important;">
                    <tbody style="box-sizing: inherit;">
                        <tr style="box-sizing: inherit;">
                            <td height="1" width="1"
                                style="box-sizing: inherit; height: 1px !important; width: 1px !important;">‌<br><br>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <?php }elseif($emailSignature->template_id == 4){ ?>

                <table class="main_html"
                    style="box-sizing: inherit; color: rgb(25, 28, 43); font-family: Mulish, sans-serif; font-size: 16px; direction: ltr; border-radius: 0px;">
                    <tbody style="box-sizing: inherit;">
                        <tr style="box-sizing: inherit;">
                            <td style="box-sizing: inherit;">
                                <table cellpadding="0" cellspacing="0" class="ws-tpl"
                                    style="box-sizing: inherit; font-family: Arial; line-height: 1.15; padding-bottom: 10px; color: rgb(0, 0, 0);">
                                    <tbody style="box-sizing: inherit;">
                                        <tr style="box-sizing: inherit;">
                                            <td valign="top"
                                                style="box-sizing: inherit; vertical-align: top; padding-right: 16px; line-height: 0px;">
                                                <table cellpadding="0" cellspacing="0" class="ws-tpl-photo"
                                                    style="box-sizing: inherit; line-height: 1.2;">
                                                    <tbody style="box-sizing: inherit;">
                                                        <tr style="box-sizing: inherit;">
                                                            <td style="box-sizing: inherit; width: 65px; padding: 0px;">
                                                                <img src="<?= $uploaded_path.$emailSignature->profile_photo ?>"
                                                                    height="68.68884540117416" alt="photo" width="65"
                                                                    style="box-sizing: inherit; width: 65px; vertical-align: initial; border-radius: 50%; display: block; height: 68.6888px;">
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                            <td valign="top"
                                                style="box-sizing: inherit; vertical-align: top; line-height: 0px;">
                                                <table cellpadding="0" cellspacing="0"
                                                    style="box-sizing: inherit; line-height: 1.2;">
                                                    <tbody style="box-sizing: inherit;">
                                                        <tr style="box-sizing: inherit;">
                                                            <td valign="top"
                                                                style="box-sizing: inherit; vertical-align: top; padding-right: 45px; line-height: 1.2;">
                                                                <span class="ws-tpl-name" data-acs="name"
                                                                    style="box-sizing: inherit; color: rgb(69, 102, 142); text-transform: initial; font-weight: bold;"><?= h($emailSignature->name) ?></span><br
                                                                    style="box-sizing: inherit;"><span
                                                                    class="ws-tpl-title" data-acs="title"
                                                                    style="box-sizing: inherit; font-size: 12px; letter-spacing: 0px; text-transform: initial; color: rgb(51, 51, 51);"><?= h($emailSignature->title) ?></span><br
                                                                    style="box-sizing: inherit;"><span
                                                                    class="ws-tpl-company" data-acs="company"
                                                                    style="box-sizing: inherit; font-size: 12px; letter-spacing: 0px; text-transform: initial; font-weight: bold; color: rgb(68, 68, 68);"><?= h($emailSignature->company_name) ?></span>
                                                            </td>
                                                            <td valign="top"
                                                                style="box-sizing: inherit; vertical-align: top; line-height: 0px;">
                                                                <table cellpadding="0" cellspacing="0"
                                                                    style="box-sizing: inherit; font-size: 12px; line-height: 1.2;">
                                                                    <tbody style="box-sizing: inherit;">
                                                                        <tr style="box-sizing: inherit;">
                                                                            <td
                                                                                style="box-sizing: inherit; line-height: 0;">
                                                                                <table cellpadding="0" cellspacing="0"
                                                                                    style="box-sizing: inherit;">
                                                                                    <tbody style="box-sizing: inherit;">
                                                                                        <tr
                                                                                            style="box-sizing: inherit;">
                                                                                            <td
                                                                                                style="box-sizing: inherit; line-height: 0px; padding-bottom: 6px;">
                                                                                                <table
                                                                                                    class="ws-tpl-phone"
                                                                                                    cellpadding="0"
                                                                                                    cellspacing="0"
                                                                                                    style="box-sizing: inherit; line-height: 14px;">
                                                                                                    <tbody
                                                                                                        style="box-sizing: inherit;">
                                                                                                        <tr
                                                                                                            style="box-sizing: inherit;">
                                                                                                            <td
                                                                                                                style="box-sizing: inherit; color-scheme: light only; font-weight: bold; color: rgb(69, 102, 142);">
                                                                                                                <img src="https://cdn.gifo.wisestamp.com/social/phone/45668E/13/trans.png"
                                                                                                                    style="box-sizing: inherit; vertical-align: -2px; line-height: 1.2;">
                                                                                                            </td>
                                                                                                            <td width="5"
                                                                                                                style="box-sizing: inherit; width: 5px; font-size: 1pt; line-height: 0;">
                                                                                                                &nbsp;
                                                                                                            </td>
                                                                                                            <td
                                                                                                                style="box-sizing: inherit; color-scheme: light only;">
                                                                                                                <a href="tel:<?= h($emailSignature->phone) ?>"
                                                                                                                    target="_blank"
                                                                                                                    style="box-sizing: inherit; color-scheme: light only; text-decoration-line: none;"><span
                                                                                                                        data-acs="phone"
                                                                                                                        style="box-sizing: inherit; line-height: 1.2; color-scheme: light only; color: rgb(33, 33, 33); white-space: nowrap;"><?= h($emailSignature->phone) ?></span></a>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr
                                                                                            style="box-sizing: inherit;">
                                                                                            <td
                                                                                                style="box-sizing: inherit; line-height: 0px; padding-bottom: 6px;">
                                                                                                <table
                                                                                                    class="ws-tpl-mobile"
                                                                                                    cellpadding="0"
                                                                                                    cellspacing="0"
                                                                                                    style="box-sizing: inherit; line-height: 14px;">
                                                                                                    <tbody
                                                                                                        style="box-sizing: inherit;">
                                                                                                        <tr
                                                                                                            style="box-sizing: inherit;">
                                                                                                            <td
                                                                                                                style="box-sizing: inherit; color-scheme: light only; font-weight: bold; color: rgb(69, 102, 142);">
                                                                                                                <img src="https://cdn.gifo.wisestamp.com/social/mobile/45668E/13/trans.png"
                                                                                                                    style="box-sizing: inherit; vertical-align: -2px; line-height: 1.2;">
                                                                                                            </td>
                                                                                                            <td width="5"
                                                                                                                style="box-sizing: inherit; width: 5px; font-size: 1pt; line-height: 0;">
                                                                                                                &nbsp;
                                                                                                            </td>
                                                                                                            <td
                                                                                                                style="box-sizing: inherit; color-scheme: light only;">
                                                                                                                <a href="tel:<?= h($emailSignature->mobile) ?>"
                                                                                                                    target="_blank"
                                                                                                                    style="box-sizing: inherit; color-scheme: light only; text-decoration-line: none;"><span
                                                                                                                        data-acs="mobile"
                                                                                                                        style="box-sizing: inherit; line-height: 1.2; color-scheme: light only; color: rgb(33, 33, 33); white-space: nowrap;"><?= h($emailSignature->mobile) ?></span></a>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr
                                                                                            style="box-sizing: inherit;">
                                                                                            <td
                                                                                                style="box-sizing: inherit; line-height: 0px; padding-bottom: 6px;">
                                                                                                <table
                                                                                                    class="ws-tpl-email"
                                                                                                    cellpadding="0"
                                                                                                    cellspacing="0"
                                                                                                    style="box-sizing: inherit; line-height: 14px;">
                                                                                                    <tbody
                                                                                                        style="box-sizing: inherit;">
                                                                                                        <tr
                                                                                                            style="box-sizing: inherit;">
                                                                                                            <td
                                                                                                                style="box-sizing: inherit; color-scheme: light only; font-weight: bold; color: rgb(69, 102, 142);">
                                                                                                                <img src="https://cdn.gifo.wisestamp.com/social/envelope/45668E/13/trans.png"
                                                                                                                    style="box-sizing: inherit; vertical-align: -2px; line-height: 1.2;">
                                                                                                            </td>
                                                                                                            <td width="5"
                                                                                                                style="box-sizing: inherit; width: 5px; font-size: 1pt; line-height: 0;">
                                                                                                                &nbsp;
                                                                                                            </td>
                                                                                                            <td
                                                                                                                style="box-sizing: inherit; color-scheme: light only;">
                                                                                                                <a href="mailto:<?= h($emailSignature->email) ?>"
                                                                                                                    target="_blank"
                                                                                                                    style="box-sizing: inherit; color-scheme: light only; text-decoration-line: none;"><span
                                                                                                                        data-acs="email"
                                                                                                                        style="box-sizing: inherit; line-height: 1.2; color-scheme: light only; color: rgb(33, 33, 33); white-space: nowrap;"><?= h($emailSignature->email) ?></span></a>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr
                                                                                            style="box-sizing: inherit;">
                                                                                            <td
                                                                                                style="box-sizing: inherit; line-height: 0px; padding-bottom: 6px;">
                                                                                                <table
                                                                                                    class="ws-tpl-website"
                                                                                                    cellpadding="0"
                                                                                                    cellspacing="0"
                                                                                                    style="box-sizing: inherit; line-height: 14px;">
                                                                                                    <tbody
                                                                                                        style="box-sizing: inherit;">
                                                                                                        <tr
                                                                                                            style="box-sizing: inherit;">
                                                                                                            <td
                                                                                                                style="box-sizing: inherit; color-scheme: light only; font-weight: bold; color: rgb(69, 102, 142);">
                                                                                                                <img src="https://cdn.gifo.wisestamp.com/social/browser/45668E/13/trans.png"
                                                                                                                    style="box-sizing: inherit; vertical-align: -2px; line-height: 1.2;">
                                                                                                            </td>
                                                                                                            <td width="5"
                                                                                                                style="box-sizing: inherit; width: 5px; font-size: 1pt; line-height: 0;">
                                                                                                                &nbsp;
                                                                                                            </td>
                                                                                                            <td
                                                                                                                style="box-sizing: inherit; color-scheme: light only;">
                                                                                                                <a href="http://www.<?= h($emailSignature->company_name) ?>.co/"
                                                                                                                    target="_blank"
                                                                                                                    style="box-sizing: inherit; color-scheme: light only; text-decoration-line: none;"><span
                                                                                                                        data-acs="website"
                                                                                                                        style="box-sizing: inherit; line-height: 1.2; color-scheme: light only; color: rgb(33, 33, 33); white-space: nowrap;"><?= h($emailSignature->website) ?></span></a>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr
                                                                                            style="box-sizing: inherit;">
                                                                                            <td
                                                                                                style="box-sizing: inherit; line-height: 0px; padding-bottom: 6px;">
                                                                                                <table
                                                                                                    class="ws-tpl-address"
                                                                                                    cellpadding="0"
                                                                                                    cellspacing="0"
                                                                                                    style="box-sizing: inherit; line-height: 14px;">
                                                                                                    <tbody
                                                                                                        style="box-sizing: inherit;">
                                                                                                        <tr
                                                                                                            style="box-sizing: inherit;">
                                                                                                            <td
                                                                                                                style="box-sizing: inherit; color-scheme: light only; font-weight: bold; color: rgb(69, 102, 142);">
                                                                                                                <img src="https://cdn.gifo.wisestamp.com/social/map/45668E/13/trans.png"
                                                                                                                    style="box-sizing: inherit; vertical-align: -2px; line-height: 1.2;">
                                                                                                            </td>
                                                                                                            <td width="5"
                                                                                                                style="box-sizing: inherit; width: 5px; font-size: 1pt; line-height: 0;">
                                                                                                                &nbsp;
                                                                                                            </td>
                                                                                                            <td
                                                                                                                style="box-sizing: inherit; color-scheme: light only;">
                                                                                                                <a href="https://maps.google.com/?q=199/1,%20west%20coast%20Join%20Harber,%20New%20Wells"
                                                                                                                    target="_blank"
                                                                                                                    style="box-sizing: inherit; color-scheme: light only; text-decoration-line: none;"><span
                                                                                                                        data-acs="address"
                                                                                                                        style="box-sizing: inherit; line-height: 1.2; color-scheme: light only; color: rgb(33, 33, 33); white-space: nowrap;"><?= h($emailSignature->address) ?></span></a>
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
                                                                            <td
                                                                                style="box-sizing: inherit; padding-top: 8px; line-height: 0px;">
                                                                                <table class="ws-tpl-social"
                                                                                    cellpadding="0" cellspacing="0"
                                                                                    style="box-sizing: inherit; width: 240px; line-height: 1.2;">
                                                                                    <tbody style="box-sizing: inherit;">
                                                                                        <tr
                                                                                            style="box-sizing: inherit;">
                                                                                            <td
                                                                                                style="box-sizing: inherit;">
                                                                                                <br>
                                                                                                <div
                                                                                                    style="box-sizing: inherit; height: 1px !important;">
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
                <table
                    style="box-sizing: inherit; color: rgb(25, 28, 43); font-family: Mulish, sans-serif; font-size: 16px; opacity: 0 !important;">
                    <tbody style="box-sizing: inherit;">
                        <tr style="box-sizing: inherit;">
                            <td height="1" width="1"
                                style="box-sizing: inherit; height: 1px !important; width: 1px !important;">‌<br><br>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <?php } ?>
            </div>
        </div>
    </div>

</div>