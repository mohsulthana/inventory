<?php
class M_petugas extends CI_Model {
	
	var $tbl='petugas';
	
	public function ubah($where,$set)
	{
		$cek=$this->db->get_where($this->tbl,$where)->num_rows();
		if ($cek > 0) {
			$where_id['id_petugas']=$this->session->id_petugas;
			$this->db
			->where($where_id)
			->set($set)
			->update($this->tbl);
			$this->berhasil('Berhasil diubah !');
		}else{
			$this->gagal('Password Tidak Cocok !');
		}

	}
	public function get_num_rows()
	{

	$select=array('l.nama_level,count(petugas.id_level) as count');
	$return=$this->db
	->select('count(petugas.id_level) as count, nama_level')
		->join('level l','l.id_level='.$this->tbl.'.id_level','INNER')
		->group_by('petugas.id_level')
		->get($this->tbl);
	foreach ($return->result() as $key => $value) {
		$back[$value->nama_level]=$value->count;
	}
	
	return $back;


	}
	public function masuk($where)
	{
		$if=$this->db
		->select('*')
		->where($where)
		->join('level l','l.id_level='.$this->tbl.'.id_level','INNER')
		->get($this->tbl);

		if ($if->num_rows() > 0) {
		$row=$if->row();
		$arr=array(
			'level' => $row->nama_level,
			'id_pegawai' => $row->id_pegawai,
			'id_petugas' => $row->id_petugas,	
			'status' => 'logged in',
		);
		$this->session->set_userdata($arr);	
		$return=$row->nama_level;
		}else{
		$this->gagal('Username atau Password Salah!');
		$return='';
		}
		return $return;
	}
	public function tambah($value='')
	{
		$this->db->insert($this->tbl, $value);
	}

	public function update($value,$where)
	{
		$this->db
		->where($where)
		->set($value)
		->update($this->tbl);
	}
	private function gagal($text='')
	{
		$this->session->set_flashdata('pesan', '
                            <div class="alert alert-danger alert-dismissible alert-mg-b-0" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true"><i class="notika-icon notika-close"></i></span></button>'.$text.'
                            </div>');
	}
	private function berhasil($text='')
	{
		$this->session->set_flashdata('pesan', '
                            <div class="alert alert-success alert-dismissible alert-mg-b-0" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true"><i class="notika-icon notika-close"></i></span></button>'.$text.'
                            </div>');
	}
	

}

/* End of file m_petugas.php */
/* Location: ./application/models/m_petugas.php */ 