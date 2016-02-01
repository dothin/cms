<?php
/**
 * @Author: gaohuabin
 * @Date:   2016-01-24 13:02:13
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2016-01-31 16:44:31
 */
class IndexAction extends Action{

    //构造方法，初始化
    public function __construct($tpl){
        
        parent::__construct($tpl);
        
    }


    public function action(){
        $this->login();
        $this->laterUser();
        $this->showList();
    }
    //显示推荐，本月热点，本月评论，头条
    private function showList(){
        parent::__construct($this->tpl,new ContentModel());
        $object=$this->model->queryNewRecList();
        $this->setObject($object);
        $this->tpl->assign('NewRecList',$object);

        $object=$this->model->queryMonthHotList();
        $this->setObject($object);
        $this->tpl->assign('MonthHotList',$object);

        $object=$this->model->queryMonthCommentList();
        $this->setObject($object);
        $this->tpl->assign('MonthCommentList',$object);

        $object=$this->model->queryNewList();
        $this->setObject($object);
        $this->tpl->assign('NewList',$object);

        $object=$this->model->queryPicList();
        $this->tpl->assign('PicList',$object);

        $object=$this->model->queryNewTop();
        $this->tpl->assign('TopTitle',Tool::subStr($object->title,null,20,'utf-8'));
        $this->tpl->assign('TopInfo',$object->info);
        $this->tpl->assign('TopId',$object->id);

        $object=$this->model->queryNewTopList();
        $this->setObject($object);
        if ($object) {
            $i=1;
            foreach ($object as $value) {
                if ($i%2==0) {
                    $value->line='';
                }else{
                    $value->line='|';
                }
                $i++;
            }
        }
        $this->tpl->assign('NewTopList',$object);
        $nav=new NavModel();
        $object=$nav->queryFourNav();
        if ($object) {
            $i=1;
            foreach ($object as $value) {
                if ($i%2==0) {
                    $value->class='list right bottom';
                }else{
                    $value->class='list bottom';
                }
                $i++;
                $this->model->nav=$value->id;
                $navList=$this->model->queryNewNavList();
                $value->list=$navList;
                $this->setObject($value->list);
            }
        }
        $this->tpl->assign('FourNav',$object);
    }
    private function setObject(&$object){
        if ($object) {
            Tool::subStr($object,'title',14,'utf-8');
            Tool::objDate($object,'date');
        }
        
    }
    //最近登录的用户
    private function laterUser(){
        $user=new UserModel();
        $this->tpl->assign('AllLaterUser',$user->getLaterUser());
    }
    //登录模块
    private function login(){
        $cookie=new Cookie('user');
        $user=$cookie->getCookie();
        $cookie=new Cookie('face');
        $face=$cookie->getCookie();

        if ($user&&$face) {
             $this->tpl->assign('user',Tool::subStr($user, null,8,'utf-8'));
             $this->tpl->assign('face',$face);
        }else{
            $this->tpl->assign('login',true);
        }
        $this->tpl->assign('cache',IS_CACHE);
        if (IS_CACHE) $this->tpl->assign('member','<script>getIndexLogin();</script>');
    }
    

}