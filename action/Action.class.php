<?php
/**
 * @Author: gaohuabin
 * @Date:   2016-01-19 20:41:58
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2016-01-26 12:22:46
 */
/**
 * 控制器基类
 */
class Action{

    protected $tpl;
    protected $model;

    protected function __construct(&$tpl,&$model=null){
        $this->tpl=$tpl;
        $this->model=$model;
    }

    protected function page($total,$pagesize=PAGE_SIZE){
        $page=new Page($total,$pagesize);
        $this->model->limit=$page->limit;
        $this->tpl->assign('page',$page->showPage());
        //注入当前页面的分页页数,用于计算编号
        $this->tpl->assign('num',($page->page-1)*$pagesize);
    }
}