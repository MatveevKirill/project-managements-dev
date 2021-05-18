<div class="container-fluid">
    <div class="row">
        <?php require_once("sidemenu_view.php"); ?>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4"><div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                <h1 class="h2"><?=$TITLE?></h1>
            </div>
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                <h1 class="h5">Поиск</h1>
            </div>
            <table class="table-responsive">
                <thead>
                    <tr>
                        <th width="100%"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="same-contract">
                                <label class="custom-control-label" for="same-contract">Только договоры.</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="same-project-documentation">
                                <label class="custom-control-label" for="same-project-documentation">Только документация по проектам.</label>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                <h1 class="h5">Документы</h1>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Тип</th>
                            <th>Название</th>
                            <th>Описание</th>
                            <th>Принадлежит</th>
                            <th>Дата добавления</th>
                            <th>Размер</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Договор</td>
                            <td>Договор о найме №20201101</td>
                            <td>-</td>
                            <td>
                                <a href="/profile/1">Матвеев К. А.</a>
                            </td>
                            <td>31.08.2020</td>
                            <td>800 КБ</td>
                            <td>
                                <a href="/download/20201101">Скачать</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
      </div>
    </div>