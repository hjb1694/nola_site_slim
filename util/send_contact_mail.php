<?php

use SendGrid\Mail\Mail;

function send_contact_mail($subject, $body) {
    $email = new Mail();
    $email->setFrom("nola@mjmconsultingtn.com", "Nola Swartz");
    $email->setSubject($subject);
    $email->addTo("nola@mjmconsultingtn.com", "Nola Swartz");
    $email->addTo("nolachef2@gmail.com", "Nola Swartz");
    $email->addContent("text/html", $body);

    $sendgrid = new \SendGrid($_ENV["SENDGRID_API_KEY"]);

    try{

        $sendgrid->send($email);

    }catch(Exception $e){
        echo 'Caught exception: '. $e->getMessage() ."\n";
    }
}


// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\SMTP;
// use PHPMailer\PHPMailer\Exception;

// function send_contact_mail($subject, $body) {

//     try{

//         $mail = new PHPMailer(true);
//         $mail->IsSMTP();
//         $mail->SMTPAuth = true;
//         $mail->Host = $_ENV["MAIL_HOST"];
//         $mail->Username = $_ENV["MAIL_USERNAME"];
//         $mail->Password = $_ENV["MAIL_PASSWORD"];
//         $mail->Port = 587;
//         $mail->SMTPSecure = 'tls';
        
//         $mail->setFrom('nola@mjmconsultingtn.com', 'Nola Swartz');
//         $mail->addAddress('nola@mjmconsultingtn.com', 'Nola Swartz');
//         $mail->addAddress('nolachef2@gmail.com', 'Nola Swartz');
        
//         $mail->isHTML();
//         $mail->Subject = $subject;
//         $mail->Body = $body;
        
//         $mail->send();
        
//         }catch(Exception $e) {
//             echo "Message could not be sent. {$mail->ErrorInfo}";
//         }


// }

?>