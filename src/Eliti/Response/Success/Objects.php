<?php

class Eliti_Response_Success_Objects extends Eliti_Response_Success {

    public function __construct($objects) {
        parent::__construct();
        $this->data = $objects;
    }
    
}
