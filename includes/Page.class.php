<?php
/**
 * @Author: gaohuabin
 * @Date:   2016-01-20 20:21:54
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2016-01-23 16:35:11
 */
/**
 * 分页类
 */
class Page{
    //总记录
    private $total;
    //limit
    private $limit;
    //每页显示多少条
    private $pagesize;
    //当前页面
    private $page;
    //总页码
    private $totalpages;
    //地址
    private $url;
    //两边保持数字分页的数量
    private $bothnum;

    //构造方法，初始化
    public function __construct($total,$pagesize){
        //如果数据库数据为空，要返回total=1才行
        $this->total=$total?$total:1;
        $this->pagesize=$pagesize;
        $this->totalpages=ceil($this->total/$this->pagesize);
        $this->page=$this->setPage();
        $this->limit="LIMIT ".($this->page-1)*$this->pagesize.",$this->pagesize";
        $this->url=$this->setUrl();
        $this->bothnum=3;
    }
    //拦截器（__set）
    public function __set($key,$value){
        $this->$key=$value;
    }
    //拦截器（__get）
    public function __get($key){
        return $this->$key;
    }
    //设置当前页码
    private function setPage(){
        if (!empty($_GET['page'])) {
            if ($_GET['page']>0) {
                if ($_GET['page']>$this->totalpages) {
                    return $this->totalpages;
                }else{
                    return $_GET['page'];
                }
            }else{
                return 1;
            }
        }else{
            return 1;
        }
    }
    //数字目录
    private function pageList(){
        for ($i=$this->bothnum; $i >=1; $i--) { 
            $page=$this->page-$i;
            if ($page<1) continue;
            @$pagelist.='<a href="'.$this->url.'&page='.$page.'" title="">'.$page.'</a>';
        }
        @$pagelist.='<span class="me">'.$this->page.'</span>';
        for ($i=1; $i <= $this->bothnum ; $i++) { 
            $page=$this->page+$i;
            if ($page>$this->totalpages) break;
            $pagelist.='<a href="'.$this->url.'&page='.$page.'" title="">'.$page.'</a>';
        }
        return $pagelist;
    }

    //获取地址
    private function setUrl(){
        $url=$_SERVER["REQUEST_URI"];
        $par=parse_url($url);
        //print_r($par);
        //Array
                /*(
                    [path] => /cms/admin/manage.php
                    [query] => action=show&page=4&page=3&page=3&page=4&page=2&page=3
                )*/
        if (isset($par['query'])) {
            parse_str($par['query'],$query);
            unset($query['page']);
            //http_build_query($query)
            //aciont=show
            $url=$par['path'].'?'.http_build_query($query);
        }
        return $url;
    }
    //首页
    private function first(){
        if ($this->page>$this->bothnum+1) {
            return '<a href="'.$this->url.'" title="">1</a>...';
        }
        
    }

    //上一页
    private function prev(){
        if ($this->page==1) {
            return '<span class="disabled">上一页</span>';
        }
        return '<a href="'.$this->url.'&page='.($this->page-1).'" title="">上一页</a>';
    }

    //下一页
    private function next(){
        if ($this->page==$this->totalpages) {
            return '<span class="disabled">下一页</span>';
        }
        return '<a href="'.$this->url.'&page='.($this->page+1).'" title="">下一页</a>';
    }
    //尾页
    private function last(){
        if ($this->totalpages-$this->page>$this->bothnum) {
            return '...<a href="'.$this->url.'&page='.$this->totalpages.'" title="">'.$this->totalpages.'</a>';
        }
        
    }

    //分页信息输出
    public function showPage(){

        $page=$this->prev();
        $page.=$this->first();
        $page.=$this->pageList();
        $page.=$this->last();
        $page.=$this->next();
        return $page;
    }
}