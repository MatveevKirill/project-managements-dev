<div class="container-fluid">
    <div class="row">
        <?php require_once("sidemenu_view.php"); ?>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4"><div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                <h1 class="h2"><?=$TITLE?></h1>
            </div>
            <div class="container-fluid">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="technicalTask" class="lead"><b>Добавить техническое задание</b></label>
                        <input type="file" class="form-control-file" name="technicalTask" id="technicalTask" required="required" accept="application/pdf,application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document">
                    </div>
                    <label for="clientType" class="lead"><b>Тип клиента</b></label>
                    <div class="form-group">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="clientType" id="clientTypePhysical" value="physical">
                            <label class="form-check-label lead" for="clientTypePhysical">Физическое лицо</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="clientType" id="clientTypeLegal" value="legal">
                            <label class="form-check-label lead" for="clientTypeLegal">Юридическое лицо</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="projectName" class="lead"><b>Название проекта</b></label>
                        <input type="text" class="form-control" name="projectName" id="projectName" required="required">
                    </div>
                    <div class="form-group">
                        <label for="projectAbout" class="lead"><b>Описание проекта</b></label>
                        <textarea class="form-control" name="projectAbout" id="projectAbout" required="" rows="5"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-3 form-group">
                            <label for="projectDeadline" class="lead"><b>Время сдачи проекта</b></label>
                            <input type="date" class="form-control" name="projectDeadline" id="projectDeadline" required="required">
                        </div>
                        <div class="col-md-3 form-group">
                            <label for="projectFullCost" class="lead"><b>Максимальная стоимость проекта</b></label>
                            <input type="text" class="form-control" name="projectFullCost" id="projectFullCost" required="required">
                        </div>
                        <div class="col-md-3 form-group">
                            <label class="lead"><b>Менеджер проекта</b></label>
                            <input type="text" class="form-control" value="<?=$SURNAME . ' ' . mb_substr($NAME, 0, 1) . '. ' . mb_substr($MIDDLENAME, 0, 1) . '.';?>" disabled>
                        </div>
                        <div class="col-md-3 form-group">
                            <label class="lead"><b>Завершить ввод данных</b></label>
                            <button type="submit" class="btn btn-primary form-control">Продолжить</button>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>