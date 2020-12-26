<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ChangePasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
     private $user_name_send_to = "";
    public function __construct($user_name)
    {
        //
        $this->user_name_send_to = $user_name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.ChangePassword', [
            'user_name_for_mail' => $this->user_name_send_to
        ])->subject('Password Changed Confirmation');
    }
}
