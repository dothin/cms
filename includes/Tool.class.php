<?php
/**
 * @Author: gaohuabin
 * @Date:   2016-01-19 13:17:52
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2016-02-01 16:59:59
 */
class Tool {
        
    //弹窗跳转
    static public function alertLocation($info, $url) {
        if (!empty($info)) {
            echo "<script type='text/javascript'>alert('$info');location.href='$url';</script>";
            exit();
        }else{
            header('Location:'.$url);
            exit();
        }
        
    }
    //日期转换
    static public function objDate(&$object,$field){
        if ($object) {
            foreach ($object as $value) {
                $value->$field=date('m-d',strtotime($value->$field));
            }
        }
        
    }
    
    //弹窗返回
    static public function alertBack($info) {
        echo "<script type='text/javascript'>alert('$info');history.back();</script>";
        exit();
    }
    //弹窗关闭
    static public function alertClose($info){
        echo "<script type='text/javascript'>alert('$info');close();</script>";
        exit();
    }
    //清理session
    static public function clearSession(){
        if (session_start()) {
            session_destroy();
        }
    }

    //将当前文件转化成.tpl文件名
    static public function tplName(){
        $str=explode('/', $_SERVER["SCRIPT_NAME"]);
        $str=explode('.', $str[count($str)-1]);
        return $str[0];
    }

    //显示html过滤处理
    static public function htmlString($data){
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                //递归
                $string[$key]=Tool::htmlString($value);
            }
        }elseif (is_object($data)) {
            foreach ($data as $key => $value) {
                @$string->$key=Tool::htmlString($value);
            }
        }else{
            $string=htmlspecialchars($data);
        }
        return @$string;
    }
    //数据库输出过滤
    static public function mysqlString($data){
        return mysqli_real_escape_string(DB::getDB(),$data);
        //return addslashes($data);
    }

    //弹窗赋值（上传专用）
    static public function alertOpenerClose($info,$path){
        echo "<script type='text/javascript'>alert('$info');</script>";
        echo "<script type='text/javascript'>opener.document.content.thumbnail.value='$path';</script>";
        echo "<script type='text/javascript'>opener.document.content.pic.style.display='block';opener.document.content.pic.src='$path';</script>";
        echo "<script type='text/javascript'>window.close();</script>";
        exit();
    }

    /**
     * [subStr 字符串截取]
     * @param  [type] $object   [操作对象]
     * @param  [type] $field    [字段名称]
     * @param  [type] $length   [要截取的长度]
     * @param  [type] $encoding [编码]
     * @return [type]           [description]
     */
    static public function subStr(&$object,$field,$length,$encoding){
        if ($object) {
            if (is_array($object)) {
                foreach ($object as $value) {
                    if (mb_strlen($value->$field,$encoding)>$length) {
                        $value->$field=mb_substr($value->$field, 0,$length,$encoding).'...';
                    }
                }
            }else{
                if (mb_strlen($object,$encoding)>$length) {
                    return mb_substr($object, 0,$length,$encoding).'...';
                }else{
                    return $object;
                }
                
            }
        }
    }
    /**
     * [objArrOfStr 将对象数组转换成字符串，并且去掉最后的逗号]
     * @param  [type] $object [操作对象]
     * @param  [type] $field  [字段]
     * @return [type]         [description]
     */
    static public function objArrOfStr(&$object,$field){
        if ($object) {
            foreach ($object as $value) {
                @$html.=$value->$field.',';
            }
        }
        return substr(@$html,0, strlen(@$html)-1);
    }

    //将HTML字符串转换成和美女标签
    static public function unHtml($str){
        return htmlspecialchars_decode($str);
    }
}