<?php
/**
 * @Author: gaohuabin
 * @Date:   2016-01-19 20:12:34
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2016-01-31 16:35:13
 */

class CommentAction extends Action{

    //构造方法，初始化
    public function __construct($tpl){
        parent::__construct($tpl,new CommentModel());
        
    }

    public function action(){
        
        switch (@$_GET['action']) {
            case 'show':
                $this->query();
                break;
            case 'delete':
                $this->delete();
                break;
            case 'state':
                $this->state();
                break;
            case 'states':
                $this->states();
                break;
            default:
                $this->query();
                break;
        }
        
    }

    private function state(){
        if (isset($_GET['id'])) {
            $this->model->id=$_GET['id'];
            if(!$this->model->queryOneComment()) Tool::alertBack('不存在此评论');
            if ($_GET['type']=='ok') {
                
                if ($this->model->setStateOk()) {
                    Tool::alertLocation(null,PREV_URL);
                }else{
                    Tool::alertBack('审核失败');
                }
            }elseif ($_GET['type']=='cancel') {
                
                if ($this->model->setStateCancel()) {
                    Tool::alertLocation(null,PREV_URL);
                }else{
                    Tool::alertBack('审核失败');
                }
            }
        }else{
            Tool::alertBack('非法操作');
        }
    }

    private function states(){
        if (isset($_POST['send'])) {
            $this->model->states=$_POST['states'];
            if($this->model->setStates()) Tool::alertLocation(null,PREV_URL);
        }
    }
    private function query(){
        parent::page($this->model->queryCommentListTotal());
        $this->tpl->assign('show',true);
        $this->tpl->assign('title','评论列表');
        $object=$this->model->queryCommentList();
        Tool::subStr($object,'content',30,'utf-8');
        if ($object) {
            foreach ($object as $value) {
                if (empty($value->state)) {
                    $value->state='<span class="red">未审核</span>|<a href="comment.php?action=state&type=ok&id='.$value->id.'" title="">通过</a>';
                }else{
                    $value->state='<span class="green">已审核</span>|<a href="comment.php?action=state&type=cancel&id='.$value->id.'" title="">取消</a>';
                }
            }
        }
        $this->tpl->assign('CommentList',$object);

    }

    
    private function delete(){
        if (isset($_GET['id'])) {
            $this->model->id=$_GET['id'];
            $this->model->deleteComment()?Tool::alertLocation('恭喜您新删除成功！',PREV_URL):Tool::alertBack('很遗憾，删除失败');
        }else{
            Tool::alertBack('非法操作');
        }
    }
    
}