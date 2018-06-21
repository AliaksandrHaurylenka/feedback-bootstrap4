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

//присваивание переменных с input формы
/*$name = $send->filter($_POST['name']);
$email = $send->filter($_POST['email']);
$message = $send->filter($_POST['message']);*/


//inputы формы для валидации
$name = $send->length($_POST['name'], 2, 100);
$email = $send->length($_POST['email'], 6, 100);


$text = " содержит недопустимое количество символов";
/*$result = 'result';
$res = 'error';*/
$res['result'] = 'error';
if(!$name):
  $data = $send->res('Ф.И.О.', $res, $text);
//  $data = $send->res('Ф.И.О.', $result, $res, $text);
elseif(!$email):
  $data = $send->res('Email', $res, $text);
//  $data = $send->res('Email', $result, $res, $text);
endif;



//валидация капчи
/*if (isset($_POST['captcha']) && isset($_SESSION['captcha'])) {
  $captcha = $send->filter($_POST['captcha']);
  if ($_SESSION['captcha'] != $captcha) { // проверка капчи
    $data['captcha'] = 'Вы неправильно ввели код с картинки';
    $data['result'] = 'error';
    var_dump($data);
  }
} else {
  $data['captcha'] = 'Произошла ошибка при проверке проверочного кода';
  $data['result'] = 'error';
}*/


// сообщаем результат клиенту
echo json_encode($data);

