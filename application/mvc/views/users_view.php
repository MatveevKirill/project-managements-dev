<div class="container-fluid">
    <div class="row">
        <?php require_once("sidemenu_view.php"); ?>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4"><div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                <?php if(isset($ACTION) && $ACTION == "all") {?>
                <h1 class="h2"><?=$TITLE?></h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group mr-2">
                        <a href="/users?act=add" class="btn btn-sm btn-outline-secondary">Добавить пользователя</a>
                    </div>
                </div>
                <?php }else if(isset($ACTION) && $ACTION == "add"){ ?>
                <h1 class="h2">Добавить пользователя</h1>
                <?php } ?>
            </div>
            <?php 
                if(isset($ACTION) && $ACTION == "all") { 
            ?>
            <div class="row">
                <div class="col-md-5">
                    <h1 class="h4">Работники компании</h1>
                    <table class="table">
                        <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th width="15%">ФИО</th>
                                <th width="35%">Должность</th>
                                <th width="15">Номер договора</th>
                                <th width="10%">Проекты</th>
                                <th width="10%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if($ADMINISTRATORS) {
                                    foreach($ADMINISTRATORS as $id => $administrator){
                            ?>
                            <tr>
                                <td><?=$id?></td>
                                <td><?=($administrator['surname'] . ' ' . mb_substr($administrator['name'], 0, 1) . '. ' . mb_substr($administrator['middlename'], 0, 1). '.')?></td>
                                <td><?=implode(", ", json_decode($administrator['position']))?></td>
                                <td>
                                    <a href="/documentation?id=<?=$administrator['contract_number']?>"><?=$administrator['contract_number']?></a>
                                </td>
                                <td>
                                    <a href="/projects?filter_by=user&user_id=<?=$id?>"><?=$id?></a>
                                </td>
                                <td>
                                    <a href="/users?act=edit&id=<?=$id?>" class="btn">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                                    </a>
                                    <?php
                                        if($CFG->getCFGValue('user_id') != $id){
                                    ?>
                                    <a href="/users?act=delete&id=<?=$id?>" class="btn">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-x"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="18" y1="8" x2="23" y2="13"></line><line x1="23" y1="8" x2="18" y2="13"></line></svg>
                                    </a>
                                    <?php
                                        }
                                    ?>
                                </td>
                            </tr>
                            <?php
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-7">
                    <h1 class="h4">Клиенты</h1>
                    <table class="table">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th width="10%">Тип</th>
                                <th width="15%">ФИО</th>
                                <th width="25%">Номер телефона</th>
                                <th width="25%">Эл. почта</th>
                                <th width="20%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if($CLIENTS) {
                                    foreach($CLIENTS as $id => $client){
                            ?>
                            <tr>
                                <td><?=$id?></td>
                                <td><?=($client['types'] == 'client-physical' ? 'Физ. лицо' : 'Юр. лицо')?></td>
                                <td><?=($client['surname'] . ' ' . mb_substr($client['name'], 0, 1) . '. ' . mb_substr($client['middlename'], 0, 1). '.')?></td>
                                <td><?=$client['phone']?></td>
                                <td><?=$client['email']?></td>
                                <td>
                                    <a href="/users?act=edit&id=<?=$id?>" class="btn">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                                    </a>
                                    <a href="/users?act=delete&id=<?=$id?>" class="btn">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-x"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="18" y1="8" x2="23" y2="13"></line><line x1="23" y1="8" x2="18" y2="13"></line></svg>
                                    </a>
                                </td>
                            </tr>
                            <?php
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div> 
            <?php 
                } else if (isset($ACTION) && ($ACTION == "add" || $ACTION == "edit")){
                    $is_disabled
            ?>
                <div class="col-md-8 order-md-1">
                    <form class="needs-validation" novalidate="">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="firstName">Имя</label>
                                <input type="text" class="form-control" id="firstName" placeholder="" value="" required="">
                            </div>
                            <div class="col-md-4">
                                <label for="lastName">Фамилия</label>
                                <input type="text" class="form-control" id="lastName" placeholder="" value="" required="">
                            </div>
                            <div class="col-md-4">
                                <label for="lastName">Отчество</label>
                                <input type="text" class="form-control" id="lastName" placeholder="" value="" required="">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="username">Электронная почта</label>
                                <div class="input-group">
                                    <input type="email" class="form-control" id="username" placeholder="example@domain.ru" required="required">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="address">Адрес проживания</label>
                            <input type="text" class="form-control" id="address" placeholder="" required="">
                        </div>
                        <div class="row">
                            <div class="col-md-5 mb-3">
                                    <label for="country">Тип пользователя</label>
                                    <select class="custom-select d-block w-100" id="country" required="">
                                        <option value="">Выбрать...</option>
                                        <option>Сотрудник</option>
                                        <option>Клиент</option>
                                        <option>Администратор</option>
                                    </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="state">Должность</label>
                                <select class="custom-select d-block w-100" multiple="multiple" id="state" required="">
                                    <option>Администратор</option>
                                    <option>Ведущий разработчик</option>
                                </select>
                            </div>
                        </div>
                        <hr class="mb-4">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="save-info">
                            <label class="custom-control-label" for="save-info">Отправить данные для входа по Email</label>
                        </div>
                        <button class="btn btn-primary btn-lg btn-block mt-3 mb-5" type="submit">Завершить</button>
                    </form>
                </div>
            <?php 
                }
            ?>
        </main>
      </div>
    </div>
</div>