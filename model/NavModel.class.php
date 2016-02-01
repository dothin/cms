<?php
/**
 * @Author: gaohuabin
 * @Date:   2016-01-19 00:39:38
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2016-01-31 11:37:11
 */
//导航实体类
class NavModel extends Model{
    private $id;
    private $limit;
    private $nav_name;
    private $nav_info;
    private $pid;
    private $sort;

    //拦截器（__set）
    public function __set($key,$value){
        if (is_array($value)) {
            $this->$key=$value;
        }else{
            $this->$key=Tool::mysqlString($value);
        }
    }
    //拦截器（__get）
    public function __get($key){
        return $this->$key;
    }

    //获取主类下的子类的id
    public function queryNavChildId(){
        $sql="SELECT 
                    id
              FROM 
                    cms_nav
              WHERE pid='$this->id'";
        return parent::all($sql);
    }
    
    //获取所有非主类的id
    public function queryAllNavChildId(){
        $sql="SELECT 
                    id
              FROM 
                    cms_nav
              WHERE pid<>0";
        return parent::all($sql);
    }
    //前台显示指定的主导航
    public function queryFrontNav(){
        $sql="SELECT 
                    id,
                    nav_name
              FROM 
                    cms_nav
              WHERE pid=0
              ORDER BY
                    sort ASC
              LIMIT 0,".NAV_SIZE;
        return parent::all($sql);
    }
    //首页获取前四个主导航
    public function queryFourNav(){
        $sql="SELECT 
                    id,
                    nav_name
              FROM 
                    cms_nav
              WHERE pid=0
              ORDER BY
                    sort ASC
              LIMIT 0,4";
        return parent::all($sql);
    }
    //导航排序
    public function setNavSort(){
        foreach ($this->sort as $key => $value) {
            if(!is_numeric($value)) continue;
            @$sql.="UPDATE cms_nav SET sort='$value' WHERE id='$key';";
        }
        return parent::multi($sql);
    }
    //获取主导航总记录
    public function queryNavTotal(){
        $sql="SELECT 
              COUNT(*)
              FROM 
                    cms_nav
              WHERE pid=0";
        return parent::total($sql);
    }
    //获取子导航总记录
    public function queryNavChildTotal(){
        $sql="SELECT 
              COUNT(*)
              FROM 
                    cms_nav
              WHERE pid='$this->id'";
        return parent::total($sql);
    }

    //查询所有主导航has limit
    public function queryNavs(){
        $sql="SELECT 
                    id,
                    nav_name,
                    nav_info,
                    sort
              FROM 
                    cms_nav
              WHERE pid=0
              ORDER BY
                    sort ASC
                    $this->limit";
        return parent::all($sql);
    }
    //查询所有主导航no limit
    public function queryFrontNavs(){
        $sql="SELECT 
                    id,
                    nav_name,
                    nav_info,
                    sort
              FROM 
                    cms_nav
              WHERE pid=0
              ORDER BY
                    sort ASC";
        return parent::all($sql);
    }
    //查询所有子导航has limit
    public function queryChildNavs(){
        $sql="SELECT 
                    id,
                    nav_name,
                    nav_info,
                    sort
              FROM 
                    cms_nav
              WHERE pid='$this->id'
              ORDER BY
                    sort ASC
                    $this->limit";
        return parent::all($sql);
    }
    //查询所有子导航no limit
    public function queryChildFrontNavs(){
        $sql="SELECT 
                    id,
                    nav_name,
                    nav_info,
                    sort
              FROM 
                    cms_nav
              WHERE pid='$this->id'
              ORDER BY
                    sort ASC";
        return parent::all($sql);
    }
    //查询单个导航
    public function queryOneNav(){
        $sql="SELECT 
                    n1.id,
                    n1.nav_name,
                    n1.nav_info,
                    n2.id iid,
                    n2.nav_name nnav_name
              FROM 
                    cms_nav n1
              LEFT JOIN
                    cms_nav n2
                 ON n1.pid=n2.id
              WHERE n1.id='$this->id'
                 OR n1.nav_name='$this->nav_name'
              LIMIT 1";
        return parent::one($sql);
    }
    //新增导航
    public function addNav(){
        $sql="INSERT INTO 
                cms_nav (
                            nav_name,
                            nav_info,
                            pid,
                            sort
                    ) 
                    VALUES (
                            '$this->nav_name',
                            '$this->nav_info',
                            '$this->pid',
                            ".parent::nextId('cms_nav')."
                        )";
        return parent::aud($sql);
    }
    //修改导航
    public function updatenav(){
        $sql="UPDATE 
                    cms_nav 
                SET 
                    nav_name='$this->nav_name',
                    nav_info='$this->nav_info'
                WHERE 
                    id='$this->id' 
                LIMIT 1";
        return parent::aud($sql);
    }
    //删除导航
    public function deleteNav(){
        $sql="DELETE FROM 
                        cms_nav 
                    WHERE 
                        id='$this->id' 
                    LIMIT 1";
        return parent::aud($sql);
    }
}