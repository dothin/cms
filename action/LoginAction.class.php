<?php
/**
 * @Author: gaohuabin
 * @Date:   2016-01-24 13:02:13
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2016-02-01 17:20:44
 */
class LoginAction extends Action{

    //构造方法，初始化
    public function __construct($tpl){
        
        parent::__construct($tpl,new ManageModel());
        
    }


    public function action(){
        switch (@$_GET['action']) {
            case 'login':
                $this->login();
                break;
            case 'logout':
                $this->logout();
                break;
        }
    }

    public function login(){
        if (isset($_POST['send'])) {
            if (Validate::checkNull($_POST['admin_user'])) Tool::alertBack('用户名不得为空');
            if (Validate::checkLength($_POST['admin_user'],2,'min')) Tool::alertBack('用户名不得小于2位');
            if (Validate::checkLength($_POST['admin_user'],20,'max')) Tool::alertBack('用户名不得大于20位');
            if (Validate::checkLength($_POST['admin_pass'],6,'min')) Tool::alertBack('密码不得小于6位');
            if(Validate::checkLength($_POST['code'],4,'equal')) Tool::alertBack('验证码位数不对');
            if(Validate::checkEqual(strtolower($_POST['code']),$_SESSION['code'])) Tool::alertBack('验证码错误');
            $this->model->admin_user=$_POST['admin_user'];
            $this->model->last_ip=$_SERVER["REMOTE_ADDR"];
            $this->model->admin_pass=md5($_POST['admin_pass']);
            $login=$this->model->queryLoginManage();
            if($login){
                $preArr=explode(',', $login->premission);
                if (in_array('1', $preArr)) {
                    $_SESSION['admin']['admin_user']=$login->admin_user;
                    $_SESSION['admin']['level_name']=$login->level_name;
                    $_SESSION['admin']['premission']=$preArr;
                    $this->model->setLoginCount();
                    Tool::alertLocation(null,'admin.php');
                }else{
                    Tool::alertBack('没有登录权限');
                }
                
            }else{
                Tool::alertBack('用户名或密码错误');
            }
        }
    }

    public function logout(){
        Tool::clearSession();
        Tool::alertLocation(null,'admin_login.php');
    }

}