<?php
class Escuelasforaneas extends CI_Model {
	function __construct(){
		parent::__construct();
	}



	function registros( $idusuario){

		$resultado = $this->db->select('idescuelaforanea,nombre,localidad,entidad,idusuario,
		(select count(*) from materias WHERE materias.idescuelaforanea=escuelasforaneas.idescuelaforanea) as bloqueado')->
		from('escuelasforaneas')->
		where(array('idusuario'=> $idusuario))->
		order_by('nombre', 'asc')->get();
		return $resultado;

	}

	function escuela($idusuario,$id){

		$resultado = $this->db->select('*')->from('escuelasforaneas')->where(array('idescuelaforanea'=> $id,'idusuario'=> $idusuario))->get();
		return $resultado->row_array();

	}


	function guardar($idusuario,$id)
	{
		if($id==0){
			$data = array(
				'nombre' => $this->input->post('nombre'),
				'entidad' => $this->input->post('entidad'),
				'localidad' => $this->input->post('localidad'),
				'idusuario' => $idusuario
			);
			$this->db->trans_start();
			$this->db->insert('escuelasforaneas', $data);
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
			{
				$error=$this->db->error();
			}
		}else{

			$data = array(
				'nombre' => $this->input->post('nombre'),
				'entidad' => $this->input->post('entidad'),
				'localidad' => $this->input->post('localidad'),
				'idusuario' => $idusuario
			);
			$this->db->trans_start();
			$this->db->update('escuelasforaneas', $data, array('idescuelaforanea'=> $id,'idusuario'=> $idusuario));
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
			{
				$error=$this->db->error();
			}

		}
	}

	function eliminar($idusuario,$id)
	{
		$this->db->where(array('idescuelaforanea'=> $id,'idusuario'=> $idusuario));
		$this->db->delete('escuelasforaneas');
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			$error=$this->db->error();
		}
	}

}
?>
