<div class="container-fluid">
    <div class="row">
        <?php require_once("sidemenu_view.php"); ?>
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4"><div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                <h1 class="h2"><?=$TITLE?></h1>
            </div>
            <div class="container-fluid mb-5">
                <div class="alert alert-primary lead text-center bordered">Для продолженя выберите активные проекты...</div>
                <form method="POST" action="">
                    <?php
                        $disabled = isset($INVOICES) && count($INVOICES) > 0 ? false : true;
                    ?>
                    <select class="custom-select d-block w-100 col-md-5 mb-2" name="projectID" required <?=($disabled) ? "disabled=''" : ""?>>
                        <option value="">Выбрать...</option>
                        <?php
                            if(isset($INVOICES) && $INVOICES){
                                foreach($INVOICES as $invoice){
                                    ?>
                                    <option name="" value="<?=$invoice['projectID']?>"><?=$invoice['projectID'] . " - " . $invoice['project_name']?></option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                    <button class="btn btn-lg btn-block col-md-5" type="submit" <?=($disabled) ? "disabled=''" : ""?>>Перейти</button>
                </form>
            </div>
        </main>
    </div>
</div>