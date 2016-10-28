<?php
class Mensajes extends CI_Model {
	function __construct(){
		parent::__construct();
	}



	function registros($nro=null){

		$this->db->select('mensajes.fechahora,mensajes.idmensaje,mensajes.asunto,mensajes.mensaje,usuarios.nombre as usuario,usuarios.miniatura')->
		from('mensajes')->
		join('usuarios', 'mensajes.idusuario = usuarios.idusuario', 'inner')->
		order_by('fechahora', 'desc');
		if(!is_null($nro))
		{
			$this->db->limit(5,0);
		}
		$resultado=$this->db->get();
		return $resultado;
	}

	function mensaje($idmensaje	){

		$resultado = $this->db->from('mensajes')->where(array('idmensaje'=> $idmensaje))->get();
		return $resultado->row_array();

	}


	function guardar($idmensaje)
	{
		if($idmensaje==0){
			$data = array(
				'mensaje' => $this->input->post('mensaje'),
				'asunto' => $this->input->post('asunto'),
				'idusuario' => $this->session->userdata('idusuario')
			);
			$this->db->trans_start();
			$this->db->insert('mensajes', $data);
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
			{
				$error=$this->db->error();
			}
		}else{

			$data = array(
				'mensaje' => $this->input->post('mensaje'),
				'asunto' => $this->input->post('asunto'),
				'idusuario' => $this->session->userdata('idusuario')
			);
			$this->db->trans_start();
			$this->db->update('mensajes', $data, array('idmensaje'=> $idmensaje));
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
			{
				$error=$this->db->error();
			}

		}
	}



	function eliminar($idmensaje)
	{
		$this->db->where(array('idmensaje'=> $idmensaje));
		$this->db->delete('mensajes');
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			$error=$this->db->error();
		}
	}

}
?>
