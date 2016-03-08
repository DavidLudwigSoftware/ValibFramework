<?php

namespace Valib\Service;

class Mail
{
    private $_mail;

    public static function send($to, $subject, $builder)
    {
        $mail = new static();

        // Check if $to is not an array
        if (gettype($to) == 'string')

            // Make $to into an array
            $to = [$to];

        // Loop through each of the recipients
        foreach ($to as $recipient)

            // Add them to the mail list
            $mail->to($recipient);

        // Set the subject
        $mail->subject($subject);

        // Build the email
        $builder($mail);

        // Send the email
        return $mail->sendMail();
    }

    public function __construct()
    {
        $this->_mail = new \PHPMailer();

        $this->config();
    }

    protected function config()
    {
        $mailConfig = env('mail_config');

        $config = config('mail')[$mailConfig];

        if ($mailConfig == 'SMTP')
        {
            // Set as SMTP
            $this->_mail->IsSMTP();

            // Configure SMTP debugging
            $this->_mail->SMTPDebug = $config['debug'];

            // Set the host settings
            $this->_mail->Host = $config['host'];
            $this->_mail->Port = $config['port'];
            $this->_mail->SMTPSecure = $config['encryption'];

            // Set the authentication settings
            $this->_mail->SMTPAuth = (bool) $config['auth'];
            $this->_mail->Username = $config['username'];
            $this->_mail->Password = $config['password'];
        }
    }

    protected function sendMail()
    {
        return $this->_mail->send();
    }

    public function phpMailer()
    {
        return $this->_mail;
    }

    public function cc($address, $name = '')
    {
        $this->_mail->addCC($address, $name);
    }

    public function bcc($address, $name = 1)
    {
        $this->_mail->addBCC($address, $name);
    }

    public function to($address, $name = '')
    {
        $this->_mail->addAddress($address, $name);
    }

    public function replyTo($address, $name = '')
    {
        $this->_mail->addReplyTo($address, $name);
    }

    public function from($address, $name = '')
    {
        $this->_mail->setFrom($address, $name);
    }

    public function subject($subject)
    {
        $this->_mail->Subject = $subject;
    }

    public function body(string $body)
    {
        $this->_mail->msgHTML(
            $body
        );
    }

    public function view($view, $args = [])
    {
        $this->body(
            view($view, $args, True)
        );
    }

    public function priority(int $priority)
    {
        max(min($priority, 5), 1);
    }
}
