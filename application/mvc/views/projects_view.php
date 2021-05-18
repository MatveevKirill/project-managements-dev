<div class="container-fluid">
    <div class="row">
        <?php require_once("sidemenu_view.php"); ?>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4"><div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2"><?=$TITLE?></h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group mr-2">
                        <a href="/projects/<?=$PROJECT_ID?>/edit" class="btn btn-sm btn-outline-secondary">Редактировать проект</a>
                        <a href="/projects/<?=$PROJECT_ID?>/client" class="btn btn-sm btn-outline-secondary"><?=(count($CLIENT) == 0 ? "Добавить клиента" : "Редактировать клиента")?></a>
                        <a href="/projects/<?=$PROJECT_ID?>/stages" class="btn btn-sm btn-outline-secondary"><?=(count($STAGES) == 0 ? "Добавить стадии" : "Редактировать стадии")?></a>
                        <a href="/invoice/<?=$PROJECT_ID?>" class="btn btn-sm btn-outline-secondary">Счёт-фактура</a>
                    </div>
                </div>
            </div>
            <div class="row ml-2 mr-2">
                <table class="col-md-6 mb-5">
                    <thead>
                        <tr>
                            <th width="40%"></th>
                            <th width="60%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">Название проекта</th>
                            <td><?=isset($PROJECT['project_name']) ? $PROJECT['project_name'] : "<Не определено>"?></td>
                        </tr>
                        <tr>
                            <th scope="row">Описание проекта</th>
                            <td><?=isset($PROJECT['project_about']) ? $PROJECT['project_about'] : "<Не определено>"?></td>
                        </tr>
                        <tr>
                            <th scope="row">Дедлайн проекта</th>
                            <td><?=isset($PROJECT['deadline']) ? $PROJECT['deadline'] : "<Не определено>"?></td>
                        </tr>
                        <tr>
                            <th scope="row">Полная максимальная стоимость</th>
                            <td><?=isset($PROJECT['full_cost']) ? $PROJECT['full_cost'] : "<Не определено>"?></td>
                        </tr>
                        <tr>
                            <th scope="row">Статус архивирования проекта</th>
                            <td><?=isset($PROJECT['is_inarchive']) ? ($PROJECT['is_inarchive'] ? "В архиве" : "Не в архиве") : "<Не определено>"?></td>
                        </tr>
                        <tr>
                            <th scope="row">Файл технического задания</th>
                            <td><?=isset($PROJECT['technical_task']) ? "<a href='$PROJECT[technical_task]' target='_blank'>Открыть</a>" : "<Не определено>"?></td>
                        </tr>
                        <tr>
                            <th scope="row">Статус проекта</th>
                            <td>
                                <?php
                                    switch($PROJECT['project_status']) {
                                        case "is-active": echo "<span class='text-success'>Активен</span>"; break;
                                        case "surrender-today": echo "<span class='text-success'>Сдача сегодня</span>"; break;
                                        case "is-losted": echo "<span class='text-danger'>Просрочен</span>"; break;
                                        default: "<Не определено>"; break;
                                    }
                                ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table class="col-md-6 mb-5">
                    <thead>
                        <tr>
                            <th width="40%"></th>
                            <th width="60%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>Имя клиента</th>
                            <td><?=isset($CLIENT['client']['surname']) && ($CLIENT['client']['name']) && $CLIENT['client']['middlename'] ? ($CLIENT['client']['surname'] . ' ' . $CLIENT['client']['name'] . ' ' . $CLIENT['client']['middlename']) : "<Не определено>"?></td>
                        </tr>
                        <tr>
                            <th>Авторизация в системе</th>
                            <td><?=isset($CLIENT['client']['is_in_system']) ? ($CLIENT['client']['is_in_system'] == "yes" ? "Да" : "Нет") : "<Не определено>"?></td>
                        </tr>
                        <tr>
                            <th>Номер телефона</th>
                            <td><?=isset($CLIENT['client']['phone']) ? $CLIENT['client']['phone'] : "<Не определено>"?></td>
                        </tr>
                        <tr>
                            <th>Электронная почта</th>
                            <td><?=isset($CLIENT['client']['email']) ? $CLIENT['client']['email'] : "<Не определено>"?></td>
                        </tr>
                        <tr>
                            <th>Дата рождения</th>
                            <td><?=isset($CLIENT['client']['date_born']) ? $CLIENT['client']['date_born'] : "<Не определено>"?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="container-fluid mt-3">
                <h1 class="h2">Стадии проекта</h1>
                <?php
                    if(count($STAGES) > 0){
                ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Статус</th>
                                <th>Название стадии</th>
                                <th>Описание стадии</th>
                                <th>Стоимость стадии</th>
                                <th>Ссылка на репозиторий</th>
                                <th>Дедлайн</th>
                                <th>Роль исполнителя</th>
                                <th>Исполнитель</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $counter = 0;
                                foreach($STAGES as $stage){
                                ?>
                                <tr class="<?=(in_array($stage['stage_status'], ["is-completed", "is-losted"]) ? ($stage['stage_status'] == "is-completed" ? "text-success" : "text-danger") : "")?>">
                                    <td><?=++$counter;?></td>
                                    <td>
                                        <?php
                                            switch($stage['stage_status']) {
                                                case "is-active": echo "Активен"; break;
                                                case "surrender-today": echo "Сдача сегодня"; break;
                                                case "is-losted": echo "<span class='text-danger'>Просрочен</span>"; break;
                                                case "is-completed": echo "<span class='text-success'>Выполнена</span>"; break;
                                                default: "<Не определено>"; break;
                                            }
                                        ?>
                                    </td>                                    
                                    <td><?=$stage['stage_name'];?></td>
                                    <td><?=$stage['stage_about'];?></td>
                                    <td><?=$stage['stage_cost'];?></td>
                                    <td><?=$stage['stage_link_github'] ? "<a href='$stage[stage_link_github]' class='btn'>Перейти</a>" : "Отсутствует";?></td>
                                    <td><?=$stage['deadline'];?></td>
                                    <td><?=$stage['executor_role'];?></td>
                                    <td>
                                        <a href="/profile/<?=$stage['executor_id'];?>" class="btn col-md-12"><?=$stage['executor_id'];?></a>
                                    </td>
                                </tr>
                                <?php
                                }
                            ?>
                        </tbody>
                    </table>
                <?php
                    } else {
                ?>
                <div class="alert text-center lead border">
                    <b>Не добавлены стадии для проекта</b>
                    <br />
                    <a href="/projects/" class="btn col-md-2 mt-4">Добавить</a>
                </div>
                <?php
                    }
                ?>
            </div>
        </main>
    </div>
</div>