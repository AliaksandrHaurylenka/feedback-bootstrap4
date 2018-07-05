<?php
//формируем тело письма
$bodyMail = file_get_contents('email.tpl'); // получаем содержимое email шаблона

// выполняем замену плейсхолдеров реальными значениями
$bodyMail = str_replace('%email.title%', MAIL_SUBJECT, $bodyMail);
$bodyMail = str_replace('%email.date%', date('d.m.Y H:i'), $bodyMail);
$bodyMail = $send->bodyMail('%email.nameuser%', $name, $bodyMail);
$bodyMail = $send->bodyMail('%email.message%', $message, $bodyMail);
$bodyMail = $send->bodyMail('%email.emailuser%', $email, $bodyMail);


// добавление файлов в виде ссылок
if (isset($attachments)) {
  $listFiles = '<ul>';
  foreach ($attachments as $attachment) {
    $fileHref = substr($attachment, strpos($attachment, 'feedback/uploads/'));
    $fileName = basename($fileHref);
    $listFiles .= '<li><a href="' . $startPath . $fileHref . '">' . $fileName . '</a></li>';
  }
  $listFiles .= '</ul>';
  $bodyMail = str_replace('%email.attachments%', $listFiles, $bodyMail);
} else {
  $bodyMail = str_replace('%email.attachments%', '-', $bodyMail);
}