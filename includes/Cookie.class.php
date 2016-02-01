<?php
/**
 * @Author: gaohuabin
 * @Date:   2016-01-29 00:15:49
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2016-01-29 00:50:35
 */
class Cookie{

    private $name;
    private $value;
    private $time;
    public function __construct($name,$value='',$time=0){
        $this->name=$name;
        $this->value=$value;
        if (empty($time)) {
            $this->time=0;
        }else{
            $this->time=time()+$time;
        }
        
    }

    //创建cookie
    public function setCookie(){
        setcookie($this->name,$this->value,$this->time);
    }

    //获取cookie
    public function getCookie(){
        return @$_COOKIE["$this->name"];
    }

    //移除cookie
    public function removeCookie(){
        setcookie($this->name,'',-1);
    }
}