<?php
/**
 * @Author: gaohuabin
 * @Date:   2016-01-20 11:02:18
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2016-02-01 17:21:43
 */
/**
 * 验证类
 */
class Validate{
    /**
     * [checkNull 非空验证]
     * @param  [type] $data [数据]
     * @return [type]       [description]
     */
    static public function checkNull($data){
        if (trim($data) == '') return true;
        return false;
    }
    /**
     * [checkLength 长度验证]
     * @param  [type] $data   [数据]
     * @param  [type] $length [长度]
     * @return [type]         [description]
     */
    static public function checkLength($data,$length,$flag){
        //不管中文还是英文，都按一个字符一位运算
        if ($flag=='min') {
            if(mb_strlen(trim($data),'utf-8')<$length) return true;
            return false;
        }elseif ($flag=='max') {
            if(mb_strlen(trim($data),'utf-8')>$length) return true;
            return false;
        }elseif ($flag=='equal') {
            if (mb_strlen(trim($data),'utf-8')!=$length) return true;
            return false;
        }else{
            Tool::alertBack('checkLength参数传递错误');
        }
    }
    /**
     * [checkEqual 一致性验证]
     * @param  [type] $data        [数据]
     * @param  [type] $anotherData [对比数据]
     * @return [type]              [description]
     */
    static public function checkEqual($data,$equalData){
        if(trim($data)!=trim($equalData)) return true;
        return false;
    }
    /**
     * [checkSession 验证管理员是否正常登录]
     * @return [type] [description]
     */
    static public function checkSession(){
        if (!isset($_SESSION['admin'])) Tool::alertBack('请先登录');
    }
    /**
     * [checkNum 判断是否为数字]
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    static public function checkNum($data){
        if (!is_numeric($data)) return true;
        return false;
    }
    /**
     * [checkEmail 验证邮件格式]
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    static public function checkEmail($data){
        if (!preg_match('/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/', $data)) return true;
        return false;
    }
    /**
     * [checkPremission 权限管理]
     * @param  [type] $data [权限标识号]
     * @param  [type] $info [提示信息]
     * @return [type]       [description]
     */
    static public function checkPremission($data,$info){
        if (!in_array($data,$_SESSION['admin']['premission'])){
            Tool::alertBack($info);
        } 
    }
}