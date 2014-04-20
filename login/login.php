<?php
class Login extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('login_model');
	}
	public function index()
	{
		switch ($this->session->userdata('acceso')) 
		{
			case '':
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
	public function log_user()
	{
		if($this->input->post('token') && $this->input->post('token') == $this->session->userdata('token'))
		{
			$this->form_validation->set_rules('nombre_usuario', 'Usuario', 'trim|required|min_length[5]|max_length[15]|xss_clean');
			$this->form_validation->set_rules('pass_usuario', 'Password', 'trim|required|min_length[5]|max_length[15]|xss_clean');
			if($this->form_validation->run() == FALSE)
			{
				$this->index();	
			}
			else
			{
				$usr = $this->input->post('nombre_usuario');
				$pass = sha1($this->input->post('pass_usuario'));
				$check_usr = $this->login_model->login_usr($usr, $pass);
				if($check_usr == TRUE)
				{
					$data = array(
						//'is_logued_in' => TRUE,
						'id_usuario' => $check_usr->id_usuario,
						'nombre_usuario' => $check_usr->nombre_usuario,
						'acceso' => $check_usr->acceso
						);
					//return $data['usr'] = $this->session->userdata('name_usuario');
				
					$this->session->set_userdata($data);
					//$this->dataSess();
					$this->index();
				}
			}
		}
		else
		{
			redirect(base_url().'login');
		}
	}
	public function token()
	{
		$token = md5(uniqid(rand(),true));
		$this->session->set_userdata('token', $token);
		return $token;
	}
	 	
}