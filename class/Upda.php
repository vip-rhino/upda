<?php
require_once ('./class/DataHandling.php');

class Upda extends DataHandling {
    
    const _MSG_01 = "DB接続に失敗しました。<br />";
    const _MSG_02 = "アップロードファイル数が異常です。<br />ファイル数を確認して再試行して下さい。";
    const _MSG_03 = "<a href=\"index.php\">とｐ</a>画面からやり直して下さい。";
    const _MSG_04 = "の削除が完了しました。";
    
    public function __construct() {
        session_start();
    }
    
    public function getList(){
        $handling = new DataHandling();
        $list = "";
        try {
            if($handling->connect()) {
                $dat = $handling->selectDat();
                $list = $this->makeFileList($dat);
                $handling->deconnect();
            } else {
                $list = self::_MSG_01;
            }
        } catch (Exception $ex) {
            $handling->deconnect();
            error_log($ex->getFile()."[".$ex->getLine()."]:::".$ex->getMessage());
        }
        return $list;
    }
    
    private function makeFileList($dat) {
        $ret = "";
        foreach ($dat as $row) {
            if($row["file_name"] !== "") {
                $filename = $row["file_name"].".".$row["file_ext"];
            } else {
                $filename = $row["file_name"];
            }
            $ret .= "<tr><td><a href=\"#\" onclick=\"delAction(".$row["id"].",'".$filename."');\">[削除]</a></td><td><a href=\"./dat/".$filename."\" target=\"_blank\">".$filename."</a></td></tr>".PHP_EOL;
        }
        $ret = "<table>".$ret."</table>";
        return $ret;
    }
    
    public function add() {
        $handling = new DataHandling();
        $ret = "";
        try {
            if(count($_FILES) === 0 || count($_FILES) > 5){
                $ret = self::_MSG_02;
                return $ret;
            }
            if($handling->connect()){
                $ret = $this->uploads($handling);
                $handling->deconnect();
            } else {
                $ret = self::_MSG_01.self::_MSG_03;
            }
        } catch (Exception $ex) {
            $handling->deconnect();
            error_log($ex->getFile()."[".$ex->getLine()."]:::".$ex->getMessage());
        }
        return $ret;
    }
    
    private function uploads($handling) {
        $ret = "";
        foreach ($_FILES["files"]["error"] as $key => $value) {
            if ($value == UPLOAD_ERR_OK) {
                $ret .= $this->upload($handling, $key);
            } else {
                $ret = "<tr><td>失敗</td><td>".$_FILES["files"]["name"][$key]."</td></tr>";
            }
        }
        $ret = "<table>".$ret."</table>";
        return $ret;
    }
    
    private function upload($handling, $key) {
        $ret = "";
        $name = $_FILES["files"]["name"][$key];
        $ext = preg_replace('/^.*\.([^.]+)$/D', '$1', $name);
        $rename = md5($name.md5(date("YmdD His")));
        if($_FILES["files"]["size"][$key] > 1048576) {
            $ret = "<tr><td>失敗</td><td>".$name."</td></tr>";
            return $ret;
        }
        if (move_uploaded_file($_FILES["files"]["tmp_name"][$key], "./dat/".$rename.".".$ext)) {
            $ret = "<tr><td>成功</td><td><a href=\"./dat/".$rename.".".$ext."\" target=\"_blank\">./dat/".$rename.".".$ext."</a></td></tr>";
        } else {
            $ret = "<tr><td>失敗</td><td>".$name."</td></tr>";
        }
        $ary = array("name" => $rename, "ext" => $ext, "ip" => filter_input(INPUT_SERVER, "REMOTE_ADDR"), "host" => gethostbyaddr(filter_input(INPUT_SERVER, "REMOTE_ADDR")));
        $handling->insertDat($ary);
        return $ret;
    }
    
    public function del() {
        $handling = new DataHandling();
        $ret = "";
        try {
            $file = filter_input(INPUT_POST, "file");
            $id = filter_input(INPUT_POST, "id");
            if($handling->connect()) {
                $ret = $this->delFile($handling, $id, $file);
                $handling->deconnect();
            } else {
                $ret = self::_MSG_01.self::_MSG_03;
            }
        } catch (Exception $ex) {
            $handling->deconnect();
            error_log($ex->getFile()."[".$ex->getLine()."]:::".$ex->getMessage());
        }
        return $ret;
    }
    
    private function delFile($handling, $id, $file) {
        $ret = "";
        if($_SESSION["ticket"] !== filter_input(INPUT_POST, "ticket") || $id === "" || $file === "") {
            $ret = self::_MSG_03;
        } else {
            $handling->deleteDat(array($id));
            if(file_exists("./dat/".$file)) { unlink("./dat/".$file); }
            /* use del_flg and move trash */
//            $handling->updateDat(array($id));
//            if(file_exists("./dat/".$file)) { rename("./dat/".$file, "./trash/".$file); }
            $ret = $file.self::_MSG_04;
        }
        return $ret;
    }
}
