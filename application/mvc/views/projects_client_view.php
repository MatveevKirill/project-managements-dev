<div class="container-fluid">
    <div class="row">
        <?php require_once("sidemenu_view.php"); ?>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4"><div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2"><?=$TITLE?></h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group mr-2">
                        <a href="/projects/<?=$PROJECT_ID?>" class="btn btn-sm btn-outline-secondary">Вернуться к проекту</a>
                        <?php
                            if(!$IS_EDIT && isset($CLIENT)) {
                        ?>
                        <a href="/projects/<?=$PROJECT_ID?>/client?edit=on" class="btn btn-sm btn-outline-secondary">Редактировать клиента</a>
                        <?php
                            } else if(isset($CLIENT)) {
                        ?>
                        <a href="/projects/<?=$PROJECT_ID?>/client" class="btn btn-sm btn-outline-secondary">Вернуться к клиенту</a>
                        <?php
                            } else {
                        ?>
                        <button type="submit" form="form_client_information" class="btn btn-sm btn-outline-primary">Сохранить данные по клиенту</a>
                        <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <form action="" id="form_client_information" method="POST">
                    <h4 class="mb-4">Данные о клиенте</h4>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="clientName">Имя</label>
                            <input type="text" form="form_client_information" class="form-control" id="clientName" <?=(isset($CLIENT) ? ($IS_EDIT ? "value=''" : "disabled") : "name='clientName' required='required'");?>>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="clientSurname">Фамилия</label>
                            <input type="text" form="form_client_information" class="form-control" id="clientSurname" <?=(isset($CLIENT) ? ($IS_EDIT ? "value=''" : "disabled") : "name='clientSurname' required='required'");?>>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="clientMiddlename">Отчество</label>
                            <input type="text" form="form_client_information" class="form-control" id="clientMiddlename" <?=(isset($CLIENT) ? ($IS_EDIT ? "value=''" : "disabled") : "name='clientMiddlename' required='required'");?>>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="clientPhone">Номер телефона</label>
                            <input type="text" form="form_client_information" class="form-control" id="clientPhone" <?=(isset($CLIENT) ? ($IS_EDIT ? "value=''" : "disabled") : "name='clientPhone' placeholder='+7 (999) 999-99-99' required='required'");?>>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="clientEmail">Электронная почта</label>
                            <input type="email" form="form_client_information" class="form-control" id="clientEmail" <?=(isset($CLIENT) ? ($IS_EDIT ? "value=''" : "disabled") : "name='clientEmail' placeholder='example@domain.ru' required='required'");?>>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="clientDateBorn">Дата рождения</label>
                            <input type="date" form="form_client_information" class="form-control" id="clientDateBorn" <?=(isset($CLIENT) ? ($IS_EDIT ? "value=''" : "disabled") : "name='clientDateBorn'");?>>
                        </div>
                    </div>
                    <h4 class="mb-4">Паспортные данные о клиенте</h4>
                    <div class="row">
                        <div class="col-md-1 mb-3">
                            <label for="clientPassportSerial">Серия</label>
                            <input type="text" form="form_client_information" class="form-control" id="clientPassportSerial" <?=(isset($CLIENT) ? ($IS_EDIT ? "value=''" : "disabled") : "name='clientPassportSerial' placeholder='00 00'");?>>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="clientPassportNumber">Номер</label>
                            <input type="text" form="form_client_information" class="form-control" id="clientPassportNumber" <?=(isset($CLIENT) ? ($IS_EDIT ? "value=''" : "disabled") : "name='clientPassportNumber' placeholder='000000'");?>>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="clientPassportDateGet">Дата выдачи</label>
                            <input type="date" form="form_client_information" class="form-control" id="clientPassportDateGet" <?=(isset($CLIENT) ? ($IS_EDIT ? "value=''" : "disabled") : "name='clientPassportDateGet'");?>>
                        </div>
                        <div class="col-md-7 mb-3">
                            <label for="clientPassportWhoGet">Кем выдан</label>
                            <input type="text" form="form_client_information" class="form-control" id="clientPassportWhoGet" <?=(isset($CLIENT) ? ($IS_EDIT ? "value=''" : "disabled") : "name='clientPassportWhoGet'");?>>
                        </div>
                    </div>
                    <?php
                        if(isset($CLIENTTYPE) && $CLIENTTYPE == "client-physical"){
                    ?>
                    <h4 class="mb-4">Карта физического лица</h4>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="clientCardNumber">Номер карты</label>
                            <input type="text" form="form_client_information" class="form-control" id="clientCardNumber" <?=(isset($CLIENT) ? ($IS_EDIT ? "value=''" : "disabled") : "name='clientCardNumber' placeholder=''");?>>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="clientCardLostDate">Дата окончания действия карты</label>
                            <input type="date" form="form_client_information" class="form-control" id="clientCardLostDate" <?=(isset($CLIENT) ? ($IS_EDIT ? "value=''" : "disabled") : "name='clientCardLostDate' placeholder=''");?>>
                        </div>
                        <div class="col-md-7 mb-3">
                            <label for="clientCardName">Имя на обороте карты</label>
                            <input type="text" form="form_client_information" class="form-control" id="clientCardName" <?=(isset($CLIENT) ? ($IS_EDIT ? "value=''" : "disabled") : "name='clientCardName'");?>>
                        </div>
                    </div>
                    <?php
                        } else if(isset($CLIENTTYPE) && $CLIENTTYPE == "client-legal") {
                    ?>
                    <h4 class="mb-4">Счёт юридического лица</h4>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="clientBillPayment">Расчётный счёт</label>
                            <input type="text" form="form_client_information" class="form-control" id="clientBillPayment" <?=(isset($CLIENT) ? ($IS_EDIT ? "value=''" : "disabled") : "name='clientBillPayment' placeholder=''");?>>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="clientBillCorrPayment">Корреспондентский счёт</label>
                            <input type="date" form="form_client_information" class="form-control" id="clientBillCorrPayment" <?=(isset($CLIENT) ? ($IS_EDIT ? "value=''" : "disabled") : "name='clientBillCorrPayment' placeholder=''");?>>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 mb-3">
                            <label for="clientBillBIK">БИК</label>
                            <input type="text" form="form_client_information" class="form-control" id="clientBillBIK" <?=(isset($CLIENT) ? ($IS_EDIT ? "value=''" : "disabled") : "name='clientBillBIK' placeholder=''");?>>
                        </div>
                        <div class="col-md-10 mb-3">
                            <label for=" ">Полное имя банка</label>
                            <input type="text" form="form_client_information" class="form-control" id="clientBillBankName" <?=(isset($CLIENT) ? ($IS_EDIT ? "value=''" : "disabled") : "name='clientBillBankName'");?>>
                        </div>
                    </div>
                    <?php
                        }
                    ?>
                </form>
            </div>
        </main>
    </div>
</div>