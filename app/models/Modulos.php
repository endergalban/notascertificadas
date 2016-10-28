<?php
class Modulos extends CI_Model {
	function __construct(){
		parent::__construct();
	}



	function registros(){

		$resultado = $this->db->select('visible,idmodulo,descripcion,archivo,orden,icono,(select count(*) from tipousuariomodulos WHERE tipousuariomodulos.idmodulo=modulos.idmodulo) as bloqueado')->
		from('modulos')->
		order_by('orden', 'asc')->get();
		return $resultado;

	}

	function modulo($id){
		$resultado = $this->db->from('modulos')->where('idmodulo',$id)->get();
		return $resultado->row_array();
	}


	function guardar($id=null)
	{
		if(is_null($id)){
			$data = array(
				'archivo' => $this->input->post('archivo'),
				'descripcion' => $this->input->post('descripcion'),
				'icono' => $this->input->post('icono'),
				'orden' => $this->input->post('orden'),
				'visible' => $this->input->post('visible')
			);
			$this->db->trans_start();
			$this->db->insert('modulos', $data);
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
			{
				$error=$this->db->error();
			}
		}else{

			$data = array(
				'archivo' => $this->input->post('archivo'),
				'descripcion' => $this->input->post('descripcion'),
				'icono' => $this->input->post('icono'),
				'orden' => $this->input->post('orden'),
				'visible' => $this->input->post('visible')
			);
			$this->db->trans_start();
			$this->db->update('modulos', $data, array('idmodulo' =>$id));
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
			{
				$error=$this->db->error();
			}

		}
	}

	function eliminar($id=null)
	{
		if(!is_null($id)){
			$this->db->where('idmodulo', $id);
			$this->db->delete('modulos');
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
			{
				$error=$this->db->error();
			}

		}
	}

}
?>
