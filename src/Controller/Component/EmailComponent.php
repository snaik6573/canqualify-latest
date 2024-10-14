<?php
namespace App\Controller\Component;

require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use Aws\Ses\SesClient;
use Aws\Exception\AwsException;
use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
/**
 * Email component
 */
class EmailComponent extends Component
{

    public function startEmail(){

         $SesClient = new SesClient([
            // 'profile' => 'default',
            'version' => '2010-12-01',
            'region'  => 'us-east-1',
            'credentials' => [
                      'key'    => 'AKIAXLWV2NB4WLF5RZW3',
                      'secret' => 'u4sC3iWilS6whTlZd6E8K7YMMqOuY3Hg6bDEe51k',
                  ],
        ]);

        // Replace sender@example.com with your "From" address.
        // This address must be verified with Amazon SES.
        $sender_email = 'info@canqualify.com';  // info@canqualify.com or support@canqualify.com

        // Replace these sample addresses with the addresses of your recipients. If
        // your account is still in the sandbox, these addresses must be verified.
        $recipient_emails = ['arundhati.lambore@canqualify.com']; // Suppliers list

        // Specify a configuration set. If you do not want to use a configuration
        // set, comment the following variable, and the
        // 'ConfigurationSetName' => $configuration_set argument below.
        //$configuration_set = 'ConfigSet';

        $subject = 'Amazon SES test (AWS SDK for PHP)';   //subject
        $plaintext_body = 'This email was sent with Amazon SES using the AWS SDK for PHP.' ;
        $html_body =  '';
        $char_set = 'UTF-8';

        try {
            $result = $SesClient->sendEmail([
                'Destination' => [
                    'ToAddresses' => $recipient_emails,
                ],
                'ReplyToAddresses' => [$sender_email],
                'Source' => $sender_email,
                'Message' => [
                  'Body' => [
                      'Html' => [
                          'Charset' => $char_set,
                          'Data' => $html_body,
                      ],
                      'Text' => [
                          'Charset' => $char_set,
                          'Data' => $plaintext_body,
                      ],
                  ],
                  'Subject' => [
                      'Charset' => $char_set,
                      'Data' => $subject,
                  ],
                ],
                // If you aren't using a configuration set, comment or delete the
                // following line
                // 'ConfigurationSetName' => $configuration_set,
            ]);
            $messageId = $result['MessageId'];
            echo("Email sent! Message ID: $messageId"."\n");
        } catch (AwsException $e) {
            // output error message if fails
            echo $e->getMessage();
            echo("The email was not sent. Error message: ".$e->getAwsErrorMessage()."\n");
            echo "\n";
        }

    }
    public function beginEmail($id,$to,$from,$cc,$subject,$htmlbody,$mail_attach){

        // pr($to); pr($from); pr($cc);pr($subject);    pr($htmlbody); 
        // die();
        $uploaded_path = Configure::read('uploaded_path');
        $message= '';
        $emailQueues = TableRegistry::get('EmailQueues');
        $SesClient = new SesClient([
            // 'profile' => 'default',
            'version' => '2010-12-01',
            'region'  => 'us-east-1',
            'credentials' => [
                      'key'    => 'AKIAXLWV2NB4WLF5RZW3',
                      'secret' => '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',
                  ],
        
        ]);

        $headerPart ='
                <div id="m_-5182915800725953308body_style" style="background-color:#f7f7f7;">
                    <table width="100%" bgcolor="#f1f2f7" cellpadding="0" cellspacing="0" border="0" style="text-align:center">
                        <tbody>
                             <tr>
                                <td>
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
                                                                                <td height="35" style="font-size:1px;line-height:1px">&nbsp;</td>
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
                                                                <td class="m_-4817871311969497422content" id="m_-4817871311969497422edit_text_1" style="font-family:"Proxima Nova",Calibri,Helvetica,sans-serif;font-size:16px;color:#505050;text-align:left;line-height:25.6px;font-weight:normal;text-transform:none">
';
$footerPart=' </td>
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
                                                                                <td style="font-family:"Proxima Nova",Calibri,Helvetica,sans-serif;font-size:12px;color:#808080;font-weight:normal;text-align:center;line-height:150%">
                                                                                    <div align="center">
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
                                     
            
                </table>
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
                                                    <td height="35" style="font-size:1px;line-height:1px">&nbsp;</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>';

        $htmlcontent = $headerPart.''.$htmlbody.''.$footerPart;

                    // Create a new PHPMailer object.
            $mail = new PHPMailer;

            // Add components to the email.
            $mail->setFrom(implode(",",$from));
            $mail->addAddress($to);  //recipient address
            $mail->Subject = $subject;
            $mail->Body = $htmlcontent;
            $mail->AltBody = $htmlbody;
            // $mail->addAttachment('C:\Users\APK911\Desktop\nik.xlsx');      
            if($mail_attach != null){
                foreach ($mail_attach as $key => $attachments) {
                    if($attachments !=null){
                    $mail->addStringAttachment(file_get_contents($uploaded_path.$attachments), $attachments);
                }
                }
            }
         // pr($mail); die();

            // $mail->addAttachment($att);
            // $mail->addCustomHeader('X-SES-CONFIGURATION-SET', $configset);

            // Attempt to assemble the above components into a MIME message.
            if (!$mail->preSend()) {
                echo $mail->ErrorInfo;
            } else {
                // Create a new variable that contains the MIME message.
                $message = $mail->getSentMIMEMessage();
            }
         // pr($message); die();
                        try {
                             $result = $SesClient->sendRawEmail([
                    'RawMessage' => [
                        'Data' => $message
                    ]
                ]);
               $messageId = $result['MessageId'];
               $query = $emailQueues->query();
               $query->update()->set(['response_id' => $messageId])->where(['id' => $id])->execute();
            // echo("Email sent! Message ID: $messageId"."\n");
            } catch (AwsException $e) {
                // output error message if fails
                echo $e->getMessage();
                echo "\n";
            }
 
    }


}
