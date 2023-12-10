<?php

// Declare variables
$name = $_POST["name"];
$email = $_POST["client-email-add"];
$service = $_POST["client-service-type"];
$phone = $_POST["client-phone-no"];
$message = $_POST["client-message"];

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';



//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
  //Server settings

  $mail->isSMTP();
  $mail->Host = 'smtp.gmail.com';
  $mail->SMTPAuth = true;
  $mail->Username = 'babubartai11@gmail.com';
  $mail->Password = 'refrdiruaeegjzxw';
  $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
  $mail->Port = 465;

  // Recipients
  $mail->setFrom($email, $name);
  $mail->addAddress("babubartai11@gmail.com");
  // $mail->addAddress("masterpiece.hydros@gmail.com");

  // Content
  $mail->isHTML(true);
  $mail->Subject = "New Email from Client";
  if($service === "Type Of Service Select" && empty($phone)){
      $fullMessage = "
              <p><b>Client Name: </b>$name</p>
              <p><b>Client Email: </b>$email</p>
              <p><b>Client Contact: </b>N/A</p>
              <p><b>Service Type: </b>N/A</p>
              <h2>Client message:</h2>
              <p>$message</p>
          ";
  }elseif ($service === "Type Of Service Select") {
    $fullMessage = "
              <p><b>Client Name: </b>$name</p>
              <p><b>Client Email: </b>$email</p>
              <p><b>Client Contact: </b>$phone</p>
              <p><b>Service Type: </b>N/A</p>
              <h2>Client message:</h2>
              <p>$message</p>
          ";
  }elseif (empty($phone)){
      $fullMessage = "
              <p><b>Client Name: </b>$name</p>
              <p><b>Client Email: </b>$email</p>
              <p><b>Client Contact: </b>N/A</p>
              <p><b>Service Type: </b>$service</p>
              <h2>Client message:</h2>
              <p>$message</p>
          ";
  }else {
    $fullMessage = "
            <p><b>Client Name: </b>$name</p>
            <p><b>Client Email: </b>$email</p>
            <p><b>Client Contact: </b>$phone</p>
            <p><b>Service Type: </b>$service</p>
            <h2>Client message:</h2>
            <p>$message</p>
        ";
  }

  $mail->Body = $fullMessage;
  $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
  $mail->send();
  header('Location: confirmation.html');
} catch (Exception $e) {
  echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}