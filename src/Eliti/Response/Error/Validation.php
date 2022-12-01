<?php

class Eliti_Response_Error_Validation extends Eliti_Response_Error
{

    // public $errors;
    // public $trace;

    public function __construct(Eliti_Exception $ee)
    {
        parent::__construct();
        $this->data = $ee->getErrors();
        // $this->trace = $ee->getTrace();
    }

}
