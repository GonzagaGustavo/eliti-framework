<?php

use epanel\Eliti\Eliti;

abstract class Eliti_Controller_Rest_Crud extends Eliti_Controller_Rest
{

    protected $service;

    public function init()
    {
        parent::init();
        $this->service = $this->getModel($this->getConfigModel())->getService($this->getConfigService());
    }

    public function indexAction()
    {
        $this->get();
    }

    public function getAction()
    {
        $this->get($this->getParamInt("id"));
    }

    public function postAction()
    {
        $this->save();
        //        die("From postAction() creating the requested article");
    }

    public function putAction()
    {
        $array = json_decode($this->getRequest()->getRawBody(), true);
        $this->sort($array);
    }

    public function save()
    {
        try {
            $array = [];
            foreach ($_POST as $key => $value) {
                $array[$key] = $value;
            }
            // Eliti::print_r($_FILES);
            foreach ($_FILES as $key => $file) {
                // Eliti::print_r($file);
                $array[$key] = $file;
            }

            // adiciona arquivos do array
            // $upload = new Zend_File_Transfer();
            // $files = $upload->getFileInfo();
            // Eliti::print_r($files);
            // foreach ($files as $key => $file) {
            //     $array[$key] = $file;
            // }

            $id = $this->service->save($array, $this->getFilter());
            $response = new Eliti_Response_Success_Object($this->get($id));
            $response->send();
        } catch (Eliti_Exception $e) {
            $response = new Eliti_Response_Error_Validation($e);
            $response->send();
        } catch (Exception $e) {
            $response = new Eliti_Response_Error_Message($e->getMessage());
            $response->send();
        }
    }

    public function deleteAction()
    {
        try {
            $this->service->delete($this->getParamInt("id"), $this->getFilter());
            $response = new Eliti_Response_Success_Silence();
            $response->send();
        } catch (Exception $e) {
            $response = new Eliti_Response_Error_Message($e->getMessage());
            $response->send();
        }
    }

    // READ
    protected function get($id = null)
    {
        if ($id) {
            // retornar apenas um
            $result = $this->getById($id);
            $this->onGetObject($result);
            //            $resultJson = json_encode($result);
            $response = new Eliti_Response_Success_Object($result);
        } else {
            // Listar com base no filtro da view
            $result = $this->listEntities();
            $this->onGetObjects($result);
            $response = new Eliti_Response_Success_Objects(Eliti::removeArrayKeys($result));
        }
        $response->send();
    }

    protected function onGetObject(&$object)
    {
    }

    protected function onGetObjects(&$objects)
    {
    }

    protected function getById($id)
    {
        return $this->service->getById($id, $this->getFilter($id));
    }

    protected function listEntities()
    {
        $filter = $this->getParam("filter");
        $filter .= $filter ? " AND " : "";
        $filter .= $this->getFilter();

        $result = $this->service->get(
            null,
            $this->getParam("q"),
            $this->getParamOrder(),
            $this->getParamBool("desc"),
            $this->getLimit(), // $this->getParamInt("limit"),
            $this->getParamInt("offset"),
            null,
            $filter
        );

        return $result;
    }

    // adicionado em 23/março/2021 por Lucas para poder filtrar por campos calculados
    protected function getParamOrder()
    {
        return $this->getParam("order");
    }

    protected function getLimit()
    {
        return $this->getParam("id") === "all" ? false : $this->getParamInt("limit");
    }

    protected function getFilter($id = null)
    {
        return null;
    }

    protected function sort($sort)
    {
        $this->service->sort($sort);
        $r = new Eliti_Response_Success_Silence();
        $r->send();
    }

    // MÉTODOS DE APOIO CRUD FONTEND
    abstract public function getConfig();

    protected function getConfigModel()
    {
        $config = $this->getConfig();
        return $config["MODEL"];
    }

    protected function getConfigService()
    {
        $config = $this->getConfig();
        return $config["SERVICE"];
    }

    protected function getConfigController()
    {
        $config = $this->getConfig();
        return $config["CONTROLLER"];
    }
}
