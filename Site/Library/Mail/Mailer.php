<?php
namespace Site\Library\Mail;

class Mailer
{
    private $_phpMailer = null;
    public $error = false;

    public function __construct()
    {
        $this->_phpMailer = new \PHPMailer();
        
        $this->_phpMailer->isSMTP();
        $this->_phpMailer->Host = SMTP_HOST;
        $this->_phpMailer->SMTPAuth = SMTP_AUTH;
        $this->_phpMailer->Username = SMTP_USER;
        $this->_phpMailer->Password = SMTP_PASSWORD;
        $this->_phpMailer->SMTPSecure = SMTP_SECURE;
    }

    public function send(stdClass $mail)
    {
        // https://github.com/PHPMailer/PHPMailer

        if(!$this->_phpMailer->send()) {
           $this->error = 'Mailer Error: ' . $mail->ErrorInfo;
           return false;
        }

        $this->error = false;
        return true;
    }
}