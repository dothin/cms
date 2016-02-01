<?php
/**
 * @Author: gaohuabin
 * @Date:   2016-01-27 00:59:59
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2016-01-30 17:21:37
 */
//静态页面，局部不缓存
class Cache{
    private $flag;
    public function __construct($noCache){
        $this->flag=in_array(Tool::tplName(), $noCache);
    }
    //返回不适用缓存页面的布尔值
    public function noCache(){
        return $this->flag;
    }

    public function action(){
        switch ($_GET['type']) {
            case 'details':
                $this->details();
                break;
            case 'list':
                $this->listc();
                break;
            case 'header':
                $this->header();
                break;
            case 'index':
                $this->index();
                break;
            default:
                # code...
                break;
        }
    }
    //details
    private function details(){
        $content=new ContentModel();
        $content->id=$_GET['id'];
        $this->setContentCount($content);
        $this->getContentCount($content);
        $comment=new CommentModel();
        $comment->cid=$content->id;
        $this->getComment($comment);
        
    }
    //list
    private function listc(){
        $content=new ContentModel();
        $content->id=$_GET['id'];
        $this->getContentCount($content);
        
    }
    //header
    private function header(){
        $cookie=new Cookie('user');
        if ($cookie->getCookie()) {
            echo "
            function getHeader(){
                document.write('{$cookie->getCookie()},您好！<a href=\"register.php?action=logout\">退出</a>');
            }
        ";
        }else{
           echo "
            function getHeader(){
                document.write('<a href=\"register.php?action=login\" class=\"user\">登录</a><a href=\"register.php?action=reg\" class=\"user\">注册</a>');
            }
        "; 
        }
        
    }
    //index
    private function index(){
        $cookie=new Cookie('user');
        $user=$cookie->getCookie();
        $cookie=new Cookie('face');
        $face=$cookie->getCookie();
        if ($user&&$face) {
            $member='<h2>会员信息</h2>';
            $member.='<div class="a">您好，<strong>'.Tool::subStr($user, null,8,'utf-8').'</strong> 欢迎光临</div>';
            $member.='<div class="b">';
            $member.='<img src="images/'.$face.'" alt="'.$user.'">';
            $member.='<a href="" title="">个人中心</a>';
            $member.='<a href="" title="">我的评论</a>';
            $member.='<a href="register.php?action=logout" title="">退出登录</a>';
            $member.='</div>';
        }else{
            $member='<h2>会员登录</h2>';
            $member.='<form method="post" name="login" action="register.php?action=login">';
            $member.='<label>用户名：<input type="text" name="user" class="text" /></label>';
            $member.='<label>密　码：<input type="password" name="pass" class="text" /></label>';
            $member.='<label>验证码：<input type="text" name="code" class="text code" /> <img src="config/code.php" onclick=javascript:this.src="config/code.php?tm="+Math.random(); class="code" /></label>';
            
            $member.='<p><input type="submit" onclick="return checkLogin();" name="send" value="登录" class="submit" /> <a href="register.php?action=reg">注册会员</a> <a href="###">忘记密码?</a></p>';
            $member.='</form>';
        }
        echo "
            function getIndexLogin(){
                document.write('$member');
            }
        ";
    }
    //累计
    private function setContentCount(&$content){
        $content->setContentCount();
    }
    //获取
    private function getContentCount(&$content){
        $count=$content->queryOneContent()->count;
        echo "
            function getContentCount(){
                document.write('$count');
            }
        ";
    }
    //获取评论总量
    private function getComment(&$comment){
        $count=$comment->queryCommentTotal();
        echo "
            function getComment(){
                document.write('$count');
            }
        ";
    }
}