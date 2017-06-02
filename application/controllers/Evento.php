<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Evento extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->library("Nusoap"); //load the library here
        $this->nusoap_server = new soap_server();
        $this->nusoap_server->configureWSDL("MySoapServer", "urn:MySoapServer");
        $this->nusoap_server->wsdl->schemaTargetNamespace = 'urn:MySoapServer';
    }

    public function index(){

    }
    public function varios(){
        /**
         * Busca eventos por la cantidad informada
         */
        $this->nusoap_server->wsdl->addComplexType('entrada',
            'complexType',
            'struct',
            'all',
            '',
            array('usuario_cliente' => array('name' => 'usuario_cliente', 'type' => 'xsd:string'),
                'contrasena_cliente' => array('name' => 'contrasena_cliente', 'type' => 'xsd:string'),
                'cantidad' => array('name' => 'cantidad', 'type' => 'xsd:string'))
        );

        $this->nusoap_server->wsdl->addComplexType('salida',
            'complexType',
            'struct',
            'all',
            '',
            array('codigo' => array('name' => 'codigo', 'type' => 'xsd:string'),
                'descripcion' => array('name' => 'descripcion', 'type' => 'xsd:string'))
        );

        $this->nusoap_server->register('mostrarEvento', // nombre del metodo o funcion
            array('login' => 'tns:entrada'), // parametros de entrada
            array('return' => 'tns:salida'), // parametros de salida
            'urn:mi_ws1', // namespace
            'urn:hellowsdl2#varifica_usuario', // soapaction debe ir asociado al nombre del metodo
            'rpc', // style
            'encoded', // use
            'Verifica que el usuario este registrado y lo valida' // documentation
        );

        function mostrarEvento($datos){
            //$edad_actual = date('Y') - $datos['ano_nac'];
            //$msg = 'Hola, ' . $datos['nombre'] . '. Hemos procesado la siguiente informacion ' . $datos['email'] . ', telefono' . $datos['telefono'] . ' y su Edad actual es: ' . $edad_actual . '.';
            $cod = '0000';
            $msg = 'Encontrado e identificado';
            return array('codigo' => $cod, 'descripcion' => $msg);
        }

        $this->nusoap_server->service(file_get_contents("php://input"));
    }
    public function individual(){
        /**
         * Busca evento por el id del evento
         */
        $this->nusoap_server->wsdl->addComplexType('entrada',
            'complexType',
            'struct',
            'all',
            '',
            array('usuario_cliente' => array('name' => 'usuario_cliente', 'type' => 'xsd:string'),
                'contrasena_cliente' => array('name' => 'contrasena_cliente', 'type' => 'xsd:string'),
                'evento' => array('name' => 'evento', 'type' => 'xsd:string'))
        );

        $this->nusoap_server->wsdl->addComplexType('salida',
            'complexType',
            'struct',
            'all',
            '',
            array('nombre' => array('name' => 'nombre', 'type' => 'xsd:string'),
                'descripcion' => array('name' => 'descripcion', 'type' => 'xsd:string'),
                'fecha' => array('name' => 'fecha', 'type' => 'xsd:string'),
                'hora' => array('name' => 'hora', 'type' => 'xsd:string'),
                'encuentro' => array('name' => 'encuentro', 'type' => 'xsd:string'),
                'cierre' => array('name' => 'cierre', 'type' => 'xsd:string'),
                'nombre_sendero' => array('name' => 'nombre_sendero', 'type' => 'xsd:string'),
                'nivel_sendero' => array('name' => 'nivel_sendero', 'type' => 'xsd:string'),
                'descripcion_sendero' => array('name' => 'descripcion_sendero', 'type' => 'xsd:string'),
                'nombre_ubicacion' => array('name' => 'nombre_ubicacion', 'type' => 'xsd:string'),
                'caracteristicas' => array('name' => 'caracteristicas', 'type' => 'xsd:string'),
                'informacion' => array('name' => 'informacion', 'type' => 'xsd:string'),
                'equipamiento' => array('name' => 'equipamiento', 'type' => 'xsd:string'),
                'recomendaciones' => array('name' => 'recomendaciones', 'type' => 'xsd:string'))
        );

        $this->nusoap_server->register('individualEvento', // nombre del metodo o funcion
            array('login' => 'tns:entrada'), // parametros de entrada
            array('return' => 'tns:salida'), // parametros de salida
            'urn:mi_ws1', // namespace
            'urn:hellowsdl2#varifica_usuario', // soapaction debe ir asociado al nombre del metodo
            'rpc', // style
            'encoded', // use
            'Verifica que el usuario este registrado y lo valida' // documentation
        );

        function individualEvento($datos){
            //$edad_actual = date('Y') - $datos['ano_nac'];
            //$msg = 'Hola, ' . $datos['nombre'] . '. Hemos procesado la siguiente informacion ' . $datos['email'] . ', telefono' . $datos['telefono'] . ' y su Edad actual es: ' . $edad_actual . '.';
            $cod = '0000';
            $msg = 'Encontrado e identificado';
            return array('codigo' => $cod, 'descripcion' => $msg);
        }

        $this->nusoap_server->service(file_get_contents("php://input"));
    }

}