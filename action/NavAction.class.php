<?php
/**
 * @Author: gaohuabin
 * @Date:   2016-01-19 20:12:34
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2016-01-24 13:58:28
 */

class NavAction extends Action{

    //构造方法，初始化
    public function __construct($tpl){
        
        parent::__construct($tpl,new NavModel());
        
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
            case 'addchild':
                $this->addChild();
                break;
            case 'showchild':
                $this->showChild();
                break;
            case 'sort':
                $this->sort();
                break;
            default:
                $this->query();
                break;
        }
        
    }
    public function showFront(){
        $this->tpl->assign('FrontNav',$this->model->queryFrontNav());
    }
    private function sort(){
        if (isset($_POST['send'])) {
            $this->model->sort=$_POST['sort'];
            if($this->model->setNavSort()) Tool::alertLocation(null,PREV_URL);
        }
    }
    private function addChild(){
        if (isset($_POST['send'])) {
            $this->add();
        }
        if (isset($_GET['id'])) {
            $this->model->id=$_GET['id'];
            $nav=$this->model->queryOneNav();
            is_object($nav)?true:Tool::alertBack('传值的导航ID有误');
            $this->tpl->assign('pid',$nav->id);
            $this->tpl->assign('prev_name',$nav->nav_name);
            $this->tpl->assign('addchild',true);
            $this->tpl->assign('prev_url',PREV_URL);
            $this->tpl->assign('title','新增子导航');
        }
    }

    private function showChild(){
        if (isset($_GET['id'])) {
            $this->model->id=$_GET['id'];
            $nav=$this->model->queryOneNav();
            is_object($nav)?true:Tool::alertBack('传值的导航ID有误');
            parent::page($this->model->queryNavChildTotal());
            $this->tpl->assign('pid',$nav->id);
            $this->tpl->assign('showchild',true);
            $this->tpl->assign('title','子导航列表');
            $this->tpl->assign('prev_name',$nav->nav_name);
            $this->tpl->assign('prev_url',PREV_URL);
            $this->tpl->assign('AllChildNav',$this->model->queryChildNavs());
        }
    }

    private function query(){
        parent::page($this->model->queryNavTotal());
        $this->tpl->assign('show',true);
        $this->tpl->assign('title','导航列表');
        $this->tpl->assign('AllNav',$this->model->queryNavs());
    }

    private function add(){
        if (isset($_POST['send'])) {
            if (Validate::checkNull($_POST['nav_name'])) Tool::alertBack('导航名不得为空');
            if (Validate::checkLength($_POST['nav_name'],2,'min')) Tool::alertBack('导航名不得小于2位');
            if (Validate::checkLength($_POST['nav_name'],20,'max')) Tool::alertBack('导航名不得大于20位');
            if (Validate::checkLength($_POST['nav_info'],200,'max')) Tool::alertBack('导航描述不得大于200位');
            $this->model->nav_name=$_POST['nav_name'];
            if($this->model->queryOneNav()) Tool::alertBack('该导航已存在');
            $this->model->nav_info=$_POST['nav_info'];
            $this->model->pid=$_POST['pid'];
            $returnUrl=$this->model->pid?'nav.php?action=showchild&id='.$this->model->pid:'nav.php?action=show';
            $this->model->addNav()?Tool::alertLocation('恭喜您新增成功！',$returnUrl):Tool::alertBack('很遗憾，新增失败');

        }
        $this->tpl->assign('add',true);
        $this->tpl->assign('prev_url',PREV_URL);
        $this->tpl->assign('title','新增导航');
    }

    private function update(){
        if (isset($_POST['send'])) {
            if (Validate::checkNull($_POST['nav_name'])) Tool::alertBack('导航名不得为空');
            if (Validate::checkLength($_POST['nav_name'],2,'min')) Tool::alertBack('导航名不得小于2位');
            if (Validate::checkLength($_POST['nav_name'],20,'max')) Tool::alertBack('导航名不得大于20位');
            if (Validate::checkLength($_POST['nav_info'],200,'max')) Tool::alertBack('导航描述不得大于200位');
            $this->model->id=$_POST['id'];
            $this->model->nav_name=$_POST['nav_name'];
            $this->model->nav_info=$_POST['nav_info'];
            $this->model->updateNav()?Tool::alertLocation('恭喜您修改成功！',$_POST['prev_url']):Tool::alertBack('很遗憾，修改失败');
        }
        if (isset($_GET['id'])) {
            $this->model->id=$_GET['id'];
            $nav=$this->model->queryOneNav();
            is_object($nav)?true:Tool::alertBack('传值的导航ID有误');
            $this->tpl->assign('nav_name',$nav->nav_name);
            $this->tpl->assign('nav_info',$nav->nav_info);
            $this->tpl->assign('id',$nav->id);
            $this->tpl->assign('prev_url',PREV_URL);
            $this->tpl->assign('update',true);
            $this->tpl->assign('title','修改导航');
        }else{
            Tool::alertBack('非法操作');
        }
    }
    private function delete(){
        if (isset($_GET['id'])) {
            $this->model->id=$_GET['id'];
            $this->model->deleteNav()?Tool::alertLocation('恭喜您新删除成功！',PREV_URL):Tool::alertBack('很遗憾，删除失败');
        }else{
            Tool::alertBack('非法操作');
        }
    }

}