<?php
//формируем тело письма
$bodyMail = file_get_contents('email.tpl'); // получаем содержимое email шаблона

// выполняем замену плейсхолдеров реальными значениями
$bodyMail = str_replace('%email.title%', MAIL_SUBJECT, $bodyMail);
$bodyMail = str_replace('%email.date%', date('d.m.Y H:i'), $bodyMail);
$bodyMail = $send->bodyMail('%email.nameuser%', $name, $bodyMail);
$bodyMail = $send->bodyMail('%email.message%', $message, $bodyMail);
$bodyMail = $send->bodyMail('%email.emailuser%', $email, $bodyMail);