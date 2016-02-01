<?php
/**
 * @Author: gaohuabin
 * @Date:   2016-01-19 20:12:34
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2016-01-30 10:22:19
 */

class UserAction extends Action{

    //构造方法，初始化
    public function __construct($tpl){
        
        parent::__construct($tpl,new UserModel());
        
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
        parent::page($this->model->queryUserTotal());
        $this->tpl->assign('show',true);
        $this->tpl->assign('title','会员列表');
        $object=$this->model->queryAllUser();
        foreach ($object as $value) {
            switch ($value->state) {
                case '0':
                    $value->state='被封杀的会员';
                    break;
                case '1':
                    $value->state='待审核的会员';
                    break;
                case '2':
                    $value->state='初级会员';
                    break;
                case '3':
                    $value->state='中级会员';
                    break;
                case '4':
                    $value->state='高级会员';
                    break;
                case '5':
                    $value->state='VIP会员';
                    break;
                
                default:
                    # code...
                    break;
            }
        }
        $this->tpl->assign('AllUser',$object);
    }

    private function add(){
        if (isset($_POST['send'])) {
            if (Validate::checkNull($_POST['user'])) Tool::alertBack('用户名不得为空');
            if (Validate::checkLength($_POST['user'],2,'min')) Tool::alertBack('用户名不得小于2位');
            if (Validate::checkLength($_POST['user'],20,'max')) Tool::alertBack('用户名不得大于20位');
            if (Validate::checkLength($_POST['pass'],6,'min')) Tool::alertBack('密码不得小于6位');
            if(Validate::checkEqual(strtolower($_POST['pass']),$_POST['notpass'])) Tool::alertBack('密码和确认密码不一致');
            if (Validate::checkNull($_POST['email'])) Tool::alertBack('电子邮件不得为空');
            if (Validate::checkEmail($_POST['email'])) Tool::alertBack('电子邮件格式不正确');
            if (!Validate::checkNull($_POST['question'])&&!Validate::checkNull($_POST['answer'])){
                $this->model->question=$_POST['question'];
                $this->model->answer=$_POST['answer'];
            }
            $this->model->user=$_POST['user'];
            $this->model->pass=sha1($_POST['pass']);
            $this->model->email=$_POST['email'];
            $this->model->face=$_POST['face'];
            $this->model->state=$_POST['state'];
            if($this->model->checkUser()) Tool::alertBack('该用户名已被注册');
            if($this->model->checkEmail()) Tool::alertBack('该邮件已被注册');
            if ($this->model->addUser()) {
                Tool::alertLocation('恭喜您注册成功','user.php?action=show');
            }else{
                Tool::alertBack('注册失败');
            }
        }
        $this->tpl->assign('add',true);
        $this->tpl->assign('prev_url',PREV_URL);
        $this->tpl->assign('title','新增会员');
        $this->tpl->assign('OptionFaceOne',range(1, 9));
        $this->tpl->assign('OptionFaceTwo',range(10, 24));
    }

    private function update(){
        if (isset($_POST['send'])) {
            if(Validate::checkNull($_POST['pass'])){
                $this->model->pass=$_POST['ppass'];
            }else{
                if (Validate::checkLength($_POST['pass'],6,'min')) Tool::alertBack('密码不得小于6位');
                $this->model->pass=sha1($_POST['pass']);
            }
            if (Validate::checkNull($_POST['email'])) Tool::alertBack('电子邮件不得为空');
            if (Validate::checkEmail($_POST['email'])) Tool::alertBack('电子邮件格式不正确');
            if (!Validate::checkNull($_POST['question'])&&!Validate::checkNull($_POST['answer'])){
                $this->model->question=$_POST['question'];
                $this->model->answer=$_POST['answer'];
            }
            $this->model->id=$_POST['id'];
            $this->model->email=$_POST['email'];
            $this->model->face=$_POST['face'];
            $this->model->state=$_POST['state'];
            if ($this->model->updateUser()) {
                Tool::alertLocation('恭喜您修改成功','user.php?action=show');
            }else{
                Tool::alertBack('修改失败');
            }
        }
        if (isset($_GET['id'])) {
            $this->model->id=$_GET['id'];
            $user=$this->model->queryOneUser();
            if ($user) {
                $this->tpl->assign('id',$_GET['id']);
                $this->tpl->assign('update',true);
                $this->tpl->assign('title','修改会员');
                $this->tpl->assign('prev_url',PREV_URL);
                $this->tpl->assign('user',$user->user);
                $this->tpl->assign('pass',$user->pass);
                $this->tpl->assign('email',$user->email);
                $this->tpl->assign('answer',$user->answer);
                $this->tpl->assign('facesrc',$user->face);
                $this->face($user->face);
                $this->question($user->question);
                $this->state($user->state);
            }else{
                Tool::alertBack('此会员不存在');
            }
            
        }else{
            Tool::alertBack('非法操作');
        }
    }
    private function delete(){
        if (isset($_GET['id'])) {
            $this->model->id=$_GET['id'];
            
            $this->model->deleteUser()?Tool::alertLocation('恭喜您新删除成功！',PREV_URL):Tool::alertBack('很遗憾，删除失败');
        }else{
            Tool::alertBack('非法操作');
        }
    }

    //头像
    private function face($face){
        $one=range(1,9);
        $two=range(10,24);
        foreach ($one as $value) {
            if ('0'.$value.'.gif'==$face) $selected='selected';
            @$html.='<option '.@$selected.' value="0'.$value.'.gif" >0'.$value.'.gif</option>';
            $selected='';
        }
        foreach ($two as $value) {
            if ($value.'.gif'==$face) $selected='selected';
            @$html.='<option '.@$selected.' value="'.$value.'.gif" >'.$value.'.gif</option>';
            $selected='';
        }
        $this->tpl->assign('face',$html);
    }
    //提问
    private function question($question){
        $questionArr=array('您父亲的姓名？','您母亲的姓名？','您配偶的姓名？');
        foreach ($questionArr as $value) {
            if ($question==$value) $selected='selected';
            @$html.='<option '.@$selected.' value="'.$value.'" >'.$value.'</option>';
            $selected='';
        }
        $this->tpl->assign('question',$html);
    }
    //状态
    private function state($state){
        $stateArr=array('被封杀的会员','待审核的会员','初级会员','中级会员','高级会员','VIP会员');
        foreach ($stateArr as $key => $value) {
            if ($key==$state) $checked='checked';
            @$html.='<input type="radio" '.@$checked.' name="state" value="'.$key.'">'.$value;
            $checked='';
        }
        $this->tpl->assign('state',$html);
    }

}