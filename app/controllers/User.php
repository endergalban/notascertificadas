<?php defined('BASEPATH') OR exit('No direct script access allowed');

	Class User extends CI_Controller{

		public function __construct() {
			parent::__construct();
				$this->load->model('usuarios');
				$this->load->model('modulos');
				$this->load->model('mensajes');
		}

		function nrogrado($nro){

			if($nro==1){
				return '1er';
			}elseif($nro==2){
				return '2do';
			}elseif($nro==3){
				return '3er';
			}elseif($nro==4){
				return '4to';
			}elseif($nro==5){
				return '5to';
			}elseif($nro==6){
				return '6to';
			}else{
				return 'N/A';
			}
		}

		function pagina($modulo) {

			//MENU DEL USUARIO LOGUEADO
			$rs_menu =$this->usuarios->menu_usuario();
			$data_menu="";

			$nombrefuncion="";
			foreach ($rs_menu->result_array() as $fila)
			{
				$activo='';
				if($fila['archivo']==$modulo)
				{
					$activo='class="current-page"';
					$nombrefuncion=$fila['descripcion'];
				}
				if($fila['visible']==1)
				{
					$data_menu=$data_menu.
					'<li '.$activo.'>
						<a href="'. site_url(array('user',$fila['archivo'])).'"> <i class="'.$fila['icono'].'"></i> '.$fila['descripcion'].' </a>
					</li>';
				}
			}


			$nombre=$this->session->userdata['nombre'];
			$miniatura=$this->session->userdata['miniatura'];

			$rs_mensajes = $this->mensajes->registros(5);
			$datamensaje = array();
			foreach ($rs_mensajes->result_array() as $mensaje) {
				$datamensaje[] = array(
							'miniatura'	=> $mensaje['miniatura'],
							'mensaje'	=> $mensaje['mensaje'],
							'asunto'	=> $mensaje['asunto'],
							'usuario'	=> $mensaje['usuario'],
							'fechahora'	=> nice_date($mensaje['fechahora'],'d-m-Y h:m:i: a')
							);
			}


			return array('menu'=>$data_menu,'titulo'=>'Módulos','nombre'=>$nombre,'miniatura'=>$miniatura,'nombrefuncion'=>$nombrefuncion,'datamensaje'=>$datamensaje);
		}


	//-------------------DASHBOARD------------------------//
		public function index()
		{
			if($this->usuarios->autorizacion('index'))
			{
				$this->load->model('calificaciones');
				$this->load->model('estudiantes');

				$this->load->view('cabecera',$this->pagina('index'));
				if($this->session->userdata('idtipousuario')==1)
				{
					$data=array(
							'cantidadusuarios'=>$this->usuarios->lista_usuarios()->num_rows(),
							'cantidadnotas'=>$this->calificaciones->cantidadmaterias()->num_rows(),
							'cantidadestudiantes'=>$this->estudiantes->cantidadestudiantes()->num_rows(),
							'cantidadmensajes'=>$this->mensajes->registros()->num_rows()
					);
					$this->load->view('dashboard',$data);
				}elseif($this->session->userdata('idtipousuario')==2){
					$this->load->model('escuelasforaneas');
					$data=array(
							'cantidadescuelasforaneas'=>$this->escuelasforaneas->registros($this->session->userdata('idusuario'))->num_rows(),
							'cantidadnotas'=>$this->calificaciones->cantidadmaterias($this->session->userdata('idusuario'))->num_rows(),
							'cantidadestudiantes'=>$this->estudiantes->registros($this->session->userdata('idusuario'))->num_rows(),
							'cantidadmensajes'=>$this->mensajes->registros()->num_rows()
					);
					$this->load->view('dashboard2',$data);

				}
				$this->load->view('pie');
			}else{
				show_error('No tienes permiso para realizar está función. Por Favor contacte con el administrador', 403, $heading = 'Acceso Denegado');
			}
		}
	//-------------------FIN DASHBOARD------------------------//

	//-------------------PERFIL------------------------//
		public function perfil()
		{
			if($this->usuarios->autorizacion('index'))
			{
				$id=$this->session->userdata('idusuario');
				$this->load->view('cabecera',$this->pagina('usuarios'));
				$this->load->library('form_validation');
				$this->form_validation->set_rules('nombre', 'Nombre', 'trim|required|min_length[1]|max_length[100]');
				$this->form_validation->set_rules('password', 'Password', 'trim|min_length[6]|max_length[20]');
				$this->form_validation->set_rules('passconf', 'Confirmación', 'trim|min_length[6]|max_length[20]|matches[password]');

				if ($this->form_validation->run() == FALSE){
					$arrayArticulo = $this->usuarios->usuario($id);
					$this->load->view('alertas',array('tipo'=>'0'));
					$this->load->view('perfil',$arrayArticulo);
				}else{
					$this->usuarios->actualizar_perfil($id);

					if(!empty($_FILES['userfile']['tmp_name'])) {
						$config['file_name']     = sha1($id);
						$config['upload_path'] = 'images/users/';
						$config['allowed_types'] = 'gif|jpg|png';
						$config['max_size']     = '100';
						$config['max_width'] = '800';
						$config['max_height'] = '600';
						$config['overwrite']=TRUE;
						$this->load->library('upload', $config);
						if ( ! $this->upload->do_upload('userfile')){
							$this->load->view('alertas',array('tipo'=>'10'));
						}else{
							$config['image_library'] = 'gd2';
							$config['source_image'] = 'images/users/'.$this->upload->data('file_name').'';
							$config['create_thumb'] = TRUE;
							$config['maintain_ratio'] = TRUE;
							$config['width']         = 75;
							$config['height']       = 50;
							$this->load->library('image_lib', $config);
							$this->image_lib->resize();
							$this->usuarios->guardar_imagen($id,array(
							'imagen'=>$this->upload->data('file_name'),
							'miniatura'=>$this->upload->data('raw_name').'_thumb'.$this->upload->data('file_ext')
							));
						}
					}

					$arrayArticulo = $this->usuarios->usuario($id);
					$config = Array(
						'protocol' => 'smtp',
						'smtp_host' => 'ssl://smtp.googlemail.com',
						'smtp_port' => 465,
						'smtp_user' => 'endergalban@gmail.com',
						'smtp_pass' => 'Alejan30',
						'mailtype'  => 'html',
						'charset'   => 'UTF-8'
					);
					$this->load->library('email', $config);
					$this->email->set_newline("\r\n");
					$this->email->from('endergalban@gmail.com');
					$this->email->to($arrayArticulo['email']);

					$this->email->subject('Actualización de datos');
					$this->email->message('
					<div >Hola '.$arrayArticulo['nombre'].',<br>
					<br>
					Tus datos han sido actualizado con éxito.<br>
					<br>
					Esta una cuenta no monitorizada por favor no responda este correo!<br>
					<br>
					<br>
					Gracias,<br>
					</div>');
					if(!$this->email->send()){
						show_error($this->email->print_debugger());
					}
					$this->load->view('alertas',array('tipo'=>'1'));
					$this->load->view('perfil',$arrayArticulo);
				}

				$this->load->view('pie');

			}else{
				show_error('No tienes permiso para realizar está función. Por Favor contacte con el administrador', 403, $heading = 'Acceso Denegado');
			}

		}
	//-------------------FIN PERFIL------------------------//




	//-------------------ESCUELAS------------------------//
		public function escuelas($accion = 'index',$id = null)
		{
			if($this->usuarios->autorizacion('escuelas'))
			{
				$this->load->model('escuelas');
				$this->load->view('cabecera',$this->pagina('escuelas'));
				if($accion=='index')
				{
					$data=array('rs_escuelas' => $this->escuelas->registros($this->session->userdata('idusuario')));
					$this->load->view('escuelas/index',$data);

				}elseif($accion=='nuevaescuela'){

					$this->load->library('form_validation');
					$this->form_validation->set_rules('director', 'Director', 'trim|required|min_length[5]|max_length[50]');
					$this->form_validation->set_rules('ceduladirector', 'Cédula de Director', 'trim|required|min_length[6]|max_length[20]');
					$this->form_validation->set_rules('codigo', 'Código DEA', 'trim|required|min_length[6]|max_length[20]');
					$this->form_validation->set_rules('nombre', 'Nombre de Escuela', 'trim|required|min_length[5]|max_length[80]');
					$this->form_validation->set_rules('telefono', 'Teléfono', 'trim|min_length[12]|max_length[12]');
					$this->form_validation->set_rules('distrito', 'Distrito', 'trim|required|min_length[1]|max_length[3]');
					$this->form_validation->set_rules('entidad', 'Entidad', 'trim|required|min_length[1]|max_length[50]');
					$this->form_validation->set_rules('municipio', 'Municipio', 'trim|required|min_length[1]|max_length[50]');
					$this->form_validation->set_rules('zona', 'Zona Educativa', 'trim|required|min_length[1]|max_length[50]');
					$this->form_validation->set_rules('direccion', 'Dirección', 'trim|required|min_length[5]|max_length[300]');


					if ($this->form_validation->run() == FALSE){
						$this->load->view('alertas',array('tipo'=>'0'));
						$this->load->view('escuelas/gestionar');
					}else{
						$this->escuelas->guardar($this->session->userdata('idusuario'),0);
						$this->load->view('alertas',array('tipo'=>'1'));
						$data=array('rs_escuelas' => $this->escuelas->registros($this->session->userdata('idusuario')));
						$this->load->view('escuelas/index',$data);
					}

				}elseif($accion=='editarescuela'){
					$this->load->library('form_validation');
					$arrayArticulo = $this->escuelas->escuela($this->session->userdata('idusuario'),$id);
					if($arrayArticulo['idusuario']==$this->session->userdata('idusuario')){
						$this->form_validation->set_rules('director', 'Director', 'trim|required|min_length[5]|max_length[50]');
						$this->form_validation->set_rules('ceduladirector', 'Cédula de Director', 'trim|required|min_length[6]|max_length[20]');
						$this->form_validation->set_rules('codigo', 'Código DEA', 'trim|required|min_length[6]|max_length[20]');
						$this->form_validation->set_rules('nombre', 'Nombre de Escuela', 'trim|required|min_length[5]|max_length[80]');
						$this->form_validation->set_rules('telefono', 'Teléfono', 'trim|min_length[12]|max_length[12]');
						$this->form_validation->set_rules('distrito', 'Distrito', 'trim|required|min_length[1]|max_length[3]');
						$this->form_validation->set_rules('entidad', 'Entidad', 'trim|required|min_length[1]|max_length[50]');
						$this->form_validation->set_rules('entidadabreviado', 'Entidad Abreviado', 'trim|required|min_length[1]|max_length[4]');
						$this->form_validation->set_rules('municipio', 'Municipio', 'trim|required|min_length[1]|max_length[50]');
						$this->form_validation->set_rules('zona', 'Zona Educativa', 'trim|required|min_length[1]|max_length[50]');
						$this->form_validation->set_rules('direccion', 'Dirección', 'trim|required|min_length[5]|max_length[300]');
						if ($this->form_validation->run() == FALSE){

							$this->load->view('alertas',array('tipo'=>'0'));
							$this->load->view('escuelas/gestionar',$arrayArticulo);
						}else{
							$this->escuelas->guardar($this->session->userdata('idusuario'),$id);
							$arrayArticulo = $this->escuelas->escuela($this->session->userdata('idusuario'),$id);
							$this->load->view('alertas',array('tipo'=>'1'));
							$this->load->view('escuelas/gestionar',$arrayArticulo);
						}
					}else{

						 show_error('No tienes permiso para realizar está función. Por Favor contacte con el administrador', 403, $heading = 'Acceso Denegado');
					}
				}elseif($accion=='eliminarescuela'){
					$arrayArticulo = $this->escuelas->escuela($this->session->userdata('idusuario'),$id);
					if($arrayArticulo['idusuario']==$this->session->userdata('idusuario')){
						$this->escuelas->eliminar($this->session->userdata('idusuario'),$id);
						$this->load->view('alertas',array('tipo'=>'2'));
						$data=array('rs_escuelas' => $this->escuelas->registros($this->session->userdata('idusuario')));
						$this->load->view('escuelas/index',$data);
					}else{
						show_error('No tienes permiso para realizar está función. Por Favor contacte con el administrador', 403, $heading = 'Acceso Denegado');
					}
				}else{
					show_404();
				}

				$this->load->view('pie');
			}else{

				 show_error('No tienes permiso para realizar está función. Por Favor contacte con el administrador', 403, $heading = 'Acceso Denegado');
			}
		}
	//-------------------FIN ESCUELAS------------------------//


	//-------------------ESCUELAS FORANEAS------------------------//

		public function escuelasforaneas($accion = 'index',$id = null)
		{
			if($this->usuarios->autorizacion('escuelasforaneas'))
			{
				$this->load->model('escuelasforaneas');
				$this->load->view('cabecera',$this->pagina('escuelasforaneas'));
				if($accion=='index')
				{
					$data=array('rs_escuelas' => $this->escuelasforaneas->registros($this->session->userdata('idusuario')));
					$this->load->view('escuelasforaneas/index',$data);

				}elseif($accion=='nuevaescuela'){

					$this->load->library('form_validation');
					$this->form_validation->set_rules('nombre', 'Nombre de Escuela', 'trim|required|min_length[5]|max_length[80]');
					$this->form_validation->set_rules('entidad', 'Entidad Federal', 'trim|required|min_length[1]|max_length[4]');
					$this->form_validation->set_rules('localidad', 'Localidad', 'trim|required|min_length[1]|max_length[50]');
					if ($this->form_validation->run() == FALSE){
						$this->load->view('alertas',array('tipo'=>'0'));
						$this->load->view('escuelasforaneas/gestionar');
					}else{
						$this->escuelasforaneas->guardar($this->session->userdata('idusuario'),0);
						$this->load->view('alertas',array('tipo'=>'1'));
						$data=array('rs_escuelas' => $this->escuelasforaneas->registros($this->session->userdata('idusuario')));
						$this->load->view('escuelasforaneas/index',$data);
					}

				}elseif($accion=='editarescuela'){
					$this->load->library('form_validation');
					$arrayArticulo = $this->escuelasforaneas->escuela($this->session->userdata('idusuario'),$id);
					if($arrayArticulo['idusuario']==$this->session->userdata('idusuario')){
						$this->form_validation->set_rules('nombre', 'Nombre de Escuela', 'trim|required|min_length[5]|max_length[80]');
						$this->form_validation->set_rules('entidad', 'Entidad Federal', 'trim|required|min_length[1]|max_length[4]');
						$this->form_validation->set_rules('localidad', 'Localidad', 'trim|required|min_length[1]|max_length[50]');
						if ($this->form_validation->run() == FALSE){
							$this->load->view('alertas',array('tipo'=>'0'));
							$this->load->view('escuelasforaneas/gestionar',$arrayArticulo);
						}else{
							$this->escuelasforaneas->guardar($this->session->userdata('idusuario'),$id);
							$arrayArticulo = $this->escuelasforaneas->escuela($this->session->userdata('idusuario'),$id);
							$this->load->view('alertas',array('tipo'=>'1'));
							$this->load->view('escuelasforaneas/gestionar',$arrayArticulo);
						}
					}else{

						 show_error('No tienes permiso para realizar está función. Por Favor contacte con el administrador', 403, $heading = 'Acceso Denegado');
					}
				}elseif($accion=='eliminarescuela'){
					$arrayArticulo = $this->escuelasforaneas->escuela($this->session->userdata('idusuario'),$id);
					if($arrayArticulo['idusuario']==$this->session->userdata('idusuario')){
						$this->escuelasforaneas->eliminar($this->session->userdata('idusuario'),$id);
						$this->load->view('alertas',array('tipo'=>'2'));
						$data=array('rs_escuelas' => $this->escuelasforaneas->registros($this->session->userdata('idusuario')));
						$this->load->view('escuelasforaneas/index',$data);
					}else{
						show_error('No tienes permiso para realizar está función. Por Favor contacte con el administrador', 403, $heading = 'Acceso Denegado');
					}
				}else{
					show_404();
				}


				$this->load->view('pie');
			}else{

				 show_error('No tienes permiso para realizar está función. Por Favor contacte con el administrador', 403, $heading = 'Acceso Denegado');
			}
		}
	//-------------------FIN ESCUELAS FORANEAS------------------------//

	//-------------------ESTUDIANTES------------------------//
		public function ajax_estudiantes()
		{
			if($this->usuarios->autorizacion('estudiantes'))
			{
				$this->load->model('estudiantes');
				$rs_estudiantes = $this->estudiantes->get_datatables($this->session->userdata('idusuario'));
				$data = array();
				foreach ($rs_estudiantes->result_array() as $estudiante) {
					$row = array();
					$row[]=$estudiante["apellido"];
					$row[]=$estudiante["nombre"];
					$row[]=$estudiante["cedula"];
					$row[]=date("d-m-Y",strtotime($estudiante["fechanac"]));

					$acciones='<a href="'.site_url(array('user','calificaciones','grados',$estudiante['idestudiante'])).'" class="btn btn-success btn-xs"><i class="fa fa-book"> Calificaciones</i></a>';
					$acciones=$acciones.'<a href="'.site_url(array('user','estudiantes','editarestudiante',$estudiante["idestudiante"])).'" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Editar </a>';
					if($estudiante["bloqueado"]==0 && $estudiante["bloqueado2"]==0){
						$acciones=$acciones.'<a href="addDialog"  class="btn btn-danger btn-xs open-AddDialog" data-toggle="modal" data-url="'.site_url(array('user','estudiantes','eliminarestudiante',$estudiante["idestudiante"])).'"><i class="fa fa-trash-o"></i> Eliminar </a>';
					}else{
						$acciones=$acciones.'<a href="#" class="btn btn-danger btn-xs" title="Bloqueado por poseer registros dependientes"><i class="fa fa-lock"></i> Eliminar</a>';
					}
					$row[] = $acciones;
					$data[] = $row;
				}
				if(!isset($_POST['draw'])){$_POST['draw']=0;}
				$cantidad=$this->estudiantes->registros($this->session->userdata('idusuario'))->num_rows();
				$output = array(
								"draw" => $_POST['draw'],
								"recordsTotal" => $cantidad,
								"recordsFiltered" => $this->estudiantes->count_filtered($this->session->userdata('idusuario')),
								"data" => $data,
						);

				echo json_encode($output);
			}
		}

		public function estudiantes($accion = 'index',$id = null)
		{
			if($this->usuarios->autorizacion('estudiantes'))
			{
				$this->load->model('estudiantes');
				$this->load->view('cabecera',$this->pagina('estudiantes'));
				if($accion=='index')
				{
					$data=array('rs_estudiantes' => $this->estudiantes->registros($this->session->userdata('idusuario')));
					$this->load->view('estudiantes/index',$data);

				}elseif($accion=='nuevoestudiante'){

					$this->load->library('form_validation');
					$this->form_validation->set_rules('apellido', 'Apellido', 'trim|required|min_length[1]|max_length[80]');
					$this->form_validation->set_rules('nombre', 'Nombre', 'trim|required|min_length[1]|max_length[80]');
					$this->form_validation->set_rules('cedula', 'Cédula', 'trim|required|min_length[1]|max_length[15]');
					$this->form_validation->set_rules('fechanac', 'Fecha de Nacimiento', 'trim|required|valid_date');
					$this->form_validation->set_rules('lugarnacimiento', 'Lugar de Nacimiento', 'trim|required|min_length[1]|max_length[50]');
					$this->form_validation->set_rules('entidad', 'Entidad o País', 'trim|required|min_length[1]|max_length[50]');

					if ($this->form_validation->run() == FALSE){
						$this->load->view('alertas',array('tipo'=>'0'));
						$this->load->view('estudiantes/gestionar');
					}else{
						$this->estudiantes->guardar($this->session->userdata('idusuario'),0);
						$this->load->view('alertas',array('tipo'=>'1'));
						$data=array('rs_estudiantes' => $this->estudiantes->registros($this->session->userdata('idusuario'),0));
						$this->load->view('estudiantes/index',$data);
					}

				}elseif($accion=='editarestudiante'){
					$this->load->library('form_validation');
					$arrayArticulo = $this->estudiantes->estudiante($this->session->userdata('idusuario'),$id);
					if($arrayArticulo['idusuario']==$this->session->userdata('idusuario')){
						$this->form_validation->set_rules('apellido', 'Apellido', 'trim|required|min_length[1]|max_length[80]');
						$this->form_validation->set_rules('nombre', 'Nombre', 'trim|required|min_length[1]|max_length[80]');
						$this->form_validation->set_rules('cedula', 'Cédula', 'trim|required|min_length[1]|max_length[15]');
						$this->form_validation->set_rules('fechanac', 'Fecha de Nacimiento', 'trim|required|valid_date');
						$this->form_validation->set_rules('lugarnacimiento', 'Lugar de Nacimiento', 'trim|required|min_length[1]|max_length[50]');
						$this->form_validation->set_rules('entidad', 'Entidad o País', 'trim|required|min_length[1]|max_length[50]');
						if ($this->form_validation->run() == FALSE){
							$this->load->view('alertas',array('tipo'=>'0'));
							$this->load->view('estudiantes/gestionar',$arrayArticulo);
						}else{
							$this->estudiantes->guardar($this->session->userdata('idusuario'),$id);
							$arrayArticulo = $this->estudiantes->estudiante($this->session->userdata('idusuario'),$id);
							$this->load->view('alertas',array('tipo'=>'1'));
							$this->load->view('estudiantes/gestionar',$arrayArticulo);
						}
					}else{

						 show_error('No tienes permiso para realizar está función. Por Favor contacte con el administrador', 403, $heading = 'Acceso Denegado');
					}
				}elseif($accion=='eliminarestudiante'){
					$arrayArticulo = $this->estudiantes->estudiante($this->session->userdata('idusuario'),$id);
					if($arrayArticulo['idusuario']==$this->session->userdata('idusuario')){
						$this->estudiantes->eliminar($this->session->userdata('idusuario'),$id);
						$this->load->view('alertas',array('tipo'=>'2'));
						$data=array('rs_estudiantes' => $this->estudiantes->registros($this->session->userdata('idusuario')));
						$this->load->view('estudiantes/index',$data);
					}else{
						show_error('No tienes permiso para realizar está función. Por Favor contacte con el administrador', 403, $heading = 'Acceso Denegado');
					}
				}else{
					show_404();
				}

				$javascript=$this->load->view('estudiantes/js','',TRUE);
				$this->load->view('pie',array('javascript'=>$javascript));
			}else{

				 show_error('No tienes permiso para realizar está función. Por Favor contacte con el administrador', 403, $heading = 'Acceso Denegado');
			}
		}
	//-------------------FIN ESTUDIANTES------------------------//

	//-------------------MODULOS------------------------//
		public function modulos($accion = 'index',$id = null)
		{
			if($this->usuarios->autorizacion('modulos'))
			{
				$this->load->view('cabecera',$this->pagina('modulos'));
				if($accion=='index')
				{
					$data=array('rs_modulos' => $this->modulos->registros());
					$this->load->view('modulos/index',$data);

				}elseif($accion=='nuevomodulo'){

					$this->load->library('form_validation');
					$this->form_validation->set_rules('descripcion', 'Nombre', 'trim|required|min_length[5]|max_length[50]');
					$this->form_validation->set_rules('archivo', 'Nombre de archivo', 'trim|required|min_length[5]|max_length[100]');
					$this->form_validation->set_rules('orden', 'Orden', 'trim|numeric|required');
					$this->form_validation->set_rules('icono', 'Icono', 'trim|required|min_length[5]|max_length[30]');


					if ($this->form_validation->run() == FALSE){
						$this->load->view('alertas',array('tipo'=>'0'));
						$this->load->view('modulos/gestionar');
					}else{
						$this->modulos->guardar();
						$this->load->view('alertas',array('tipo'=>'1'));
						$data=array('rs_modulos' => $this->modulos->registros());
						$this->load->view('modulos/index',$data);
					}

				}elseif($accion=='editarmodulo'){
					if($this->modulos->modulo($id))
					{
						$this->load->library('form_validation');
						$this->form_validation->set_rules('descripcion', 'Nombre', 'trim|required|min_length[5]|max_length[50]');
						$this->form_validation->set_rules('archivo', 'Nombre de Archivo', 'trim|required|min_length[5]|max_length[100]');
						$this->form_validation->set_rules('orden', 'Orden', 'trim|numeric|required');
						$this->form_validation->set_rules('icono', 'Icono', 'trim|required|min_length[5]|max_length[30]');
						$this->form_validation->set_rules('visible', 'Visible', 'trim|required|is_natural');
						if ($this->form_validation->run() == FALSE){
							$arrayArticulo = $this->modulos->modulo($id);
							$this->load->view('alertas',array('tipo'=>'0'));
							$this->load->view('modulos/gestionar',$arrayArticulo);
						}else{
							$this->modulos->guardar($id);
							$arrayArticulo = $this->modulos->modulo($id);
							$this->load->view('alertas',array('tipo'=>'1'));
							$this->load->view('modulos/gestionar',$arrayArticulo);
						}
					}else{
							show_404();
					}

				}elseif($accion=='eliminarmodulo'){
					if($this->modulos->modulo($id))
					{
						$this->modulos->eliminar($id);
						$this->load->view('alertas',array('tipo'=>'2'));
						$data=array('rs_modulos' => $this->modulos->registros());
						$this->load->view('modulos/index',$data);
					}else{
							show_404();
					}

				}else{
					show_404();
				}

				$this->load->view('pie');
			}else{

				 show_error('No tienes permiso para realizar está función. Por Favor contacte con el administrador', 403, $heading = 'Acceso Denegado');
			}
		}
	//-------------------FIN MODULOS------------------------//



	//-------------------USUARIOS------------------------//
		public function ajax_usuarios()
		{
			if($this->usuarios->autorizacion('usuarios'))
			{
				$rs_usuarios = $this->usuarios->get_datatables();
				$data = array();
				foreach ($rs_usuarios->result_array() as $usuarios) {
					$row = array();
					$row[] = '<img class="avatar" alt="avatar" src="'.site_url(array('images','users',$usuarios['miniatura'])).'" />';
					//$row[] = $usuarios['miniatura'];
					$row[] = $usuarios['nombre'];
					$row[] = $usuarios['email'];
					$row[] = $usuarios['descripcion'];
					$row[] ='<a href="'.site_url(array('user','usuarios','restablecer', $usuarios['idusuario'])).'" class="btn btn-primary btn-xs"><i class="fa fa-refresh"></i> Clave </a></td>';
					if($usuarios['activo']==1)
					{
						$row[]='<a href="addDialog"  class="btn btn-primary btn-xs open-AddDialog" data-toggle="modal" data-url="'.site_url(array('user','usuarios','bloquear',$usuarios['idusuario'])).'" ><i class="fa fa-unlock"></i> Habilitado </a></td>';
					}else{
						$row[]='<a href="addDialog"  class="btn btn-primary btn-xs open-AddDialog" data-toggle="modal" data-url="'.site_url(array('user','usuarios','desbloquear',$usuarios['idusuario'])).'" ><i class="fa fa-lock"></i> Bloqueado </a></td>';
					}

					$acciones='<a href="'.site_url(array('user','usuarios','editarusuario',$usuarios["idusuario"])).'" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Editar </a>';
					if($usuarios["bloqueado"]==0 && $usuarios["bloqueado2"]==0){
						$acciones=$acciones.'<a href="addDialog"  class="btn btn-danger btn-xs open-AddDialog" data-toggle="modal" data-url="'.site_url(array('user','usuarios','eliminarusuario',$usuarios["idusuario"])).'"><i class="fa fa-trash-o"></i> Eliminar </a>';
					}else{
						$acciones=$acciones.'<a href="#" class="btn btn-danger btn-xs" title="Bloqueado por poseer registros dependientes"><i class="fa fa-lock"></i> Eliminar</a>';
					}
					$row[] = $acciones;
					$data[] = $row;
				}
				if(!isset($_POST['draw'])){$_POST['draw']=0;}
				$output = array(
								"draw" => $_POST['draw'],
								"recordsTotal" => $this->usuarios->count_all(),
								"recordsFiltered" => $this->usuarios->count_filtered(),
								"data" => $data,
						);

				echo json_encode($output);
			}
		}

		public function usuarios($accion = 'index',$id = null)
		{
			if($this->usuarios->autorizacion('usuarios'))
			{
				$this->load->view('cabecera',$this->pagina('usuarios'));
				if($accion=='index')
				{
					$this->load->view('usuarios/index');

				}elseif($accion=='buscar'){
					$this->load->library('form_validation');
					$this->form_validation->set_rules('search', 'Buscar', 'trim|required|valid_email');
					if ($this->form_validation->run() == FALSE){
						$this->load->view('alertas',array('tipo'=>'0'));
						$this->load->view('usuarios/index');
					}else{
						$result=$this->usuarios->usuario_email($this->input->post('search'));
						if($result)
						{
							$arrayArticulo = $this->usuarios->usuario($result['idusuario']);
							$this->load->view('usuarios/gestionar',$arrayArticulo);
						}else{
							$this->load->view('alertas',array('tipo'=>'3'));
							$this->load->view('usuarios/index');
						}
					}

				}elseif($accion=='nuevousuario'){

					$this->load->library('form_validation');
					$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[usuarios.email]',array('is_unique' => 'El email ingresado ya se encuantra registrado!'));
					$this->form_validation->set_rules('nombre', 'Nombre', 'trim|required|min_length[1]|max_length[100]');
					$this->form_validation->set_rules('activo', 'Estatus', 'trim|required|is_natural');
					$this->form_validation->set_rules('idtipousuario', 'Tipo de Usuario', 'trim|required|is_natural_no_zero');

					if ($this->form_validation->run() == FALSE){
						$this->load->view('alertas',array('tipo'=>'0'));
						$this->load->view('usuarios/gestionar');
					}else{
						$this->usuarios->guardar();
						$this->load->view('alertas',array('tipo'=>'1'));
						$data=array('rs_usuarios' => $this->usuarios->lista_usuarios());
						$this->load->view('usuarios/index',$data);
					}

				}elseif($accion=='editarusuario'){
					if($this->usuarios->usuario($id))
					{
						$this->load->library('form_validation');
						$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|edit_unique[usuarios.email.idusuario.'.$id.']',array('edit_unique' => 'El email ingresado ya se encuantra registrado!'));
						$this->form_validation->set_rules('nombre', 'Nombre', 'trim|required|min_length[1]|max_length[100]');
						$this->form_validation->set_rules('activo', 'Estatus', 'trim|required|is_natural');
						$this->form_validation->set_rules('idtipousuario', 'Tipo de Usuario', 'trim|required|is_natural_no_zero');
						if ($this->form_validation->run() == FALSE){
							$arrayArticulo = $this->usuarios->usuario($id);
							$this->load->view('alertas',array('tipo'=>'0'));
							$this->load->view('usuarios/gestionar',$arrayArticulo);
						}else{
							$this->usuarios->guardar($id);

							$this->load->view('alertas',array('tipo'=>'1'));
							if(!empty($_FILES['userfile']['tmp_name'])) {
								$config['file_name']     = sha1($id);
								$config['upload_path'] = 'images/users/';
								$config['allowed_types'] = 'gif|jpg|png';
								$config['max_size']     = '100';
								$config['max_width'] = '800';
								$config['max_height'] = '600';
								$config['overwrite']=TRUE;
								$this->load->library('upload', $config);
								if ( ! $this->upload->do_upload('userfile')){
									$this->load->view('alertas',array('tipo'=>'10'));
								}else{
									$config['image_library'] = 'gd2';
									$config['source_image'] = 'images/users/'.$this->upload->data('file_name').'';
									$config['create_thumb'] = TRUE;
									$config['maintain_ratio'] = TRUE;
									$config['width']         = 75;
									$config['height']       = 50;
									$this->load->library('image_lib', $config);
									$this->image_lib->resize();
									$this->usuarios->guardar_imagen($id,array(
									'imagen'=>$this->upload->data('file_name'),
									'miniatura'=>$this->upload->data('raw_name').'_thumb'.$this->upload->data('file_ext')
									));
								}
							}
							$arrayArticulo = $this->usuarios->usuario($id);
							$this->load->view('usuarios/gestionar',$arrayArticulo);
						}
					}else{

						show_404();
					}
				}elseif($accion=='eliminarusuario'){
					if($this->usuarios->usuario($id))
					{
						$this->usuarios->eliminar($id);
						$this->load->view('alertas',array('tipo'=>'2'));
						$data=array('rs_usuarios' => $this->usuarios->lista_usuarios());
						$this->load->view('usuarios/index',$data);
					}else{
						show_404();
					}

				}elseif($accion=='bloquear'){
					if($this->usuarios->usuario($id))
					{
						$this->usuarios->bloquear($id);
						$this->load->view('alertas',array('tipo'=>'1'));
						$data=array('rs_usuarios' => $this->usuarios->lista_usuarios());
						$this->load->view('usuarios/index',$data);
					}else{
						show_404();
					}

				}elseif($accion=='desbloquear'){
					if($this->usuarios->usuario($id))
					{
						$this->usuarios->desbloquear($id);
						$this->load->view('alertas',array('tipo'=>'1'));
						$data=array('rs_usuarios' => $this->usuarios->lista_usuarios());
						$this->load->view('usuarios/index',$data);
					}else{
						show_404();
					}

				}elseif($accion=='restablecer'){
					if($this->usuarios->usuario($id))
					{
						$this->usuarios->restablecer($id);
						$this->load->view('alertas',array('tipo'=>'1'));
						$data=array('rs_usuarios' => $this->usuarios->lista_usuarios());
						$this->load->view('usuarios/index',$data);
					}else{
						show_404();
					}
				}else{
					show_404();
				}

				$javascript=$this->load->view('usuarios/js','',TRUE);
				$this->load->view('pie',array('javascript'=>$javascript));
			}else{

				 show_error('No tienes permiso para realizar está función. Por Favor contacte con el administrador', 403, $heading = 'Acceso Denegado');
			}
		}
	//-------------------FIN USUARIOS------------------------//

	//-------------------MENSAJES------------------------//
		public function mensajes($accion = 'index',$id = null){

			if($this->usuarios->autorizacion('mensajes'))
			{
				$this->load->model('mensajes');
				$this->load->view('cabecera',$this->pagina('mensajes'));
				if($accion=='index')
				{
					$data=array('rs_mensajes' => $this->mensajes->registros());
					$this->load->view('mensajes/index',$data);

				}elseif($accion=='nuevomensaje'){
					$this->load->library('form_validation');
					$this->form_validation->set_rules('asunto', 'Asunto', 'trim|required|min_length[1]|max_length[500]');
					$this->form_validation->set_rules('mensaje', 'Mensaje', 'trim|required|min_length[1]|max_length[5000]');
					if ($this->form_validation->run() == FALSE){
						$this->load->view('alertas',array('tipo'=>'0'));
						$this->load->view('mensajes/gestionar');
					}else{
						$this->mensajes->guardar(0);
						$this->load->view('alertas',array('tipo'=>'1'));
						$data=array('rs_mensajes' => $this->mensajes->registros());
					    $this->load->view('mensajes/index',$data);
					}
				}elseif($accion=='editarmensaje'){
					if($this->mensajes->mensaje($id))
					{
						$this->load->library('form_validation');
						$this->form_validation->set_rules('asunto', 'Asunto', 'trim|required|min_length[1]|max_length[500]');
						$this->form_validation->set_rules('mensaje', 'Mensaje', 'trim|required|min_length[1]|max_length[5000]');
						if ($this->form_validation->run() == FALSE){
							$arrayArticulo = $this->mensajes->mensaje($id);
							$this->load->view('alertas',array('tipo'=>'0'));
							$this->load->view('mensajes/gestionar',$arrayArticulo);
						}else{
							$this->mensajes->guardar($id);
							$arrayArticulo = $this->mensajes->mensaje($id);
							$this->load->view('alertas',array('tipo'=>'1'));
							$this->load->view('mensajes/gestionar',$arrayArticulo);
						}
					}else{
						show_404();
					}
				}elseif($accion=='eliminarmensaje'){
					if($this->mensajes->mensaje($id))
					{
						$this->mensajes->eliminar($id);
						$this->load->view('alertas',array('tipo'=>'2'));
						$data=array('rs_mensajes' => $this->mensajes->registros());
						$this->load->view('mensajes/index',$data);
					}else{
						show_404();
					}
				}else{
					show_404();
				}


				$this->load->view('pie');

			}else{

				 show_error('No tienes permiso para realizar está función. Por Favor contacte con el administrador', 403, $heading = 'Acceso Denegado');
			}
		}

		public function inbox($accion = 'index',$id = null){

			if($this->usuarios->autorizacion('inbox'))
			{
				$this->load->model('mensajes');
				$this->load->view('cabecera',$this->pagina('inbox'));
				if($accion=='index')
				{
					$data=array('rs_mensajes' => $this->mensajes->registros());
					$this->load->view('mensajes/inbox',$data);

				}

				$this->load->view('pie');

			}else{

				 show_error('No tienes permiso para realizar está función. Por Favor contacte con el administrador', 403, $heading = 'Acceso Denegado');
			}
		}

	//-------------------FIN MENASJES------------------------//

	//-------------------TIPOS USUARIOS------------------------//
		public function tipousuario($accion = 'index',$id = null){

			if($this->usuarios->autorizacion('tipousuario'))
			{
				$this->load->view('cabecera',$this->pagina('tipousuario'));
				if($accion=='index')
				{
					$data=array('rs_tipousuario' => $this->usuarios->lista_tipos_usuarios());
					$this->load->view('tiposusuarios/index',$data);

				}elseif($accion=='nuevotipousuario'){
					$this->load->library('form_validation');
					$this->form_validation->set_rules('descripcion', 'Nombre', 'trim|required|min_length[1]|max_length[100]|is_unique[tipousuario.descripcion]');
					if ($this->form_validation->run() == FALSE){
						$this->load->view('alertas',array('tipo'=>'0'));
						$this->load->view('tiposusuarios/gestionar');
					}else{
						$this->usuarios->guardartipousuario();
						$this->load->view('alertas',array('tipo'=>'1'));
						$data=array('rs_tipousuario' => $this->usuarios->lista_tipos_usuarios());
					    $this->load->view('tiposusuarios/index',$data);
					}
				}elseif($accion=='editartipousuario'){

					if($this->usuarios->tipousuario($id))
					{
						$this->load->library('form_validation');
						$this->form_validation->set_rules('descripcion', 'Nombre', 'trim|required|min_length[1]|max_length[100]');
						if ($this->form_validation->run() == FALSE){
							$arrayArticulo = $this->usuarios->tipousuario($id);
							$this->load->view('alertas',array('tipo'=>'0'));
							$this->load->view('tiposusuarios/gestionar',$arrayArticulo);
						}else{
							$this->usuarios->guardartipousuario($id);
							$this->load->view('alertas',array('tipo'=>'1'));
							$arrayArticulo = $this->usuarios->tipousuario($id);
							$this->load->view('tiposusuarios/gestionar',$arrayArticulo);
						}
					}else{
						show_404();
					}

				}elseif($accion=='permisotipousuario'){
					if($this->usuarios->tipousuario($id))
					{
						$this->load->library('form_validation');
						$arraytipousuario = $this->usuarios->tipousuario($id);
						$this->form_validation->set_rules('id', 'Tipo de usuario', 'trim|required');
						if ($this->form_validation->run() == FALSE){

							$rs_funciones = array(
												'rs_funciones' 	=> $this->usuarios->lista_funciones_tipos_usuarios($id),
												'idtipousuario' =>$arraytipousuario['idtipousuario'],
												'descripcion' => $arraytipousuario['descripcion']
												);
							$this->load->view('alertas',array('tipo'=>'0'));
							$this->load->view('tiposusuarios/funciones',$rs_funciones);

						}else{

							$this->usuarios->guardar_funciones($id);
							$this->load->view('alertas',array('tipo'=>'1'));
							$arraytipousuario = $this->usuarios->tipousuario($id);
							$rs_funciones = array(
												'rs_funciones' 	=> $this->usuarios->lista_funciones_tipos_usuarios($id),
												'idtipousuario' => $arraytipousuario['idtipousuario'],
												'descripcion' => $arraytipousuario['descripcion']
												);
							$this->load->view('tiposusuarios/funciones',$rs_funciones);

						}
					}else{
						show_404();
					}
				}elseif($accion=='eliminartipousuario'){
					if($this->usuarios->tipousuario($id))
					{
						$this->usuarios->eliminartipousuario($id);
						$this->load->view('alertas',array('tipo'=>'2'));
						$data=array('rs_tipousuario' => $this->usuarios->lista_tipos_usuarios());
						$this->load->view('tiposusuarios/index',$data);
					}else{
						show_404();
					}
				}else{
					show_404();
				}

				$this->load->view('pie');

			}else{

				 show_error('No tienes permiso para realizar está función. Por Favor contacte con el administrador', 403, $heading = 'Acceso Denegado');
			}
		}

		//-------------------FIN TIPOS USUARIOS------------------------//

		//-------------------CALIFICACIONES------------------------//

		public function ajax_calificaciones()
		{
			if($this->usuarios->autorizacion('calificaciones'))
			{
				$this->load->model('estudiantes');
				$rs_estudiantes = $this->estudiantes->get_datatables($this->session->userdata('idusuario'));
				$data = array();
				foreach ($rs_estudiantes->result_array() as $estudiante) {
					$row = array();
					$row[]=$estudiante["apellido"];
					$row[]=$estudiante["nombre"];
					$row[]=$estudiante["cedula"];
					$row[]=date("d-m-Y",strtotime($estudiante["fechanac"]));
					$row[]=$estudiante["lugarnacimiento"];
					$row[]=$estudiante["entidad"];
					$acciones='<a href="'.site_url(array('user','estudiantes','editarestudiante',$estudiante["idestudiante"])).'" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Editar </a>';
					$acciones=$acciones.'<a href="'.site_url(array('user','calificaciones','grados',$estudiante['idestudiante'])).'" class="btn btn-success btn-xs"><i class="fa fa-book"> Calificaciones</i></a>';
					$row[] = $acciones;
					$data[] = $row;
				}
				if(!isset($_POST['draw'])){$_POST['draw']=0;}
				$result=$this->estudiantes->registros($this->session->userdata('idusuario'));
				$cantidad=$result->num_rows();
				$output = array(
								"draw" => $_POST['draw'],
								"recordsTotal" => $cantidad,
								"recordsFiltered" => $this->usuarios->count_filtered($this->session->userdata('idusuario')),
								"data" => $data,
						);

				echo json_encode($output);
			}
		}



		function calificaciones($accion = 'index',$id=null,$grado=null,$id2=null){
			if($this->usuarios->autorizacion('calificaciones'))
			{
				$this->load->model('estudiantes');
				$this->load->model('calificaciones');
				$this->load->view('cabecera',$this->pagina('calificaciones'));
				if($accion=='index')
				{
					$data=array('rs_estudiantes' => $this->estudiantes->registros($this->session->userdata('idusuario')));
					$this->load->view('calificaciones/index',$data);

				}elseif($accion=='buscar'){

					$this->load->library('form_validation');
					$this->form_validation->set_rules('search', 'Buscar', 'trim|required|min_length[1]|max_length[15]');
					if ($this->form_validation->run() == FALSE){
						$this->load->view('alertas',array('tipo'=>'0'));
						$data=array('rs_estudiantes' => $this->estudiantes->registros($this->session->userdata('idusuario')));
						$this->load->view('calificaciones/index',$data);

					}else{
						$result=$this->estudiantes->estudiante_cedula($this->session->userdata('idusuario'),$this->input->post('search'));
						if($result)
						{
							for($i=0;$i<6;$i++)
							{
								$grado=$i+1;
								$cantidad_materias=$this->calificaciones->listamaterias($result['idestudiante'],$grado)->num_rows();
								$cantidad_materiaset=$this->calificaciones->listaet($result['idestudiante'],$grado)->num_rows();
								$array_grados[] = array('grado' => ($i+1),'cantidad_materias' => $cantidad_materias,'cantidad_materiaset' => $cantidad_materiaset);
							}
							$estudiante=$this->estudiantes->estudiante($this->session->userdata('idusuario'),$result['idestudiante']);
							$data=array('array_grados'	=> $array_grados,'estudiante' 	=>	$estudiante);
							$this->load->view('calificaciones/grados',$data);

						}else{
							$this->load->view('alertas',array('tipo'=>'3'));
							$data=array('rs_estudiantes' => $this->estudiantes->registros($this->session->userdata('idusuario')));
							$this->load->view('calificaciones/index',$data);
						}
					}

				}elseif($accion=='grados'){

					$estudiante=$this->estudiantes->estudiante($this->session->userdata('idusuario'),$id);
					if($estudiante){
						for($i=0;$i<6;$i++)
						{
							$grado=$i+1;
							$cantidad_materias=$this->calificaciones->listamaterias($id,$grado)->num_rows();
							$cantidad_materiaset=$this->calificaciones->listaet($id,$grado)->num_rows();
							$array_grados[] = array('grado' => ($i+1),'cantidad_materias' => $cantidad_materias,'cantidad_materiaset' => $cantidad_materiaset);

						}

						$data=array(
									'array_grados'	=> $array_grados,
									'estudiante' 	=>	$estudiante
								   );

						$this->load->view('calificaciones/grados',$data);
					}else{
						show_404();
					}

				}elseif($accion=='materias'){
					if(($this->estudiantes->estudiante($this->session->userdata('idusuario'),$id)) && ($grado>0) && ($grado<7))
					{
						$this->load->library('form_validation');
						$this->form_validation->set_rules('idescuela', 'Escuela', 'trim|required|is_natural_no_zero');
						$this->form_validation->set_rules('plan', 'Plan de Estudio', 'trim|required|min_length[1]|max_length[100]');
						$this->form_validation->set_rules('mencion', 'Mención', 'trim|required|min_length[1]|max_length[8]');
						$this->form_validation->set_rules('codigo', 'Código', 'trim|required|min_length[1]|max_length[100]');
						$this->form_validation->set_rules('observacion', 'Observaciones', 'trim|min_length[0]|max_length[500]');
						if(isset($_POST['materias']))
						{
							$materias=$_POST['materias'];
							$notas=$_POST['notas'];
							$tipos=$_POST['tipos'];
							$mess=$_POST['mess'];
							$anios=$_POST['anios'];
							$idescuelaforaneas=$_POST['idescuelaforaneas'];
							for($i=0;$i<17;$i++)
							{
								if(($materias[$i]!='') || ($notas[$i]!='') || ($tipos[$i]!='') || ($mess[$i]!='') || ($anios[$i]!='') || ($idescuelaforaneas[$i]!='') )
								{
									$this->form_validation->set_rules('materias['.$i.']', 'Materia Nro '.($i+1).'', 'trim|required|min_length[1]|max_length[50]');
									$this->form_validation->set_rules('notas['.$i.']', 'Calificación Nro '.($i+1).'', 'trim|required|min_length[1]|is_natural|less_than[21]');
									$this->form_validation->set_rules('tipos['.$i.']', 'Tipo Nro '.($i+1).'', 'trim|required|min_length[1]|max_length[3]');
									$this->form_validation->set_rules('mess['.$i.']', 'Mes Nro '.($i+1).'', 'trim|required|min_length[1]|is_natural_no_zero');
									$this->form_validation->set_rules('anios['.$i.']', 'Año Nro '.($i+1).'', 'trim|required|min_length[4]|max_length[4]|is_natural');
									$this->form_validation->set_rules('idescuelaforaneas['.$i.']', 'Escuela Nro '.($i+1).'', 'trim|required|is_natural_no_zero');
								}
							}
						}

						if($this->form_validation->run()==FALSE)
						{
							$data=array(
										'estudiante' 			=>	$this->estudiantes->estudiante($this->session->userdata('idusuario'),$id),
										'grado'		 			=>	$grado,
										'rs_escuelasforaneas' 	=>  $this->calificaciones->comboescuelasforaneas($this->session->userdata('idusuario')),
										'rs_escuelas' 			=>  $this->calificaciones->comboescuelas($this->session->userdata('idusuario')),
										'rs_plan' 				=>  $this->calificaciones->plan($id,$grado),
										'rs_materias' 			=>  $this->calificaciones->listamaterias($id,$grado),
										'rs_materias_precargada'=>  $this->calificaciones->listamaterias_precargadas($grado),
										'rs_plan_precargado'	=>  $this->calificaciones->plan_precargado($grado),


							);
							$this->load->view('alertas',array('tipo'=>'0'));
							$this->load->view('calificaciones/materias',$data);
						}else{

							$this->calificaciones->guardarplan($id,$grado);
							$materias=$this->input->post('materias');
							$notas=$this->input->post('notas');
							$tipos=$this->input->post('tipos');
							$mess=$this->input->post('mess');
							$anios=$this->input->post('anios');
							$idescuelaforaneas=$this->input->post('idescuelaforaneas');
							$data=array();

							for($i=0;$i<count($materias);$i++)
							{
								if(($materias[$i]!='') && ($notas[$i]!='') && ($tipos[$i]!='') && ($mess[$i]!='') && ($anios[$i]!='') && ($idescuelaforaneas[$i]!='')  )
								{
									$data[] = array('materia' => $materias[$i],'nota' => $notas[$i],'tipo' => $tipos[$i],'mes' => $mess[$i],'anio' => $anios[$i],'idescuelaforanea' => $idescuelaforaneas[$i],'grado' => $grado,'idestudiante' => $id);
								}
							}
							$this->calificaciones->guardarmaterias($id,$grado,$data);
							/*$data=array('estudiante' 			=>	$this->estudiantes->estudiante($this->session->userdata('idusuario'),$id),
										'grado'		 			=>	$grado,
										'rs_escuelasforaneas' 	=>  $this->calificaciones->comboescuelasforaneas($this->session->userdata('idusuario')),
										'rs_plan' 				=>  $this->calificaciones->plan($id,$grado),
										'rs_escuelas' 			=>  $this->calificaciones->comboescuelas($this->session->userdata('idusuario')),
										'rs_materias' 			=>  $this->calificaciones->listamaterias($id,$grado)
									);
							$this->load->view('alertas',array('tipo'=>'1'));
							$this->load->view('calificaciones/materias',$data);*/
							$estudiante=$this->estudiantes->estudiante($this->session->userdata('idusuario'),$id);
							for($i=0;$i<6;$i++)
							{
								$grado=$i+1;
								$cantidad_materias=$this->calificaciones->listamaterias($id,$grado)->num_rows();
								$cantidad_materiaset=$this->calificaciones->listaet($id,$grado)->num_rows();
								$array_grados[] = array('grado' => ($i+1),'cantidad_materias' => $cantidad_materias,'cantidad_materiaset' => $cantidad_materiaset);
							}
							$data=array('array_grados'	=> $array_grados,
										'estudiante' 	=>	$estudiante
									   );
							$this->load->view('alertas',array('tipo'=>'1'));
							$this->load->view('calificaciones/grados',$data);
						}
					}else{

						show_404();
					}

				}elseif($accion=='listaet'){
					if(($this->estudiantes->estudiante($this->session->userdata('idusuario'),$id)) && ($grado>0) && ($grado<7))
					{
						$data=array('estudiante' 	=>	$this->estudiantes->estudiante($this->session->userdata('idusuario'),$id),
									'grado'		 	=>	$grado,
									'rs_materiaset' => 	$this->calificaciones->listaet($id,$grado)
									);
						$this->load->view('calificaciones/listaet',$data);
					}else{

						show_404();
					}

				}elseif($accion=='eliminaret'){
					if(($this->estudiantes->estudiante($this->session->userdata('idusuario'),$id)) && ($grado>0) && ($grado<7) && ($this->calificaciones->materiaet($id2)))
					{
						$this->calificaciones->eliminaret($id2);
						$data=array('estudiante' 	=>	$this->estudiantes->estudiante($this->session->userdata('idusuario'),$id),
									'grado'		 	=>	$grado,
									'rs_materiaset' => 	$this->calificaciones->listaet($id,$grado)
								);
						$this->load->view('alertas',array('tipo'=>'1'));
						$this->load->view('calificaciones/listaet',$data);
					}else{
							show_404();
					}

				}elseif($accion=='nuevoet'){
					if(($this->estudiantes->estudiante($this->session->userdata('idusuario'),$id)) && ($grado>0) && ($grado<7))
					{
						$this->load->library('form_validation');
						$this->form_validation->set_rules('nombre', 'Nombre', 'trim|required|min_length[1]|max_length[100]');
						$this->form_validation->set_rules('horas', 'Horas', 'trim|required|min_length[1]|max_length[2],is_natural');
						if ($this->form_validation->run() == FALSE){
							$data=array('estudiante' 	=>	$this->estudiantes->estudiante($this->session->userdata('idusuario'),$id),
										'grado'		 	=>	$grado
									);
							$this->load->view('alertas',array('tipo'=>'0'));
							$this->load->view('calificaciones/gestionaret',$data);
						}else{
							$this->calificaciones->guardaret($id,$grado,0);
							$data=array('estudiante' 	=>	$this->estudiantes->estudiante($this->session->userdata('idusuario'),$id),
										'grado'		 	=>	$grado,
										'rs_materiaset' => 	$this->calificaciones->listaet($id,$grado)
									);
							$this->load->view('alertas',array('tipo'=>'1'));
							$this->load->view('calificaciones/listaet',$data);
						}
					}else{
							show_404();
					}

				}elseif($accion=='editaret'){
					if(($this->estudiantes->estudiante($this->session->userdata('idusuario'),$id)) && ($grado>0) && ($grado<7) && ($this->calificaciones->materiaet($id2)))
					{
						$this->load->library('form_validation');
						$this->form_validation->set_rules('nombre', 'Nombre', 'trim|required|min_length[1]|max_length[100]');
						$this->form_validation->set_rules('horas', 'Horas', 'trim|required|min_length[1]|max_length[2],is_natural');
						if ($this->form_validation->run() == FALSE){
							$data=array('estudiante' 	=>	$this->estudiantes->estudiante($this->session->userdata('idusuario'),$id),
										'grado'		 	=>	$grado,
										'rs_materia' 	=>  $this->calificaciones->materiaet($id2)
									);
							$this->load->view('alertas',array('tipo'=>'0'));
							$this->load->view('calificaciones/gestionaret',$data);

						}else{
							$this->calificaciones->guardaret($id,$grado,$id2);
							$data=array('estudiante' 	=>	$this->estudiantes->estudiante($this->session->userdata('idusuario'),$id),
									'grado'		 	=>	$grado,
									'rs_materiaset' => 	$this->calificaciones->listaet($id,$grado)
									);
							$this->load->view('alertas',array('tipo'=>'1'));
							$this->load->view('calificaciones/listaet',$data);

						}
					}else{
							show_404();
					}

				}else{
					show_404();
				}

				$javascript=$this->load->view('calificaciones/js','',TRUE);
				$this->load->view('pie',array('javascript'=>$javascript));

			}else{

				 show_error('No tienes permiso para realizar está función. Por Favor contacte con el administrador', 403, $heading = 'Acceso Denegado');
			}


		}

	}
