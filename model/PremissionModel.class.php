<?php
/**
 * @Author: gaohuabin
 * @Date:   2016-01-19 00:39:38
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2016-02-01 13:50:07
 */
//权限实体类
class PremissionModel extends Model{
    private $id;
    private $name;
    private $info;
    private $limit;

    //拦截器（__set）
    public function __set($key,$value){
        $this->$key=Tool::mysqlString($value);
    }
    //拦截器（__get）
    public function __get($key){
        return $this->$key;
    }
    //获取权限总记录
    public function queryPremissionTotal(){
        $sql="SELECT 
              COUNT(*)
              FROM 
                    cms_premission";
        return parent::total($sql);
    }
    //查询所有权限has limit
    public function queryLimitPremissions(){
        $sql="SELECT 
                    id,
                    name,
                    info
              FROM 
                    cms_premission
              ORDER BY
                    id DESC
                    $this->limit";
        return parent::all($sql);
    }
    //查询所有权限no limit
    public function queryPremissions(){
        $sql="SELECT 
                    id,
                    name,
                    info
              FROM 
                    cms_premission
              ORDER BY
                    id ASC";
        return parent::all($sql);
    }
    //查询单个权限
    public function queryOnePremission(){
        $sql="SELECT 
                    id,
                    name,
                    info
              FROM 
                    cms_premission
              WHERE name='$this->name'
                 OR id='$this->id'
              LIMIT 1";
        return parent::one($sql);
    }
    //新增权限
    public function addPremission(){
        $sql="INSERT INTO 
                        cms_premission (
                                    name,
                                    info
                            ) 
                            VALUES (
                                    '$this->name',
                                    '$this->info'
                                )";
        return parent::aud($sql);
    }
    //修改权限
    public function updatePremission(){
        $sql="UPDATE 
                    cms_premission 
                SET 
                    name='$this->name',
                    info='$this->info'
                WHERE 
                    id='$this->id' 
                LIMIT 1";
        return parent::aud($sql);
    }
    //删除权限
    public function deletePremission(){
        $sql="DELETE FROM 
                        cms_premission 
                    WHERE 
                        id='$this->id' 
                    LIMIT 1";
        return parent::aud($sql);
    }
}