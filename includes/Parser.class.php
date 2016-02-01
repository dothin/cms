<?php
/**
 * @Author: gaohuabin
 * @Date:   2016-01-18 12:45:10
 * @Last Modified by:   gaohuabin
 * @Last Modified time: 2016-01-31 11:57:34
 */
/**
 * 模板解析类
 */
class Parser{
    private $tpl;
    //构造方法。用于获取模板文件里的内容
    public function __construct($tplFile){
        //读取文件里面的内容
        if (!$this->tpl=file_get_contents($tplFile)) {
            exit('ERROR:模板文件读取错误');
        }
    }
    /**
     * [complice 公开对外的方法]
     * @param  [type] $parFile [生成的编译文件名称]
     * @return [type]          [description]
     */
    public function complice($parFile){
        //解析模板内容
        $this->parConfig();
        $this->parVar();
        $this->parFor();
        $this->parIf();
        $this->parIff();
        $this->parCommon();
        $this->parInclude();
        $this->parForeach();

        //生成编译文件
        if (!file_put_contents($parFile, $this->tpl)) {
            exit('ERROR:编译文件生成错误');
        }
    }   
    /**
     * [parVar 解析系统变量]
     * @return [type] [description]
     */
    private function parConfig() {
        $patten = '/<!--\{([\w]+)\}-->/';
        if (preg_match($patten,$this->tpl)) {
            $this->tpl = preg_replace($patten,"<?php echo \$this->config['$1'];?>",$this->tpl);
        }
    }
    /**
     * [parVar 解析普通变量]
     * @return [type] [description]
     */
    private function parVar() {
        $patten = '/\{\$([\w]+)\}/';
        if (preg_match($patten,$this->tpl)) {
            $this->tpl = preg_replace($patten,"<?php echo \$this->vars['$1'];?>",$this->tpl);
        }
    }
    /**
     * [parVar 解析if语句]
     * @return [type] [description]
     */
    private function parIf(){
        $pattenIf = '/\{if\s+\$([\w]+)\}/';
        $pattenEndIf = '/\{\/if\}/';
        $pattenElse='/\{else\}/';
        if (preg_match($pattenIf, $this->tpl)) {
            if (preg_match($pattenEndIf, $this->tpl)) {
                $this->tpl=preg_replace($pattenIf, "<?php if(@\$this->vars['$1']){?>", $this->tpl);
                $this->tpl=preg_replace($pattenEndIf, "<?php }?>", $this->tpl);
                if (preg_match($pattenElse, $this->tpl)){
                    $this->tpl=preg_replace($pattenElse, "<?php }else{?>", $this->tpl);
                }
            }else{
                exit('ERROR:if语句没有关闭');
            }
        }
    }
    /**
     * [parVar 解析iff语句]
     * @return [type] [description]
     */
    private function parIff(){
        $pattenIf = '/\{iff\s+\@([\w\-\>]+)\}/';
        $pattenEndIf = '/\{\/iff\}/';
        $pattenElse='/\{else\}/';
        if (preg_match($pattenIf, $this->tpl)) {
            if (preg_match($pattenEndIf, $this->tpl)) {
                $this->tpl=preg_replace($pattenIf, "<?php if(@\$$1){?>", $this->tpl);
                $this->tpl=preg_replace($pattenEndIf, "<?php }?>", $this->tpl);
                if (preg_match($pattenElse, $this->tpl)){
                    $this->tpl=preg_replace($pattenElse, "<?php }else{?>", $this->tpl);
                }
            }else{
                exit('ERROR:if语句没有关闭');
            }
        }
    }
    /**
     * [parVar 解析php代码注释]
     * @return [type] [description]
     */
    private function parCommon() {
        $patten = '/\{#\}(.*)\{#\}/';
        if (preg_match($patten,$this->tpl)) {
            $this->tpl = preg_replace($patten,"<?php /* $1 */ ?>",$this->tpl);
        }
    }
    /**
     * [parVar 解析include语句]
     * @return [type] [description]
     */
    private function parInclude() {
        $patten = '/\{include\s+file=(\"|\')([\w\.\-\/]+)(\"|\')\}/';
        if (preg_match_all($patten,$this->tpl,$file)) {
            foreach ($file[2] as $value) {
                if (!file_exists('templates/'.$value)) {
                    exit('ERROR：包含文件错误');
                }
                $this->tpl = preg_replace($patten,"<?php \$tpl->create('$2'); ?>",$this->tpl);
            }
        }
    }
    /**
     * [parVar 解析foreach语句]
     * @return [type] [description]
     */
    private function parForeach() {
        $pattenForeach = '/\{foreach\s+\$([\w]+)\(([\w]+),([\w]+)\)\}/';
        $pattenForeachEnd='/\{\/foreach\}/';
        $pattenForeachContent='/\{@([\w]+)([\w\-\>\+]*)\}/';
        if (preg_match($pattenForeach,$this->tpl)) {
            if (preg_match($pattenForeachEnd,$this->tpl)) {
                $this->tpl = preg_replace($pattenForeach,"<?php foreach(\$this->vars['$1'] as \$$2=>\$$3){ ?>",$this->tpl);
                $this->tpl = preg_replace($pattenForeachEnd,"<?php } ?>",$this->tpl);
                if (preg_match($pattenForeachContent,$this->tpl)) {
                    $this->tpl = preg_replace($pattenForeachContent,"<?php echo \$$1$2; ?>",$this->tpl);
                }
            }else{
                exit('ERROR:foreach语句必须有结尾标签');
            }
        }
    }
    /**
     * [parFor 解析for语句，用内嵌循环]
     * @return [type] [description]
     */
    private function parFor(){
        $pattenFor = '/\{for\s+\@([\w\-\>]+)\(([\w]+),([\w]+)\)\}/';
        $pattenForEnd='/\{\/for\}/';
        $pattenForContent='/\{@([\w]+)([\w\-\>\+]*)\}/';
        if (preg_match($pattenFor,$this->tpl)) {
            if (preg_match($pattenForEnd,$this->tpl)) {
                $this->tpl = preg_replace($pattenFor,"<?php foreach(\$$1 as \$$2=>\$$3){ ?>",$this->tpl);
                $this->tpl = preg_replace($pattenForEnd,"<?php } ?>",$this->tpl);
                if (preg_match($pattenForContent,$this->tpl)) {
                    $this->tpl = preg_replace($pattenForContent,"<?php echo \$$1$2; ?>",$this->tpl);
                }
            }else{
                exit('ERROR:for语句必须有结尾标签');
            }
        }
    }
}