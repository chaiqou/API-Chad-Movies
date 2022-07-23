<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailreset extends Mailable
{
	use Queueable, SerializesModels;

	public $token;

	public $email;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct($email, $token)
	{
		$this->email = $email;
		$this->token = $token;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		return $this->markdown('Email.passwordReset')->with([
			'email' => $this->email,
			'token' => $this->token,
		]);
	}
}
