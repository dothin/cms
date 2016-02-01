<?php
/**
 * @Author: gaohuabin
 * @Date:   2016-01-18 12:44:59
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2016-01-31 23:52:52
 */
//模板类
class Templates{

    //我想通过一个字段来接受变量
    //但是又不知道有多少个变量要接受
    //所以要动态的接受变量
    //可以通过数组来实现这个功能
    private $vars=array();
    //保存系统变量的数组
    private $config=array();
    //缓存对象
    private $cache;
    //创建构造方法,来验证各个目录是否存在
    public function __construct($cache){
        if (!is_dir(TPL_DIR)||!is_dir(TPL_C_DIR)||!is_dir(CACHE)) {
            exit('ERROR:模板目录或编译目录或缓存目录不存在，请手工添加');
        }
        //读取系统变量
        $sxml=simplexml_load_file(ROOT_PATH.'/config/profile.xml');
        $taglib=$sxml->xpath('/root/taglib');
        foreach ($taglib as $tag) {
            $this->config["$tag->name"]=$tag->value;
        }
        $this->cache=$cache;
        
    }

    /**
     * [assign 用于注入变量]
     * @param  [type] $var   [用于同步模板里的变量名，例如index.php是name那么index.tpl就是{name}]
     * @param  [type] $value [表示的事index.php里的值，就是‘dothin’]
     * @return [type]        [description]
     */
    public function assign($var,$value){
        if (isset($var)&&!empty($var)) {
            //$this->vars['name']
            $this->vars[$var]=$value;
        }else{
            exit('请设置模板变量');
        }
    }
    /**
     * [cache 跳转到缓存文件，不执行php代码，不连接数据]
     * @param  [type] $模板文件 [description]
     * @return [type]       [description]
     */
    public function cache($file){
        //设置模板的路径
        $tplFile=TPL_DIR.$file;
        //判断模板是否存在
        if (!file_exists($tplFile)) {
            exit('ERROR:模板文件不存在');
        }
        //是否加入参数,为了让首页list下面可以正常生成缓存文件
        if (!empty($_SERVER["QUERY_STRING"])) {
            $file.=$_SERVER["QUERY_STRING"];
        }
        
        //生成编译文件名
        $parFile=TPL_C_DIR.md5($file).$file.'.php';
        //生成缓存文件名
        $cacheFile=CACHE.md5($file).$file.'.html';

        //当第二次运行相同文件的时候，直接载入缓存文件，避开编译
        if (IS_CACHE) {
            //缓存文件和编译文件都存在，就直接载入缓存文件，达到效率最高
            if (file_exists($cacheFile)&&file_exists($parFile)) {
                //判断模板文件是否修改过,并且判断编译文件是否修改过
                if (filemtime($parFile)>=filemtime($tplFile)&&filemtime($cacheFile)>=filemtime($parFile)) {
                    //载入缓冲文件
                    include $cacheFile;
                    //跳转到缓存文件后终止后续执行
                    exit();
                }
            }
        }
    }

    /**
     * [display 用于载入tpl文件]
     * @param  [type] $file [文件名]
     * @return [type]       [description]
     */
    public function display($file){
        //给include进来的tpl传一个模板操作的对象
        $tpl=$this;
        //设置模板的路径
        $tplFile=TPL_DIR.$file;
        //判断模板是否存在
        if (!file_exists($tplFile)) {
            exit('ERROR:模板文件不存在');
        }
        //是否加入参数,为了让首页list下面可以正常生成缓存文件
        if (!empty($_SERVER["QUERY_STRING"])) {
            $file_query=$_SERVER["QUERY_STRING"];
        }
        
        //生成编译文件名
        $parFile=TPL_C_DIR.md5($file).$file.'.php';
        //生成缓存文件名
        $cacheFile=CACHE.md5($file).$file.@$file_query.'.html';
        //如果编译文件不存在或者编译文件被修改过，则新生成文件$parFile
        if (!file_exists($parFile)||filemtime($parFile)<filemtime($tplFile)) {
            //引入模板解析类
            require_once ROOT_PATH.'/includes/Parser.class.php';
            $parser=new Parser($tplFile);//使模板文件被解析类解析
            $parser->complice($parFile);//生成解析后的编译文件
        }
        //载入编译文件
        include $parFile;
        //缓存开启并且没有设置不缓存的页面才生成缓存文件
        if (IS_CACHE&&!$this->cache->noCache()) {
            //获取缓冲区内的数据,生成缓存文件
            ///echo ob_get_contents();
            file_put_contents($cacheFile, ob_get_contents());
            //清除缓冲区（清除了编译文件加载的内容）
            ob_end_clean();
            //载入缓冲文件
            include $cacheFile;
        }
    }
    /**
     * [cerate 当编译文件不存在，或者模板文件修改过，则生成编译文件]
     * @param  [type] $file [文件名]
     * @return [type]       [description]
     */
    public function create($file){
        //设置模板的路径
        $tplFile=TPL_DIR.$file;
        //判断模板是否存在
        if (!file_exists($tplFile)) {
            exit('ERROR:模板文件不存在');
        }
        //生成编译文件名
        $parFile=TPL_C_DIR.md5($file).$file.'.php';
        //如果编译文件不存在或者编译文件被修改过，则新生成文件$parFile
        if (!file_exists($parFile)||filemtime($parFile)<filemtime($tplFile)) {
            //引入模板解析类
            require_once ROOT_PATH.'/includes/Parser.class.php';
            $parser=new Parser($tplFile);//模板文件
            $parser->complice($parFile);//编译文件
        }
        //载入编译文件
        include $parFile;
        
    }

}
