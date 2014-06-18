<!DOCTYPE html>
<?php
require_once ("./class/DataHandling.php");
session_start();
$handling = new DataHandling();
$msg = "";
$tableData = "";
$file = filter_input(INPUT_POST, "file");
$id = filter_input(INPUT_POST, "id");
if($_SESSION["ticket"] !== filter_input(INPUT_POST, "ticket") || $id === "" || $file === "") {
    $msg = "<a href=\"index.php\">とｐ</a>画面からやり直して下さい。";
} else {
    $handling->deleteDat(array($id));
    /* 削除フラグ利用時はこっち */
    //$handling->updateDat(array($id));
    unlink("./dat/".$file);
    /* 削除じゃなくて移動はこっち */
    //rename("./dat/".$file, "./trash/".$file);
    $msg = $file."の削除が完了しました。";
}
$_SESSION['ticket'] = "";
?>
<html>
    <head>
        <title>うｐろだ作ってみるテスト</title>
        <meta charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="css/reset.css" />
        <link rel="stylesheet" type="text/css" href="css/simplegrid.css" />
        <link rel="stylesheet" type="text/css" href="css/style.css" />
    </head>
    <body>
        <div class="grid grid-pad">
            <div class="col-1-1">
                <div id="title" class="content">
                    <a href="./index.php"><h1>うｐろだ作ってみるテスト</h1></a>
                </div>
            </div>
        </div>
        <div class="grid grid-pad">
            <div class="col-1-1">
                <div class="content">
                    <div><?php echo $msg; ?></div>
                </div>
            </div>
        </div>
        <div class="grid grid-pad">
            <div class="col-1-1">
                <div class="content">
                    <div><a href="index.php">とｐ</a>に戻る</div>
                </div>
            </div>
        </div>
        <div class="grid grid-pad">
            <div class="col-1-1">
                <div id="footer" class="content">
                    (c) 2014 rhino.
                </div>
            </div>
        </div>
    </body>
</html>
