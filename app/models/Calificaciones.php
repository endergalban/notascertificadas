<?php
class Calificaciones extends CI_Model {
	function __construct(){
		parent::__construct();
	}



	function listaet( $idestudiante,$grado){

		$resultado = $this->db->from('materiaset')->where(array('idestudiante'=> $idestudiante,'grado'=> $grado))->get();
		return $resultado;

	}

	function eliminaret($idmateriaet)
	{
		$this->db->where(array('idmateriaet'=> $idmateriaet));
		$this->db->delete('materiaset');
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			$error=$this->db->error();
		}
	}

	function materiaet($id){

		$resultado = $this->db->from('materiaset')->where(array('idmateriaet'=> $id))->get();
		return $resultado->row_array();

	}


	function guardaret($idestudiante,$grado, $idmateriaet)
	{

		if($idmateriaet==0){
			$data = array(
				'nombre' => $this->input->post('nombre'),
				'horas' => $this->input->post('horas'),
				'idestudiante' => $idestudiante,
				'grado' => $grado

			);
			$this->db->trans_start();
			$this->db->insert('materiaset', $data);
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
			{
				$error=$this->db->error();
			}
		}else{

			$data = array(
				'nombre' => $this->input->post('nombre'),
				'horas' => $this->input->post('horas')
			);
			$this->db->trans_start();
			$this->db->update('materiaset', $data,array('idmateriaet'=> $idmateriaet));
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
			{
				$error=$this->db->error();
			}

		}
	}

	function guardarplan($idestudiante,$grado)
	{
		$resultado = $this->db->select('idgrado')->from('grados')->where(array('idestudiante'=>$idestudiante,'grado'=>$grado))->get();
		if ($resultado->num_rows() == 0) {
			$data = array(
				'plan' 			=> $this->input->post('plan'),
				'codigo' 		=> $this->input->post('codigo'),
				'mencion' 		=>  $this->input->post('mencion'),
				'observacion' 	=>  $this->input->post('observacion'),
				'idescuela' 	=>  $this->input->post('idescuela'),
				'idestudiante' 	=>  $idestudiante,
				'grado' 		=>  $grado
			);
			$this->db->trans_start();
			$this->db->insert('grados', $data);
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
			{
				$error=$this->db->error();
			}
		}else{
			$data = array(
				'plan' 			=> $this->input->post('plan'),
				'codigo' 		=> $this->input->post('codigo'),
				'mencion' 		=>  $this->input->post('mencion'),
				'observacion' 	=>  $this->input->post('observacion'),
				'idescuela' 	=>  $this->input->post('idescuela')
			);
			$this->db->trans_start();
			$this->db->update('grados', $data,array('grado'=> $grado,'idestudiante'=> $idestudiante));
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
			{
				$error=$this->db->error();
			}
		}
	}

	function plan($id,$grado){
		$resultado = $this->db->from('grados')->where(array('idestudiante'=> $id,'grado'=> $grado))->get();
		return $resultado->row_array();

	}

	function plan_precargado($grado){

		$query=$this->db->select('MAX(estudiantes.idestudiante) as idestudiante')->from('grados')->join('estudiantes','grados.idestudiante = estudiantes.idestudiante','inner')->where(array('idusuario'=>$this->session->userdata('idusuario'),'grado'=>$grado))->get();
		if ($query->num_rows() > 0) {
			$resultado=$query->row_array();
			$result = $this->db->from('grados')->where(array('idestudiante'=> $resultado['idestudiante'],'grado'=> $grado))->get();
			return $result->row_array();
		}else{
			return false;
		}



	}

	function comboescuelas($idusuario){

		$resultado = $this->db->select('idescuela,nombre')->from('escuelas')->where(array('idusuario'=>$idusuario))->get();
		if ($resultado->num_rows() > 0) {
			$Datos[''] = '';
			foreach($resultado->result_array() as $fila){
			   $Datos[$fila['idescuela']] = $fila['nombre'];
			}
			$resultado->free_result();
			return $Datos;
		 }
	}

	function comboescuelasforaneas($idusuario){

		$resultado = $this->db->select('idescuelaforanea,nombre')->from('escuelasforaneas')->where(array('idusuario'=>$idusuario))->get();
		if ($resultado->num_rows() > 0) {
			$Datos[''] = '';
			foreach($resultado->result_array() as $fila){
			   $Datos[$fila['idescuelaforanea']] = $fila['nombre'];
			}
			$resultado->free_result();
			return $Datos;
		 }
	}

	function listamaterias( $idestudiante,$grado){

		$resultado = $this->db->from('materias')->where(array('idestudiante'=> $idestudiante,'grado'=> $grado))->get();
		return $resultado;

	}

	function listamaterias_precargadas($grado){

		$query=$this->db->select('MAX(estudiantes.idestudiante) as idestudiante')->from('grados')->join('estudiantes','grados.idestudiante = estudiantes.idestudiante','inner')->where(array('idusuario'=>$this->session->userdata('idusuario'),'grado'=>$grado))->get();
		if ($query->num_rows() > 0) {
			$resultado=$query->row_array();
			$result = $this->db->from('materias')->where(array('idestudiante'=> $resultado['idestudiante'],'grado'=> $grado))->get();
			return $result;
		}else{
			return false;
		}

	}

	function guardarmaterias( $idestudiante,$grado,$datamateria){

		$this->db->trans_start();
		$resultado = $this->db->from('materias')->where(array('idestudiante'=> $idestudiante,'grado'=> $grado))->get();
		if ($resultado->num_rows()!=0){
			$this->db->where(array('idestudiante'=> $idestudiante,'grado'=> $grado));
			$this->db->delete('materias');
		}
		if(count($datamateria)>0){
			$this->db->insert_batch('materias', $datamateria);
		}
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			$error=$this->db->error();
		}
	}

	function cantidadmaterias($idusuario = null){


		$this->db->from('materias');
		if(!is_null($idusuario))
		{
			$this->db->join('estudiantes', 'materias.idestudiante = estudiantes.idestudiante', 'inner');
			$this->db->where(array('idusuario'=> $idusuario));
		}
		$resultado = $this->db->get();
		return $resultado;
	}





}
?>
