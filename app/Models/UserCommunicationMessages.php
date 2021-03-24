<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class UserCommunicationMessages extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_communication_messages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['message_title', 'message_type', 'offer_id', 'message_text', 'maximum_points_available', 'notify_users_by', 'email_image', 'image_url', 'email_from_name', 'email_from_email', 'email_subject', 'email_body', 'test_mode', 'test_email_address', 'test_mobile_number', 'message_send_time', 'status'];

}
