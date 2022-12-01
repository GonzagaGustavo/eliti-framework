<?php

namespace epanel\Eliti;

class Eliti
{

    public static function r($a, $die = true)
    {
        self::print_r($a, $die);
    }

    public static function print_r($a, $die = true)
    {
        echo "<pre>";
        print_r($a);
        echo "</pre>";
        if ($die) {
            die();
        }
    }

    public static function removeArrayKeys($original)
    {
        $new = array();
        foreach ($original as $o) {
            $new[] = $o;
        }
        return $new;
    }

    /*
     * Singleton
     */

    private static $_instance;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    /**
     * @return Eliti
     */
    public static function getInstance()
    {
        if (!isset(self::$_instance)) { // Testa se há instância definida na propriedade, caso sim, a classe não será instanciada novamente.
            self::$_instance = new self; // o new self cria uma instância da própria classe à própria classe.
        }
        return self::$_instance;
    }

    public function getModel($name)
    {
        $modelFacadeClass = $name . "_" . "Model";
        return new $modelFacadeClass;
    }

    /**
     * Retorna a sessão geral da Aplicação
     * (Vale para todos os Modelos)
     *
     * @return Zend_Session_Namespace
     */
    public function getSession()
    {
        return new Zend_Session_Namespace("Eliti_Session");
    }

    public function setUser(Eliti_User $user)
    {
        $this->getSession()->user = $user;
    }

    public function unsetUser()
    {
        unset($this->getSession()->user);
    }

    public function hasUser()
    {
        if (isset($this->getSession()->user)) {
            return true;
        }
        return false;
    }

    /**
     */
    // public function getLocale() {
    //     return $this->getSession()->locale;
    // }

    // public function getLang() {
    //     return $this->getSession()->lang ?? false;
    // }

    // public function setLang($lang) {
    //     $this->getSession()->lang = $lang;
    // }

    // public function clearLang() {
    //     unset($this->getSession()->lang);
    // }

    // public function hasLocale() {
    //     return $this->getSession()->locale instanceof User_Entity_Locale ? true : false;
    // }

    // public function setLocale($locale) {
    //     $this->getSession()->locale = $locale instanceof User_Entity_Locale ? $locale : Eliti::getInstance()->getModel("User")->getService("Locale")->getById($locale, null);
    // }

    // public function clearLocale() {
    //     unset($this->getSession()->locale);
    // }

    /**
     * Retorna o usuário registrado na sessão
     *
     * @return Eliti_User
     */
    public function getUser()
    {
        return $this->getSession()->user;
    }

    /**
     * Define se solicitação foi por AJAX
     */
    public static function isAjaxRequest(Zend_Controller_Request_Abstract $request)
    {
        /*
         * Verificação de strpos foi adicionada porque solitações ajax via $http do AngularJS não estavam sendo identificadas como AJAX.
         */
        return $request->isXmlHttpRequest() || strpos(@$_SERVER['HTTP_ACCEPT'], "application/json") !== false;
    }

    public function generateCode()
    {
        return strtoupper(substr(sha1(time() * rand(2, 100)), 0, 10));
    }
}
