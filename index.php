<!DOCTYPE html>
<?php
require_once ("./class/Upda.php");
$_SESSION["ticket"] = md5(uniqid());
$obj = new Upda();
?>
<html>
    <head>
        <title>うｐろだ作ってみるテスト</title>
        <meta charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="css/reset.css" />
        <link rel="stylesheet" type="text/css" href="css/simplegrid.css" />
        <link rel="stylesheet" type="text/css" href="css/style.css" />
        <script src="js/common.js"></script>
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
                <div id="list" class="content"><?php echo $obj->getList(); ?></div>
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
