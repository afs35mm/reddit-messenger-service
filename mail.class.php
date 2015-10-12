<?php 
    
require 'PHPMailer/PHPMailerAutoload.php';

class Mail {

    protected $new_message_count;
    

    public function __construct($msg_count = 0) {
        $this->new_message_count = $msg_count;
    }

    public function send() {
        //SMTP needs accurate times, and the PHP time zone MUST be set
        //This should be done in your php.ini, but this is how to do it if you don't have access to that
        date_default_timezone_set('Etc/UTC');

        //Create a new PHPMailer instance
        $mail = new PHPMailer;

        //Tell PHPMailer to use SMTP
        //$mail->isSMTP();

        //Enable SMTP debugging
        // 0 = off (for production use)
        // 1 = client messages
        // 2 = client and server messages
        $mail->SMTPDebug = 2;

        //Ask for HTML-friendly debug output
        $mail->Debugoutput = 'html';

        //Set the hostname of the mail server
        $mail->Host = 'smtp.gmail.com';
        // use
        // $mail->Host = gethostbyname('smtp.gmail.com');
        // if your network does not support SMTP over IPv6

        //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
        $mail->Port = 587;

        //Set the encryption system to use - ssl (deprecated) or tls
        $mail->SMTPSecure = 'tls';

        //Whether to use SMTP authentication
        $mail->SMTPAuth = true;

        //Username to use for SMTP authentication - use full email address for gmail
        $mail->Username = "mm53sfa@gmail.com";

        //Password to use for SMTP authentication
        $mail->Password = "Agway123";

        //Set who the message is to be sent from
        $mail->setFrom('mm53sfa@example.com', 'Alertzzzz');

        //Set an alternative reply-to address
        $mail->addReplyTo('mm53sfa@example.com', 'First Last');

        //Set who the message is to be sent to
        $mail->addAddress('afs35mm@gmail.com', 'Andrew Schorr');

        //Set the subject line
        $mail->Subject = 'You have '. $this->new_message_count . ' new messages.';

        //Read an HTML message body from an external file, convert referenced images to embedded,
        //convert HTML into a basic plain-text alternative body
        $mail->msgHTML(file_get_contents(__ROOT__ . '/contents.html'));

        //Replace the plain text body with one created manually
        $mail->AltBody = 'This is a plain-text message body';


        //send the message, check for errors
        if (!$mail->send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
            echo "Message sent!";
        }
    }


}