<?php
/**
 * @Author: gaohuabin
 * @Date:   2016-01-24 13:02:13
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2016-02-01 17:14:35
 */
class SystemAction extends Action{

    //构造方法，初始化
    public function __construct($tpl){
        
        parent::__construct($tpl,new SystemModel());
        
    }

    public function action(){
        $this->show();
    }

    private function show(){
        if (isset($_POST['send'])) {
            $this->model->webname=$_POST['webname'];
            $this->model->page_size=$_POST['page_size'];
            $this->model->article_size=$_POST['article_size'];
            $this->model->nav_size=$_POST['nav_size'];
            $this->model->updir=$_POST['updir'];
            $this->model->ro_time=$_POST['ro_time'];
            $this->model->ro_num=$_POST['ro_num'];
            $this->model->adver_text_num=$_POST['adver_text_num'];
            $this->model->adver_pic_num=$_POST['adver_pic_num'];
            if($this->model->updateSystem()){
                $br="\r\n";
                $tab="\t";
                $profile='<?php'.$br;
                $profile.=$tab."//系统配置文件".$br;
                $profile.=$tab."define('WEBNAME', '{$this->model->webname}');".$br;
                $profile.=$tab."define('PAGE_SIZE', {$this->model->page_size});".$br;
                $profile.=$tab."define('ARTICLE_SIZE', {$this->model->article_size});".$br;
                $profile.=$tab."define('NAV_SIZE', {$this->model->nav_size});".$br;
                $profile.=$tab."define('UPDIR', '{$this->model->updir}');".$br;

                $profile.=$br;
                $profile.=$tab."//轮播器配置".$br;
                $profile.=$tab."define('RO_TIME', {$this->model->ro_time});".$br;
                $profile.=$tab."define('RO_NUM', {$this->model->ro_num});".$br;

                $profile.=$br;
                $profile.=$tab."//广告服务".$br;
                $profile.=$tab."define('ADVER_TEXT_NUM', {$this->model->adver_text_num});".$br;
                $profile.=$tab."define('ADVER_PIC_NUM', {$this->model->adver_pic_num});".$br;

                $profile.=$br;
                $profile.=$tab."//不可修改的配置".$br;
                $profile.=$br;
                $profile.=$tab."//数据库配置文件".$br;
                $profile.=$tab."define('DB_HOST', 'localhost'); ".$br;
                $profile.=$tab."define('DB_USER', 'root');  ".$br;
                $profile.=$tab."define('DB_PASS', ''); ".$br;
                $profile.=$tab."define('DB_NAME', 'cms'); ".$br;
                $profile.=$tab."define('DB_PORT', 3306); ".$br;
                $profile.=$br;
                $profile.=$tab."define('MARK', ROOT_PATH.'/images/yc.png'); ".$br;
                $profile.=$tab."define('PREV_URL', @\$_SERVER[\"HTTP_REFERER\"]); ".$br;
                $profile.=$br;
                $profile.=$tab."//模板配置信息".$br;
                $profile.=$tab."define('TPL_DIR',ROOT_PATH.'/templates/');".$br;
                $profile.=$tab."define('TPL_C_DIR',ROOT_PATH.'/templates_c/'); ".$br;
                $profile.=$tab."define('CACHE',ROOT_PATH.'/cache/'); ".$br;

                $profile.='?>'.$br;
                if(!file_put_contents('../config/profile.inc.php', $profile)){
                    Tool::alertBack('生成配置文件失败');
                }
                Tool::alertLocation('修改成功','system.php');
            }else{
                Tool::alertBack('修改失败');
            }
        }
        $object=$this->model->querySystem();
        $this->tpl->assign('webname',$object->webname);
        $this->tpl->assign('page_size',$object->page_size);
        $this->tpl->assign('article_size',$object->article_size);
        $this->tpl->assign('nav_size',$object->nav_size);
        $this->tpl->assign('updir',$object->updir);
        $this->tpl->assign('ro_time',$object->ro_time);
        $this->tpl->assign('ro_num',$object->ro_num);
        $this->tpl->assign('adver_text_num',$object->adver_text_num);
        $this->tpl->assign('adver_pic_num',$object->adver_pic_num);
    }

}