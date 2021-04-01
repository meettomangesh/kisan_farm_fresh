<?php

/**
 * The helper library class for Data related functionality
 *
 *
 * @author 
 * @package Admin
 * @since 1.0
 */

namespace App\Helper;

use Illuminate\Support\Facades\File;
use App\Models\CustomerLoyalty;
use PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class EmailHelper
{


    public static function send($emailData)
    {
        try {
            $subject = !empty($emailData['subject']) ? $emailData['subject'] : '';
            $message = !empty($emailData['message']) ? $emailData['message'] : '';
            $fromName = !empty($emailData['from']['name']) ? $emailData['from']['name'] : config('services.ses.fromname');

            $mail = new PHPMailer\PHPMailer(); // create a n
            $mail->isSMTP();
            $mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
            $mail->SMTPAuth = true; // authentication enabled
            $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
            $mail->Host = config('services.ses.host');
            $mail->Port = 465; // or 587
            $mail->IsHTML(true);
            $mail->Username = config('services.ses.username');
            $mail->Password = config('services.ses.password');
            $mail->SetFrom(config('services.ses.email'), $fromName, 0);
            $mail->Subject = $subject;
            $mail->Body = $message;
            if (!empty($emailData['to'])) {
                foreach ($emailData['to'] as $key => $toEmailInfo) {
                    $mail->AddAddress($toEmailInfo['email']);
                }
            }
            if (!empty($emailData['attachment'])) {
                foreach ($emailData['attachment'] as $key => $value) {
                    $mail->addAttachment($value['attachment']);
                }             
            }


            if ($mail->Send()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            //throw new Exception($e->getMessage());
            return false;
        }
    }

    // public static function sendBulk($emailData)
    // {

    //     try {
    //         $subject = !empty($emailData['subject']) ? $emailData['subject'] : '';
    //         $message = !empty($emailData['message']) ? $emailData['message'] : '';
    //         $fromName = !empty($emailData['from']['name']) ? $emailData['from']['name'] : config('services.ses.fromname') ;

    //         $mail = new PHPMailer\PHPMailer(); // create a n
    //         $mail->isSMTP();
    //         $mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
    //         $mail->SMTPAuth = true; // authentication enabled
    //         $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
    //         $mail->Host = config('services.ses.host');
    //         $mail->Port = 465; // or 587
    //         $mail->IsHTML(true);
    //         $mail->Username = config('services.ses.username');
    //         $mail->Password = config('services.ses.password');
    //         $mail->SetFrom(config('services.ses.email'), $fromName, 0);
    //         $mail->Subject = $subject;
    //         $mail->Body = $message;
    //         if (!empty($emailData['to'])) {
    //             foreach ($emailData['to'] as $key => $toEmailInfo) {
    //                 $mail->AddAddress($toEmailInfo['email']);
    //             }
    //         }

    //         if ($mail->Send()) {
    //             return true;
    //         } else {
    //             return false;
    //         }

    //     } catch (Exception $e) {
    //         //throw new Exception($e->getMessage());
    //         return false;
    //     }

    // }


    // public static function sendMessage($subject, $message, $toEmail, $toName = null, $fromEmail = null, $fromName = null, $isHtml = true, $deliveryTime = '', $tags = [], $campaignId = '')
    // {
    //     try {
    //         $fromName = !empty($fromName) ? $fromName : config('services.ses.fromname') ;

    //         $mail = new PHPMailer\PHPMailer(); // create a n
    //         $mail->isSMTP();
    //         $mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
    //         $mail->SMTPAuth = true; // authentication enabled
    //         $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
    //         $mail->Host = config('services.ses.host');
    //         $mail->Port = 465; // or 587
    //         $mail->IsHTML(true);
    //         $mail->Username = config('services.ses.username');
    //         $mail->Password = config('services.ses.password');
    //         $mail->SetFrom(config('services.ses.email'), $fromName, 0);
    //         $mail->Subject = $subject;
    //         $mail->Body = $message;

    //         $mail->AddAddress($toEmail);
    //         if ($mail->Send()) {
    //             return true;
    //         } else {
    //             return false;
    //         }

    //     } catch (Exception $e) {
    //         //throw new Exception($e->getMessage());
    //         return false;
    //     }

    // }

    // public static function sendBulkMessage($toList, $subject, $message, $fromEmail = null, $fromName = null, $isHtml = true, $deliveryTime = '', $tags = [], $campaignId = '')
    // {
    //     try {
    //         $fromName = !empty($fromName) ? $fromName : config('services.ses.fromname') ;

    //         $mail = new PHPMailer\PHPMailer(); // create a n
    //         $mail->isSMTP();
    //         $mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
    //         $mail->SMTPAuth = true; // authentication enabled
    //         $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
    //         $mail->Host = config('services.ses.host');
    //         $mail->Port = 465; // or 587
    //         $mail->IsHTML(true);
    //         $mail->Username = config('services.ses.username');
    //         $mail->Password = config('services.ses.password');
    //         $mail->SetFrom(config('services.ses.email'), $fromName, 0);
    //         $mail->Subject = $subject;
    //         $mail->Body = $message;


    //         foreach ($toList as $key => $toEmailInfo) {
    //             $mail->AddAddress($toEmailInfo['email']);
    //         }
    //         if ($mail->Send()) {
    //             return true;
    //         } else {
    //             return false;
    //         }

    //     } catch (Exception $e) {
    //         //throw new Exception($e->getMessage());
    //         return false;
    //     }

    // }

    /**
     * get Email body in Email Template format
     * @param string      $merchantId
     * @param string      $emailBody
     *
     * @return Response
     */
    // public static function getCustomerEmailTemplate($merchantId, $emailBody)
    // {
    //     $inloyalLogo1 = ConfigConstantHelper::getValue('INLOYAL_LOGO_URL');

    //     $vars['emailBody'] = isset($emailBody) ? $emailBody : '';
    //     if (!empty($merchantId) && $merchantId != 0) {
    //         $getMerchantInfoForEmail = DB::select('call getMerchantInfoForEmail(?)', array($merchantId));
    //         $vars['merchantLogo'] = $getMerchantInfoForEmail[0]->merchant_logo;
    //         $vars['merchantName'] = $getMerchantInfoForEmail[0]->merchant_name;
    //         if (!empty($getMerchantInfoForEmail[0]->merchant_logo)) {
    //             $vars['merchantLogo'] = ImageHelper::getFileUrl($getMerchantInfoForEmail[0]->merchant_logo);
    //         } else {
    //             $vars['merchantLogo'] = $inloyalLogo1;
    //         }
    //         $vars['clubLogo'] = $getMerchantInfoForEmail[0]->loyalty_program_logo;
    //         $vars['loyaltyClub'] = $getMerchantInfoForEmail[0]->loyalty_program_name;
    //         if (!empty($getMerchantInfoForEmail[0]->loyalty_program_logo)) {
    //             $vars['clubLogo'] = ImageHelper::getFileUrl($getMerchantInfoForEmail[0]->loyalty_program_logo);
    //         } else {
    //             $vars['clubLogo'] = asset('images/no-img-trans.png');
    //         }
    //     } else {
    //         $vars['merchantLogo'] = $inloyalLogo1;
    //         $vars['merchantName'] = 'inloyal';
    //         $vars['clubLogo'] = asset('images/no-img-trans.png');
    //         $vars['loyaltyClub'] = '';
    //     }
    //     $vars['baseInloyalLogo'] = $inloyalLogo1;
    //     $vars['iosLogo'] = ConfigConstantHelper::getValue('EMAIL_IOS_LOGO');
    //     $vars['androidLogo'] = ConfigConstantHelper::getValue('EMAIL_ANDROID_LOGO');

    //     $email_teplate_name = 'IN_CUSTOMER_COMMUNICATION_MESSAGES';
    //     $emailContent = SystemEmail::whereName($email_teplate_name)->firstOrFail()->toArray();

    //     $emailMessage = $emailContent['text1'];
    //     foreach ($vars as $key => $var) {
    //         $emailMessage = preg_replace('/{\$(' . preg_quote($key) . ')}/i', $var, $emailMessage);
    //     }

    //     return html_entity_decode($emailMessage);
    // }
}
