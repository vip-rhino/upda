
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

