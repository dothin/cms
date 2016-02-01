<?php
/**
 * @Author: gaohuabin
 * @Date:   2016-01-24 14:16:18
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2016-02-01 17:11:33
 */
class DetailsAction extends Action{

    //构造方法，初始化
    public function __construct($tpl){
        
        parent::__construct($tpl);
        
    }
    //执行方法
    public function action(){
        $this->queryDetails();
    }
    
    //获取文档详细内容
    private function queryDetails(){
        if (isset($_GET['id'])) {
            parent::__construct($this->tpl,new ContentModel());
            $this->model->id=$_GET['id'];
            if(!$this->model->queryOneContent()) Tool::alertBack('此文章不存在');
            $content=$this->model->queryOneContent();
            $comment=new CommentModel();
            $comment->cid=$this->model->id;

            $tagArr=explode(',', $content->tag);

            if (is_array($tagArr)) {
                foreach ($tagArr as $value) {
                    $content->tag=str_replace($value, '<a href="search.php?type=3&inputkeyword='.$value.'" title="">'.$value.'</a>', $content->tag);
                }
            }

            $this->tpl->assign('id',$content->id);
            $this->tpl->assign('titlec',$content->title);
            
            $this->tpl->assign('date',$content->date);
            $this->tpl->assign('source',$content->source);
            $this->tpl->assign('author',$content->author);
            $this->tpl->assign('info',$content->info);
            $this->tpl->assign('tag',$content->tag);
            $this->tpl->assign('content',Tool::unHtml($content->content));
            $this->queryNav($content->nav);
            if(IS_CACHE){
                $this->tpl->assign('comment','<script>getComment();</script>');
                $this->tpl->assign('count','<script>getContentCount();</script>');
            }else{
                
                $this->tpl->assign('comment',$comment->queryCommentTotal());
                $this->tpl->assign('count',$content->count);
            }
            $object=$comment->queryThreeNewComment();
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
            $this->tpl->assign('ThreeNewComment',$object);

            $this->model->nav=$content->nav;

            $object=$this->model->queryMonthNavRec();
            $this->setObject($object);
            $this->tpl->assign('MonthNavRec',$object);
            $object=$this->model->queryMonthNavHot();
            $this->setObject($object);
            $this->tpl->assign('MonthNavHot',$object);
            $object=$this->model->queryMonthNavPic();
            $this->setObject($object);
            $this->tpl->assign('MonthNavPic',$object);
        }else{
            Tool::alertBack('非法操作');
        }
    }
    private function setObject(&$object){
        if ($object) {
            Tool::subStr($object,'title',14,'utf-8');
            Tool::objDate($object,'date');
        }
        
    }
    //获取前台显示的导航
    private function queryNav($id){
            $nav=new NavModel();
            $nav->id=$id;
            if ($nav->queryOneNav()) {
                //主导航
                if ($nav->queryOneNav()->nnav_name) {
                    $nav1='<a href="list.php?id='.$nav->queryOneNav()->iid.'" title="">'.$nav->queryOneNav()->nnav_name.'</a> &gt;';
                }
                $nav2='<a href="list.php?id='.$nav->queryOneNav()->id.'" title="">'.$nav->queryOneNav()->nav_name.'</a>';
                $this->tpl->assign('nav',@$nav1.$nav2);
                //子导航
                $this->tpl->assign('childNav',$nav->queryChildFrontNavs());
            }else{
                Tool::alertBack('此导航不存在');
            }
    }

}