<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Peminjam extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if ( !isset($this->session->level) || $this->session->level != 'peminjam') {
			
			redirect('auth','refresh');

		}
		$this->load->model('M_barang','m_barang');
		$this->load->model('M_petugas','m_petugas');
		$this->load->model('M_pegawai','m_pegawai');

	}

	public function peminjaman(){
		$data['customer']=$this->m_pegawai->get_customer();
		$data['pinjam']=$this->m_barang->get_pinjam_peminjam();
		$data['barang']=$this->m_barang->get();
		$data['title']='Peminjaman';
		$this->load->view('backend/layouts/header', $data);
		$this->load->view('backend/layouts/navbar', $data);
		$this->load->view('backend/layouts/peminjam_sidebar', $data);
		$this->load->view('backend/peminjaman', $data);
		$this->load->view('backend/layouts/footer', $data);
	}
	
	public function setting($value='')
	{
		$data['title']='Setting';
		$this->load->view('backend/layouts/header', $data);
		$this->load->view('backend/layouts/navbar', $data);
		$this->load->view('backend/layouts/peminjam_sidebar', $data);
		$this->load->view('backend/setting', $data);
		$this->load->view('backend/layouts/footer', $data);
	}


}

/* End of file peminjam.php */
/* Location: ./application/controllers/peminjam.php */ ?>