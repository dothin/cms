<?php
/**
 * @Author: gaohuabin
 * @Date:   2016-01-24 18:13:33
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2016-01-30 22:14:50
 */
class ContentAction extends Action{

    //构造方法，初始化
    public function __construct($tpl){
        
        parent::__construct($tpl,new ContentModel());
        
    }

    public function action(){
        switch (@$_GET['action']) {
            case 'show':
                $this->query();
                break;
            case 'add':
                $this->add();
                break;
            case 'update':
                $this->update();
                break;
            case 'delete':
                $this->delete();
                break;
            default:
                $this->query();
                break;
        }
        
    }

    private function query(){
        $this->tpl->assign('show',true);
        $this->tpl->assign('title','文档列表');
        $this->nav();


        $nav=new NavModel();
        if (empty($_GET['nav'])) {
            
            $id=$nav->queryAllNavChildId();
            $this->model->nav=Tool::objArrOfStr($id,'id');
        }else{
            $nav->id=$_GET['nav'];
            if(!$nav->queryOneNav()) Tool::alertBack('参数错误');
            $this->model->nav=$nav->id;
        }
        parent::page($this->model->queryListContentTotal());
        $object=$this->model->queryListContent();
        Tool::subStr($object,'title',20,'utf-8');
        
        $this->tpl->assign('SearchContent',$object);
    }

    private function add(){
        if (isset($_POST['send'])) {
            $this->getPost();
            $this->model->addContent()?Tool::alertLocation('文档发表成功','?action=show'):Tool::alertBack('文档发表失败');
        }

        $this->tpl->assign('add',true);
        $this->tpl->assign('title','新增文档');
        $this->nav();
        $this->tpl->assign('author',$_SESSION['admin']['admin_user']);

    }
    //新增和修改都需要数据，写到一起
    private function getPost(){
        if(Validate::checkNull($_POST['title'])) Tool::alertBack('标题不能为空');
            if(Validate::checkLength($_POST['title'],2,'min')) Tool::alertBack('标题长度不能少于2位');
            if(Validate::checkLength($_POST['title'],50,'max')) Tool::alertBack('标题长度不能大于50位');
            if(Validate::checkNull($_POST['nav'])) Tool::alertBack('栏目不能为空');
            if(Validate::checkLength($_POST['tag'],30,'max')) Tool::alertBack('标签长度不能大于30位');
            if(Validate::checkLength($_POST['keyword'],30,'max')) Tool::alertBack('关键字长度不能大于30位');
            if(Validate::checkLength($_POST['source'],20,'max')) Tool::alertBack('文章来源长度不能大于20位');
            if(Validate::checkLength($_POST['author'],10,'max')) Tool::alertBack('作者长度不能大于10位');
            if(Validate::checkLength($_POST['info'],200,'max')) Tool::alertBack('内容摘要长度不能大于200位');
            if(Validate::checkNull($_POST['content'])) Tool::alertBack('详细内容不能为空');
            if(Validate::checkNum($_POST['count'])) Tool::alertBack('浏览次数必须是数字');
            if(Validate::checkNum($_POST['gold'])) Tool::alertBack('消费金币必须是数字');
            if (isset($_POST['attr'])) {
                $this->model->attr = implode(',', $_POST['attr']);
            }else{
                $this->model->attr='无';
            }
            

            $this->model->title=$_POST['title'];
            $this->model->nav=$_POST['nav'];
            $this->model->tag=$_POST['tag'];
            $this->model->keyword=$_POST['keyword'];
            $this->model->thumbnail=$_POST['thumbnail'];
            $this->model->info=$_POST['info'];
            $this->model->source=$_POST['source'];
            $this->model->author=$_POST['author'];
            $this->model->content=$_POST['content'];
            $this->model->commend=$_POST['commend'];
            $this->model->count=$_POST['count'];
            $this->model->gold=$_POST['gold'];
            $this->model->color=$_POST['color'];
            $this->model->sort=$_POST['sort'];
            $this->model->readlimit=$_POST['readlimit'];
    }
    private function update(){
        if (isset($_POST['send'])) {
            $this->model->id=$_POST['id'];
            $this->getPost();
            $this->model->updateContent()?Tool::alertLocation('文档修改成功',$_POST['prev_url']):Tool::alertBack('文档修改失败');
        }
        if (isset($_GET['id'])) {
            $this->tpl->assign('update',true);
            $this->tpl->assign('title','修改文档');
            $this->tpl->assign('id',$_GET['id']);
            $this->model->id=$_GET['id'];
            $content=$this->model->queryOneContent();
            if($content){
                $this->tpl->assign('titlec',$content->title);
                $this->tpl->assign('tag',$content->tag);
                $this->tpl->assign('keyword',$content->keyword);
                $this->tpl->assign('thumbnail',$content->thumbnail);
                $this->tpl->assign('source',$content->source);
                $this->tpl->assign('author',$content->author);
                $this->tpl->assign('content',$content->content);
                $this->tpl->assign('info',$content->info);
                $this->tpl->assign('count',$content->count);
                $this->tpl->assign('gold',$content->gold);
                $this->tpl->assign('commend',$content->commend);
                $this->tpl->assign('prev_url',PREV_URL);
                $this->nav($content->nav);
                $this->attr($content->attr);
                $this->color($content->color);
                $this->sort($content->sort);
                $this->readlimit($content->readlimit);
                $this->commend($content->commend);

            }else{
                Tool::alertBack('不存在此文档');
            }
        }else{
            Tool::alertBack('非法操作');
        }
    }
    private function delete(){
        if (isset($_GET['id'])) {
            $this->model->id=$_GET['id'];
            $this->model->deleteContent()?Tool::alertLocation('文档删除成功',PREV_URL):Tool::alertBack('文档删除失败');
        }else{
            Tool::alertBack('非法操作');
        }
    }

    //nav
    private function nav($n=0){
        $nav=new NavModel();
        foreach ($nav->queryFrontNavs() as $object) {
            @$html.='<optgroup label="'.$object->nav_name.'">'."\r\n";
            $nav->id=$object->id;
            //如果父级存在，才循环子级
            if (!!$childnav=$nav->queryChildFrontNavs()) {
                foreach ($childnav as $object) {
                    if ($n==$object->id) $selected='selected';
                    $html.='<option '.@$selected.' value="'.$object->id.'">'.$object->nav_name.'</option>'."\r\n";
                    $selected='';
                }
            }
            
            $html.='</optgroup>';
        }
        $this->tpl->assign('nav',$html);
    }
    //attr
    private function attr($attr){
        $attrArr=array('头条','推荐','加粗','跳转');
        $attrSelected=explode(',', $attr);
        //array_diff取两个数组的差集
        $attrNoSelected=array_diff($attrArr, $attrSelected);
        if ($attrSelected[0]!='无') {
            foreach ($attrSelected as $value) {
                @$html.='<input  type="checkbox" name="attr[]" checked value="'.$value.'" />'.$value;
            }
        }
        foreach ($attrNoSelected as $value) {
            @$html.='<input  type="checkbox" name="attr[]" value="'.$value.'" />'.$value;
        }
        $this->tpl->assign('attr',$html);
    }
    //color
    private function color($color){
        $colorArr=array(''=>'默认颜色','red'=>'红色','blue'=>'蓝色','orange'=>'橙色');
        foreach ($colorArr as $key => $value) {
            if ($key==$color) $selected='selected';
            @$html.='<option '.@$selected.' value="'.$key.'" style="color:'.$key.';">'.$value.'</option>';
            $selected='';
        }
        $this->tpl->assign('color',$html);
    }
    //sort
    private function sort($sort){
        $sortArr=array(0=>'默认排序',1=>'置顶一天',2=>'置顶一周',3=>'置顶一月',4=>'置顶一年');
        foreach ($sortArr as $key => $value) {
            if ($key==$sort) $selected='selected';
            @$html.='<option '.@$selected.' value="'.$key.'" >'.$value.'</option>';
            $selected='';
        }
        $this->tpl->assign('sort',$html);
    }

    //readlimit
    private function readlimit($readlimit){
        $readlimitArr=array(0=>'开放浏览',1=>'初级会员',2=>'中级会员',3=>'高级会员',4=>'VIP会员');
        foreach ($readlimitArr as $key => $value) {
            if ($key==$readlimit) $selected='selected';
            @$html.='<option '.@$selected.' value="'.$key.'" >'.$value.'</option>';
            $selected='';
        }
        $this->tpl->assign('readlimit',$html);
    }
    //commend
    private function commend($commend){
        $commendArr=array(1=>'允许评论',0=>'禁止评论');
        foreach ($commendArr as $key => $value) {
            if ($key==$commend) $checked='checked';
            @$html.='<input type="radio" '.@$checked.' name="commend" value="'.$key.'">'.$value;
            $checked='';
        }
        $this->tpl->assign('commend',$html);
    }

}
