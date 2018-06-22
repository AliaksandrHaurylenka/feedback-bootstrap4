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
$name = $send->length($_POST['name'], 2, 100);
$email = $send->length($_POST['email'], 6, 100);
$message = $send->length($_POST['message'], 20, 500);

//Текст для вывода информации об ошибке
//Впереди стоит имя поля, которое не валидно
$text = " содержит недопустимое количество символов";


//Проверка форм ввода на валидность по количеству введенных символов
if (!$name):
  $data = $send->res('Ф.И.О.', $text);
elseif (!$email):
  $data = $send->res('Email', $text);
elseif (!$message):
  $data = $send->res('Сообщение', $text);
endif;


//валидация капчи
if (isset($_POST['captcha']) && isset($_SESSION['captcha'])) {
  $captcha = $send->filter($_POST['captcha']);
  if ($_SESSION['captcha'] != $captcha) { // проверка капчи
    $data['captcha'] = 'Вы неправильно ввели код с картинки';
    $data['result'] = 'error';
  }
} else {
  $data['captcha'] = 'Произошла ошибка при проверке проверочного кода';
  $data['result'] = 'error';
}


//Этап после валидации формы
//присваивание переменных с input формы
$name = $send->filter($_POST['name']);
$email = $send->filter($_POST['email']);
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

// отправка данных формы в файл
if ($data['result'] == 'success') {
  $name = isset($name) ? $name : '-';
  $email = isset($email) ? $email : '-';
  $message = isset($message) ? $message : '-';
  $output = "---------------------------------" . "\n";
  $output .= date("d-m-Y H:i:s") . "\n";
  $output .= "Имя пользователя: " . $name . "\n";
  $output .= "Адрес email: " . $email . "\n";
  $output .= "Сообщение: " . $message . "\n";
  if (isset($attachments)) {
    $output .= "Файлы: " . "\n";
    foreach ($attachments as $attachment) {
      $output .= $attachment . "\n";
    }
  }
  if (!file_put_contents(dirname(dirname(__FILE__)) . '/info/message.txt', $output, FILE_APPEND | LOCK_EX)) {
    $data['result'] = 'error';
  }
}


// сообщаем результат клиенту
echo json_encode($data);

