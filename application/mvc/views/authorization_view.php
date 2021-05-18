<?php
    if(isset($_ERROR) && !empty($_ERROR)) {
?>
<div class="container warning-msg">
    <div class="alert alert-warning border lead"><b>Ошибка (<?=$_ERROR['code']?>):</b> <?=$_ERROR['desc']?></div>
</div>
<?php
    }
?>

<form class="form-signin" method="POST" action="">
    <h1 class="h3 mb-3 font-weight-normal text-center">КОНТЕКС</h1>
    <label for="authInputEmail" class="sr-only">Электронная почта</label>
    <input type="email" id="authInputEmail" name="authInputEmail" class="form-control" placeholder="Электронная почта" required="" autofocus="">
    <label for="authInputPassword" class="sr-only">Пароль</label>
    <input type="password" id="authInputPassword" name="authInputPassword" class="form-control" placeholder="Пароль" required="">
    <div class="checkbox mb-3">
        <label>
            <input type="checkbox" name="authRememberMe" value="yes-remember"> Запомнить меня
        </label>
    </div>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Вход</button>
    <p class="mt-5 mb-3 text-muted text-center">КОНТЕКС &copy;<?=date('Y')?></p>
</form>