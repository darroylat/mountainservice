<?php
class Cliente extends CI_Model {

    public function __construct()	{
        $this->load->database();
    }

    public function obtener_datos_cliente($usuario, $pass){
        $query = $this->db->get_where('cliente', array('usuariocliente' => $usuario, 'passcliente' => $pass));
        return $query->row_array();
    }

}