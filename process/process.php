<?php
//временная зона
date_default_timezone_set('Europe/Moscow');

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

//подключение класса для формирования и обработки сообщения
require_once "SendMail.php";
$send = new SendMail;

//валидация полей
require_once ('input-valid.php');

//валидация загружаемых файлов
require_once ('file_valid.php');


//Этап после валидации форм
//присваивание переменных с input полей
//для формирования тела сообщения
$name = $send->filter($_POST['name']);
$email = $send->filter($_POST['email']);
$phone = $send->filter($_POST['phone']);
$select = $send->filter($_POST['select']);
//$multiSelect = $send->filter($_POST['multiSelect']);
$multiSelect = $_POST['multiSelect'];
$message = $send->filter($_POST['message']);
$radio = $send->filter($_POST['radio']);
$check = $send->filter($_POST['check']);

// отправка формы (данных на почту)
if ($data['result'] == 'success') {

  //формируем тело письма
  require_once ('body_mail.php');

  //обработка письма
  require_once('php_mailer.php');
}

//запись сообщения в файл
require_once('write-in-file.php');

//сообщаем результат клиенту
echo json_encode($data);

