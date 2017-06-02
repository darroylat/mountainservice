<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    function __construct()
    {
        parent::__construct();

        $this->load->library("Nusoap"); //load the library here
        $this->nusoap_server = new soap_server();
        $this->nusoap_server->configureWSDL("MySoapServer", "urn:MySoapServer");
        $this->nusoap_server->wsdl->schemaTargetNamespace = 'urn:MySoapServer';

        //DATA TYPES
        $this->nusoap_server->wsdl->addComplexType(
            'Cd',
            'complexType',
            'struct',
            'all',
            '',
            array(
                'id' => array('name' => 'id', 'type' => 'xsd:integer'),
                'jahr' => array('name' => 'jahr', 'type' => 'xsd:integer'),
                'interpret' => array('name' => 'interpret', 'type' => 'xsd:string'),
                'titel' => array('name' => 'titel', 'type' => 'xsd:string')
            )
        );

        $this->nusoap_server->wsdl->addComplexType(
            "CdArray",
            "complexType",
            "array",
            "",
            "SOAP-ENC:Array",
            array(),
            array(
                array("ref"=>"SOAP-ENC:arrayType","wsdl:arrayType"=>"tns:Cd[]")
            ),
            "tns:Cd"
        );

        //REGISTRATION
        $this->nusoap_server->register(
            'getCdInfo',
            array('id' => 'xsd:integer'),  //parameters
            array('return' => 'tns:Cd'),  //output
            'urn:MySoapServer',   //namespace
            'urn:MySoapServer#getCdInfo',  //soapaction
            'rpc', // style
            'encoded', // use
            'Get CD Info by ID' //description
        );

        $this->nusoap_server->register(
            'getCds',
            array(),  //parameters
            array('return' => 'tns:CdArray'),  //output
            'urn:MySoapServer',   //namespace
            'urn:MySoapServer#getCds',  //soapaction
            'rpc', // style
            'encoded', // use
            'Get all CDs' //description
        );

        //IMPLEMENTATION
        function getCdInfo($id)
        {
            $ci =& get_instance();
            $ci->db->where('id', $id);
            $qcd = $ci->db->get('cds');
            if ($qcd->num_rows()>0) {
                return $qcd->row_array();
            } else {
                return false;
            }

        }

        function getCds()
        {
            $ci =& get_instance();
            $qcd = $ci->db->get('cds');
            if ($qcd->num_rows()>0) {
                $ret_val=array();
                $i=0;
                //echo "masuk hasil";
                foreach ($qcd->result_array() as $row) {
                    //var_dump($row);
                    $ret_val[$i]=$row;
                    $i++;
                }
                //var_dump($ret_val);
                return $ret_val;
            } else {
                return false;
            }

        }
    }
    public function index()
    {
        $this->nusoap_server->service(file_get_contents("php://input")); //shows the standard info about service
    }

    public function testClient()
    {
        $wsdl = 'http://localhost/webservice2/?wsdl';
        $this->load->library("Nusoap"); //load the library here

        $client = new nusoap_client($wsdl, 'wsdl');

        $res1 = $client->call('getCdInfo', array('id'=>1));
        var_dump($res1);

        $res2 = $client->call('getCds');
        var_dump($res2);
    }

}
