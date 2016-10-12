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
        $mail->Username="mquattrochi@gmail.com";
        $mail->Password="l2jh432n";
        $mail->SetFrom('cubesubd.com','CubeSubD');
        $mail->AddReplyTo("mquattrochi@gmail.com","CubeSubD");
        $mail->Subject    = $subject;
        $mail->MsgHTML($message);
        $mail->Send();
    }


}