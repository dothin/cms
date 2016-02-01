<?php
/**
 * @Author: gaohuabin
 * @Date:   2016-01-19 00:39:38
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2016-02-01 14:04:26
 */
//管理员实体类
class ManageModel extends Model{

    private $id;
    private $admin_user;
    private $admin_pass;
    private $level;
    private $last_ip;
    private $limit;

    //拦截器（__set）
    public function __set($key,$value){
        $this->$key=Tool::mysqlString($value);
    }
    //拦截器（__get）
    public function __get($key){
        return $this->$key;
    }
    //获取管理员总记录
    public function queryManageTotal(){
        $sql="SELECT 
              COUNT(*)
              FROM 
                    cms_manage";
        return parent::total($sql);
    }
    //设置管理员登录统计次数，IP，时间
    public function setLoginCount(){
        $sql="UPDATE 
                    cms_manage 
                SET 
                    login_count=login_count+1,
                    last_ip='$this->last_ip',
                    last_time=NOW()
                WHERE 
                    admin_user='$this->admin_user' 
                LIMIT 1";
        return parent::aud($sql);
    }
    //查询登录管理员
    public function queryLoginManage(){
        $sql="SELECT 
                    m.id,
                    m.admin_user,
                    l.level_name,
                    l.premission
              FROM 
                    cms_manage m,
                    cms_level l
              WHERE m.admin_user='$this->admin_user'
                AND m.admin_pass='$this->admin_pass'
                AND m.level=l.id
              LIMIT 1";
        return parent::one($sql);
    }
    //查询所有管理员
    public function queryManages(){
        $sql="SELECT 
                    m.id,
                    m.admin_user,
                    m.level,
                    m.login_count,
                    m.last_time,
                    m.last_ip,
                    l.level_name
              FROM 
                    cms_manage m,
                    cms_level l
              WHERE m.level=l.id
              ORDER BY
                    m.id DESC
                    $this->limit";
        return parent::all($sql);
    }
    //查询单个管理员
    public function queryOneManage(){
        $sql="SELECT 
                    id,
                    admin_user,
                    admin_pass,
                    level
              FROM 
                    cms_manage
              WHERE id='$this->id'
                 OR admin_user='$this->admin_user'
                 OR level='$this->level'
              LIMIT 1";
        return parent::one($sql);
    }
    //新增管理员
    public function addManage(){
        $sql="INSERT INTO 
                        cms_manage (
                                    admin_user,
                                    admin_pass,
                                    level,
                                    reg_time
                            ) 
                            VALUES (
                                    '$this->admin_user',
                                    '$this->admin_pass',
                                    '$this->level',
                                    NOW()
                                )";
        return parent::aud($sql);
    }
    //修改管理员
    public function updateManage(){
        $sql="UPDATE 
                    cms_manage 
                SET 
                    admin_pass='$this->admin_pass',
                    level='$this->level'
                WHERE 
                    id='$this->id' 
                LIMIT 1";
        return parent::aud($sql);
    }
    //删除管理员
    public function deleteManage(){
        $sql="DELETE FROM 
                        cms_manage 
                    WHERE 
                        id='$this->id' 
                    LIMIT 1";
        return parent::aud($sql);
    }
}