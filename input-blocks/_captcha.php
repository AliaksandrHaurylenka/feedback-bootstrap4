<!-- Капча -->
<div class="captcha">
  <div class="refresh-captcha">
    <img class="img-captcha img-responsive" src="/captcha/captcha.php"
         data-src="/captcha/captcha.php" alt="">
    <span>* Нажмите на картинку, чтобы обновить.</span>
  </div>
  <div class="form-group has-feedback">
    <label for="captcha_a" class="control-label">Код с картинки</label>
    <input type="text" name="captcha" maxlength="6" required="required" id="captcha"
           class="form-control captcha" placeholder="*******" autocomplete="off">
  </div>
</div>