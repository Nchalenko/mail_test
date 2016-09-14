<?php

require_once 'vendor/autoload.php';

$mail = new PHPMailer;
$mail->CharSet = 'utf-8';
$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.yandex.ru';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'testmailforpolaz@yandex.ru';                 // SMTP username
$mail->Password = 'password112233';                           // SMTP password
$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 465;                                    // TCP port to connect to

$mail->setFrom('testmailforpolaz@yandex.ru', 'TEST');
$mail->addAddress($_POST['mail'], 'Test');     // Add a recipient

if (!empty($_FILES)) {
	$files = array();
	for ($i = 0; $i < count($_FILES['file']['name']); $i++) {
		$files['file_' . $i] = array(
			$_FILES['file']['name'][$i] => $_FILES['file']['tmp_name'][$i]
		);
	}

	foreach ($files as $item) {
		foreach ($item as $key => $value)
			$mail->addAttachment($value, $key);         // Add attachments

	}
}
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = $_POST['mail_subject'];
$mail->Body = $_POST['mail_body'];

if (!$mail->send()) {
	echo "Сообщение не было отправлено, возникла ошибка";
	echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
	echo "Сообщение было отправлено, спасибо";
}
