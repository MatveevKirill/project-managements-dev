<div class="container-fluid">
    <div class="row">
        <?php require_once("sidemenu_view.php"); ?>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4"><div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                <h1 class="h2"><?=$TITLE?></h1>
            </div>
            <?php
                if(isset($CLIENT) && count($CLIENT) == 0){
            ?>
            <div class="alert alert-warning lead border text-center">
                <b>Необходимо добавить данные о клиенте для ввода данных о счёт-фактуре.</b>
                <br />
                <a href="/projects/<?=$PROJECT['projectID']?>/client" class="btn">Перейти</a>
            </div>
            <?php
                } else {
            ?>
            <div class="container-fluid mb-5">
                <form action="" method="POST">
                    <div class="row">
                        <div class="col-md-4 order-md-2 mb-4">
                        <h4 class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted">Стадии разработки</span>
                            <span class="badge badge-secondary badge-pill"><?=count($STAGES);?></span>
                        </h4>
                        <ul class="list-group mb-3">
                            <?php
                                if($STAGES){
                                    foreach($STAGES as $stage) {
                                        if(!$stage['stageID']){
                                            break;
                                        }
                            ?>
                                <li class="list-group-item d-flex justify-content-between lh-condensed">
                                    <div class="text-success">
                                        <h6 class="my-0"><a href="/projects/<?=$PROJECT['projectID']?>/stages/<?=$stage['stageID']?>"><?=$stage['stage_name']?></a></h6>
                                        <small class="text-muted">Ответственный:<?=' ' . $stage['executorName']?></small>
                                        <br/>
                                        <small class="text-muted">Роль:<?=' ' . $stage['executorRole']?></small>
                                        <br />
                                        <small class="text-muted">Дата сдачи:<?=' ' . $stage['deadline']?></small>
                                    </div>
                                    <span class="text-muted"><?=$stage['stage_cost'];?></span>
                                </li>
                            <?php
                                    }
                            ?>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Общая сумма (РУБ)</span>
                                <strong><?=$FULL_COST;?></strong>
                            </li>
                            <?php
                                } else {
                            ?>
                            <div class="alert alert-primary lead text-center border">Не добавлены стадии для проекта.</div>
                            <?php
                                }
                            ?>
                        </ul>
                        <button class="btn btn-primary btn-lg btn-block" type="submit" <?=$FULL_COST == 0 ? "disabled" : ""?>>Сформировать счёт-фактуру</button>
                    </div>
                    <div class="col-md-8 order-md-1">
                        <h4 class="mb-3">Данные о клиенте</h4>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label>Имя</label>
                                <input type="text" class="form-control" placeholder="<?=$CLIENT['name']?>" disabled>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="lastName">Фамилия</label>
                                <input type="text" class="form-control" placeholder="<?=$CLIENT['surname']?>" disabled>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="lastName">Отчество</label>
                                <input type="text" class="form-control" placeholder="<?=$CLIENT['middlename']?>" disabled>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label>Электронная почта <span class="text-muted">(При наличии)</span></label>
                            <input type="text" class="form-control" placeholder="<?=$CLIENT['email']?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="fsAddress">Адрес</label>
                            <input type="text" class="form-control" id="fsAddress" name="fsAddress" placeholder="" required="required">
                        </div>
                        <div class="mb-3">
                            <label for="exAddress">Дополнительный адрес <span class="text-muted">(При наличии)</span></label>
                            <input type="text" class="form-control" id="exAddress" name="exAddress" placeholder="">
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="country">Страна</label>
                                <select class="custom-select d-block w-100" id="country" name="country" required="">
                                    <option value="">Выбрать...</option>
                                    <option value="RussianFederation">Российская Федерация</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Тип клиента</label>
                                <input type="text" class="form-control" placeholder="<?=isset($CLIENT['types']) ? ($CLIENT['types'] == "physical" ? "Физическое лицо" : "Юридическое лицо") : "<Не определено>"?>" required="" disabled>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="state">Область</label>
                                <select class="custom-select d-block w-100" id="state" name="state" required="required">
                                    <option value="">Выбрать...</option>
                                    <option value="Moscow">Москва</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="zip">Индекс</label>
                                <input type="text" class="form-control" id="zip" name="zip" placeholder="" required="required">
                            </div>
                        </div>
                        <hr class="mb-4" />
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="resend-on-email">
                            <label class="custom-control-label" for="resend-on-email" name="resend-on-email">Отправить копию на электронную почту клиента.</label>
                        </div>
                        <hr class="mb-4">
                        <h4 class="mb-3">Данные оплаты</h4>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="cc-name">Имя на карте</label>
                                <input type="text" class="form-control" id="cc-name" name="cc-name" placeholder="" required="required">
                                <small class="text-muted">Полное имя на карте большими буквами</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="cc-number">Номер карты</label>
                                <input type="text" class="form-control" id="cc-number" name="cc-number" placeholder="" required="required">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <?php
                }
            ?>  
        </main>
      </div>
    </div>
</div>