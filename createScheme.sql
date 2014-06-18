CREATE DATABASE `upda` /*!40100 DEFAULT CHARACTER SET utf8 */;
CREATE TABLE `dat` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `file_name` varchar(255) NOT NULL COMMENT 'ファイル名',
  `file_ext` varchar(10) DEFAULT '' COMMENT '拡張子',
  `ins_datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '登録年月日',
  `up_ip` varchar(40) NOT NULL COMMENT 'アップロード元IPアドレス',
  `up_host` varchar(255) NOT NULL COMMENT 'アップロード元ホスト',
  `del_flg` tinyint(4) NOT NULL DEFAULT '0' COMMENT '削除フラグ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
