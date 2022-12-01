<?php

class Eliti_Response_Json extends Eliti_Response
{

    public function __construct($value)
    {
        $this->data = $value;
    }

    public function send($callback = false)
    {
        header("HTTP/1.0 200");
        header('Content-Type: application/json');
        echo json_encode($this->data, true);
        exit();
    }
}
