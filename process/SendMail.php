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
  function val($input, $min, $max, $nameInput){
//    $text = filter_var($_POST[$input], FILTER_SANITIZE_STRING); // защита от XSS
    $text = $this -> filter($input);
    $checkTextLength = $this -> checkTextLength($text, $min, $max);
    if (isset($_POST[$input])){
      if (!$checkTextLength) { // проверка на количество символов в тексте
        $data[$input] = "Поле <b>".$nameInput."</b> содержит недопустимое количество символов";
        $data['result'] = 'error';
      }
    } else {
      $data[$input] = "Поле <b>".$nameInput."</b> не заполнено";
      $data['result'] = 'error';
    }
    return $data;
  }


  function bodyMail ($search, $var, $template){
    $data = str_replace($search, isset($var) ? $var : '-', $template);
    return $data;
  }


  function valFile(){
    // валидация файлов
    if (isset($_FILES['attachment'])) {
      // перебор массива $_FILES['attachment']
      foreach ($_FILES['attachment']['error'] as $key => $error) {
        // если файл был успешно загружен на сервер (ошибок не возникло), то...
        if ($error == UPLOAD_ERR_OK) {
          // получаем имя файла
          $fileName = $_FILES['attachment']['name'][$key];
          // получаем расширение файла в нижнем регистре
          $fileExtension = mb_strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
          // получаем размер файла
          $fileSize = $_FILES['attachment']['size'][$key];
          // результат проверки расширения файла
          $resultCheckExtension = true;
          // проверяем расширение загруженного файла
          if (!in_array($fileExtension, $allowedExtensions)) {
            $resultCheckExtension = false;
            $data['info'][] = 'Тип файла ' . $fileName . ' не соответствует разрешенному';
            $data['result'] = 'error';
          }
          // проверяем размер файла
          if ($resultCheckExtension && ($fileSize > MAX_FILE_SIZE)) {
            $data['info'][] = 'Размер файла ' . $fileName . ' превышает 512 Кбайт';
            $data['result'] = 'error';
          }
        }
      }
      // если ошибок валидации не возникло, то...
      if ($data['result'] == 'success') {
        // переменная для хранения имён файлов
        $attachments = array();
        // перемещение файлов в директорию UPLOAD_PATH
        foreach ($_FILES['attachment']['name'] as $key => $attachment) {
          // получаем имя файла
          $fileName = basename($_FILES['attachment']['name'][$key]);
          // получаем расширение файла в нижнем регистре
          $fileExtension = mb_strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
          // временное имя файла на сервере
          $fileTmp = $_FILES['attachment']['tmp_name'][$key];
          // создаём уникальное имя
          $fileNewName = uniqid('upload_', true) . '.' . $fileExtension;
          // перемещаем файл в директорию
          if (!move_uploaded_file($fileTmp, $uploadPath . $fileNewName)) {
            // ошибка при перемещении файла
            $data['info'][] = 'Ошибка при загрузке файлов';
            $data['result'] = 'error';
          } else {
            $attachments[] = $uploadPath . $fileNewName;
          }
        }
      }
    }
  }


  function uploadFile(){
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

    return $bodyMail;
  }
}