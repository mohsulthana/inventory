<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Pegawai extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_pegawai');
		$this->load->model('M_petugas');
	}
	public function tambah_customer($value='')
	{
		$insert=[
			'nama_customer' => $this->input->post('nama'),
			'tlp_customer' => $this->input->post('no'),
			'alamat_customer' => $this->input->post('alamat'),
			'nama_pic' => $this->input->post('pic')
		];
		$this->berhasil();
		$this->db->insert('customer',$insert);
		if ($this->session->level=="admin") {
		redirect('admin/customer','refresh');
		}
	}

	public function edit_customer($value)
	{
		$insert=[
			'nama_customer' => $this->input->post('nama'),
			'tlp_customer' => $this->input->post('no'),
			'alamat_customer' => $this->input->post('alamat'),
			'nama_pic' => $this->input->post('pic')
		];
		$this->berhasil();
		$this->db
		->set($insert)
		->where('id_customer',$value)
		->update('customer',$insert);
		if ($this->session->level=="admin") {
		redirect('admin/customer','refresh');
		}
	}

	public function hapus_customer($value)
	{
		$where['id_customer']=$value;
		$this->M_pegawai->delete_customer($where);
		redirect('Admin/customer');
	
	}
	public function tambah()
	{
		$data=array(
			 	'nama_pegawai' => $this->input->post('nama'),
			 	'nip' => $this->input->post('nip'),
			 	'alamat' => $this->input->post('alamat')
			 );
		$where['nip']=$data['nip'];

		$id_pegawai=$this->M_pegawai->tambah($data,$where);
		
		if ($id_pegawai != '') {
		
		$insert=array(
			 	'id_pegawai' => $id_pegawai,
				'nama_petugas' => $data['nama_pegawai'],
			 	'username' => $data['nip'],
			 	'password' => sha1($data['nama_pegawai']),
			 	'id_level' => $this->input->post('level'),
			);

		$this->M_petugas->tambah($insert);
		
		}

		redirect('Admin/pegawai');

	}
	public function hapus($value)
	{
		$where['id_pegawai']=$value;
		$this->M_pegawai->hapus($where);
		$this->berhasil();
		redirect('Admin/pegawai');
	
	}
	public function edit($value)
	{
		$data=array(
			 	'nama_pegawai' => $this->input->post('nama'),
			 	'nip' => $this->input->post('nip'),
			 	'alamat' => $this->input->post('alamat')
			 );
		$where['id_pegawai']=$value;

		$this->M_pegawai->update($data,$where);
		
		
		$update=array(
				'nama_petugas' => $data['nama_pegawai'],
			 	'username' => $data['nip'],
			 	'password' => sha1($data['nama_pegawai']),
			 	'id_level' => $this->input->post('level'),
		);

		$this->M_petugas->update($update,$where);
		

		redirect('Admin/pegawai');
	}


	private function berhasil()
	{
		$this->session->set_flashdata('pesan', '
	                            <div class="alert alert-success alert-dismissible alert-mg-b-0" role="alert">
	                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true"><i class="notika-icon notika-close"></i></span></button>Berhasil!
	                            </div>');	
	}
	public function get_edit()
	{
		
		$where['pegawai.id_pegawai']=$this->input->post('id');
		$json=$this->M_pegawai->get_edit($where);
		echo json_encode($json);

	}

	public function get_edit_customer()
	{
		$where['customer.id_customer']=$this->input->post('id');
		$json=$this->M_pegawai->get_edit_customer($where);
		echo json_encode($json);
	}
	public function ubah($value='')
	{
		$where = array(
			'password' => sha1($this->input->post('old_pass')),
			'id_petugas' => $this->session->id_petugas,
			 );
		$set=array(
			'password' => sha1($this->input->post('new_pass')),
		);
		$this->M_petugas->ubah($where,$set);
		if ($this->session->level == 'admin'){
			$this->session->set_flashdata('pesan', 'Password berhasil diubah');
		redirect('Admin/setting','refresh');
		}elseif($this->session->level=='operator'){
			$this->session->set_flashdata('pesan', 'Password berhasil diubah');
		redirect('Operator/setting');
		}elseif($this->session->level=='peminjam'){
			$this->session->set_flashdata('pesan', 'Password berhasil diubah');
		redirect('Peminjam/setting');
		}

	}
	

}