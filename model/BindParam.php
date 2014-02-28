<?php

class BindParam{

    private $values = array(), $types = '';

    public function add( $type, $value ){
        $this->values[] = $value;
        $this->types .= $type;
    }

    public function get(){
        $bindParmeters = array();
        $bindParmeters[] = & $this->types;
        for($count=0; $count < (count($this->values)); $count++) {
            $bindParmeters[] =  & $this->values[$count];
        }
        return $bindParmeters;
    }
}