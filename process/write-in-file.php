<?php
// отправка данных формы в файл
if ($data['result'] == 'success') {
  $name = $send->sendFile($name);
  $email = $send->sendFile($email);
  $email = $send->sendFile($email);
  $phone = $send->sendFile($phone);
  $select = $send->sendFile($select);
  $radio = $send->sendFile($radio);
  $check = $send->sendFile($check);
  $message = $send->sendFile($message);
  $output = "---------------------------------" . "\n";
  $output .= date("d-m-Y H:i:s") . "\n";
  $output .= $send->label("Имя пользователя: ", $name);
  $output .= $send->label("Адрес email: ", $email);
  $output .= $send->label("Телефон: ", $phone);
  $output .= $send->label("Select: ", $select);
  if (isset($multiSelect)) {
    $output .= "Multi Select: " . "\n";
    foreach ($multiSelect as $select) {
      $output .= $select . "\n";
    }
  }
  $output .= $send->label("Radio: ", $radio);
  $output .= $send->label("Check: ", $check);
  $output .= $send->label("Сообщение: ", $message);
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