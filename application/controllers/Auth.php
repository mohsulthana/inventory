<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Auth extends MY_Controller {

	public function __construct()
	{
	  parent::__construct();
		$this->load->model('M_petugas');

	}

	public function index()
	{
		$this->load->view('login');
	}

	public function masuk()
	{
		$where=array(
			'petugas.username' =>$this->input->post('username'),
			'petugas.password' =>sha1($this->input->post('password'))
		);

		$if=$this->M_petugas->masuk($where);

		if ($if=='operator') {
			redirect('Operator/peminjaman');
		}else if($if == 'admin') {
			redirect('Admin');
		}else if($if=='peminjam') {
			redirect('Peminjam/peminjaman');

		}else{
			redirect('Auth');
		}

	}
	public function keluar(){
		session_destroy();
		redirect('Auth');
	}

	public function no_page()
	{
		$data['title']				= '404 Page Not Found';
		$this->load->template('backend/404', $data);
	}
}
?>