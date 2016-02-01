<?php
/**
 * @Author: gaohuabin
 * @Date:   2016-01-19 00:39:38
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2016-01-31 17:58:46
 */
//tag实体类
class TagModel extends Model{
    private $id;
    private $count;
    private $tagname;

    //拦截器（__set）
    public function __set($key,$value){
        $this->$key=Tool::mysqlString($value);
    }
    //拦截器（__get）
    public function __get($key){
        return $this->$key;
    }

    //查找单一
    public function queryOneTag(){
        $sql="SELECT 
                    id
              FROM 
                    cms_tag
              WHERE 
                    tagname='$this->tagname'
              LIMIT 1";
        return parent::one($sql);
    }
    
    //新增tag
    public function addTag(){
        $sql="INSERT INTO 
                cms_tag (
                            tagname
                    ) 
                    VALUES (
                            '$this->tagname'
                        )";
        return parent::aud($sql);
    }
    //累计
    public function addTagCount(){
        $sql="UPDATE 
                    cms_tag
                SET 
                    count=count+1
              WHERE 
                    tagname='$this->tagname' 
                LIMIT 1";
        return parent::aud($sql);
    }
    //获取前五条
    public function queryFiveTag(){
        $sql="SELECT 
                    tagname,
                    count
              FROM 
                    cms_tag
              ORDER BY
                    count DESC
              LIMIT 0,5";
        return parent::all($sql);
    }
}