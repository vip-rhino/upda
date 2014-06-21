<?php
require_once ('./class/DbConnect.php');

class DataHandling extends DbConnect {
    
    const _SELECT_DAT = " SELECT * FROM dat WHERE del_flg = 0 ORDER BY ins_datetime DESC ";
    const _SELECT_DAT_COUNT = " SELECT count(id) FROM dat WHERE del_flg = 0 ";
    const _INSERT_DAT = " INSERT INTO dat (file_name, file_ext, up_ip, up_host) VALUES (?, ?, ?, ?) ";
    const _UPDATE_DAT = " UPDATE dat SET del_flg = 1 WHERE id = ? ";
    const _DELETE_DAT = " DELETE FROM dat WHERE id = ? ";
    
    protected function makeLimit($limitParam) {
        try {
            $ret = '';
            if(isset($limitParam['from']) && isset($limitParam['to'])) {
                $ret = ' LIMIT ' . $limitParam['from'] . ' , ' . $limitParam['to'] . ' ';
            }
        } catch (Exception $ex) {
            error_log($ex->getFile()."[".$ex->getLine()."]:::".$ex->getMessage());
            throw new Exception($ex);
        }
        return $ret;
    }
    
    protected function selectDat($limitParam = array()) {
        try {
            $limit = $this->makeLimit($limitParam);
            $ret = parent::select(self::_SELECT_DAT.$limit);
        } catch (Exception $ex) {
            error_log($ex->getFile()."[".$ex->getLine()."]:::".$ex->getMessage());
            throw new Exception($ex);
        }
        return $ret;
    }

    protected function selectDatCount() {
        try {
            $ret = parent::select(self::_SELECT_DAT_COUNT);
        } catch (Exception $ex) {
            error_log($ex->getFile()."[".$ex->getLine()."]:::".$ex->getMessage());
            throw new Exception($ex);
        }
        return $ret[0][0];
    }
    
    protected function insertDat($param) {
        try {
            $ary = $this->makeInsertDatArgs($param);
            $ret = parent::insert(self::_INSERT_DAT, $ary);
        } catch (Exception $ex) {
            error_log($ex->getFile()."[".$ex->getLine()."]:::".$ex->getMessage());
            throw new Exception($ex);
        }
        return $ret;
    }
    
    private function makeInsertDatArgs($param) {
        try {
            $ret = array();
            if(isset($param['name'])) { array_push($ret, $param['name']); }
            if(isset($param['ext'])) { array_push($ret, $param['ext']); }
            if(isset($param['ip'])) { array_push($ret, $param['ip']); }
            if(isset($param['host'])) { array_push($ret, $param['host']); }
        } catch (Exception $ex) {
            error_log($ex->getFile()."[".$ex->getLine()."]:::".$ex->getMessage());
            throw new Exception($ex);
        }
        return $ret;
    }
    
    protected function updateDat($param) {
        try {
            $ret = parent::update(self::_UPDATE_DAT, $param);
        } catch (Exception $ex) {
            error_log($ex->getFile()."[".$ex->getLine()."]:::".$ex->getMessage());
            throw new Exception($ex);
        }
        return $ret;
    }
    
    protected function deleteDat($param) {
        try {
            $ret = parent::delete(self::_DELETE_DAT, $param);
        } catch (Exception $ex) {
            error_log($ex->getFile()."[".$ex->getLine()."]:::".$ex->getMessage());
            throw new Exception($ex);
        }
        return $ret;
    }
}
