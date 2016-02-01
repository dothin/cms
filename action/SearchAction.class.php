<?php
/**
 * @Author: gaohuabin
 * @Date:   2016-01-24 14:16:18
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2016-01-31 18:02:13
 */
class SearchAction extends Action{

    //构造方法，初始化
    public function __construct($tpl){
        
        parent::__construct($tpl,new ContentModel());
        
    }
    //执行方法
    public function action(){
        switch (@$_GET['type']) {
            case '1':
                $this->searchTitle();
                break;
            case '2':
                $this->serachKeyWord();
                break;
            case '3':
                $this->searchTag();
                break;
            default:
                # code...
                break;
        }
    }
    
    //按照标题搜索
    private function searchTitle(){
        if (empty($_GET['inputkeyword'])) Tool::alertBack('搜索关键字不能为空');
        $this->model->inputkeyword=$_GET['inputkeyword'];
        parent::page($this->model->queryTitleContentTotal(),ARTICLE_SIZE);
        $object=$this->model->searchTitleContent();
        Tool::subStr($object,'info',130,'utf-8');
        Tool::subStr($object,'title',30,'utf-8');
        if ($object) {
            foreach ($object as $value) {
                if (empty($value->thumbnail)) {
                    $value->thumbnail='images/none.jpg';
                }
                $value->title=str_replace($this->model->inputkeyword, '<span class="red">'.$this->model->inputkeyword.'</span>', $value->title);
            }
        }
        $this->tpl->assign('SearchContent',$object);
        $this->tpl->assign('titlec',$this->model->inputkeyword);
    }
    //按照关键字搜索
    private function serachKeyWord(){
        if (empty($_GET['inputkeyword'])) Tool::alertBack('搜索关键字不能为空');
        $this->model->inputkeyword=$_GET['inputkeyword'];
        parent::page($this->model->queryKeywordContentTotal(),ARTICLE_SIZE);
        $object=$this->model->searchKeywordContent();
        Tool::subStr($object,'info',130,'utf-8');
        Tool::subStr($object,'title',30,'utf-8');
        if ($object) {
            foreach ($object as $value) {
                if (empty($value->thumbnail)) {
                    $value->thumbnail='images/none.jpg';
                }
                $value->keyword=str_replace($this->model->inputkeyword, '<span class="red">'.$this->model->inputkeyword.'</span>', $value->keyword);
            }
        }
        $this->tpl->assign('SearchContent',$object);
        $this->tpl->assign('titlec',$this->model->inputkeyword);
    }
    //按照tag搜索
    private function searchTag(){
        $this->model->inputkeyword=$_GET['inputkeyword'];
        parent::page($this->model->queryTagContentTotal(),ARTICLE_SIZE);
        $object=$this->model->searchTagContent();
        Tool::subStr($object,'info',130,'utf-8');
        Tool::subStr($object,'title',30,'utf-8');
        if ($object) {
            foreach ($object as $value) {
                if (empty($value->thumbnail)) {
                    $value->thumbnail='images/none.jpg';
                }
            }
        }

        $tag=new TagModel();
        $tag->tagname=$this->model->inputkeyword;
        $tag->queryOneTag()?$tag->addTagCount():$tag->addTag();
        
        $this->tpl->assign('SearchContent',$object);
        $this->tpl->assign('titlec',$this->model->inputkeyword);
    }
}