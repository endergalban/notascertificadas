<?php
class Estudiantes extends CI_Model {
	function __construct(){
		parent::__construct();
	}



	function registros($idusuario){

		$resultado = $this->db->select('idestudiante,nombre,apellido,cedula,lugarnacimiento,entidad,fechanac,
		(select count(*) from materias WHERE materias.idestudiante=estudiantes.idestudiante) as bloqueado,
		(select count(*) from materiaset WHERE materiaset.idestudiante=estudiantes.idestudiante) as bloqueado2')->
		from('estudiantes')->
		where(array('idusuario'=> $idusuario))->
		order_by('apellido,nombre', 'asc')->get();
		return $resultado;

	}

	function estudiante($idusuario,$id){

		$resultado = $this->db->from('estudiantes')->where(array('idestudiante'=> $id,'idusuario'=> $idusuario))->get();
		return $resultado->row_array();

	}

	function estudiante_cedula($idusuario,$cedula){

		$resultado = $this->db->from('estudiantes')->where(array('cedula'=> $cedula,'idusuario'=> $idusuario))->get();
		return $resultado->row_array();

	}

	function guardar($idusuario,$id)
	{

		if($id==0){
			$data = array(
				'nombre' => $this->input->post('nombre'),
				'apellido' => $this->input->post('apellido'),
				'cedula' => $this->input->post('cedula'),
				'fechanac' => date("Y-m-d", strtotime($this->input->post('fechanac'))),
				'entidad' => $this->input->post('entidad'),
				'lugarnacimiento' => $this->input->post('lugarnacimiento'),
				'idusuario' => $idusuario
			);
			$this->db->trans_start();
			$this->db->insert('estudiantes', $data);
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
			{
				$error=$this->db->error();
			}
		}else{

			$data = array(
				'nombre' => $this->input->post('nombre'),
				'apellido' => $this->input->post('apellido'),
				'cedula' => $this->input->post('cedula'),
				'fechanac' => date("Y-m-d", strtotime($this->input->post('fechanac'))),
				'entidad' => $this->input->post('entidad'),
				'lugarnacimiento' => $this->input->post('lugarnacimiento'),
				'idusuario' => $idusuario
			);
			$this->db->trans_start();
			$this->db->update('estudiantes', $data,array('idestudiante'=> $id,'idusuario'=> $idusuario));
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
			{
				$error=$this->db->error();
			}

		}
	}

	function eliminar($idusuario,$id)
	{

		$this->db->where(array('idestudiante'=> $id,'idusuario'=> $idusuario));
		$this->db->delete('estudiantes');
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			$error=$this->db->error();
		}
	}

	var $column_order = array(null, 'apellido','nombre','cedula','fechanac','lugarnacimiento','entidad'); //set column field database for datatable orderable
    var $column_search = array('apellido','nombre','cedula','fechanac','lugarnacimiento','entidad'); //set column field database for datatable searchable
    var $order = array('idestudiante' => 'asc'); // default order

    private function _get_datatables_query($idusuario)
    {
      $resultado = $this->db->select('idestudiante,nombre,apellido,cedula,lugarnacimiento,entidad,fechanac,
		(select count(*) from materias WHERE materias.idestudiante=estudiantes.idestudiante) as bloqueado,
		(select count(*) from materiaset WHERE materiaset.idestudiante=estudiantes.idestudiante) as bloqueado2')->
		from('estudiantes')->where(array('idusuario'=> $idusuario));

        $i = 0;

         foreach ($this->column_search as $item) // loop column
        {
            if(isset($_POST['search']['value'])) // if datatable send POST for search
            {

                if($i===0) // first loop
                {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

       if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables($idusuario)
    {
        $this->_get_datatables_query($idusuario);
        if(isset($_POST['length'])){
		    if($_POST['length'] != -1)
		    {
				$this->db->limit($_POST['length'], $_POST['start']);
			}
		}
        $query = $this->db->get();
        return $query;
    }

    function count_filtered($idusuario)
    {
        $this->_get_datatables_query($idusuario);
        $query = $this->db->get();
        return $query->num_rows();
    }



	function cantidadestudiantes(){

		$resultado = $this->db->from('estudiantes')->get();
		return $resultado;
	}

}
?>
