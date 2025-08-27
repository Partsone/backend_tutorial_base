<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class RegistrationTokenMail extends Mailable
{
    public string $token;

    public function __construct(string $token) { $this->token = $token; }

    public function build()
    {
        return $this->subject('Your registration token')
            ->view('emails.registration_token')
            ->with(['token' => $this->token]);
    }
}
//bladeなしだからここのファイルはいらない。
