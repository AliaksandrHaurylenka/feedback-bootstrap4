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


//проверка на введенное количество символов
//$send->length($_POST['name'], 2, 10);

//inputы формы для валидации
/*$send->val($_POST['name'], 2, 100, 'Имя');
$send->val($_POST['email'], 6, 100, 'E-mail');*/
/*$data = $send->val($_POST['name'], 2, 100, 'Имя');
$data = $send->val($_POST['email'], 6, 100, 'E-mail');*/
//$send->val($_POST['message'], 2, 500, 'Сообщение');


$name = $send->length($_POST['name'], 2, 100);
$email = $send->length($_POST['email'], 6, 100);
if(!$name){
  $data = $send->res('Имя');
}elseif(!$email){
  $data = $send->res('Email');
}



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

