<?php

class Webclient extends CI_Controller {

    public $client;

    public function __construct() {
        parent::__construct();
        $wsdl = "http://127.0.0.1:8888/superchemist/index.php/Soap?wsdl";
        $this->client = new SoapClient($wsdl);
    }

    function index() {
        try {
            $fcs = $this->client->__getFunctions();
            var_dump($fcs);
            $res = $this->client->getVersion('Akshay', 'WEBDEVELOPER');
            $res = $this->client->zeroArg();
            var_dump($res);
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }

}
