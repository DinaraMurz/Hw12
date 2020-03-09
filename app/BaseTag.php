<?php

namespace TagElement;


abstract class BaseTag
{
    private $name;
    private $attributes;
    private $isSelfClosing;
    private $body;

    private const SELF_CLOSED = ['area', 'base', 'br', 'col', 'embed', 'hr', 'img', 'input', 'link', 'meta', 'param', 'source', 'track', 'wbr', 'command', 'keygen', 'menuitem'];

    function __construct(string $name, array $attributes = [])
    {
        $this->body = new Body();
        $this->name = $name;
        $this->attributes = new Attributes($attributes);

        if(in_array($name, self::SELF_CLOSED)){
            $this->selfClosing();
        }
    }

    public function setAttribute($key, $default = null){
        return $this->attributes->setAttribute($key, $default);
    }

    public function appendAttributes($key, $value){
        return $this->attributes->setAttribute($key, $this->attributes->getAttribute($key) . $value);
    }

    protected function selfClosing()
    {
        $this->isSelfClosing = true;
    }

    public function prependBody($body)
    {
        $this->body->prependBody($body);

        return $this;
    }

    public function appendBody($body)
    {
        $this->body->appendBody($body);

        return $this;
    }

    public function __toString() : string
    {
        $result = "<$this->name ";

        $result .= $this->attributes;

        $result .=  $this->isSelfClosing ? " />" : ">$this->body</$this->name>";

        return $result;
    }

    public function appendTo(BaseTag $tag){
        $tag->appendBody($this);
        return $this;
    }

    public function prependTo(BaseTag $tag){
        $tag->prependBody($this);
        return $this;
    }

    /*
    public function selfClosing(){
        $this->isSelfClosing = true;
    }
    public function addAttribute($key,string $value = "null"){
        $this->attrs[$key] = $value;
    }
    public function addAttributes(array $attrs){
        foreach($attrs as $key => $value)
        $this->addAttribute($key, $value);
    }
    public function appendBody($body){
        $this->body = $body . $this->body;
    }
    public function prependBody($body){
        $this->body = $this->body . $body;
    }
    public function getString(){
        $str = "";
        $str = "<{$this->name} ";
        foreach($this->attrs as $key=>$value){
            $str .= "{$key}='{$value}'";
        }
        $str .= ">";
        if($this->isSelfClosing)
            $str .= "{$this->body}</{$this->name}>";
        return $str;
    }
    public function addClass(string $name){
        addAttribute("class", $name);
    }
    public function appendAttribute($key,string $value = "null"){
        array_unshift($this->attrs[$key],$value);
    }
    public function prependAttribute($key,string $value = "null"){
        array_push($this->attrs[$key],$value);
    }*/
}