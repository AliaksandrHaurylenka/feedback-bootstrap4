<?php
// отправляем письмо с помощью PHPMailer
$mail = new PHPMailer;


$mail->CharSet = 'UTF-8';
$mail->IsHTML(true);  // формат HTML
$fromName = '=?UTF-8?B?'.base64_encode(MAIL_FROM_NAME).'?=';
$mail->setFrom(MAIL_FROM, $fromName);
$mail->Subject = '=?UTF-8?B?'.base64_encode(MAIL_SUBJECT).'?=';
$mail->Body = $bodyMail;
// $mail->addAddress(MAIL_ADDRESS);
foreach($bcc as $mail_list)
{
  $mail->AddBCC($mail_list);
}
$mail->addCustomHeader('Precedence', 'bulk');


// отправляем письмо
if (!$mail->send()) {
  $data['result'] = 'error';
}

// информируем пользователя по email о доставке
if (isset($email)) {
  // очистка всех адресов и прикреплёных файлов
  $mail->clearAllRecipients();
  $mail->clearAttachments();
  //формируем тело письма
  $bodyMail = file_get_contents('email_client.tpl'); // получаем содержимое email шаблона
  // выполняем замену плейсхолдеров реальными значениями
  $bodyMail = str_replace('%email.title%', MAIL_SUBJECT, $bodyMail);
  $bodyMail = $send -> bodyMail('%email.nameuser%', $name, $bodyMail);
  $bodyMail = str_replace('%email.date%', date('d.m.Y H:i'), $bodyMail);
  $mail->Subject = MAIL_SUBJECT_CLIENT;
  $mail->Body = $bodyMail;
  $mail->addAddress($email);
  $mail->send();
}