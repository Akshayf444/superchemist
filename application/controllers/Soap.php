<?php

require_once APPPATH . '/third_party/lib/nusoap.php';

class Soap extends CI_Controller {

    public $server;

    public function __construct() {

        parent::__construct();

        $this->server = new soap_server();
        $this->server->configureWSDL("MySoap", "urn:MySoap");
        $this->server->register("getVersion", array('name' => 'xsd:string', 'profession' => 'xsd:string'), array('return' => 'xsd:string'), "urn:MySoap");
        $this->server->register("zeroArg", array(), array('return' => 'xsd:string'), 'urn:MySoap');
    }

    function index() {
        function getVersion($name, $profession) {
            return $name . " " . $profession;
        }

        function zeroArg() {
            $CI =& get_instance();
            $CI->load->model("User_model");
            $appVersion = $CI->User_model->getAppVersion();
            $version = $appVersion->version;
            return $version;
        }

        $this->server->service(file_get_contents("php://input"));
    }

}
