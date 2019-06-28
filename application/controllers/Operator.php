<?php
// defined('BASEPATH') OR exit('No direct script access allowed');

// class Operator extends CI_Controller {
// public function __construct()
// 	{
// 		parent::__construct();
// 		if ( !isset($this->session->level) || $this->session->level != 'operator') {
			
// 			redirect('Auth','refresh');

// 		}
// 		$this->load->model('M_barang','m_barang');
// 		$this->load->model('M_pegawai','m_pegawai');
// 		$this->load->model('M_petugas','m_petugas');

// 	}

// 	public function  peminjaman(){
// 		$data['pegawai']=$this->m_pegawai->get();
// 		$data['pinjam']=$this->m_barang->get_pinjam();
// 		$data['barang']=$this->m_barang->get();
// 		$data['title']='Peminjaman';
// 		$this->load->view('operator/header',$data);
// 		$this->load->view('comp/pinjam',$data);
// 		$this->load->view('comp/footer');
// 	}
	
// 	public function pengembalian()
// 	{ 
// 		$data['title']='Pengembalian';
// 		$this->load->view('operator/header',$data);
// 		$this->load->view('comp/pengembalian',$data);
// 		$this->load->view('comp/footer');
// 	}
// 		public function request($value='')
// 	{
// 		$data['title']='Request';
// 		$data['pinjam']=$this->m_barang->get_request($value);
// 		$this->load->view('operator/header',$data);
// 		$this->load->view('comp/request',$data);
// 		$this->load->view('comp/footer');


// 	}
// 	public function setting($value='')
// 	{
// 		$data['title']='Setting';
// 		$this->load->view('operator/header',$data);
// 		$this->load->view('comp/setting',$data);
// 		$this->load->view('comp/footer');
// 	}

	

// }

/* End of file operator.php */
/* Location: ./application/controllers/operator.php */ ?>