<?php
class Escuelas extends CI_Model {
	function __construct(){
		parent::__construct();
	}



	function registros($idusuario){

		if(is_null($idusuario)){
			$idusuario=$this->session->userdata('idusuario');
		}

		$resultado = $this->db->select('idescuela,codigo,nombre,distrito,direccion,telefono,municipio,entidad,zona,director,ceduladirector,idusuario,(select count(*) from grados WHERE grados.idescuela=escuelas.idescuela) as bloqueado')->
		from('escuelas')->
		where(array('idusuario'=> $idusuario))->
		order_by('codigo', 'asc')->get();
		return $resultado;

	}

	function escuela($idusuario,$id){


		$resultado = $this->db->select('*')->from('escuelas')->where(array('idescuela'=> $id,'idusuario'=> $idusuario))->get();
		return $resultado->row_array();

	}


	function guardar($idusuario,$id)
	{

		if($id==0){
			$data = array(
				'codigo' => $this->input->post('codigo'),
				'nombre' => $this->input->post('nombre'),
				'distrito' => $this->input->post('distrito'),
				'direccion' => $this->input->post('direccion'),
				'telefono' => $this->input->post('telefono'),
				'municipio' => $this->input->post('municipio'),
				'entidad' => $this->input->post('entidad'),
				'entidadabreviado' => $this->input->post('entidadabreviado'),
				'director' => $this->input->post('director'),
				'zona' => $this->input->post('zona'),
				'ceduladirector' => $this->input->post('ceduladirector'),
				'idusuario' => $idusuario
			);

			$data2 = array(
				'nombre' => $this->input->post('nombre'),
				'entidad' => $this->input->post('entidadabreviado'),
				'localidad' => $this->input->post('municipio'),
				'idusuario' => $idusuario
			);
			$this->db->trans_start();
			$this->db->insert('escuelas', $data);
			$this->db->insert('escuelasforaneas', $data2);
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
			{
				$error=$this->db->error();
			}
		}else{

			$data = array(
				'codigo' => $this->input->post('codigo'),
				'nombre' => $this->input->post('nombre'),
				'distrito' => $this->input->post('distrito'),
				'direccion' => $this->input->post('direccion'),
				'telefono' => $this->input->post('telefono'),
				'municipio' => $this->input->post('municipio'),
				'entidad' => $this->input->post('entidad'),
				'entidadabreviado' => $this->input->post('entidadabreviado'),
				'director' => $this->input->post('director'),
				'zona' => $this->input->post('zona'),
				'ceduladirector' => $this->input->post('ceduladirector'),
				'idusuario' => $idusuario
			);
			$this->db->trans_start();
			$this->db->update('escuelas', $data,array('idescuela'=> $id,'idusuario'=> $idusuario));
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
			{
				$error=$this->db->error();
			}

		}
	}

	function eliminar($idusuario,$id)
	{

		if(!is_null($id)){
			$this->db->where(array('idescuela'=> $id,'idusuario'=> $idusuario));
			$this->db->delete('escuelas');
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
			{
				$error=$this->db->error();
			}

		}
	}



}
?>
