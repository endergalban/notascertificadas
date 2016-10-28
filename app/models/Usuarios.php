<?php
class Usuarios extends CI_Model {
	function __construct(){
		parent::__construct();
	}

	function registrar(){
		$data = array(
				'nombre' => $this->input->post('nombre'),
				'email' => $this->input->post('email'),
				'idtipousuario' => 2,
				'activo' => 1,
				'password' => sha1($this->input->post('password')),
				'verificar' => sha1(rand())
		);
		$this->db->trans_start();
		$this->db->insert('usuarios', $data);
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE){
			$error=$this->db->error();
			return false;
		}else{
			return true;
		}
	}

	function verificar($verificar){
		$array = array( 'verificar =' => $verificar);
		$resultado = $this->db->select('usuarios.idusuario')->
		from('usuarios')->
		where($array)->get();
		if ($resultado->num_rows()==0){
			return false;
		}else{
			$resultado=$resultado->row_array();
			$idusuario=$resultado['idusuario'];
			$data = array(
				'verificar' => '',
			);
			$this->db->trans_start();
			$this->db->update('usuarios', $data, array('idusuario' =>$idusuario));
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
			{
				$error=$this->db->error();
				return false;
			}else{
				return true;
			}
		}

	}

	function verificar_email_restablecer($email){

		$array = array('email =' => $email);
		$resultado = $this->db->
		from('usuarios')->
		join('tipousuario', 'usuarios.idtipousuario = tipousuario.idtipousuario', 'inner')->
		where($array)->get();
		if ($resultado->num_rows()==0){
			return false;
		}else{
			$result=$resultado->row_array();
			$data = array('reset' => sha1(rand()));
			$this->db->trans_start();
			$this->db->update('usuarios', $data, array('idusuario' =>$result['idusuario']));
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
			{
				return false;
			}else{
				return $result;
			}
		}
	}

	function verificar_reset($reset,$tipo){

		$resultado = $this->db->
		from('usuarios')->
		join('tipousuario', 'usuarios.idtipousuario = tipousuario.idtipousuario', 'inner')->
		where(array('reset =' => $reset))->get();
		if ($resultado->num_rows()==0){
			return false;
		}else{
			$result=$resultado->row_array();
			if($tipo==0)
			{
				return $result;
			}else{
				$data = array('reset' => '','password' => sha1($this->input->post('password')));
				$this->db->trans_start();
				$this->db->update('usuarios', $data, array('idusuario' =>$result['idusuario']));
				$this->db->trans_complete();
				if ($this->db->trans_status() === FALSE)
				{
					return false;
				}else{
					return $result;
				}
			}
		}
	}

	function login($data){

		$array = array('password =' => sha1($data['password']), 'email =' => $data['email']);
		$resultado = $this->db->
		from('usuarios')->
		join('tipousuario', 'usuarios.idtipousuario = tipousuario.idtipousuario', 'inner')->
		where($array)->
		get();
		if ($resultado->num_rows()==0){
			return false;
		}else{

			return $resultado->row_array();
		}
	}



	function autorizacion($modulo){

		if($this->session->has_userdata('logueado')){
			$idusuario=$this->session->userdata('idusuario');
			$array = array('usuarios.idusuario =' => $idusuario,'usuarios.activo =' => 1,'modulos.archivo =' => $modulo);
			$resultado = $this->db->select('usuarios.idusuario')->
			from('usuarios')->
			join('tipousuario', 'usuarios.idtipousuario = tipousuario.idtipousuario', 'inner')->
			join('tipousuariomodulos', 'tipousuario.idtipousuario = tipousuariomodulos.idtipousuario', 'inner')->
			join('modulos', 'tipousuariomodulos.idmodulo = modulos.idmodulo', 'inner')->
			where($array)->get();
			if ($resultado->num_rows()==0){
				return false;
			}else{
				return true;
			}
		}else{
			redirect(index_page());
		}
	}

	public function logout() {
		// Removing session data
		$data = array('idusuario','email','nombre','miniatura','tipousuario','imagen' ,'logueado');
		$this->session->unset_userdata($data);

	}

	function usuario($id){

		$array = array('idusuario =' => $id);
		$resultado = $this->db->
		from('usuarios')->
		join('tipousuario', 'usuarios.idtipousuario = tipousuario.idtipousuario', 'inner')->
		where($array)->get();
		if ($resultado->num_rows()==0){
			return false;
		}else{
			return $resultado->row_array();
		}
	}

	function usuario_email($email){

		$array = array('email =' => $email);
		$resultado = $this->db->
		from('usuarios')->
		join('tipousuario', 'usuarios.idtipousuario = tipousuario.idtipousuario', 'inner')->
		where($array)->get();
		if ($resultado->num_rows()==0){
			return false;
		}else{
			return $resultado->row_array();
		}
	}

	function menu_usuario(){

		$idusuario=$this->session->userdata('idusuario');
		$array = array('usuarios.idusuario =' => $idusuario,'usuarios.activo =' => 1);
		$resultado = $this->db->select('*')->
		from('usuarios')->
		join('tipousuario', 'usuarios.idtipousuario = tipousuario.idtipousuario', 'inner')->
		join('tipousuariomodulos', 'tipousuario.idtipousuario = tipousuariomodulos.idtipousuario', 'inner')->
		join('modulos', 'tipousuariomodulos.idmodulo = modulos.idmodulo', 'inner')->
		where($array)->
		group_by('modulos.idmodulo')->
		order_by('modulos.orden', 'asc')->get();
		return $resultado;

	}

	function lista_usuarios(){
		$resultado = $this->db->select('fechaHora,idusuario,email,nombre,activo,imagen,miniatura,descripcion,usuarios.idtipousuario as idtipousuario, (select count(*) from escuelas WHERE escuelas.idusuario=usuarios.idusuario) as bloqueado,(select count(*) from estudiantes WHERE estudiantes.idusuario=usuarios.idusuario) as bloqueado2')->
		from('usuarios')->
		join('tipousuario', 'usuarios.idtipousuario = tipousuario.idtipousuario', 'inner')->
		order_by('nombre', 'desc')->get();
		return $resultado;

	}


	function guardar($id=null)
	{
		if(is_null($id)){
			$data = array(
				'nombre' => $this->input->post('nombre'),
				'email' => $this->input->post('email'),
				'idtipousuario' => $this->input->post('idtipousuario'),
				'activo' => $this->input->post('activo'),
				'password' => sha1('123456')
			);
			$this->db->trans_start();
			$this->db->insert('usuarios', $data);
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
			{
				$error=$this->db->error();
			}
		}else{

			$data = array(
				'nombre' => $this->input->post('nombre'),
				'email' => $this->input->post('email'),
				'idtipousuario' => $this->input->post('idtipousuario'),
				'activo' => $this->input->post('activo')
			);
			$this->db->trans_start();
			$this->db->update('usuarios', $data, array('idusuario' =>$id));
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
			$this->db->where('idusuario', $id);
			$this->db->delete('usuarios');
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
			{
				$error=$this->db->error();
			}

		}
	}

	function guardar_imagen($id,$data)
	{
		$data = array(
			'imagen' => $data['imagen'],
			'miniatura' => $data['miniatura'],
		);
		$this->db->trans_start();
		$this->db->update('usuarios', $data, array('idusuario' =>$id));
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			$error=$this->db->error();
		}
	}

	function bloquear($id)
	{
		if(!is_null($id)){
			$data = array('activo' => 0);
			$this->db->trans_start();
			$this->db->update('usuarios', $data, array('idusuario' =>$id));
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
			{
				$error=$this->db->error();
			}
		}
	}

	function desbloquear($id)
	{
		if(!is_null($id)){
			$data = array('activo' => 1);
			$this->db->trans_start();
			$this->db->update('usuarios', $data, array('idusuario' =>$id));
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
			{
				$error=$this->db->error();
			}
		}
	}



	function restablecer($id=null)
	{
		if(!is_null($id)){
			$data = array('password' => sha1('123456'));
			$this->db->trans_start();
			$this->db->update('usuarios', $data, array('idusuario' =>$id));
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
			{
				$error=$this->db->error();
			}
		}
	}

	function actualizar_perfil($id=null)
	{
		if($this->input->post('password')==''){
			$data = array('nombre' => $this->input->post('nombre'));
		}else{
			$data = array(
			'nombre' => $this->input->post('nombre'),
			'password' => sha1($this->input->post('password'))
			);
		}
		$this->db->trans_start();
		$this->db->update('usuarios', $data, array('idusuario' =>$id));
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE)
		{
			$error=$this->db->error();
		}
	}

	function lista_tipos_usuarios(){
		$resultado = $this->db->select('descripcion,idtipousuario, (select count(*) from tipousuariomodulos WHERE tipousuariomodulos.idtipousuario=tipousuario.idtipousuario) as bloqueado,(select count(*) from usuarios WHERE usuarios.idtipousuario=tipousuario.idtipousuario) as bloqueado2')->
		from('tipousuario')->
		order_by('descripcion', 'desc')->get();
		return $resultado;

	}

	function tipousuario($id){

		$array = array('idtipousuario =' => $id);
		$resultado = $this->db->
		from('tipousuario')->
		where($array)->get();
		return $resultado->row_array();

	}

	function guardartipousuario($id=null)
	{
		if(is_null($id)){
			$data = array(
				'descripcion' => $this->input->post('descripcion')
			);
			$this->db->trans_start();
			$this->db->insert('tipousuario', $data);
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
			{
				$error=$this->db->error();
			}
		}else{

			$data = array(
				'descripcion' => $this->input->post('descripcion'),
			);
			$this->db->trans_start();
			$this->db->update('tipousuario', $data, array('idtipousuario' =>$id));
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
			{
				$error=$this->db->error();
			}

		}
	}

	function lista_funciones_tipos_usuarios($id = null){
		$resultado = $this->db->select('descripcion,idmodulo,(SELECT COUNT(*)  FROM tipousuariomodulos WHERE tipousuariomodulos.idtipousuario='.$id.' AND
		tipousuariomodulos.idmodulo =modulos.idmodulo) as activo')->
		from('modulos')->
		order_by('orden', 'asc')->get();
		return $resultado;



	}

	function guardar_funciones($id)
	{
		if(!is_null($id)){
			$ListFunciones=$this->input->post('funciones');
			$data=array();
			for($i=0;$i<count($ListFunciones);$i++)
			{
				$data[] = array('idmodulo' => $ListFunciones[$i],'idtipousuario' => $id);
			}
			$this->db->trans_start();
			$this->db->where('idtipousuario', $id);
			$this->db->delete('tipousuariomodulos');
			if(count($data)>0)
			{
				$this->db->insert_batch('tipousuariomodulos', $data);
			}
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
			{
				$error=$this->db->error();
			}

		}

	}

	function eliminartipousuario($id=null)
	{
		if(!is_null($id)){
			$this->db->where('idtipousuario', $id);
			$this->db->delete('tipousuario');
			$this->db->trans_complete();
			if ($this->db->trans_status() === FALSE)
			{
				$error=$this->db->error();
			}

		}
	}


    var $column_order = array(null, 'nombre','email','descripcion'); //set column field database for datatable orderable
    var $column_search = array('nombre','email','descripcion'); //set column field database for datatable searchable
    var $order = array('idusuario' => 'asc'); // default order

    private function _get_datatables_query()
    {
       $resultado = $this->db->select('fechaHora,idusuario,email,nombre,activo,imagen,miniatura,descripcion,usuarios.idtipousuario as idtipousuario,
        (select count(*) from escuelas WHERE escuelas.idusuario=usuarios.idusuario) as bloqueado,
       (select count(*) from estudiantes WHERE estudiantes.idusuario=usuarios.idusuario) as bloqueado2')->
		from('usuarios')->
		join('tipousuario', 'usuarios.idtipousuario = tipousuario.idtipousuario', 'inner');

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

    function get_datatables()
    {
        $this->_get_datatables_query();
        if(isset($_POST['length'])){
		    if($_POST['length'] != -1)
		    {
				$this->db->limit($_POST['length'], $_POST['start']);
			}
		}
        $query = $this->db->get();
        return $query;
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        return $this->lista_usuarios()->num_rows();
    }



}
?>
