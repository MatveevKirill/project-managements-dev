<div class="container-fluid">
    <div class="row">
        <?php require_once("sidemenu_view.php"); ?>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4"><div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2"><?=$TITLE?></h1>
            </div>
            <div class="table-responsive">
                <table class="col-md-5 mb-5">
                    <thead>
                        <tr>
                            <th width="30%"></th>
                            <th width="70%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">Фамилия</th>
                            <td><?=isset($SURNAME) ? $SURNAME : "<Не определено>"?></td>
                        </tr>
                        <tr>
                            <th scope="row">Имя</th>
                            <td><?=isset($NAME) ? $NAME : "<Не определено>"?></td>
                        </tr>
                        <tr>
                            <th scope="row">Отчество</th>
                            <td><?=isset($MIDDLENAME) ? $MIDDLENAME : "<Не определено>"?></td>
                        </tr>
                        <tr>
                            <th scope="row">Дата рождения</th>
                            <td><?=isset($DATE_BORN) ? $DATE_BORN : "<Не определено>"?></td>
                        </tr>
                        <?php if(isset($TYPE) && $TYPE != "client") { ?>
                        <tr>
                            <th scope="row">Должность</th>
                            <td>
                                <?php
                                    $positions = isset($POSITION) ? json_decode($POSITION, JSON_INVALID_UTF8_IGNORE) : null;

                                    if($positions) {
                                        echo implode(" / ", $positions);
                                    }
                                    else {
                                        echo "<Не определено>";
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Дата начала работы</th>
                            <td><?=isset($DATE_START_WORKING) ? $DATE_START_WORKING : "<Не определено>"?></td>
                        </tr>
                        <tr>
                            <th scope="row">Номер договора</th>
                            <td>
                                <?php
                                    $contract_number = isset($CONTRACT_NUMBER) ?  $CONTRACT_NUMBER : null;
                                    if($contract_number){
                                ?>
                                <a href="/documentation?id=<?=$contract_number?>"><?=$contract_number?></a>
                                <?php
                                    } else {
                                        echo "<Не определено>";
                                    }
                                ?>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php if(isset($TYPE) && $TYPE != "client") { ?>
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                    <h1 class="h2">Проекты пользователя</h1>
                </div>
                <?php } else if(isset($TYPE) && $TYPE == "client") { ?>
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                    <h1 class="h2">Доступные проекты</h1>
                </div>
                <?php } ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Номер счёт-фактуры</th>
                            <th>Тип</th>
                            <th>Название</th>
                            <th>Роль</th>
                            <th>Дата сдачи проекта</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if($MANAGER) {
                                foreach($MANAGER as $projectId => $project_pos){
                                    ?>
                                    <tr>
                                        <td><?=$projectId?></td>
                                        <td>Проект</td>
                                        <td><?=$project_pos['project_name']?></td>
                                        <td>Менеджер проекта</td>
                                        <td><?=$project_pos['deadline']?></td>
                                    </tr>
                                    <?php
                                }
                            }

                            if($STAGES){
                                foreach($STAGES as $projectID => $stage_pos){
                                    ?>
                                    <tr>
                                        <td><?=$projectID?></td>
                                        <td>Стадия</td>
                                        <td><?=$stage_pos['stage_name']?></td>
                                        <td><?=$stage_pos['executorRole']?></td>
                                        <td><?=$stage_pos['deadline']?></td>
                                    </tr>
                                    <?php
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>
      </div>
    </div>
</div>