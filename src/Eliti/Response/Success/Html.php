<?php

class Eliti_Response_Success_Html extends Eliti_Response_Success
{
    public function __construct($target, $html)
    {
        parent::__construct();
        $this->data = array(
            /**
             * Conteúdo HTML que será injetado na página
             */
            "html" => $html,
            /**
             * Normalmente o id com a # indicando o componente html que deverá
             * desaparecer para dar lugar ao novo conteudo enviado no atributo html.
             */
            "target" => $target,
        );
    }

}
