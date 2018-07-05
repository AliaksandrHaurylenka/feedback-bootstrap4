<?php
/**
* Для версий PHP ниже 7 убрать const
* и раскомментировать define
*/
// стартовый путь ('http://mydomain.ru/')
// почта, с которой посылается письмо
// должна содержать доменное имя сайта, напр. mail@sport-kostukovka.by
$startPath = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . $_SERVER['HTTP_HOST'] . '/';

// максимальный размер файла 512Кбайт (512*1024=524288)
//const MAX_FILE_SIZE = 524288;
const MAX_FILE_SIZE = 3145728;
//define('MAX_FILE_SIZE', 524288);

// директория для хранения загруженных файлов
$uploadPath = dirname(dirname(__FILE__)) . '/uploads/';

// разрешённые расширения файлов
$allowedExtensions = array('gif', 'jpg', 'png');

// от какого email будет отправляться письмо
// const MAIL_FROM = 'mail@sport-kostukovka.by';
//const MAIL_FROM = 'goric0312@mail.ru';
define('MAIL_FROM', 'mail@sport-kostukovka.by');

// от какого имени будет отправляться письмо
//const MAIL_FROM_NAME = 'Web-freelancer.by';
define('MAIL_FROM_NAME', 'Костюковка-Спорт');

// тема письма
//const MAIL_SUBJECT = 'Сообщение с сайта Web-freelancer.by';
define('MAIL_SUBJECT', 'Сообщение с сайта Костюковка-Спорт');

// кому необходимо отправить письмо
//const MAIL_ADDRESS = 'aliaksandr.haurylenka@gmail.com';
$bcc = ['aliaksandr.haurylenka@gmail.com'];// для массовой рассылки

// настройки mail для информирования пользователя о доставке сообщения
//const MAIL_SUBJECT_CLIENT = 'Ваше сообщение доставлено';
define('MAIL_SUBJECT_CLIENT', 'Ваше сообщение доставлено');