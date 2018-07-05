<?php
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
        $data['info'][] = 'Размер файла ' . $fileName . ' превышает 3 Мбайт';
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