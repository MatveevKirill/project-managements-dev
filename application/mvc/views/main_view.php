<div class="container-fluid">
    <div class="row">
        <?php require_once("sidemenu_view.php"); ?>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4"><div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                <h1 class="h2"><?=$TITLE?></h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group mr-2">
                        <a href="/?act=add" class="btn btn-sm btn-outline-secondary">Добавить заказ</a>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Название проекта</th>
                            <th>ФИО менеджера</th>
                            <th>Дата сдачи проекта</th>
                            <th>Статус проекта</th>
                            <th>Количество стадий</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(isset($ORDERS) && $ORDERS){
                                foreach($ORDERS as $order){
                        ?>
                            <tr>
                                <td><?=$order['projectID']?></td>
                                <td>
                                    <a href="/projects/<?=$order['projectID']?>"><?=$order['project_name']?></a>
                                </td>
                                <td>
                                    <a href="/profile/<?=$order['executorID']?>"><?=implode(" ", [$order['surname'], $order['name'], $order['middlename']])?></a></td>
                                <td><?=$order['deadline']?></td>
                                <?php
                                    switch($order['status']){
                                        case "is-active":
                                            ?>
                                            <td class="text-success">Активно</td>
                                            <?php
                                        break;
                                        case "surrender-today":
                                            ?>
                                            <td class="text-success">Сдача сегодня</td>
                                            <?php
                                        break;
                                        case "is-completed":
                                            ?>
                                            <td>Выполнено</td>
                                            <?php
                                        break;
                                        default:
                                            ?>
                                            <td class="text-danger">Просрочено</td>
                                            <?php
                                        break;
                                    }
                                ?>
                                <td>
                                    <a href="/projects/<?=$order['projectID']?>/stages"><?=$order['count_stages']?></a>
                                </td>
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