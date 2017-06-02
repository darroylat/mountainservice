<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuario extends CI_Controller {

    function __construct(){
        parent::__construct();

        $this->load->library("Nusoap"); //load the library here
        $this->nusoap_server = new soap_server();
        $this->nusoap_server->configureWSDL("MySoapServer", "urn:MySoapServer");
        $this->nusoap_server->wsdl->schemaTargetNamespace = 'urn:MySoapServer';
    }

    public function index(){

    }

    public function encontrar(){
        /**
         * Busca Usuario para logiar en pagina cliente
         */
        $this->nusoap_server->wsdl->addComplexType('entrada',
            'complexType',
            'struct',
            'all',
            '',
            array('usuario_cliente' => array('name' => 'usuario_cliente', 'type' => 'xsd:string'),
                'contrasena_cliente' => array('name' => 'contrasena_cliente', 'type' => 'xsd:string'),
                'usuario' => array('name' => 'usuario', 'type' => 'xsd:string'),
                'contrasena' => array('name' => 'contrasena', 'type' => 'xsd:string'))
        );

        $this->nusoap_server->wsdl->addComplexType('salida',
            'complexType',
            'struct',
            'all',
            '',
            array('codigo' => array('name' => 'codigo', 'type' => 'xsd:string'),
                'descripcion' => array('name' => 'descripcion', 'type' => 'xsd:string'))
        );

        $this->nusoap_server->register('loginUsuario', // nombre del metodo o funcion
            array('login' => 'tns:entrada'), // parametros de entrada
            array('return' => 'tns:salida'), // parametros de salida
            'urn:mi_ws1', // namespace
            'urn:hellowsdl2#varifica_usuario', // soapaction debe ir asociado al nombre del metodo
            'rpc', // style
            'encoded', // use
            'Verifica que el usuario este registrado y lo valida' // documentation
        );

        $this->load->model('Cliente');

        function loginUsuario($datos){
            //$edad_actual = date('Y') - $datos['ano_nac'];
            //$msg = 'Hola, ' . $datos['nombre'] . '. Hemos procesado la siguiente informacion ' . $datos['email'] . ', telefono' . $datos['telefono'] . ' y su Edad actual es: ' . $edad_actual . '.';
            $usuario = $datos['usuario_cliente'];
            $pass = $datos['contrasena_cliente'];

            $query = $this->Cliente->obtener_datos_cliente($usuario, $pass);

            $cod = '0000';
            $msg = 'Encontrado e identificado, '.$query['idcliente'].', '.$query['datoscliente'];
            return array('codigo' => $cod, 'descripcion' => $msg);
        }

        $this->nusoap_server->service(file_get_contents("php://input"));
    }

    public function registrar(){
        /**
         * Registra nuevo Usuario
         */
        $this->nusoap_server->wsdl->addComplexType('entrada',
            'complexType',
            'struct',
            'all',
            '',
            array(
                'usuario_cliente' => array('name' => 'usuario_cliente', 'type' => 'xsd:string'),
                'contrasena_cliente' => array('name' => 'contrasena_cliente', 'type' => 'xsd:string'),
                'rut' => array('name' => 'usuario', 'type' => 'xsd:string'),
                'nombre' => array('name' => 'usuario', 'type' => 'xsd:string'),
                'apellido' => array('name' => 'usuario', 'type' => 'xsd:string'),
                'contrasena' => array('name' => 'usuario', 'type' => 'xsd:string'),
                'contrasenac' => array('name' => 'usuario', 'type' => 'xsd:string'),
                'email' => array('name' => 'usuario', 'type' => 'xsd:string'),
                'sexo' => array('name' => 'usuario', 'type' => 'xsd:string'),
                'fecha_nacimiento' => array('name' => 'usuario', 'type' => 'xsd:string'),
                'telefono' => array('name' => 'usuario', 'type' => 'xsd:string'))
        );
        $this->nusoap_server->wsdl->addComplexType('salida',
            'complexType',
            'struct',
            'all',
            '',
            array('codigo' => array('name' => 'codigo', 'type' => 'xsd:string'),
                'descripcion' => array('name' => 'descripcion', 'type' => 'xsd:string'),
                'usuario' => array('name' => 'usuario', 'type' => 'xsd:string'))
        );
        $this->nusoap_server->register('guardarUsuario', // nombre del metodo o funcion
            array('nuevoUsuario' => 'tns:entrada'), // parametros de entrada
            array('return' => 'tns:salida'), // parametros de salida
            'urn:mi_ws1', // namespace
            'urn:hellowsdl2#guardar_usuario', // soapaction debe ir asociado al nombre del metodo
            'rpc', // style
            'encoded', // use
            'Verifica que el usuario este registrado y lo valida' // documentation
        );
        function guardarUsuario($datos)
        {
            //$edad_actual = date('Y') - $datos['ano_nac'];
            //$msg = 'Hola, ' . $datos['nombre'] . '. Hemos procesado la siguiente informacion ' . $datos['email'] . ', telefono' . $datos['telefono'] . ' y su Edad actual es: ' . $edad_actual . '.';
            $cod = '0000';
            $msg = 'Ingreso de nuevo usuario de forma correcta';
            $usuario = $datos['usuario'];
            return array('codigo' => $cod, 'descripcion' => $msg, 'usuario' => $usuario);
        }

        $this->nusoap_server->service(file_get_contents("php://input"));
    }
    public function actualizar(){
        /**
         * Actualiza Usuario
         */
        $this->nusoap_server->wsdl->addComplexType('entrada',
            'complexType',
            'struct',
            'all',
            '',
            array('usuario_cliente' => array('name' => 'usuario_cliente', 'type' => 'xsd:string'),
                'contrasena_cliente' => array('name' => 'contrasena_cliente', 'type' => 'xsd:string'),
                'usuario' => array('name' => 'usuario', 'type' => 'xsd:string'),
                'nombre' => array('name' => 'usuario', 'type' => 'xsd:string'),
                'apellido' => array('name' => 'usuario', 'type' => 'xsd:string'),
                'contrasena' => array('name' => 'usuario', 'type' => 'xsd:string'),
                'contrasenac' => array('name' => 'usuario', 'type' => 'xsd:string'),
                'email' => array('name' => 'usuario', 'type' => 'xsd:string'),
                'sexo' => array('name' => 'usuario', 'type' => 'xsd:string'),
                'edad' => array('name' => 'usuario', 'type' => 'xsd:string'),
                'rut' => array('name' => 'usuario', 'type' => 'xsd:string'),
                'telefono' => array('name' => 'usuario', 'type' => 'xsd:string'),
                'auto' => array('name' => 'usuario', 'type' => 'xsd:string'))
        );
        $this->nusoap_server->wsdl->addComplexType('salida',
            'complexType',
            'struct',
            'all',
            '',
            array('codigo' => array('name' => 'codigo', 'type' => 'xsd:string'),
                'descripcion' => array('name' => 'descripcion', 'type' => 'xsd:string'),
                'usuario' => array('name' => 'usuario', 'type' => 'xsd:string'))
        );
        $this->nusoap_server->register('actualizarUsuario', // nombre del metodo o funcion
            array('actualizaUsuario' => 'tns:entrada'), // parametros de entrada
            array('return' => 'tns:salida'), // parametros de salida
            'urn:mi_ws1', // namespace
            'urn:hellowsdl2#guardar_usuario', // soapaction debe ir asociado al nombre del metodo
            'rpc', // style
            'encoded', // use
            'Verifica que el usuario este registrado y lo valida' // documentation
        );
        function actualizarUsuario($datos)
        {
            //$edad_actual = date('Y') - $datos['ano_nac'];
            //$msg = 'Hola, ' . $datos['nombre'] . '. Hemos procesado la siguiente informacion ' . $datos['email'] . ', telefono' . $datos['telefono'] . ' y su Edad actual es: ' . $edad_actual . '.';
            $cod = '0000';
            $msg = 'Ingreso de nuevo usuario de forma correcta';
            $usuario = $datos['usuario'];
            return array('codigo' => $cod, 'descripcion' => $msg, 'usuario' => $usuario);
        }

        $this->nusoap_server->service(file_get_contents("php://input"));
    }
}