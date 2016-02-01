<?php
/**
 * @Author: gaohuabin
 * @Date:   2016-01-19 00:39:38
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2016-02-01 17:00:45
 */
//等级实体类
class LevelModel extends Model{

    private $id;
    private $level_name;
    private $level_info;
    private $premission;
    private $limit;

    //拦截器（__set）
    public function __set($key,$value){
        $this->$key=Tool::mysqlString($value);
    }
    //拦截器（__get）
    public function __get($key){
        return $this->$key;
    }
    //获取等级总记录
    public function queryLevelTotal(){
        $sql="SELECT 
              COUNT(*)
              FROM 
                    cms_level";
        return parent::total($sql);
    }
    //查询所有等级has limit
    public function queryLimitLevels(){
        $sql="SELECT 
                    id,
                    level_name,
                    level_info,
                    premission
              FROM 
                    cms_level
              ORDER BY
                    id DESC
                    $this->limit";
        return parent::all($sql);
    }
    //查询所有等级no limit
    public function queryLevels(){
        $sql="SELECT 
                    id,
                    level_name,
                    level_info
              FROM 
                    cms_level
              ORDER BY
                    id DESC";
        return parent::all($sql);
    }
    //查询单个等级
    public function queryOneLevel(){
        $sql="SELECT 
                    id,
                    level_name,
                    level_info,
                    premission
              FROM 
                    cms_level
              WHERE id='$this->id'
                 OR level_name='$this->level_name'
              LIMIT 1";
        return parent::one($sql);
    }
    //新增等级
    public function addLevel(){
        $sql="INSERT INTO 
                        cms_level (
                                    level_name,
                                    level_info,
                                    premission
                            ) 
                            VALUES (
                                    '$this->level_name',
                                    '$this->level_info',
                                    '$this->premission'
                                )";
        return parent::aud($sql);
    }
    //修改等级
    public function updateLevel(){
        $sql="UPDATE 
                    cms_level 
                SET 
                    level_name='$this->level_name',
                    level_info='$this->level_info',
                    premission='$this->premission'
                WHERE 
                    id='$this->id' 
                LIMIT 1";
        return parent::aud($sql);
    }
    //删除等级
    public function deleteLevel(){
        $sql="DELETE FROM 
                        cms_level 
                    WHERE 
                        id='$this->id' 
                    LIMIT 1";
        return parent::aud($sql);
    }
}