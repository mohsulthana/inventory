<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if (!isset($this->session->level) || $this->session->level != 'admin') {
			redirect('Auth');
		}
		$this->load->model('M_barang','m_barang');
		$this->load->model('M_pegawai','m_pegawai');
		$this->load->model('M_petugas','m_petugas');
	}
	public function index()
	{
		$data['title']='Dashboard';
		$data['barang']=$this->m_barang->get_num_rows();
		$data['petugas']=$this->db->get('petugas')->num_rows();
		$data['customer']=$this->db->get('customer')->num_rows();
		$data['chart']=$this->m_barang->get_chart();
		$this->load->template('backend/dashboard', $data);
	}

	public function pegawai()
	{
		$data['pegawai']=$this->m_pegawai->get();
		$data['level']=$this->db->get('level');
		
		$data['title']='Pegawai';
		$this->load->template('backend/pegawai', $data);
	}
	public function barang()
	{
		$data['title']='Barang';
		$data['supplier']=$this->m_barang->get_supplier();
		$data['barang']=$this->m_barang->get();
		$data['jenis']=$this->db->get('jenis');
		$data['ruang']=$this->db->get('ruang');
		$this->load->template('backend/barang', $data, FALSE);

	
	}
	public function supplier()
	{
		$data['title']='Supplier';
		$data['barang']=$this->m_barang->get_supplier();
		$this->load->template('backend/supplier', $data, FALSE);

	}
		public function customer()
	{
		$data['title']='Customer';
		$data['pegawai']=$this->m_pegawai->get_customer();
		$this->load->template('backend/customer', $data);
	}

	public function ruangan()
	{
		$data['ruang']=$this->db->order_by('kode_ruang','DESC')->get('ruang');
		$data['title']='Kelola Ruangan';
		$this->load->template('backend/ruangan', $data);

	
	}
	public function peminjaman()
	{	
		$data['customer']=$this->m_pegawai->get_customer();
		$data['pegawai']=$this->m_pegawai->get();
		$data['pinjam']=$this->m_barang->get_pinjam();
		$data['barang']=$this->m_barang->get();
		$data['title']='Peminjaman';
		$this->load->template('backend/peminjaman', $data);
	}
	public function jenis()
	{
		$data['jenis']=$this->db->order_by('kode_jenis','DESC')->get('jenis');
		$data['title']='Kelola Jenis';
		$this->load->template('backend/jenis', $data);
	
	}
	public function pengembalian()
	{
		$data['title']='Pengembalian';
		$this->load->template('backend/pengembalian', $data);
	}
	public function laporan($value='')
	{	$data['date']=$value;
		$data['title']='Laporan';
		$data['barang']=$this->m_barang->get($value);
		$data['peminjaman']=$this->m_barang->get_laporan($value);
		$this->load->template('backend/laporan', $data);
		
	}
	public function request($value='')
	{
		$data['title']='Request';
		$data['pinjam']=$this->m_barang->get_request($value);
		$this->load->template('backend/request', $data);


	}
	public function setting($value='')
	{
		$data['title']='Setting';
		$cek_jml=$this->db->get('setting');
		if ($cek_jml->num_rows()>0) {
			$data['denda']=$cek_jml->row()->denda;
		}else{
			$data['denda']=0;
		}
		$this->load->template('backend/setting', $data);
	}
}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */ ?>