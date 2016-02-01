<?php
/**
 * @Author: gaohuabin
 * @Date:   2016-01-24 18:13:33
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2016-01-30 22:28:33
 */
class FeedBackAction extends Action{

    //构造方法，初始化
    public function __construct($tpl){
        
        parent::__construct($tpl);
        
    }

    public function action(){
        $this->addComment();
        $this->setCount();
        $this->showComment();
    }

    //新增评论
    private function addComment(){
        if (isset($_POST['send'])) {
            $url='http://'.$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
            if ($url==PREV_URL) {
                if (Validate::checkNull($_POST['content'])) Tool::alertBack('评论内容不得为空');
                if (Validate::checkLength($_POST['content'],255,'max')) Tool::alertBack('评论内容不得大于255位');
                if(Validate::checkLength($_POST['code'],4,'equal')) Tool::alertBack('验证码位数不对');
                if(Validate::checkEqual(strtolower($_POST['code']),$_SESSION['code'])) Tool::alertBack('验证码错误');
            }else{
                if (Validate::checkNull($_POST['content'])) Tool::alertClose('评论内容不得为空');
                if (Validate::checkLength($_POST['content'],255,'max')) Tool::alertClose('评论内容不得大于255位');
                if(Validate::checkLength($_POST['code'],4,'equal')) Tool::alertClose('验证码位数不对');
                if(Validate::checkEqual(strtolower($_POST['code']),$_SESSION['code'])) Tool::alertClose('验证码错误');
            }
            
            parent::__construct($this->tpl,new CommentModel());
            $cookie=new Cookie('user');
            if ($cookie->getCookie()) {
                $this->model->user=$cookie->getCookie();
            }else{
                $this->model->user='游客';
            }
            $this->model->manner=$_POST['manner'];
            $this->model->content=$_POST['content'];
            $this->model->cid=$_GET['cid'];
            $this->model->addComment()?Tool::alertLocation('评论成功，请等待审核','feedback.php?cid='.$this->model->cid):Tool::alertLocation('评论失败，请重新添加','feedback.php?cid='.$this->model->cid);
        }
    }

    //显示评论
    private function showComment(){

        if (isset($_GET['cid'])) {
            parent::__construct($this->tpl,new CommentModel());
            $this->model->cid=$_GET['cid'];
            $content=new ContentModel();
            $content->id=$_GET['cid'];
            if (!$content->queryOneContent()) Tool::alertBack('不存在此评论');
            parent::page($this->model->queryCommentTotal());
            $object=$this->model->queryAllComment();
            $object2=$this->model->queryThreeHotComment();
            $object3=$content->queryTwentyHotContent();
            $this->setObject($object);
            $this->setObject($object2);
            
            $contents=$content->queryOneContent();
            $this->tpl->assign('titlec',$contents->title);
            $this->tpl->assign('info',$contents->info);
            $this->tpl->assign('id',$contents->id);
            $this->tpl->assign('cid',$this->model->cid);
            $this->tpl->assign('AllComment',$object);
            $this->tpl->assign('ThreeHotComment',$object2);
            $this->tpl->assign('TwentyHotContent',$object3);
        }else{
            Tool::alertBack('非法操作');
        }
    }
    //支持和反对
    private function setCount(){
        if (isset($_GET['cid'])&&isset($_GET['id'])&&isset($_GET['type'])) {
            parent::__construct($this->tpl,new CommentModel());
            $this->model->id=$_GET['id'];
            if (!$this->model->queryOneComment()) {
                Tool::alertBack('不存在此评论');
            }
            if ($_GET['type']=='sustain') {
                $this->model->setSustain()?Tool::alertLocation('支持成功','feedback.php?cid='.$_GET['cid']):Tool::alertLocation('支持失败','feedback.php?cid='.$_GET['cid']);
            }
            if ($_GET['type']=='oppose') {
                $this->model->setOppose()?Tool::alertLocation('反对成功','feedback.php?cid='.$_GET['cid']):Tool::alertLocation('反对失败','feedback.php?cid='.$_GET['cid']);
            }
        }
    }
    //转换
    private function setObject(&$object){
        if ($object) {
            foreach ($object as $value) {
                switch ($value->manner) {
                    case '-1':
                        $value->manner='反对';
                        break;
                    case '0':
                        $value->manner='中立';
                        break;
                    case '1':
                        $value->manner='支持';
                        break;
                    
                    default:
                        # code...
                        break;
                }
                if (empty($value->face)) {
                    $value->face='00.gif';
                }
                if (!empty($value->oppose)) {
                    $value->oppose='-'.$value->oppose;
                }
            }
        }
    }
}
