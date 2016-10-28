<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{

	public function recaptcha($str='')
	{
	  $google_url="https://www.google.com/recaptcha/api/siteverify";
	  $secret='6LeqJwcUAAAAAHskKnLZPXpgs_hlYF7rSCOIU51A';
	  $ip=$_SERVER['REMOTE_ADDR'];
	  $url=$google_url."?secret=".$secret."&response=".$str."&remoteip=".$ip;
	  $curl = curl_init();
	  curl_setopt($curl, CURLOPT_URL, $url);
	  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	  curl_setopt($curl, CURLOPT_TIMEOUT, 10);
	  curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.16) Gecko/20110319 Firefox/3.6.16");
	  $res = curl_exec($curl);
	  curl_close($curl);
	  $res= json_decode($res, true);
	  //reCaptcha success check
	  if($res['success'])
	  {
		return TRUE;
	  }
	  else
	  {
		$this->form_validation->set_message('recaptcha', 'El campo de verificación reCAPTCHA  que eres un robot. Deseas intentarlo de nuevo?');
		return FALSE;
	  }
	}

	public function index()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[18]');


		if ($this->form_validation->run() == FALSE) {
			$data=array('form' => $this->load->view('login/iniciar',array('message'=>''),TRUE));
			$this->load->view('login/login',$data);

		}else{
			$this->load->model('usuarios');
			$data_post = array(
			'email' => $this->input->post('email'),
			'password' => $this->input->post('password')
			);
			$result = $this->usuarios->login($data_post);
			if(!($result == FALSE)){

				if($result['activo']==1){

					if($result['verificar']==''){
						$data = array(
						'idusuario' =>$result['idusuario'],
						'email' =>$result['email'],
						'nombre' =>$result['nombre'],
						'miniatura' =>$result['miniatura'],
						'idtipousuario' =>$result['idtipousuario'],
						'imagen' =>$result['imagen'],
						'logueado' =>TRUE
						);
						// Add user data in session
						$this->session->set_userdata($data);
						redirect(site_url(array('user')));
					}else{

						$data=array('form' => $this->load->view('login/iniciar',array('message'=>'Debes verificar tu cuenta de usuario a través de tu correo electrónico'),TRUE));
						$this->load->view('login/login',$data);

					}
				}else{
					$data=array('form' => $this->load->view('login/iniciar',array('message'=>'Cuenta de usuario inactiva'),TRUE));
					$this->load->view('login/login',$data);
				}
			}else{
				$data=array('form' => $this->load->view('login/iniciar',array('message'=>'Usuario o Password errado'),TRUE));
				$this->load->view('login/login',$data);
			}
		}

	}

	public function registro(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('nombre', 'Nombre', 'trim|required|min_length[6]|max_length[80]');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[usuarios.email]',array('is_unique' => 'El email ingresado ya se encuentra registrado en nuestra base de datos'));
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[18]');
		//$this->form_validation->set_rules('g-recaptcha-response','Casilla de Verificación','callback_recaptcha');
		if ($this->form_validation->run() == FALSE) {
			$data=array('form' => $this->load->view('login/registro',array('message'=>''),TRUE));
			$this->load->view('login/login',$data);

		}else{
			$this->load->model('usuarios');
			if($result = $this->usuarios->registrar()){
				$result = $this->usuarios->login($data_post = array('email' => $this->input->post('email'),'password' => $this->input->post('password')));
				$config = Array(
					'protocol' => 'smtp',
					'smtp_host' => 'mail.endergalban.com.ve',
					'smtp_port' => 26,
					'smtp_user' => 'noreply@endergalban.com.ve',
					'smtp_pass' => 'p#Q_uCQi78IT',
					'mailtype'  => 'html',
					'charset'   => 'UTF-8'
				);
				$this->load->library('email', $config);
				$this->email->set_newline("\r\n");
				$this->email->from('noreply@endergalban.com.ve');
				$this->email->to($result['email']);

				$this->email->subject('Bienvenido al sistema de Notas Certificadas');
				$this->email->message('
				<div >Hola '.$result['nombre'].',<br>
				<br>
				Sea bienvenido a nuestro sitio web. Esta a punto de tener acceso a una de las mejores formas de gestionar las notas certificadas de los estudiantes.<br>
				<br>
				Tu nombre de usuario es '.$result['email'].',<br>
				<br>
				Para activar tu cuenta debes hacer click en la dirección mostrada a continuación:<br>
				<br>
				<a href="'.base_url(array('login','activacion',$result['verificar'])).'">'.base_url(array('login','activacion',$result['verificar'])).'</a><br>
				<br>
				<br>
				Gracias,<br>
				</div>');
				if(!$this->email->send()){
					show_error($this->email->print_debugger());
				}
				$data=array('form' => $this->load->view('login/registro',array('message'=>'Tu cuenta ha sido creada, te hemos enviado un correo electrónico con la información necesaria para ingresar al sistema.'),TRUE));
				$this->load->view('login/login',$data);

			}
		}


	}

	public function activacion($verificar = null)
	{
		if(is_null($verificar)){
			$data=array('form' => $this->load->view('login/iniciar',array('message'=>''),TRUE));
			$this->load->view('login/login',$data);
		}else{
			$this->load->library('form_validation');
			$this->load->model('usuarios');
			if($this->usuarios->verificar($verificar)){
				$data=array('form' => $this->load->view('login/iniciar',array('message'=>'Su cuenta de correo ha sido verificada. Para continuar ingrese sus datos a continuación'),TRUE));
				$this->load->view('login/login',$data);
			}else{

				$data=array('form' => $this->load->view('login/iniciar',array('message'=>'Código de verificación incorrecto'),TRUE));
				$this->load->view('login/login',$data);
			}
		}


	}


	public function restablecer(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		//$this->form_validation->set_rules('g-recaptcha-response','Casilla de Verificación','callback_recaptcha');
		if ($this->form_validation->run() == FALSE) {
			$data=array('form' => $this->load->view('login/restablecer',array('message'=>''),TRUE));
			$this->load->view('login/login',$data);

		}else{
			$this->load->model('usuarios');
			$result = $this->usuarios->verificar_email_restablecer($this->input->post('email'));
			if($result){
				$result = $this->usuarios->usuario($result['idusuario']);
				$config = Array(
					'protocol' => 'smtp',
					'smtp_host' => 'mail.endergalban.com.ve',
					'smtp_port' => 26,
					'smtp_user' => 'noreply@endergalban.com.ve',
					'smtp_pass' => 'p#Q_uCQi78IT',
					'mailtype'  => 'html',
					'charset'   => 'UTF-8'
				);
				$this->load->library('email', $config);
				$this->email->set_newline("\r\n");
				$this->email->from('noreply@endergalban.com.ve');
				$this->email->to($result['email']);

				$this->email->subject('Cambiando el password para el sistema de Notas Certificadas');
				$this->email->message('
				<div >Hola '.$result['nombre'].',<br>
				<br>
				Esta a punto de cambiar tu password de inicio de sesión.<br>
				<br>
				Para realizar el cambio debes hacer click en la dirección mostrada a continuación:<br>
				<br>
				<a href="'.base_url(array('login','reset',$result['reset'])).'">'.base_url(array('login','activacion',$result['reset'])).'</a><br>
				<br>
				<br>
				Gracias,<br>
				</div>');
				if(!$this->email->send()){
					show_error($this->email->print_debugger());
				}
				$data=array('form' => $this->load->view('login/iniciar',array('message'=>'Te hemos enviado un correo electrónico con la información necesaria para restablecer tu password.'),TRUE));
				$this->load->view('login/login',$data);

			}else{

				$data=array('form' => $this->load->view('login/restablecer',array('message'=>'El email ingresado no se encuentra registrado en nuestra base de datos.'),TRUE));
				$this->load->view('login/login',$data);
			}
		}
	}

	public function reset($reset=null)
	{
		$this->load->library('form_validation');
		if(!is_null($reset)){
			$this->load->model('usuarios');
			$result = $this->usuarios->verificar_reset($reset,0);
			if($result){
				$this->form_validation->set_rules('password', 'Password', 'trim|min_length[6]|max_length[20]|required');
				$this->form_validation->set_rules('passconf', 'Confirmación', 'trim|min_length[6]|max_length[20]|required|matches[password]');
				if ($this->form_validation->run() == FALSE){

					$data=array('form' => $this->load->view('login/reset',array('message'=>''),TRUE));
					$this->load->view('login/login',$data);
				}else{

					$this->load->model('usuarios');
					$result = $this->usuarios->verificar_reset($reset,1);
					if($result){
						$config = Array(
							'protocol' => 'smtp',
							'smtp_host' => 'mail.endergalban.com.ve',
							'smtp_port' => 26,
							'smtp_user' => 'noreply@endergalban.com.ve',
							'smtp_pass' => 'p#Q_uCQi78IT',
							'mailtype'  => 'html',
							'charset'   => 'UTF-8'
						);
						$this->load->library('email', $config);
						$this->email->set_newline("\r\n");
						$this->email->from('noreply@endergalban.com.ve');
						$this->email->to($result['email']);

						$this->email->subject('Actualización de datos');
						$this->email->message('
						<div >Hola '.$result['nombre'].',<br>
						<br>
						Tus datos de inicio de sesión han sido actualizado con éxito.<br>
						<br>
						Esta una cuenta no monitorizada por favor no responda este correo!<br>
						<br>
						<br>
						Gracias,<br>
						</div>');
						if(!$this->email->send()){
							show_error($this->email->print_debugger());
						}
						$data=array('form' => $this->load->view('login/iniciar',array('message'=>'Tu password ha sido actualizado con éxito. Para continuar ingrese sus datos a continuación'),TRUE));
						$this->load->view('login/login',$data);

					}else{
						$data=array('form' => $this->load->view('login/iniciar',array('message'=>''),TRUE));
						$this->load->view('login/login',$data);
					}

				}
			}else{

				show_404();
			}
		}else{

			show_404();

		}

	}

	public function logout()
	{
		$this->load->library('form_validation');
		$this->load->model('usuarios');
		$this->usuarios->logout();

		$data=array('form' => $this->load->view('login/iniciar',array('message'=>''),TRUE));
		$this->load->view('login/login',$data);


	}



}
