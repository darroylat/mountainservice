<?php
class EventoModelo extends CI_Model {

    public function __construct()	{
        $this->load->database();
    }

    public function obtener_datos_cliente($usuario, $pass){
        $query = $this->db->get_where('CLIENTE', array('USUARIOCLIENTE' => $usuario, 'PASSCLIENTE' => $pass));
        return $query->row();
    }

    public function obtenerEventos(){
        $query = $this->db->get('EVENTO');

        if ($query->num_rows() > 0) {
            return $query->result();
        }else{
            return FALSE;
        }
    }

}