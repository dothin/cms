<?php
/**
 * @Author: gaohuabin
 * @Date:   2016-01-24 14:16:18
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2016-01-29 18:30:02
 */
class RegisterAction extends Action{

    //构造方法，初始化
    public function __construct($tpl){
        
        parent::__construct($tpl);
        
    }
    //执行方法
    public function action(){
        switch ($_GET['action']) {
            case 'reg':
                $this->reg();
                break;
            case 'login':
                $this->login();
                break;
            case 'logout':
                $this->logout();
                break;
            default:
                Tool::alertBack('非法操作');
                break;
        }
    }
    
    private function reg(){
        if (isset($_POST['send'])) {
            parent::__construct($this->tpl,new UserModel());
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
            if(Validate::checkLength($_POST['code'],4,'equal')) Tool::alertBack('验证码位数不对');
            if(Validate::checkEqual(strtolower($_POST['code']),$_SESSION['code'])) Tool::alertBack('验证码错误');
            $this->model->user=$_POST['user'];
            $this->model->pass=sha1($_POST['pass']);
            $this->model->email=$_POST['email'];
            $this->model->face=$_POST['face'];
            $this->model->state=1;
            $this->model->time=time();
            if($this->model->checkUser()) Tool::alertBack('该用户名已被注册');
            if($this->model->checkEmail()) Tool::alertBack('该邮件已被注册');
            if ($this->model->addUser()) {
                $cookie=new Cookie('user',$this->model->user,0);
                $cookie->setCookie();
                $cookie=new Cookie('face',$this->model->face,0);
                $cookie->setCookie();
                Tool::alertLocation('恭喜您注册成功','./');
            }else{
                Tool::alertBack('注册失败');
            }
        }
        $this->tpl->assign('reg',true);
        $this->tpl->assign('OptionFaceOne',range(1, 9));
        $this->tpl->assign('OptionFaceTwo',range(10, 24));
    }

    private function login(){
        if (isset($_POST['send'])) {
            parent::__construct($this->tpl,new UserModel());
            if (Validate::checkNull($_POST['user'])) Tool::alertBack('用户名不得为空');
            if (Validate::checkLength($_POST['user'],2,'min')) Tool::alertBack('用户名不得小于2位');
            if (Validate::checkLength($_POST['user'],20,'max')) Tool::alertBack('用户名不得大于20位');
            if (Validate::checkLength($_POST['pass'],6,'min')) Tool::alertBack('密码不得小于6位');
            if(Validate::checkLength($_POST['code'],4,'equal')) Tool::alertBack('验证码位数不对');
            if(Validate::checkEqual(strtolower($_POST['code']),$_SESSION['code'])) Tool::alertBack('验证码错误');
            $this->model->user=$_POST['user'];
            $this->model->pass=sha1($_POST['pass']);
            if (!!$user=$this->model->checkLogin()){
                $cookie=new Cookie('user',$user->user,$_POST['time']);
                $cookie->setCookie();
                $cookie=new Cookie('face',$user->face,$_POST['time']);
                $cookie->setCookie();
                $this->model->time=time();
                $this->model->id=$user->id;
                $this->model->setLaterUser();
                Tool::alertLocation(null,'./');
            }else{
                Tool::alertBack('用户名或密码错误');
            }

        }
        $this->tpl->assign('login',true);
    }

    private function logout(){
        $cookie=new Cookie('user');
        $cookie->removeCookie();
        $cookie=new Cookie('face');
        $cookie->removeCookie();
        Tool::alertLocation(null,'./');
    }
}