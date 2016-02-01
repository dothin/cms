<?php
/**
 * @Author: gaohuabin
 * @Date:   2016-01-19 20:12:34
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2016-01-24 13:05:51
 */

class ManageAction extends Action{

    //构造方法，初始化
    public function __construct($tpl){
        parent::__construct($tpl,new ManageModel());
        
    }

    public function action(){
        
        switch (@$_GET['action']) {
            case 'show':
                $this->query();
                break;
            case 'add':
                $this->add();
                break;
            case 'update':
                $this->update();
                break;
            case 'delete':
                $this->delete();
                break;
            default:
                $this->query();
                break;
        }
        
    }

    private function query(){
        parent::page($this->model->queryManageTotal());
        $this->tpl->assign('show',true);
        $this->tpl->assign('title','管理员列表');
        $this->tpl->assign('AllManage',$this->model->queryManages());
        
    }

    private function add(){
        if (isset($_POST['send'])) {
            if (Validate::checkNull($_POST['admin_user'])) Tool::alertBack('用户名不得为空');
            if (Validate::checkLength($_POST['admin_user'],2,'min')) Tool::alertBack('用户名不得小于2位');
            if (Validate::checkLength($_POST['admin_user'],20,'max')) Tool::alertBack('用户名不得大于20位');
            if (Validate::checkLength($_POST['admin_pass'],6,'min')) Tool::alertBack('密码不得小于6位');
            if(Validate::checkEqual($_POST['admin_pass'],$_POST['noadmin_pass'])) Tool::alertBack('密码和确认密码不一致');
            $this->model->admin_user=$_POST['admin_user'];
            if($this->model->queryOneManage()) Tool::alertBack('该用户已存在');
            $this->model->admin_pass=md5($_POST['admin_pass']);
            $this->model->level=$_POST['level'];
            $this->model->addManage()?Tool::alertLocation('恭喜您新增成功！','manage.php?action=show'):Tool::alertBack('很遗憾，新增失败');
        }
        $this->tpl->assign('add',true);
        $this->tpl->assign('title','新增管理员');
        $this->tpl->assign('prev_url',PREV_URL);
        $level=new LevelModel();
        $this->tpl->assign('AllLevel',$level->queryLevels());
    }

    private function update(){
        if (isset($_POST['send'])) {
            $this->model->id=$_POST['id'];
            if (trim($_POST['admin_pass']) == '') {
                $this->model->admin_pass=$_POST['pass'];
            }else{
                if (Validate::checkLength($_POST['admin_pass'],6,'min')) Tool::alertBack('密码不得小于6位');
                $this->model->admin_pass=md5($_POST['admin_pass']);
            }
            $this->model->level=$_POST['level'];
            $this->model->updateManage()?Tool::alertLocation('恭喜您修改成功！',$_POST['prev_url']):Tool::alertBack('很遗憾，修改失败');
        }
        if (isset($_GET['id'])) {
            $this->model->id=$_GET['id'];
            $manage=$this->model->queryOneManage();
            is_object($manage)?true:Tool::alertBack('传值的管理员ID有误');
            $this->tpl->assign('admin_user',$manage->admin_user);
            $this->tpl->assign('admin_pass',$manage->admin_pass);
            $this->tpl->assign('level',$manage->level);
            $this->tpl->assign('update',true);
            $this->tpl->assign('id',$manage->id);
            $this->tpl->assign('title','修改管理员');
            $this->tpl->assign('prev_url',PREV_URL);
            $level=new LevelModel();
            $this->tpl->assign('AllLevel',$level->queryLevels());
        }else{
            Tool::alertBack('非法操作');
        }
    }
    private function delete(){
        if (isset($_GET['id'])) {
            $this->model->id=$_GET['id'];
            $this->model->deleteManage()?Tool::alertLocation('恭喜您新删除成功！',PREV_URL):Tool::alertBack('很遗憾，删除失败');
        }else{
            Tool::alertBack('非法操作');
        }
    }
    
}