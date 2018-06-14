<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 07.06.2018
 * Time: 13:00
 */

class SendMail
{

  public $a = 'Hy';
  // функция для проверки количества символов в тексте
  function checkTextLength($text, $minLength, $maxLength)
  {
    $result = false;
    $textLength = mb_strlen($text, 'UTF-8');
    if (($textLength >= $minLength) && ($textLength <= $maxLength)) {
      $result = true;
    }
    return $result;
  }

  //фильтрация входящих данных
  function filter($input){
    $text = filter_var($_POST[$input], FILTER_SANITIZE_STRING); // защита от XSS
    return $text;
  }

  // валидация формы
  function val($input, $min, $max){
//  function val($input, $min, $max, $nameInput){
//    $text = $this -> filter($input);
    $text = filter_var($_POST[$input], FILTER_SANITIZE_STRING); // защита от XSS
    $checkTextLength = $this -> checkTextLength($text, $min, $max);
    return $checkTextLength;
    /*if (isset($_POST[$input])){
      if (!$checkTextLength) { // проверка на количество символов в тексте
        $data[$input] = "Поле <b>".$nameInput."</b> содержит недопустимое количество символов";
        $data['result'] = 'error';
      }
    } else {
      $data[$input] = "Поле <b>".$nameInput."</b> не заполнено";
      $data['result'] = 'error';
    }
    return $data;*/
  }


  function bodyMail ($search, $var, $template){
    $data = str_replace($search, isset($var) ? $var : '-', $template);
    return $data;
  }

}