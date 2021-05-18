<div style="height:auto; min-height:100%; ">
    <div style="text-align: center; width:800px; margin-left: -400px; position:absolute; top: 30%; left:50%;">
        <h1 style="margin:0; font-size:150px; line-height:150px; font-weight:bold;">500</h1>
        <h2 style="margin-top:20px;font-size: 30px;">Internal Server Error</h2>
        <p><?=$ERROR_CODE?></p>
        <p>Если Вы видите эту страницу постоянно при переходе по ссылке, то удалите cookie-файлы.</p>
        <button class="btn btn-primary" onclick="location.href='/';">Вернуться на главную страницу</button>
        <button class="btn btn-primary" onclick="delete_cookie();">Удалить Cookie</button>
    </div>
</div>
<script>
    function delete_cookie(){
        let cookies = document.cookie.split(";");
        for (var i = 0; i < cookies.length; i++) {
            let cookie = cookies[i];
            let eqPos = cookie.indexOf("=");
            let name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
            document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
        }
        location.href = '/';
    }
</script>
