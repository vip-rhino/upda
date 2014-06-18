<?php

class DbConnect {
    
    const _DSN = "mysql:dbname=upda;host=localhost;charset=utf-8";
    const _USER = "root";
    const _PASSWORD = "pass";
    
    private $PDO = NULL;
    
    public function __construct() {
        $this->connect();
    }
    
    protected function connect() {
        $ret = FALSE;
        try {
            if(is_null($this->PDO)) {
                $this->PDO = new PDO(self::_DSN, self::_USER, self::_PASSWORD);
                $ret = TRUE;
            }
        } catch (Exception $ex) {
            error_log($ex->getFile()."[".$ex->getLine()."]:::".$ex->getMessage());
            throw new Exception($ex);
        }
        return $ret;
    }
    
    public function deconnect() {
        try {
            $this->PDO = NULL;
        } catch (Exception $ex) {
            error_log($ex->getFile()."[".$ex->getLine()."]:::".$ex->getMessage());
            throw new Exception($ex);
        }
    }
    
    protected function startTransaction() {
        try{
            $ret = $this->PDO->beginTransaction();
        } catch (Exception $ex) {
            error_log($ex->getFile()."[".$ex->getLine()."]:::".$ex->getMessage());
            throw new Exception($ex);
        }
        return $ret;
    }
    
    protected function execRollback() {
        try{
            $ret = $this->PDO->rollBack();
        } catch (Exception $ex) {
            error_log($ex->getFile()."[".$ex->getLine()."]:::".$ex->getMessage());
            throw new Exception($ex);
        }
        return $ret;
    }
    
    protected function execCommit() {
        try{
            $ret = $this->PDO->commit();
        } catch (Exception $ex) {
            error_log($ex->getFile()."[".$ex->getLine()."]:::".$ex->getMessage());
            throw new Exception($ex);
        }
        return $ret;
    }
    
    protected function select($sql, $params = NULL) {
        try {
            $sth = $this->PDO->prepare($sql);
            $sth->execute($params);
            $ret = $sth->fetchAll();
        } catch (PDOException $ex) {
            error_log($ex->getFile()."[".$ex->getLine()."]:::".$ex->getMessage());
            throw new Exception($ex);
        }
        return $ret;
    }
    
    protected function insert($sql, $params) {
        try {
            $sth = $this->PDO->prepare($sql);
            $sth->execute($params);
            $ret = $this->PDO->lastInsertId();
        } catch (PDOException $ex) {
            error_log($ex->getFile()."[".$ex->getLine()."]:::".$ex->getMessage());
            throw new Exception($ex);
        }
        return $ret;
    }
    
    protected function update($sql, $params) {
        try {
            $sth = $this->PDO->prepare($sql);
            $ret = $sth->execute($params);
        } catch (PDOException $ex) {
            error_log($ex->getFile()."[".$ex->getLine()."]:::".$ex->getMessage());
            throw new Exception($ex);
        }
        return $ret;
    }
    
    protected function delete($sql, $params) {
        try {
            $sth = $this->PDO->prepare($sql);
            $ret = $sth->execute($params);
        } catch (PDOException $ex) {
            error_log($ex->getFile()."[".$ex->getLine()."]:::".$ex->getMessage());
            throw new Exception($ex);
        }
        return $ret;
    }
    
}
