<?php
/**
 * @Author: gaohuabin
 * @Date:   2016-01-19 20:12:34
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2016-01-31 17:55:32
 */

class TagAction extends Action{

    //构造方法，初始化
    public function __construct($tpl){
        
        parent::__construct($tpl,new TagModel());
        
    }

    public function action(){
        $this->queryFiveTag();
        
    }
   
    //前台显示5条
    private function queryFiveTag(){
        $this->tpl->assign('FiveTag',$this->model->queryFiveTag());
    }
}