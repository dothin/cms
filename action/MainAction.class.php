<?php
/**
 * @Author: gaohuabin
 * @Date:   2016-01-24 13:02:13
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2016-02-01 17:24:18
 */
class MainAction extends Action{

    //构造方法，初始化
    public function __construct($tpl){
        
        parent::__construct($tpl);
        
    }


    public function action(){
        $this->cacheNum();
        if (@$_GET['action']=='clearcache') {
            if (in_array('2',$_SESSION['admin']['premission'])) {
                $this->clearCache();
            }else{
                Tool::alertBack('没有清除缓存的权限');
            }
            
        }
    }

    //计算缓存目录的文件量
    private function cacheNum(){
        $dir=ROOT_PATH.'/cache/';
        $num=sizeof(scandir($dir));
        //扫描出的文件包含当前上级目录和当前目录，所以要减去2
        $this->tpl->assign('cacheNum',$num-2);
    }

    //清理缓存
    private function clearCache(){
        $dir=ROOT_PATH.'/cache/';
        if (!$dh=@opendir($dir)) return;
        while (false!==($obj=readdir($dh))) {
            if ($obj=='.'||$obj=='..') continue;
            @unlink($dir.''.$obj);
        }
        closedir($dh);
        Tool::alertLocation('清理完毕','main.php');
    }

}