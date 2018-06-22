<?php
// подключаем файл настроек
require_once dirname(__FILE__) . '/process_settings.php';

// открываем сессию
session_start();

// переменная, хранящая основной статус обработки формы
$data['result'] = 'success';


// обрабатывать будем только ajax запросы
// для функции var_dump закомитить
if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
  exit();
}
// обрабатывать данные будет только если они посланы методом POST
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
  exit();
}


require_once "SendMail.php";

$send = new SendMail;

//input формы для валидации
require_once ('input-valid.php');

//валидация загружаемых файлов
require_once ('file_valid.php');


//Этап после валидации формы
//присваивание переменных с input формы
$name = $send->filter($_POST['name']);
$email = $send->filter($_POST['email']);
$phone = $send->filter($_POST['phone']);
$message = $send->filter($_POST['message']);

// отправка формы (данных на почту)
if ($data['result'] == 'success') {
  // включить файл PHPMailerAutoload.php
  require_once('../phpmailer/PHPMailerAutoload.php');

  //формируем тело письма
  $bodyMail = file_get_contents('email.tpl'); // получаем содержимое email шаблона


  // выполняем замену плейсхолдеров реальными значениями
  $bodyMail = str_replace('%email.title%', MAIL_SUBJECT, $bodyMail);
  $bodyMail = str_replace('%email.date%', date('d.m.Y H:i'), $bodyMail);
  $bodyMail = $send->bodyMail('%email.nameuser%', $name, $bodyMail);
  $bodyMail = $send->bodyMail('%email.message%', $message, $bodyMail);
  $bodyMail = $send->bodyMail('%email.emailuser%', $email, $bodyMail);

  require_once('inc_php_mailer.php');
}

require_once('write-in-file.php');


// сообщаем результат клиенту
echo json_encode($data);

