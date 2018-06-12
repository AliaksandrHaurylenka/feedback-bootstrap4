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
    <? include_once "input-blocks/_name-input.php"?>
    <? include_once "input-blocks/_email-input.php"?>
    <? include_once "input-blocks/_phone-input.php"?>
    <? include_once "input-blocks/_select-input.php"?>
    <? include_once "input-blocks/_multiselect-input.php"?>
    <? include_once "input-blocks/_textarea-input.php"?>
    <? include_once "input-blocks/_file-input.php"?>
    <? include_once "input-blocks/_radio-input.php"?>
    <? include_once "input-blocks/_check-input.php"?>
    <? include_once "input-blocks/_captcha.php"?>

    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
</div>


<script src="/vendors/jquery/jquery-3.2.1.min.js"></script>
<script src="/vendors/bootstrap/js/bootstrap.min.js"></script>
<script src="/vendors/jgrowl/jquery.jgrowl.min.js"></script>
<script src="/js/main.js"></script>

</body>
</html>