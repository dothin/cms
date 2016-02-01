<?php
/**
 * @Author: gaohuabin
 * @Date:   2016-01-19 00:39:38
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2016-01-31 16:34:58
 */
//评论实体类
class CommentModel extends Model{

   private $user;
   private $manner;
   private $content;
   private $cid;
   private $limit;
   private $states;
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

    //批量审核
    public function setStates(){
        foreach ($this->states as $key => $value) {
            if (!is_numeric($value)) continue;
            if($value>0) $value=1;
            if($value<0) $value=0;
            @$sql.="UPDATE cms_comment SET state='$value' WHERE id='$key';";
        }
        return parent::multi($sql);
    }
    //获取评论的总个数(前台)
    public function queryCommentTotal(){
        $sql="SELECT 
              COUNT(*)
              FROM 
                    cms_comment
              WHERE cid='$this->cid'
                AND state=1";
        return parent::total($sql);
    }
    //获取评论的总个数(后台)
    public function queryCommentListTotal(){
        $sql="SELECT 
              COUNT(*)
              FROM 
                    cms_comment";
        return parent::total($sql);
    }
    //新增评论
    public function addComment(){
        $sql="INSERT INTO 
                    cms_comment (
                                user,
                                manner,
                                content,
                                cid,
                                date
                        ) 
                    VALUES (
                            '$this->user',
                            '$this->manner',
                            '$this->content',
                            '$this->cid',
                            NOW()
                        )";
        return parent::aud($sql);
    }
    //所有评论（前台）
    public function queryAllComment(){
        $sql="SELECT 
                    c.id,
                    c.cid,
                    c.user,
                    c.manner,
                    c.content,
                    c.sustain,
                    c.oppose,
                    c.date,
                    u.face
              FROM 
                    cms_comment c
            LEFT JOIN 
                    cms_user u
                ON  c.user=u.user
              WHERE c.cid='$this->cid'
                AND c.state=1
            ORDER BY c.date DESC
                    $this->limit";
        return parent::all($sql);
    }
    //所有评论（后台）
    public function queryCommentList(){
        $sql="SELECT 
                    c.id,
                    c.user,
                    c.cid,
                    c.content,
                    c.content full,
                    c.state,
                    c.state num,
                    ct.title
              FROM 
                    cms_comment c,
                    cms_content ct
              WHERE c.cid=ct.id
              ORDER BY c.date DESC
                    $this->limit";
        return parent::all($sql);
    }

    //通过审核
    public function setStateOk(){
        $sql="UPDATE 
                    cms_comment 
                SET 
                    state=1
                WHERE 
                    id='$this->id' 
                LIMIT 1";
        return parent::aud($sql);
    }
    //取消通过审核
    public function setStateCancel(){
        $sql="UPDATE 
                    cms_comment 
                SET 
                    state=0
                WHERE 
                    id='$this->id' 
                LIMIT 1";
        return parent::aud($sql);
    }
    //获取三条最火评论，如果其中有支持+反对=0的话，那么就不显示出来（前台）
    public function queryThreeHotComment(){
        $sql="SELECT 
                    c.id,
                    c.cid,
                    c.user,
                    c.manner,
                    c.content,
                    c.sustain,
                    c.oppose,
                    c.date,
                    u.face
              FROM 
                    cms_comment c
            LEFT JOIN 
                    cms_user u
                ON  c.user=u.user
              WHERE c.cid='$this->cid'
                AND c.state=1
                AND c.sustain+c.oppose>0
            ORDER BY c.sustain+c.oppose DESC
                LIMIT 0,3";
        return parent::all($sql);
    }
    //获取三条最新评论（前台）
    public function queryThreeNewComment(){
        $sql="SELECT 
                    c.id,
                    c.cid,
                    c.user,
                    c.manner,
                    c.content,
                    c.sustain,
                    c.oppose,
                    c.date,
                    u.face
              FROM 
                    cms_comment c
            LEFT JOIN 
                    cms_user u
                ON  c.user=u.user
              WHERE c.cid='$this->cid'
                AND c.state=1
            ORDER BY c.date DESC
                LIMIT 0,3";
        return parent::all($sql);
    }
    //查找单一评论
    public function queryOneComment(){
        $sql="SELECT 
                    id
              FROM 
                    cms_comment
            
              WHERE id='$this->id'
              LIMIT 1";
        return parent::one($sql);
    }
    //支持
    public function setSustain(){
        $sql="UPDATE 
                    cms_comment 
                SET 
                    sustain=sustain+1 
                WHERE 
                    id='$this->id' 
                LIMIT 1";
        return parent::aud($sql);
    }
    //反对
    public function setOppose(){
        $sql="UPDATE 
                    cms_comment 
                SET 
                    oppose=oppose+1 
                WHERE 
                    id='$this->id' 
                LIMIT 1";
        return parent::aud($sql);
    }
    //删除评论
    public function deleteComment(){
        $sql="DELETE FROM 
                        cms_comment 
                    WHERE 
                        id='$this->id' 
                    LIMIT 1";
        return parent::aud($sql);
    }
}