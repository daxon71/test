<?php

require 'PHPMailer-master/PHPMailerAutoload.php';

$mail = new PHPMailer;


$mail->isSMTP(); 
$mail->SMTPDebug = 3;
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'izvekov71@gmail.com';
$mail->Password = 'kOOswap3';
$mail->SMTPSecure = 'ssl';
$mail->Port = 465;

$mail->CharSet = "UTF-8";
$mail->setFrom($mail->Username);
$mail->addAddress('daxon71@mail.ru');
$mail->addAddress('goltseva96@mail.ru');

$mail->isHTML(true);

$mail->Subject = "Сообщение с сайта akrobatika71.ru";
if($_POST['name']!='') $mail->Body .= "Имя: ".$_POST['name']."<br>";
if($_POST['mail']!='') $mail->Body .= "E-mail: ".$_POST['mail']."<br>";
if($_POST['tel']!='') $mail->Body .= "Телефон: ".$_POST['tel']."<br>";
if($_POST['message']!='') $mail->Body .= "Сообщение: ".$_POST['message']."<br>";


if(!$mail->send()) {
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'ok';
}


/*if(isset($_POST['name']))  $message .= "Имя: ".$_POST['name']."\n";
if(isset($_POST['mail'])) $message .= "E-mail: ".$_POST['mail']."\n";
if(isset($_POST['tel'])) $message .= "Телефон: ".$_POST['tel']."\n";
if(isset($_POST['message'])) $message .= "Сообщение: ".$_POST['message']."\n";
mail("daxon71@mail.ru", "Сообщение с сайта akrobatika71", $message);
echo "ok";*/
?>