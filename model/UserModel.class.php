<?php
/**
 * @Author: gaohuabin
 * @Date:   2016-01-19 00:39:38
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2016-01-30 10:21:15
 */
//用户实体类
class UserModel extends Model{

    private $id;
    private $user;
    private $pass;
    private $email;
    private $question;
    private $answer;
    private $face;
    private $time;
    private $state;
    private $limit;
    //拦截器（__set）
    public function __set($key,$value){
        $this->$key=Tool::mysqlString($value);
    }
    //拦截器（__get）
    public function __get($key){
        return $this->$key;
    }
    //查找单一会员
    public function queryOneUser(){
        $sql="SELECT 
                    id,
                    user,
                    pass,
                    email,
                    state,
                    face,
                    question,
                    answer
              FROM 
                    cms_user
              WHERE id='$this->id'
              LIMIT 1";
        return parent::one($sql);
    }
    //获取会员的总个数
    public function queryUserTotal(){
        $sql="SELECT 
              COUNT(*)
              FROM 
                    cms_user";
        return parent::total($sql);
    }
    //取得所有的会员
    public function queryAllUser(){
        $sql="SELECT 
                    id,
                    user,
                    email,
                    state
              FROM 
                    cms_user
              ORDER BY 
                    date DESC
                    $this->limit";
        return parent::all($sql);
    }
    //注册和登录时更新最近的登录时间戳
    public function setLaterUser(){
        $sql="UPDATE 
                    cms_user
                SET time='$this->time'
              WHERE id='$this->id'
              LIMIT 1";
        return parent::aud($sql);
    }
    //获取6条最近登录的会员
    public function getLaterUser(){
        $sql="SELECT 
                    user,
                    face
              FROM 
                    cms_user
              ORDER BY 
                    time DESC
              LIMIT 0,6";
        return parent::all($sql);
    }
    //检查登录
    public function checkLogin(){
        $sql="SELECT 
                    id,
                    user,
                    pass,
                    face
              FROM 
                    cms_user
              WHERE user='$this->user'
                AND
                    pass='$this->pass'
              LIMIT 1";
        return parent::one($sql);
    }
    //用户名重复
    public function checkUser(){
        $sql="SELECT 
                    id
              FROM 
                    cms_user
              WHERE user='$this->user'
              LIMIT 1";
        return parent::one($sql);
    }
    //邮件重复
    public function checkEmail(){
        $sql="SELECT 
                    id
              FROM 
                    cms_user
              WHERE email='$this->email'
              LIMIT 1";
        return parent::one($sql);
    }
    //新增用户
    public function addUser(){
        $sql="INSERT INTO 
                    cms_user (
                                user,
                                pass,
                                email,
                                question,
                                answer,
                                face,
                                state,
                                time,
                                date
                        ) 
                    VALUES (
                            '$this->user',
                            '$this->pass',
                            '$this->email',
                            '$this->question',
                            '$this->answer',
                            '$this->face',
                            '$this->state',
                            '$this->time',
                            NOW()
                        )";
        return parent::aud($sql);
    }
    //修改会员
    public function updateUser(){
        $sql="UPDATE 
                    cms_user 
                SET 
                    pass='$this->pass',
                    face='$this->face',
                    email='$this->email',
                    question='$this->question',
                    answer='$this->answer',
                    state='$this->state'
                WHERE 
                    id='$this->id' 
                LIMIT 1";
        return parent::aud($sql);
    }
    //删除会员
    public function deleteUser(){
        $sql="DELETE FROM 
                        cms_user 
                    WHERE 
                        id='$this->id' 
                    LIMIT 1";
        return parent::aud($sql);
    }
}