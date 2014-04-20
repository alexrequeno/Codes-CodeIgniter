<?php
class Login extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		#Cargamos el modelo para comparar el usuarios con la contraseña
		$this->load->model('login_model');
	}
	public function index()
	{
		/*
		Este switch evaluara en cada case dependiendo de como tienen sus nivel para usuarios,
		si el case esta vacio mostrara de nuevo la vista login_view,
		los otros case's dependeran de sus niveles de acceso asi sera su redireccionamiento hacia un contralador predeterminado,
		si no se complen por defecto cargara otra vez la vista
		*/
		switch ($this->session->userdata('acceso')) 
		{
			case '':
				#Volvemos a generar el token
				$data['token'] = $this->token();
				$data['page_title'] = "Iniciar Sesion | Bodeger";
				#Cargar vistas
				$this->load->view('template/header', $data);
				$this->load->view('login_view', $data);
				$this->load->view('template/footer');
				break;
			case '1':
				#Redireccionar a panel de control
				redirect(base_url().'administracion');
				break;
			case '2':
				#Redireccionar a modulos estandar
				redirect(base_url().'pedidos');
				break;
			default:
				$data['token'] = $this->token();
				$data['page_title'] = "Iniciar Sesión | Bodeger";
				#Cargar vistas
				$this->load->view('template/header', $data);
				$this->load->view('login_view', $data);
				$this->load->view('template/footer');
				break;
		}
	}
	#Metodo para hacer la comparacion del usuario
	public function log_user()
	{
		#Comparamos el token de sesion con el token del formulario para evitar fallos en la seguridad de envio de datos
		if($this->input->post('token') && $this->input->post('token') == $this->session->userdata('token'))
		{
			#ponemos las reglas de validacion
			$this->form_validation->set_rules('nombre_usuario', 'Usuario', 'trim|required|min_length[5]|max_length[15]|xss_clean');
			$this->form_validation->set_rules('pass_usuario', 'Password', 'trim|required|min_length[5]|max_length[15]|xss_clean');
			#Verificamos si la validacion es correcta
			if($this->form_validation->run() == FALSE)
			{
				#Si es falsa redireccionamos al index
				$this->index();	
			}
			else
			{
				#sino, capturamos el post del formulario
				$usr = $this->input->post('nombre_usuario');
				$pass = sha1($this->input->post('pass_usuario'));
				#comparamos en la base de datos
				$check_usr = $this->login_model->login_usr($usr, $pass);
				#Verificamos si la comparacion nos sale bien
				if($check_usr == TRUE)
				{
					#si es correcto creamos un array con los datos del usuario
					$data = array(
						//'is_logued_in' => TRUE,
						'id_usuario' => $check_usr->id_usuario,
						'nombre_usuario' => $check_usr->nombre_usuario,
						'acceso' => $check_usr->acceso
						);
					//return $data['usr'] = $this->session->userdata('name_usuario');
					#mandamos el array a sesion
					$this->session->set_userdata($data);
					//$this->dataSess();
					#corremos el index nuevamente y como ya habra una sesion con el nivel de acceso
					#redireccionara hacia donde corresponda
					$this->index();
				}
			}
		}
		else
		{
			redirect(base_url().'login');
		}
	}
	#metodo para la generacion de tokens
	public function token()
	{
		$token = md5(uniqid(rand(),true));
		$this->session->set_userdata('token', $token);
		return $token;
	}
	 	
}
