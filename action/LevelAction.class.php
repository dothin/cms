<?php
/**
 * @Author: gaohuabin
 * @Date:   2016-01-19 20:12:34
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2016-02-01 17:26:50
 */

class LevelAction extends Action{

    //构造方法，初始化
    public function __construct($tpl){
        
        parent::__construct($tpl,new LevelModel());
        
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
        parent::page($this->model->queryLevelTotal());
        $this->tpl->assign('show',true);
        $this->tpl->assign('title','等级列表');
        $this->tpl->assign('AllLevel',$this->model->queryLimitLevels());
    }

    private function add(){
        if (isset($_POST['send'])) {

            if (Validate::checkNull($_POST['level_name'])) Tool::alertBack('等级名不得为空');
            if (Validate::checkLength($_POST['level_name'],2,'min')) Tool::alertBack('等级名不得小于2位');
            if (Validate::checkLength($_POST['level_name'],20,'max')) Tool::alertBack('等级名不得大于20位');
            if (Validate::checkLength($_POST['level_info'],200,'max')) Tool::alertBack('等级描述不得大于200位');
            $this->model->level_name=$_POST['level_name'];
            if($this->model->queryOneLevel()) Tool::alertBack('该等级已存在');
            $this->model->level_info=$_POST['level_info'];
            if (@$_POST['premission']) {
                $this->model->premission=implode(',', $_POST['premission']);
            }
            
            $this->model->addLevel()?Tool::alertLocation('恭喜您新增成功！','level.php?action=show'):Tool::alertBack('很遗憾，新增失败');
        }
        $this->tpl->assign('add',true);
        $this->tpl->assign('prev_url',PREV_URL);
        $this->tpl->assign('title','新增等级');
        $premission=new PremissionModel();
            
        $this->tpl->assign('AllPremission',$premission->queryPremissions());
    }

    private function update(){
        if (isset($_POST['send'])) {
            
            if (Validate::checkNull($_POST['level_name'])) Tool::alertBack('等级名不得为空');
            if (Validate::checkLength($_POST['level_name'],2,'min')) Tool::alertBack('等级名不得小于2位');
            if (Validate::checkLength($_POST['level_name'],20,'max')) Tool::alertBack('等级名不得大于20位');
            if (Validate::checkLength($_POST['level_info'],200,'max')) Tool::alertBack('等级描述不得大于200位');
            $this->model->id=$_POST['id'];
            $this->model->level_name=$_POST['level_name'];
            $this->model->level_info=$_POST['level_info'];
            $this->model->premission=implode(',', $_POST['premission']);
            $this->model->updateLevel()?Tool::alertLocation('恭喜您修改成功！',$_POST['prev_url']):Tool::alertBack('很遗憾，修改失败');
        }
        if (isset($_GET['id'])) {
            $premission=new PremissionModel();
            //$this->tpl->assign('AllPremission',$premission->queryPremissions());
            $this->model->id=$_GET['id'];
            $level=$this->model->queryOneLevel();
            is_object($level)?true:Tool::alertBack('传值的等级ID有误');
            $this->tpl->assign('level_name',$level->level_name);
            $this->tpl->assign('level_info',$level->level_info);
            $this->tpl->assign('id',$level->id);
            $this->tpl->assign('prev_url',PREV_URL);
            $this->tpl->assign('update',true);
            $this->tpl->assign('title','修改等级');
            foreach ($premission->queryPremissions() as $value) {
               @$arr[$value->name]=$value->id;
            }
            $this->premission($arr,$level->premission);
        }else{
            Tool::alertBack('非法操作');
        }
    }
    //premission
    private function premission($arr,$premission){
        $premissionArr=$arr;

        //交换key和value
        $result=array_flip($premissionArr);
        $premissionSelected=explode(',', $premission);
        //array_diff取两个数组的差集
        $premissionNoSelected=array_diff($premissionArr, $premissionSelected);
        foreach ($premissionSelected as $key=>$value) {
            @$html.='<input  type="checkbox" name="premission[]" checked value="'.$value.'" />'.$result[$value];
        }
        foreach ($premissionNoSelected as $key=>$value) {

            @$html.='<input  type="checkbox" name="premission[]" value="'.$value.'" />'.$result[$value];
        }
        $this->tpl->assign('premission',$html);
    }
    private function delete(){
        if (isset($_GET['id'])) {
            $this->model->id=$_GET['id'];
            $manage=new ManageModel();
            $manage->level=$this->model->id;
            if($manage->queryOneManage()) Tool::alertBack('该等级有管理员使用，无法删除，请先删除该等级下所有管理员，方可删除该等级');
            $this->model->deleteLevel()?Tool::alertLocation('恭喜您新删除成功！',PREV_URL):Tool::alertBack('很遗憾，删除失败');
        }else{
            Tool::alertBack('非法操作');
        }
    }

}