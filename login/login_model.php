<?php
/*
Modelo para el login en codeigniter

*/
class Login_model extends CI_Model
{
	public function login_usr($usr, $pass)
	{
		$this->db->where('nombre_usuario', $usr);
		$this->db->where('pass_usuario', $pass);
		$q = $this->db->get('usuarios');
		if($q->num_rows() == 1)
		{
			return $q->row();
		}
		else
		{
			$this->session->set_flashdata('usuario_incorrecto', 'Datos erroneos!');
			redirect(base_url().'login', 'refresh');
		}
	}
}
