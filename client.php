<?php

class client {
    public function __construct() {
        $params = [
            'uri' => 'http://localhost/EjerciciosServidor/AutomovilesSoapAuth/',
            'location' => 'http://localhost/EjerciciosServidor/AutomovilesSoapAuth/service.php',
            'trace' => 1
        ];
        $this->instance = new SoapClient(null, $params);

        $auth_params = new stdClass();
        $auth_params->username = 'ies';
        $auth_params->password = 'daw';

        $header_params = new SoapVar($auth_params, SOAP_ENC_OBJECT);
        $header = new SoapHeader('http://localhost/EjerciciosServidor/AutomovilesSoapAuth/', 'authenticate', $header_params, false);
        $this->instance->__setSoapHeaders(array($header));
        
    }

    public function getInstance() {
        return $this->instance;
    }
}

$client = new client();
