<!DOCTYPE html>
<?php
require_once ("./class/DataHandling.php");
session_start();
$handling = new DataHandling();
$msg = "";
$tableData = "";
if($_SESSION["ticket"] !== filter_input(INPUT_POST, "ticket")) {
    $msg = "<a href=\"index.php\">とｐ</a>画面からやり直して下さい。";
} else {
    if($handling->connect()){
        try {
            if(count($_FILES) === 0 || count($_FILES) > 5){
                $msg = "アップロードファイル数が異常です。<br />ファイル数を確認して再試行して下さい。";
            } else {
                foreach ($_FILES["files"]["error"] as $key => $value) {
                    if ($value == UPLOAD_ERR_OK) {
                        $size = $_FILES["files"]["size"][$key];
                        $name = $_FILES["files"]["name"][$key];
                        $ext = preg_replace('/^.*\.([^.]+)$/D', '$1', $name);
                        $type = $_FILES["files"]["type"][$key];
                        $temp = $_FILES["files"]["tmp_name"][$key];
                        $dateHash = md5(date("YmdD His"));
                        $rename = md5($name.$dateHash);
                        if($size > 1048576) {
                            $tableData .= "<tr><td>失敗</td><td>".$name."</td></tr>";
                            continue;
                        }
                        //file upload
                        if (move_uploaded_file($temp, "./dat/".$rename.".".$ext)) {
                            $tableData .= "<tr><td>成功</td><td><a href=\"./dat/".$rename.".".$ext."\" target=\"_blank\">./dat/".$rename.".".$ext."</a></td></tr>";
                        } else {
                            $tableData .= "<tr><td>失敗</td><td>".$name."</td></tr>";
                        }
                        //db add
                        $ary = array("name" => $rename, "ext" => $ext, "ip" => filter_input(INPUT_SERVER, "REMOTE_ADDR"), "host" => gethostbyaddr(filter_input(INPUT_SERVER, "REMOTE_ADDR")));
                        $handling->insertDat($ary);
                    }
                }
            }
            $handling->deconnect();
        } catch (Exception $ex) {
            $handling->deconnect();
            error_log($ex->getFile()."[".$ex->getLine()."]:::".$ex->getMessage());
        }
    } else {
        $msg = "DB接続に失敗しました。<br /><a href=\"index.php\">とｐ</a>画面からやり直して下さい。";
        
    }
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
                <div id="list" class="content">
                    <table>
                        <?php echo $tableData; ?>
                    </table>
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
