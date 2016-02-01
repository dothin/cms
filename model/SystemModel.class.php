<?php
/**
 * @Author: gaohuabin
 * @Date:   2016-01-19 00:39:38
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2016-02-01 00:56:39
 */
//系统配置实体类
class SystemModel extends Model{

    private $webname;
    private $page_size;
    private $article_size;
    private $nav_size;
    private $ro_time;
    private $ro_num;
    private $updir;
    private $adver_text_num;
    private $adver_pic_num;

    //拦截器（__set）
    public function __set($key,$value){
        $this->$key=Tool::mysqlString($value);
    }
    //拦截器（__get）
    public function __get($key){
        return $this->$key;
    }

    //获取数据
    public function querySystem(){
        $sql="SELECT 
                    webname,
                    page_size,
                    article_size,
                    nav_size,
                    updir,
                    ro_time,
                    ro_num,
                    adver_text_num,
                    adver_pic_num
               FROM cms_system
              WHERE id=1";
        return parent::one($sql);
    }
    //修改
    public function updateSystem(){
        $sql="UPDATE 
                    cms_system 
                SET 
                    webname='$this->webname',
                    page_size='$this->page_size',
                    article_size='$this->article_size',
                    nav_size='$this->nav_size',
                    updir='$this->updir',
                    ro_time='$this->ro_time',
                    ro_num='$this->ro_num',
                    adver_text_num='$this->adver_text_num',
                    adver_pic_num='$this->adver_pic_num'
                WHERE 
                    id=1";
        return parent::aud($sql);
    }
    
}