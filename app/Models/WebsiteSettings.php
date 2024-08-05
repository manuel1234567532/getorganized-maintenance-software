<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteSettings extends Model
{
    use HasFactory;
	  protected $table = 'website_settings';
     protected $fillable = [
        'website_name',
        'website_logo',
        'website_icon',
        'sidebar_open_white',
        'sidebar_open_black',
        'sidebar_minimized_white',
        'sidebar_minimized_black',
		 'account_created_mail',
		 'account_created_welcome_mail',
		 'sidebar_minimized_black',
		 'account_blocked_mail',
		 'account_unlocked_mail',
		 'workorder_overdue_mail',
		 'workorder_completed_mail',
		 'file_accepted_mail',
		 'file_notaccepted_mail',
		 'smtp_host',
		 'test_email_set',
		 'smtp_port',
		 'smtp_username',
		 'smtp_password',
		 'smtp_security',
		 'smtp_settings_saved',
		 'test_mail_send ',
         ];
}
