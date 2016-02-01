<?php
/**
 * @Author: gaohuabin
 * @Date:   2016-01-24 18:14:58
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2016-01-31 17:27:23
 */
//内容实体类
class ContentModel extends Model{

    private $id;
    private $title;
    private $nav;
    private $attr;
    private $tag;
    private $keyword;
    private $thumbnail;
    private $info;
    private $source;
    private $author;
    private $content;
    private $commend;
    private $count;
    private $gold;
    private $color;
    private $sort;
    private $readlimit;
    private $limit;
    private $inputkeyword;

    //拦截器（__set）
    public function __set($key,$value){
        $this->$key=Tool::mysqlString($value);
    }
    //拦截器（__get）
    public function __get($key){
        return $this->$key;
    }
    //按照搜索标题的文档总记录
    public function queryTitleContentTotal(){
        $sql="SELECT 
              COUNT(*)
              FROM 
                    cms_content c,
                    cms_nav n
              WHERE 
                    c.nav=n.id 
                AND c.title LIKE '%$this->inputkeyword%'";
        return parent::total($sql);
    }
    //按照搜索关键字的文档总记录
    public function queryKeywordContentTotal(){
        $sql="SELECT 
              COUNT(*)
              FROM 
                    cms_content c,
                    cms_nav n
              WHERE 
                    c.nav=n.id 
                AND c.keyword LIKE '%$this->inputkeyword%'";
        return parent::total($sql);
    }
    //按照搜索tag的文档总记录
    public function queryTagContentTotal(){
        $sql="SELECT 
              COUNT(*)
              FROM 
                    cms_content c,
                    cms_nav n
              WHERE 
                    c.nav=n.id 
                AND c.tag LIKE '%$this->inputkeyword%'";
        return parent::total($sql);
    }
    //获取按照标题搜索的文档列表
    public function searchTitleContent(){
        $sql="SELECT 
                    c.id,
                    c.title,
                    c.title t,
                    c.nav,
                    c.date,
                    c.attr,
                    c.gold,
                    c.info,
                    c.thumbnail,
                    c.keyword,
                    c.count,
                    n.nav_name
              FROM 
                    cms_content c,
                    cms_nav n
              WHERE 
                    c.nav=n.id 
                AND c.title LIKE '%$this->inputkeyword%'
            ORDER BY 
                    c.date DESC
                    $this->limit";
        return parent::all($sql);
    }
    //获取按照关键字搜索的文档列表
    public function searchKeywordContent(){
        $sql="SELECT 
                    c.id,
                    c.title,
                    c.title t,
                    c.nav,
                    c.date,
                    c.attr,
                    c.gold,
                    c.info,
                    c.thumbnail,
                    c.keyword,
                    c.count,
                    n.nav_name
              FROM 
                    cms_content c,
                    cms_nav n
              WHERE 
                    c.nav=n.id 
                AND c.keyword LIKE '%$this->inputkeyword%'
            ORDER BY 
                    c.date DESC
                    $this->limit";
        return parent::all($sql);
    }
    //获取按照tag搜索的文档列表
    public function searchTagContent(){
        $sql="SELECT 
                    c.id,
                    c.title,
                    c.title t,
                    c.nav,
                    c.date,
                    c.tag,
                    c.attr,
                    c.gold,
                    c.info,
                    c.thumbnail,
                    c.keyword,
                    c.count,
                    n.nav_name
              FROM 
                    cms_content c,
                    cms_nav n
              WHERE 
                    c.nav=n.id 
                AND c.tag LIKE '%$this->inputkeyword%'
            ORDER BY 
                    c.date DESC
                    $this->limit";
        return parent::all($sql);
    }
    //累计文档点击量
    public function setContentCount(){
        $sql="UPDATE 
                    cms_content
                SET 
                    count=count+1
              WHERE 
                    id='$this->id' 
                LIMIT 1";
        return parent::aud($sql);
    }
    //获取文档列表
    public function queryListContent(){
        $sql="SELECT 
                    c.id,
                    c.title,
                    c.title t,
                    c.nav,
                    c.date,
                    c.attr,
                    c.gold,
                    c.info,
                    c.thumbnail,
                    c.keyword,
                    c.count,
                    n.nav_name
              FROM 
                    cms_content c,
                    cms_nav n
              WHERE 
                    c.nav=n.id 
                AND
                    c.nav IN ($this->nav)
            ORDER BY 
                    c.date DESC
                    $this->limit";
        return parent::all($sql);
    }
    //获取文章总记录
    public function queryListContentTotal(){
        $sql="SELECT 
              COUNT(*)
              FROM 
                    cms_content c,
                    cms_nav n
              WHERE 
                    c.nav=n.id 
                AND
                    c.nav IN ($this->nav)";
        return parent::total($sql);
    }
    //首页获取最新的7条推荐文档
    public function queryNewRecList(){
        $sql="SELECT 
                    id,
                    title,
                    date
              FROM 
                    cms_content
              WHERE 
                    attr LIKE '%推荐%'
           ORDER BY date DESC
              LIMIT 0,7";
        return parent::all($sql);
    }
    //首页获取热点（点击量）的7条排行文档
    public function queryMonthHotList(){
        $sql="SELECT 
                    id,
                    title,
                    date
              FROM 
                    cms_content
              WHERE 
                    MONTH(NOW())=DATE_FORMAT(date,'%c')
           ORDER BY count DESC
              LIMIT 0,7";
        return parent::all($sql);
    }
    //首页获取图文4条排行文档
    public function queryPicList(){
        $sql="SELECT 
                    id,
                    title,
                    thumbnail
              FROM 
                    cms_content
              WHERE 
                    thumbnail!=''
           ORDER BY date DESC
              LIMIT 0,4";
        return parent::all($sql);
    }
    //首页获取10个文档
    public function queryNewList(){
        $sql="SELECT 
                    id,
                    title,
                    date
              FROM 
                    cms_content
           ORDER BY date DESC
              LIMIT 0,10";
        return parent::all($sql);
    }
    //首页获取最新的一条头条
    public function queryNewTop(){
        $sql="SELECT 
                    id,
                    title,
                    info
              FROM 
                    cms_content
              WHERE 
                    attr LIKE '%头条%'
           ORDER BY date DESC
              LIMIT 1";
        return parent::one($sql);
    }
    //首页获取最新的2-5条头条
    public function queryNewTopList(){
        $sql="SELECT 
                    id,
                    title,
                    info,
                    date
              FROM 
                    cms_content
              WHERE 
                    attr LIKE '%头条%'
           ORDER BY date DESC
              LIMIT 1,4";
        return parent::all($sql);
    }
    //首页获取所有主栏目的11条最新文档
    public function queryNewNavList(){
        $sql="SELECT 
                    id,
                    title,
                    date
              FROM 
                    cms_content
              WHERE 
                    nav IN (SELECT id FROM cms_nav WHERE pid='$this->nav')
           ORDER BY date DESC
              LIMIT 0,11";
        return parent::all($sql);
    }
    //首页获取评论的7条排行文档
    public function queryMonthCommentList(){
        $sql="SELECT 
                    ct.id,
                    ct.title,
                    ct.date
              FROM 
                    cms_content ct
              WHERE 
                    MONTH(NOW())=DATE_FORMAT(ct.date,'%c')
           ORDER BY (SELECT
                            COUNT(*)
                    FROM
                            cms_comment c
                    WHERE
                            c.cid=ct.id) DESC
              LIMIT 0,7";
        return parent::all($sql);
    }
    //获取总排行榜，文档的评论量，从大到小，20条
    public function queryTwentyHotContent(){
        $sql="SELECT 
                    ct.id,
                    ct.title
              FROM 
                    cms_content ct
            ORDER BY 
                    (SELECT
                            COUNT(*)
                    FROM
                            cms_comment c
                    WHERE
                            c.cid=ct.id)
                     DESC
              LIMIT 0,20";
        return parent::all($sql);
    }
    //获取本月，本类，推荐排行榜，10条
    public function queryMonthNavRec(){
        $sql="SELECT 
                    id,
                    title,
                    date
              FROM 
                    cms_content
              WHERE 
                    attr LIKE '%推荐%'
                AND
                    MONTH(NOW())=DATE_FORMAT(date,'%c')
                AND
                    nav IN ($this->nav)
           ORDER BY date DESC
              LIMIT 0,10";
        return parent::all($sql);
    }
    //获取本月，本类，热点排行榜，10条
    public function queryMonthNavHot(){
        $sql="SELECT 
                    ct.id,
                    ct.title,
                    ct.date
              FROM 
                    cms_content ct
              WHERE 
                    MONTH(NOW())=DATE_FORMAT(ct.date,'%c')
                AND
                    ct.nav IN ($this->nav)
           ORDER BY 
                    (SELECT
                            COUNT(*)
                    FROM
                            cms_comment c
                    WHERE
                            c.cid=ct.id)
                     DESC
              LIMIT 0,10";
        return parent::all($sql);
    }
    //获取本月，本类，图文排行榜，10条
    public function queryMonthNavPic(){
        $sql="SELECT 
                    id,
                    title,
                    date
              FROM 
                    cms_content
              WHERE 
                    thumbnail!=''
                AND
                    MONTH(NOW())=DATE_FORMAT(date,'%c')
                AND
                    nav IN ($this->nav)
           ORDER BY date DESC
              LIMIT 0,10";
        return parent::all($sql);
    }
    //获取单一的文档内容
    public function queryOneContent(){
        $sql="SELECT 
                    id,
                    title,
                    content,
                    tag,
                    attr,
                    keyword,
                    thumbnail,
                    info,
                    date,
                    count,
                    gold,
                    nav,
                    author,
                    color,
                    sort,
                    readlimit,
                    commend,
                    source
              FROM 
                    cms_content
              WHERE id='$this->id'";
        return parent::one($sql);
    }

    //新增文档内容
    public function addContent(){
        $sql="INSERT INTO 
                cms_content (
                            title,
                            nav,
                            attr,
                            info,
                            thumbnail,
                            source,
                            author,
                            tag,
                            keyword,
                            content,
                            commend,
                            count,
                            gold,
                            color,
                            sort,
                            readlimit,
                            date
                    ) 
                    VALUES (
                            '$this->title',
                            '$this->nav',
                            '$this->attr',
                            '$this->info',
                            '$this->thumbnail',
                            '$this->source',
                            '$this->author',
                            '$this->tag',
                            '$this->keyword',
                            '$this->content',
                            '$this->commend',
                            '$this->count',
                            '$this->gold',
                            '$this->color',
                            '$this->sort',
                            '$this->readlimit',
                            NOW()
                        )";
        return parent::aud($sql);
    }

    //修改文档
    public function updateContent(){
        $sql="UPDATE 
                    cms_content
                SET 
                    title='$this->title',
                    nav='$this->nav',
                    attr='$this->attr',
                    info='$this->info',
                    thumbnail='$this->thumbnail',
                    source='$this->source',
                    author='$this->author',
                    tag='$this->tag',
                    keyword='$this->keyword',
                    content='$this->content',
                    commend='$this->commend',
                    count='$this->count',
                    gold='$this->gold',
                    color='$this->color',
                    sort='$this->sort',
                    readlimit='$this->readlimit'
              WHERE 
                    id='$this->id' 
                LIMIT 1";
        return parent::aud($sql);
    }
    //删除文档
    public function deleteContent(){
        $sql="DELETE FROM 
                        cms_content 
                    WHERE 
                        id='$this->id' 
                    LIMIT 1";
        return parent::aud($sql);
    }
    
}