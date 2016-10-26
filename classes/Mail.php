<?php

class Mail{


    function send_mail($email,$message,$subject)
    {
        require_once('../PHPMailer/class.phpmailer.php');
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPDebug  = 0;
        $mail->SMTPAuth   = true;
        $mail->SMTPSecure = "ssl";
        $mail->Host       = "smtp.gmail.com";
        $mail->Port       = 465;
        $mail->AddAddress($email);
        $mail->Username="N/A";
        $mail->Password="N/A";
        $mail->SetFrom('N/A','N/A');
        $mail->AddReplyTo("N/A","N/A");
        $mail->Subject    = $subject;
        $mail->MsgHTML($message);
        $mail->Send();
    }


}
