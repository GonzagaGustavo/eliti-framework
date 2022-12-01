<?php

class Eliti_Response_Success_Object extends Eliti_Response_Success {

    public function __construct($object) {
        parent::__construct();
        $this->data = $object;
    }
    
}
