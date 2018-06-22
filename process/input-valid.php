<?php
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