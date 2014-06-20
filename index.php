<!DOCTYPE html>
<?php
require_once ("./class/DataHandling.php");
session_start();
$_SESSION["ticket"] = md5(uniqid());
$handling = new DataHandling();
$tableData = "";
if($handling->connect()) {
    try {
        $dat = $handling->selectDat();
        $handling->deconnect();
        foreach ($dat as $row) {
            if($row["file_name"] !== "") {
                $filename = $row["file_name"].".".$row["file_ext"];
            } else {
                $filename = $row["file_name"];
            }
            $tableData .= "<tr><td><a href=\"#\" onclick=\"delAction(".$row["id"].",'".$filename."');\">[削除]</a></td><td><a href=\"./dat/".$filename."\" target=\"_blank\">".$filename."</a></td></tr>".PHP_EOL;
        }
        $tableData = "<table>".$tableData."</table>";
        $handling->deconnect();
    } catch (Exception $ex) {
        $handling->deconnect();
        error_log($ex->getFile()."[".$ex->getLine()."]:::".$ex->getMessage());
    }
} else {
    $tableData = "DB接続に失敗しました。<br />";
}
?>
<html>
    <head>
        <title>うｐろだ作ってみるテスト</title>
        <meta charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="css/reset.css" />
        <link rel="stylesheet" type="text/css" href="css/simplegrid.css" />
        <link rel="stylesheet" type="text/css" href="css/style.css" />
        <script>
            function uploadAction(){
                var files = document.getElementById("files").files;
                if(files.length === 0) {
                    alert("アップロードするファイルを選択して下さい。");
                    return false;
                }
                if(files.length > 5) {
                    alert("一度にアップロード出来るファイル数は5ファイルまでです。");
                    return false;
                }
                for (var i = 0; i < files.length; i++) {
                    if(1048576 < files[i].size){
                        alert("最大ファイルサイズは1MByte(1048576Byte)です。");
                        return false;
                    }
                }
                document.add.submit();
            }
            function delAction(id, file){
                document.getElementById("id").value = id;
                document.getElementById("file").value = file;
                document.del.submit();
            }
        </script>
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
                <div id="welkom" class="content">
                    <div>誰でもうｐできて気に食わなければ誰でも削除できる、そんなうｐろだがあってもいいじゃない。</div>
                    <div>ファイルをアップした時点で<a href="#">利用規約</a>に承諾されたものとしますので、<a href="#">利用規約</a>を一読してからご利用下さい。</div>
                </div>
            </div>
        </div>
        <div class="grid grid-pad">
            <div class="col-1-1">
                <div id="choice" class="content">
                    <form name="add" action="add.php" method="post" enctype="multipart/form-data">
                        <input type="file" name="files[]" id="files" multiple>
                        <input type="hidden" name="ticket" value="<?php echo $_SESSION['ticket']; ?>">
                    </form>
                </div>
            </div>
        </div>
        <div class="grid grid-pad">
            <div class="col-1-1">
                <a class="button" href="#" onclick="uploadAction();">
                    <div id="upload" class="content button">
                        うｐしてみるテスト
                    </div>
                </a>
            </div>
        </div>
        <div class="grid grid-pad">
            <div class="col-1-1">
                <div id="list" class="content"><?php echo $tableData; ?></div>
            </div>
        </div>
        <form action="del.php" name="del" method="post">
            <input type="hidden" id="id" name="id">
            <input type="hidden" id="file" name="file">
            <input type="hidden" name="ticket" value="<?php echo $_SESSION['ticket']; ?>">
        </form>
        <div class="grid grid-pad">
            <div class="col-1-1">
                <div id="footer" class="content">
                    (c) 2014 rhino.
                </div>
            </div>
        </div>
    </body>
</html>
