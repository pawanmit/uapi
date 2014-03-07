<?php

class BindParam{

    private $values = array(), $types = '', $sql='';

    public function add( $type, $value ){
        $this->values[] = $value;
        $this->types .= $type;
    }

    public function getParameters(){
        $bindParmeters = array();
        if (strlen($this->types) > 0) {
            $bindParmeters[] = & $this->types;
            for($count=0; $count < (count($this->values)); $count++) {
                $bindParmeters[] =  & $this->values[$count];
            }
        }
        return $bindParmeters;
    }

    public function getSql() {
        return $this->sql;
    }

    public function setSql($sql) {
        $this->sql = $sql;
    }
}