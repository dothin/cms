<?php
/**
 * @Author: gaohuabin
 * @Date:   2016-01-24 14:16:18
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2016-01-30 23:22:05
 */
class ListAction extends Action{

    //构造方法，初始化
    public function __construct($tpl){
        
        parent::__construct($tpl);
        
    }
    //执行方法
    public function action(){
        $this->queryNav();
        $this->queryListContent();
    }
    //获取前台列表显示
    private function queryListContent(){
        if (isset($_GET['id'])) {
            //重写构造
            parent::__construct($this->tpl,new ContentModel());
            $nav=new NavModel();
            $nav->id=$_GET['id'];

            $navId=$nav->queryNavChildId();
            //如果有子类id，就用子类id，没有直接用传过来的id
            if ($navId) {
                $this->model->nav=Tool::objArrOfStr($navId,'id');
            }else{
                $this->model->nav=$nav->id;
            }
            parent::page($this->model->queryListContentTotal(),ARTICLE_SIZE);
            $object=$this->model->queryListContent();
            Tool::subStr($object,'info',130,'utf-8');
            Tool::subStr($object,'title',30,'utf-8');
            if ($object) {
                foreach ($object as $value) {
                    if (empty($value->thumbnail)) {
                        $value->thumbnail='images/none.jpg';
                    }
                }
            }
            if(IS_CACHE&&$object){
                foreach ($object as $value) {
                    $value->count='<script>getContentCount();</script>';
                }
            }
            $this->tpl->assign('AllListContent',$object);
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
    private function queryNav(){
        if (isset($_GET['id'])) {
            $nav=new NavModel();
            $nav->id=$_GET['id'];

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
                
        }else{
            Tool::alertBack('非法操作');
        }
    }
    

}