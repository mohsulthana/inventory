<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_pegawai extends CI_Model {
var $tbl='pegawai';
var $select=array('p.nama_petugas','l.nama_level as level','l.id_level','pegawai.*');
public function tambah($insert,$if)
{
	$if=$this->db->get_where($this->tbl,$if)->num_rows();
	
	if ($if < 1) {
	
	
	$this->db->insert($this->tbl,$insert);
	$insert=$this->db->insert_id();	
	$this->berhasil();
	
	}else{
	$insert='';
	$this->sudah_ada();
	}
	return $insert;
}
public function delete_customer($where)
{

	$query2="DELETE dp FROM peminjaman ,detail_peminjaman as dp WHERE dp.id_peminjaman = peminjaman.id_peminjaman AND  peminjaman.id_customer= ? ";
	$this->db->query($query2,array($where['id_customer']));
	$this->db->delete('peminjaman',$where);
	$this->db->delete('customer',$where);
	$this->berhasil();
}
public function hapus($value)
{	
	// $this->db->delete('petugas',$value)
	// ->join('inventaris i','i.id_petugas=petugas.id_petugas')
	// ->join('detail_peminjaman d','d.id_inventaris ');

	$query2="DELETE peminjaman,dp FROM peminjaman LEFT JOIN detail_peminjaman as dp ON dp.id_peminjaman = peminjaman.id_peminjaman WHERE peminjaman.id_pegawai= ? ";
	$this->db->query($query2,array($value));
	$query="DELETE inventaris,dp FROM petugas  INNER JOIN inventaris ON inventaris.id_petugas=petugas.id_petugas INNER JOIN detail_peminjaman as dp ON dp.id_inventaris=inventaris.id_inventaris  WHERE petugas.id_pegawai= ? ";
	$query3="DELETE petugas,pegawai FROM petugas  INNER JOIN pegawai ON pegawai.id_pegawai=petugas.id_pegawai  WHERE petugas.id_pegawai= ? ";


	$this->db->query($query,array($value));
	$this->db->query($query3,array($value));
}
public function update($set,$where)
{
	$this->db
	->where($where)
	->set($set)
	->update($this->tbl);
	$this->berhasil();

}

public function get_customer()
{
	
	$return=$this->db->get_where('customer');

	return $return;


}
public function get()
{
	
	$return=$this->db
	->select($this->select)
	->join('petugas p','p.id_pegawai='.$this->tbl.'.id_pegawai','INNER')
	->join('level l','l.id_level=p.id_level','INNER')
	->get($this->tbl);

	return $return;


}
public function get_edit_customer($where)
{
	return $this->db->get_where('customer',$where)->row();
}
public function get_edit($where)
{
	
	$return=$this->db
	->select($this->select)
	->join('petugas p','p.id_pegawai='.$this->tbl.'.id_pegawai','	INNER')
	->join('level l','l.id_level=p.id_level','INNER')
	->where($where)
	->get($this->tbl)->row();

	return $return;


}
private function sudah_ada()
{
	$this->session->set_flashdata('pesan', '
                            <div class="alert alert-danger alert-dismissible alert-mg-b-0" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true"><i class="notika-icon notika-close"></i></span></button>Gagal!
                            </div>');	
}

private function berhasil()
{
	$this->session->set_flashdata('pesan', '
                            <div class="alert alert-success alert-dismissible alert-mg-b-0" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true"><i class="notika-icon notika-close"></i></span></button>Berhasil!
                            </div>');	
}
	

}

/* End of file m_pegawai.php */
/* Location: ./application/models/m_pegawai.php */ ?>