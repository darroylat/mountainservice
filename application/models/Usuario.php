<?php
class Usuario extends CI_Model {

    public function __construct()	{
        $this->load->database();
    }

    public function obtener_usuario($rut, $dv, $clave){
        $query = $this->db->get_where('cliente', array('rutcliente' => $rut, 'dvcliente' => $dv, 'passcliente' => $clave));
        return $query->row_array();
    }

}
