<?php
class ClienteModelo extends CI_Model {

    public function __construct()	{
        $this->load->database();
    }

    public function obtener_datos_cliente($usuario, $pass){
        $query = $this->db->get_where('CLIENTE', array('USUARIOCLIENTE' => $usuario, 'PASSCLIENTE' => $pass));

        if ($query->num_rows() > 0) {
            return $query->row();
        }else{
            return FALSE;
        }
    }


}