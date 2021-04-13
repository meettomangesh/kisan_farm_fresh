<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class Notifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send-notifications {--notification_id=0}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if ($this->option('notification_id') != '' && $this->option('notification_id') > 0) {
            $notificationId = (int) $this->option('notification_id');
        } else {
            $notificationId = 0;
        }
        
        $notificationData = $this->getNotificationdata($notificationId);
        // echo '<pre>'; 
        // print_r($notificationData);
        // exit;

        foreach ($notificationData as $key => $notification) {
            $emailCount = 0;
            $smsCount = 0;
            $notificationCount = 0;
            switch ($notification->notify_users_by) {
                case "0001": {
                        $countArray = $this->pushAndSmsNotifications($notification, $notificationId);
                        $smsCount = $countArray['smsCount'];
                        $notificationCount = $countArray['notificationCount'];
                        break;
                    }
                case "0010": {
                        $smsCount = $this->smsNotifications($notification, $notificationId);
                        break;
                    }
                case "0011": {
                        $countArray = $this->pushAndSmsNotifications($notification, $notificationId);
                        $smsCount = $countArray['smsCount'];
                        $notificationCount = $countArray['notificationCount'];
                        break;
                    }
                case "0100": {
                        $notificationCount = $this->pushNotifications($notification, $notificationId);
                        break;
                    }
                case "0101": {
                        $countArray = $this->pushAndSmsNotifications($notification, $notificationId);
                        $smsCount = $countArray['smsCount'];
                        $notificationCount = $countArray['notificationCount'];
                        break;
                    }
                case "0110": {
                        $notificationCount = $this->pushNotifications($notification, $notificationId);
                        $smsCount = $this->smsNotifications($notification, $notificationId);
                        break;
                    }
                case "1000": {
                        $emailCount = $this->emailNotifications($notification, $notificationId);
                        break;
                    }
                case "1001": {
                        $emailCount = $this->emailNotifications($notification, $notificationId);
                        $countArray = $this->pushAndSmsNotifications($notification, $notificationId);
                        $smsCount = $countArray['smsCount'];
                        $notificationCount = $countArray['notificationCount'];
                        break;
                    }
                case "1010": {
                        $emailCount = $this->emailNotifications($notification, $notificationId);
                        $smsCount = $this->smsNotifications($notification, $notificationId);
                        break;
                    }
                case "1011": {
                        $emailCount = $this->emailNotifications($notification, $notificationId);
                        $countArray = $this->pushAndSmsNotifications($notification, $notificationId);
                        $smsCount = $countArray['smsCount'];
                        $notificationCount = $countArray['notificationCount'];
                        break;
                    }
                case "1100": {
                        $emailCount = $this->emailNotifications($notification, $notificationId);
                        $notificationCount = $this->pushNotifications($notification, $notificationId);
                        break;
                    }
                case "1101": {
                        $emailCount = $this->emailNotifications($notification, $notificationId);
                        $countArray = $this->pushAndSmsNotifications($notification, $notificationId);
                        $smsCount = $countArray['smsCount'];
                        $notificationCount = $countArray['notificationCount'];
                        break;
                    }
                case "1110": {
                        $emailCount = $this->emailNotifications($notification, $notificationId);
                        $notificationCount = $this->pushNotifications($notification, $notificationId);
                        $smsCount = $this->smsNotifications($notification, $notificationId);
                        break;
                    }
                case "1111": {
                        $emailCount = $this->emailNotifications($notification, $notificationId);
                        $countArray = $this->pushAndSmsNotifications($notification, $notificationId);
                        $smsCount = $countArray['smsCount'];
                        $notificationCount = $countArray['notificationCount'];
                        break;
                    }
                default: {
                        break;
                    }
            }
            $this->updateNotification($notification->id, $emailCount, $smsCount, $notificationCount);
        }
        $this->comment(PHP_EOL . "Handle Notifications" . PHP_EOL);
    }

    /**
     * This function is used to get all the customer communication messages data for today
     * @return array $response
     */
    public function getNotificationData($notificationId)
    {
        $response = DB::select('call getNotificationData(' . $notificationId . ')');
        return $response;
    }

    /**
     * This function will do the action of sending bulk emails
     * firstly it will fetch all the valid customer emails with names
     * then chunk then in the bunch of 500 and then perform the send action
     * @param array $notification
     */
    public function emailNotifications($notification, $notificationId)
    {
        $emailNotificationData = [];
        if (!empty($notification)) {

            $mailgun = new Mailgun(config('services.mailgun.secret'));
            $domain = config('services.mailgun.domain');
            $emailCount = 0;
            $emailNotificationData = DB::select('call getEmailNotificationData(' . $notificationId . '")');
            $emailCount = count($emailNotificationData);
            $emailNotificationData = array_chunk($emailNotificationData, 500);

            $emailData = [];

            $mailgunHelper = new MailgunHelper();
            foreach ($emailNotificationData as $key => $customerData) {
                $customerData = json_decode(json_encode($customerData), True);
                $emailData = [
                    'isHtml' => true,
                    'subject' => $notification->email_subject,
                    'message' => $mailgunHelper->getCustomerEmailTemplate($notification->merchant_id, $notification->email_body),
                    'to' => (array) $customerData,
                    'from' => [
                        "name" => $notification->email_from_name,
                        "email" => $notification->email_from_email
                    ],
                    'delay' => '20',
                    'tags' => explode(',', $notification->email_tags),
                    'deliveryTime' => $notification->message_send_time,
                    'campaignId' => '',
                ];
                //                TODO: Call the function to send bulk emails
                if ($notificationId != 0) {
                    $job = (new SendBulkEmail($emailData))->onQueue('high-bulk-emails')->delay(0);
                } else {
                    $delay = (strtotime($notification->message_send_time) > time()) ? strtotime($notification->message_send_time) - time() : 0;
                    $job = (new SendBulkEmail($emailData))->onQueue('bulk-emails')->delay($delay);
                }
                $this->dispatch($job);
            }
        } else {
            $this->comment(PHP_EOL . "Empty Array" . PHP_EOL);
        }
        Log::info('Bulk Actions Call.', ['method' => 'emailNotifications', 'process_records' => count($emailNotificationData)]);
        return $emailCount;
    }

    /**
     * This function will perform the action of sending bulk push notifications to valid users
     * @param array $notification
     */
    public function pushNotifications($notification, $notificationId)
    {
        $staticSeconds = 60;
        if (!empty($notification)) {
            $pushNotificationData = DB::select('call getPushNotificationData(' . $notificationId . ')');

            $pushNotificationDataGroup = array_chunk($pushNotificationData, 500);

            $arrCustomerIds = [];
            $counter = 1;
            $pushNotificationCount = 0;
            foreach ($pushNotificationDataGroup as $pushNotificationData) {
                $customerPushNotificationData = [];
                $iosTokensData = [];
                $androidTokensData = [];
                foreach ($pushNotificationData as $key => $customerData) {
                    if ($customerData->device_type == 1) {
                        if (!in_array($customerData->device_token, $androidTokensData)) {
                            $androidTokensData[] = $customerData->device_token;
                        }
                    } else {
                        if (!in_array($customerData->device_token, $iosTokensData)) {
                            $iosTokensData[] = $customerData->device_token;
                        }
                    }
                    if (!in_array($customerData->customer_id, $arrCustomerIds)) {
                        $customerPushNotificationData[] = [
                            'customer_id' => $customerData->customer_id,
                            'merchant_id' => $notification->merchant_id,
                            'loyalty_id' => $notification->loyalty_id,
                            'custom_data' => $notification->offer_id,
                            'push_text' => $notification->push_text,
                            'communication_msg_id' => $notification->id,
                            'deep_link_screen' => $notification->deep_link_screen,
                            'created_by' => 1,
                            'created_at' => date('Y-m-d H:i:s', strtotime($notification->message_send_time))
                        ];
                        $arrCustomerIds[] = $customerData->customer_id;
                    }
                }
                $pushData = [
                    'message' => $notification->push_text,
                    'iosTokens' => $iosTokensData,
                    'androidTokens' => $androidTokensData,
                    'deepLink' => $notification->deep_link_screen,
                    'merchantId' => $notification->merchant_id,
                    'notificationType' => 0,
                    'uniqueId' => $notification->id,
                    'id' => ($notification->offer_id != '') ? $notification->offer_id : 0
                ];

                if (count($customerPushNotificationData) > 0) {
                    $this->saveCustomerPushNotification($customerPushNotificationData);
                }

                //                TODO: Call the function to send bulk push notification
                if ($counter > 1) {
                    $delay = ((strtotime($notification->message_send_time) > time()) ? strtotime($notification->message_send_time) - time() : 0) + ($staticSeconds * $counter);
                } else {
                    $delay = (strtotime($notification->message_send_time) > time()) ? strtotime($notification->message_send_time) - time() : 0;
                }
                if ($notificationId != 0) {
                    $job = (new SendBulkNotification($pushData))->onQueue('high-bulk-notifications')->delay($delay);
                } else {
                    $job = (new SendBulkNotification($pushData))->onQueue('bulk-notifications')->delay($delay);
                }
                $this->dispatch($job);
                $counter++;
                $pushNotificationCount = $pushNotificationCount + (count($androidTokensData) + count($iosTokensData));
            }
        } else {
            $this->comment(PHP_EOL . "Empty Array" . PHP_EOL);
        }
        Log::info('Bulk Actions Call.', ['method' => 'pushNotifications', 'process_records' => (isset($iosTokensData) ? count($iosTokensData) : 0) + (isset($androidTokensData) ? count($androidTokensData) : 0)]);
        return $pushNotificationCount;
    }

    /**
     * This function will perform the acxtion of sending bulk SMS to valid users
     * @param array $notification
     */
    public function smsNotifications($notification, $notificationId)
    {
        $smsNotificationData = [];
        if (!empty($notification)) {
            $smsNotificationData = DB::select('call getSmsNotificationData(' . $notificationId .')');
            $smsData = [];
            if ($notification->merchant_id != 0) {
                $getMerchantInfoForEmail = DB::select('call getMerchantInfoForEmail(?)', array($notification->merchant_id));
                $smsFrom = $getMerchantInfoForEmail[0]->sms_sender_name;
            } else {
                $smsFrom = '';
            }
            foreach ($smsNotificationData as $key => $customerData) {
                $smsData = [
                    'message' => $notification->sms_text,
                    'to' => $customerData->mobile_number,
                    'from' => $smsFrom
                ];
                //                TODO: Call the function to send bulk sms notification
                $delay = (strtotime($notification->message_send_time) > time()) ? strtotime($notification->message_send_time) - time() : 0;
                if ($notificationId != 0) {
                    $job = (new SendBulkSms($smsData))->onQueue('high-bulk-sms')->delay($delay);
                } else {
                    $job = (new SendBulkSms($smsData))->onQueue('bulk-sms')->delay($delay);
                }
                $this->dispatch($job);
            }
            $smsCount = count($smsNotificationData);
        } else {
            $this->comment(PHP_EOL . "Empty Array" . PHP_EOL);
        }
        Log::info('Bulk Actions Call.', ['method' => 'smsNotifications', 'process_records' => count($smsNotificationData)]);
        return $smsCount;
    }

    /**
     * This function will perfom the action of sending bulk SMS for the valid users
     * who hasn't installed the app and sends the push notifications to users
     * who has installed the app.
     * @param array $notification
     */
    public function pushAndSmsNotifications($notification, $notificationId)
    {
        $pushAndSmsNotificationData = [];
        $staticSeconds = 60;
        if (!empty($notification)) {
            $pushAndSmsNotificationData = DB::select('call getPushAndSmsNotificationData(' . $notification->merchant_id . ',' . $notification->loyalty_id . ',' . $notification->loyalty_tier_id . ')');
            $pushNotificationDataGroup = array_chunk($pushAndSmsNotificationData, 500);
            $counter = 1;
            if ($notification->merchant_id != 0) {
                $getMerchantInfoForEmail = DB::select('call getMerchantInfoForEmail(?)', array($notification->merchant_id));
                $smsFrom = $getMerchantInfoForEmail[0]->sms_sender_name;
            } else {
                $smsFrom = '';
            }
            $smsCount = 0;
            $pushNotificationCount = 0;
            foreach ($pushNotificationDataGroup as $pushAndSmsNotificationData) {
                $smsData = [];
                $iosTokensData = [];
                $androidTokensData = [];
                $customerPushNotificationData = [];
                $arrCustomerIds = [];
                foreach ($pushAndSmsNotificationData as $key => $customerData) {
                    if (empty($customerData->device_token) || $customerData->device_token == NULL) {
                        if ($customerData->first_mobile_verified == 1) {
                            $smsData = [
                                'message' => $notification->sms_text,
                                'to' => $customerData->mobile_number,
                                'from' => $smsFrom
                            ];
                            //                TODO: Call the function to send bulk sms notification
                            $delay = (strtotime($notification->message_send_time) > time()) ? strtotime($notification->message_send_time) - time() : 0;

                            if ($notificationId != 0) {
                                $job = (new SendBulkSms($smsData))->onQueue('high-bulk-sms')->delay($delay);
                            } else {
                                $job = (new SendBulkSms($smsData))->onQueue('bulk-sms')->delay($delay);
                            }
                            $this->dispatch($job);
                            $smsCount++;
                        }
                    } elseif ($customerData->status == 1) {
                        if ($customerData->device_type == 1) {
                            if (!in_array($customerData->device_token, $androidTokensData)) {
                                $androidTokensData[] = $customerData->device_token;
                            }
                        } else {
                            if (!in_array($customerData->device_token, $iosTokensData)) {
                                $iosTokensData[] = $customerData->device_token;
                            }
                        }
                        if (!in_array($customerData->customer_id, $arrCustomerIds)) {
                            $customerPushNotificationData[] = [
                                'customer_id' => $customerData->customer_id,
                                'merchant_id' => $notification->merchant_id,
                                'loyalty_id' => $notification->loyalty_id,
                                'custom_data' => $notification->offer_id,
                                'communication_msg_id' => $notification->id,
                                'push_text' => $notification->push_text,
                                'deep_link_screen' => $notification->deep_link_screen,
                                'created_by' => 1,
                                'created_at' => date('Y-m-d H:i:s', strtotime($notification->message_send_time))
                            ];
                            $arrCustomerIds[] = $customerData->customer_id;
                        }
                    }
                }
                $pushData = [
                    'message' => $notification->push_text,
                    'iosTokens' => $iosTokensData,
                    'androidTokens' => $androidTokensData,
                    'deepLink' => $notification->deep_link_screen,
                    'merchantId' => $notification->merchant_id,
                    'notificationType' => 0,
                    'uniqueId' => $notification->id,
                    'id' => ($notification->offer_id != '') ? $notification->offer_id : 0
                ];
                if (count($customerPushNotificationData) > 0) {
                    $this->saveCustomerPushNotification($customerPushNotificationData);
                }

                if ($counter > 1) {
                    $delay = ((strtotime($notification->message_send_time) > time()) ? strtotime($notification->message_send_time) - time() : 0) + ($staticSeconds * $counter);
                } else {
                    $delay = (strtotime($notification->message_send_time) > time()) ? strtotime($notification->message_send_time) - time() : 0;
                }

                if ($notificationId != 0) {
                    $job = (new SendBulkNotification($pushData))->onQueue('high-bulk-notifications')->delay($delay);
                } else {
                    $job = (new SendBulkNotification($pushData))->onQueue('bulk-notifications')->delay($delay);
                }
                $this->dispatch($job);
                $counter++;
                $pushNotificationCount = $pushNotificationCount + (count($androidTokensData) + count($iosTokensData));
            }
        } else {
            $this->comment(PHP_EOL . "Empty Array" . PHP_EOL);
        }
        Log::info('Bulk Actions Call.', ['method' => 'pushAndSmsNotifications', 'process_records' => count($pushAndSmsNotificationData)]);
        return ['smsCount' => $smsCount, 'pushNotificationCount' => $pushNotificationCount];
    }

    /**
     * This function saves the sent push notification for future use
     * @param array $customerData
     */
    public function saveCustomerPushNotification($customerData)
    {
        DB::table('customer_push_notifications')->insert($customerData);
    }

    /**
     * It will set the notification as processed
     * @param integer $notificationId
     */
    public function updateNotification($notificationId, $emailCount = 0, $smsCount = 0, $pushNotificationCount = 0)
    {
        DB::table('customer_communication_messages')->where('id', $notificationId)->update(['processed' => 1, 'email_count' => $emailCount, 'sms_count' => $smsCount, 'push_notification_count' => $pushNotificationCount]);
    }
}
