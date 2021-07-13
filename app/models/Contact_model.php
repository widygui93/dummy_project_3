<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


class Contact_model extends Model
{
    public function sendMail(array $data)
    {
        if ($this->isDataEmpty($data)) {
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'Data Form Contact must be sent'
            ];
        } elseif (!$this->doesMandatoryDataFilled(array(
            "name" => $data['name'],
            "email" => $data['email'],
            "subject" => $data['subject'],
            "messages" => $data['messages']
        ))) {
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'Data Form Contact of name, email, subject and messages are mandatory'
            ];
        } elseif ($this->isBreak($data['name'], "/^[a-zA-Z .,]{6,12}$/")) {
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'Name Format of Form Contact: Combination of letters, space, comma and full stop, Length: 6 - 12'
            ];
        } elseif ($this->isBreak($data['email'], "/^([a-z\d\.-]+)@([a-z\d-]+)\.([a-z]{2,8})(\.[a-z]{2,8})?$/")) {
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'Invalid Email Format of Form Contact'
            ];
        } elseif ($this->isBreak($data['subject'], "/^[a-zA-Z0-9 .,]{6,12}$/")) {
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'Subject Format of Form Contact: Combination of letters,numbers, space, comma and full stop, Length: 6 - 12'
            ];
        } elseif ($this->isBreak($data['messages'], "/^[a-zA-Z0-9 .,]{6,40}$/")) {
            return [
                'icon' => 'error',
                'title' => 'Failed',
                'text' => 'Messages Format of Form Contact: Combination of letters,numbers, space, comma and full stop, Length: 6 - 40'
            ];
        } else {
            $data['name'] = $this->purify($data['name']);
            $data['email'] = $this->purify($data['email']);
            $data['subject'] = $this->purify($data['subject']);
            $data['messages'] = $this->purify($data['messages']);

            $mail = new PHPMailer(true);

            try {
                //Server settings
                // $mail->SMTPDebug = SMTP::DEBUG_SERVER;     //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'smtp.mailgun.org';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'postmaster@sandbox86cf1bed3fa64eb4b3bb2f4b5563a555.mailgun.org';  //username dari mailgun SMTP service
                $mail->Password   = SMTP_PASSWORD;                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                //Recipients
                $mail->setFrom($data['email'], $data['name']);
                $mail->addAddress('dummy_smtp_server@protonmail.com');               //Name is optional


                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = $data['subject'];
                $mail->Body    = $data['messages'];

                $mail->send();
                return [
                    'icon' => 'success',
                    'title' => 'Success',
                    'text' => 'Sent Mail successfully'
                ];
            } catch (Exception $e) {
                return [
                    'icon' => 'error',
                    'title' => 'Failed',
                    'text' => 'Sent Mail Failed'
                ];
            }
        }
    }
}
