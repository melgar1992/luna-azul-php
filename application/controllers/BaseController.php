<?php
defined('BASEPATH') or exit('No direct script access allowed');

class BaseController extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
	}


	public function loadView($pagina, $url, $data = [])
	{

		$data['pagina'] = $pagina;
		$this->load->view('template/header');
		$this->load->view('template/sidebar');
		$this->load->view($url, $data);
		$this->load->view('template/footer');
	}
	public function login_process()
	{
		$username = $this->input->post("username");
		$password = $this->input->post("password");

		//$res = $this->Usuario_model->login($username, sha1($password));
		$res = $this->Usuario_model->login($username, $password);
		if (!$res) {
			$this->session->set_flashdata("error", "El usuario y/o contraseña son incorrectos");
			redirect(base_url());
		} else {

			$data = array(
				'id_usuario' => $res->id_usuarios,
				'nombres' => $res->nombres,
				'permisos' => array(
				),
				'login' => true,
			);
			$this->session->set_userdata($data);
			redirect(base_url() . '');
		}
	}
	public function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url());
	}
}
