<!doctype html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="/vendors/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="/vendors/jgrowl/jquery.jgrowl.min.css">
  <link rel="stylesheet" href="/css/main.css">
  <title>Feedback</title>
</head>
<body>

<div class="row justify-content-center">
  <form id="feedbackForm" class="col-6" method="post" action="/process/process.php" enctype="multipart/form-data" novalidate>
<!--  <form class="col-6" method="post" action="/process/process.php" enctype="multipart/form-data" novalidate>-->
    <? include_once "input-blocks/_name-input.php"?>
<!--    --><?// include_once "input-blocks/_email-input.php"?>
<!--    --><?// include_once "input-blocks/_phone-input.php"?>
<!--    --><?// include_once "input-blocks/_select-input.php"?>
<!--    --><?// include_once "input-blocks/_multiselect-input.php"?>
<!--    --><?// include_once "input-blocks/_textarea-input.php"?>
<!--    --><?// include_once "input-blocks/_file-input.php"?>
<!--    --><?// include_once "input-blocks/_radio-input.php"?>
<!--    --><?// include_once "input-blocks/_check-input.php"?>
    <? include_once "input-blocks/_captcha.php"?>

    <button type="submit" class="btn btn-primary">Submit</button>

    <!-- Индикация загрузки данных формы на сервер -->
    <div class="clearfix"></div>
    <div class="progress" style="display:none; margin-top: 20px;">
      <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar"
           aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0">
        <span class="sr-only">0%</span>
      </div>
    </div>
    <div class="clearfix"></div>
  </form>

  <!-- Сообщение об успешной отправки формы -->
  <div class="alert alert-warning success-message d-none">
    <!-- Сообщение об успешной отправки формы -->
    <div class="card-footer text-muted">
      <!-- Сообщение об успешной отправки формы -->
      Сообщение успешно отправлено. Нажмите на <a class="show-form" href="#">ссылку</a>, чтобы отправить ещё одно сообщение.
    </div>
  </div>
</div>


<script src="/vendors/jquery/jquery-3.2.1.min.js"></script>
<script src="/vendors/bootstrap/js/bootstrap.min.js"></script>
<script src="/vendors/jgrowl/jquery.jgrowl.min.js"></script>
<script src="/js/main.js"></script>

</body>
</html>