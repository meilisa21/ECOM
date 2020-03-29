<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends MX_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('login_m');
		$this->load->library(array('form_validation', 'session'));
		$this->load->helper('url');
	}


	function index()
	{
		if ($this->login_m->cek_session()) {
			redirect(base_url("admin/dashboard"));
		} else {
			$this->load->view('login_v');
			$this->load->helper('url');
		}
	}

	function verif_login()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$where = array(
			'username' => $username,
			'password' => md5($password)
		);
		$cek = $this->login_m->cek_login("users", $where)->num_rows();
		if ($cek > 0) {
			$this->session->set_userdata('username', $username);

			redirect(base_url("admin/dashboard"));
			$this->session->set_flashdata('success', 'Login sukses');
		} else {
			$this->session->set_flashdata('login_failed', '<div class = "alert alert-danger"> Username atau Password salah !</div>');
			redirect(base_url('login'));
		}
	}

	

	function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url('login'));
	}

	public function cekLogin()
	{
		if (isset($_SESSION['username'])) {
			return true;
		}
	}
}
