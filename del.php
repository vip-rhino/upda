<!DOCTYPE html>
<?php
require_once ("./class/Upda.php");
$obj = new Upda();
if($_SESSION["ticket"] !== filter_input(INPUT_POST, "ticket")) {
    $msg = "<a href=\"index.php\">とｐ</a>画面からやり直して下さい。";
} else {
    $msg = $obj->del();
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
