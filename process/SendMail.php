<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 07.06.2018
 * Time: 13:00
 */

class SendMail
{

  // функция для проверки количества символов в тексте
  function checkTextLength($text, $minLength, $maxLength)
  {
    $result=false;
    $textLength=mb_strlen($text, 'UTF-8');
    if(($textLength>=$minLength) && ($textLength<=$maxLength)){
      $result=true;
    }
    return $result;
  }

  //фильтрация входящих данных
  function filter($input)
  {
    $text=filter_var($input, FILTER_SANITIZE_STRING); // защита от XSS
    return $text;
  }

  // валидация формы
  function val($input, $min, $max, $nameInput)
  {
    $data['result'] = 'success';
    $text=$this->filter($input);
    $checkTextLength=$this->checkTextLength($text, $min, $max);
    if (isset($input)){
      if (!$checkTextLength) { // проверка на количество символов в тексте
        $data[$nameInput] = "Поле <b>".$nameInput."</b> содержит недопустимое количество символов";
        $data['result'] = 'error';
      }
    }
//    echo json_encode($data);
//    var_dump($data);
//    return json_encode($data);
    return $data;
  }




    function length($input, $min, $max){
      $text=$this->filter($input);
      $checkTextLength=$this->checkTextLength($text, $min, $max);
//      var_dump($checkTextLength);
      return $checkTextLength;
  }

  function res($nameInput){
    $data[$nameInput] = "Поле <b>".$nameInput."</b> содержит недопустимое количество символов";
    $data['result'] = 'error';
    return $data;
  }


  function bodyMail($search, $var, $template)
  {
    $data=str_replace($search, isset($var) ? $var : '-', $template);
    return $data;
  }

}