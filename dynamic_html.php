<?php

define( "NL", "\n" ); //or PHP_EOL
/*
echo html::div(['class:container'])
    ->div(['class:left'],'left')
    ->div(['class:right'],'right')
    ->div(['class:header'],'header')
    ->div(['class:footer'],'footer')
    ->end();
*/
echo html::form(['method'=>'get', 'action'=>''])
    ->span(['id:pass'],'Username')
    ->input(['type:text','name:user', "id:user", "placeholder:Username"])
    ->div(["id:append", "class:append"],'append')
    ->div(["id:append", "class:append"],'append')
    ->div(["id:append", "class:append"],'append')
    ->input(['type:password','name:pass', "id:pass", "placeholder:Password"])
    ->span(['id:pass'],'Select multiple')
    ->select(['name:cars','size:2', 'multiple:multiple'], ["img", "br", "hr", "input", "area"])
    ->span(['id:pass'],'Select Single')
    ->select(['name:cars'], ["img", "br", "hr", "input", "area", "link", "meta", "param"])
    ->radio(['name:cars'], ['img'=>'Image', "br", "hr"])
    ->cheakbox(['name:cars'], ['img'=>'Image','link'=>'Imlinkage', 'input'=>'inlinkput'])
    ->input(['type:submit','value:submit'])
    ->fieldset('Signup');
    //->end();


class html{
    static $tag = null;
    static $attr = [];
    public $items = [];
    function __construct(){

    }
    static function __callStatic($name, $args){
        self::$tag = $name;
        self::$attr = cln2Arr(array_shift($args));
        return new self;
    }
    function __call($name, $args){
        $attr = array_shift($args);
        $attr = is_array($attr) ? cln2Arr($attr) : $attr;
        $vals = array_shift($args);
        if(isset($vals) && $vals=='append'){
            $this->items[] = tag($name, $attr, array_pop($this->items));
        }else{
            switch ($name){
                case "radio"    : $this->items[] = $this->mkradio($attr, $vals); break;
                case "select"   : $this->items[] = $this->mkselect($attr, $vals); break;
                case "cheakbox" : $this->items[] = $this->mkcheakbox($attr, $vals); break;
                default: $this->items[] = tag($name, $attr, $vals);
            }
        }
        return $this;
    }
    function mkselect($attr, $args){ $options = [];
        foreach ($args as $key => $val)
            $options[] = '<option value="'.$key.'">'.$val.'</option>';
        return tag("select", $attr, implode(NL, $options));
    }
    function mkradio($attr, $args){ $radios = [];
        foreach ($args as $key => $val)
            $radios[] = '<label><input type="radio" name="'.$attr['name'].'" value="'.$key.'"/>'.$val.'</label>';
        return implode(NL, $radios);
    }
    function mkcheakbox($attr, $args){ $checkbox = [];
        foreach ($args as $key => $val)
            $checkbox[] = '<label><input type="checkbox" name="'.$attr['name'].'" value="'.$key.'"/>'.$val.'</label>';
        return implode(NL, $checkbox);
    }
    function fieldset($label=null){
        return tag(self::$tag, self::$attr, tag('fieldset', ['style'=>'display:inline-grid'], ($label ? "<legend>$label</legend>":'') .NL. implode(NL, $this->items)));
    }
    function end(){ return tag(self::$tag, self::$attr, implode(NL, $this->items));}
}
function isIndexed($_arr){return array_values($_arr) === $_arr;}
function tag($tag, $attr="", $htm=""){
    $selfClose = ["img", "br", "hr", "input", "area", "link", "meta", "param"];
    $dom = "<".$tag;
    if(is_array($attr) && isIndexed($attr)) $attr = cln2Arr($attr);
    if(is_array($attr)) foreach($attr as $key=>$val) $dom .= " $key=\"$val\"";
    if(empty($htm) && is_string($attr)) $htm = $attr;
    if(in_array($tag, $selfClose)) return $dom . " />";
    return $dom .= ">".PHP_EOL. (is_array($htm)? implode(PHP_EOL, $htm) : $htm) .PHP_EOL. "</$tag>";
}
function cln2Arr($args){ $attr = [];
    if(!isIndexed($args)) return $args;
    foreach ($args as $arg) { $p = explode(':', $arg); $attr[$p[0]] = isset($p[1]) ? $p[1] : ""; }
    return $attr;
}
function pre($v){
    print('<pre>');print_r($v);print('</pre>');exit;
}
function _ln($str){
    global $language;
    return isset($language[$str]) ? $language[$str] : $str;
}
function pr($v){
    print('<pre>');print_r($v);print('</pre>');
}