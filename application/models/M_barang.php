<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_barang extends CI_Model {
	var $tbl_ruang = 'ruang'; 
	var $tbl_jenis = 'jenis'; 
	var $tbl = 'inventaris'; 
	var $tbl_peminjam = 'peminjaman';
	var $tbl_detail_peminjam = 'detail_peminjaman';
	public function get_supplier()
	{
		return $this->db->get('supplier');
	}
	public function tambah_supply($tbl,$insert,$cek='')
	{
		$this->db->insert($tbl, $insert);
		if ($cek!='') {
			$this->tambah_qty_all($insert['jumlah'],$insert['id_inventaris']);
			$this->tambah_qty($insert['jumlah'],$insert['id_inventaris']);
			$this->berhasil();
		}
	}

	public function cek_qty($value='')
	{
		$cek= $this->db->get_where($this->tbl, $value)->num_rows();
		if ($cek < 1 ) {
			$this->warning();
		}
		return $cek;

	}
	private function get_kode($tbl,$select,$order,$awal){
		$cek= $this->db->select($select.' as kode ')
		->order_by($order,'DESC')
		->limit(1)
		->get($tbl);
		if ($cek->num_rows() > 0) {
			# telah tersedia
			$row=str_replace($awal,"", $cek->row()->kode);
			$kode=(int)$row+1;
		}else{
			#belum tersedia
			$kode=1;


		}
		$bts=str_pad($kode,5,"0",STR_PAD_LEFT);
		return $awal.$bts;


	}
	public function get_num_rows($value='')
	{
		$return= $this->db
		->select('sum(jumlah) as jumlah,kondisi')
		->group_by('kondisi')
		->get('inventaris');
		$data['ttl']=0;
		foreach ($return->result() as $key => $value) {
			$data['ttl']+=$value->jumlah;
			$data[$value->kondisi]=$value->jumlah;
		}
		$each=$this->db
		->select('rusak as rusak')
		->order_by('rusak','DESC')
		->get('detail_peminjaman')->result();
		$data['sekarang']=0;
		foreach ($each as $key => $value) {
			$data['sekarang']+=$value->rusak;
		}
		return $data;
	}
	public function tambah_detail($value='')
	{
		$this->db->insert($this->tbl_detail_peminjam, $value);
		
		if ($this->session->level=='admin' || $this->session->level=='operator' ) {
		$this->kurang_barang($value['jumlah'],$value['id_inventaris']);
		}
		return $this->db->insert_id();
	
	}
	public function tambah_peminjam($value)
	{
		$this->db->insert($this->tbl_peminjam, $value);
		$this->berhasil();
		return $this->db->insert_id();

	}

	private function kurang_barang($kurang,$where)
	{

		$update='UPDATE inventaris SET jumlah = jumlah - ? WHERE id_inventaris = ?';
		$this->db->query($update,array($kurang,$where));

	}
	public function tambah_qty($tambah,$where)
	{
		$update='UPDATE inventaris SET jumlah = jumlah + ? WHERE id_inventaris = ?';
		$this->db->query($update,array($tambah,$where));

	}
	public function tambah_qty_all($tambah,$where)
	{

		$update='UPDATE inventaris SET jumlah_all = jumlah_all + ? WHERE id_inventaris = ?';
		$this->db->query($update,array($tambah,$where));

	}


	public function get_request($value='')
	{
		$select=array('pegawai.nama_pegawai','nama_inventaris');
		$this->db
		->join('pegawai','pegawai.id_pegawai=peminjaman.id_pegawai');
		if ($value !='') {
		$this->db->where('peminjaman.id_peminjaman', $value);
		}
		$return=$this->db->get($this->tbl_peminjam);
		return $return;

	}
	public function get_notif($value='')
	{
		$return=$this->db
		->join('pegawai','pegawai.id_pegawai=peminjaman.id_pegawai')
		->where('peminjaman.status_peminjaman','REQUESTED')
		->get($this->tbl_peminjam);
		return $return;

	}

	public function get_chart($value='')
	{
		$select=array('COUNT(distinct peminjaman.id_peminjaman) as jumlah, peminjaman.tanggal_pinjam as bulan');
		$return=$this->db
		->select($select)
		->join('pegawai','pegawai.id_pegawai=peminjaman.id_pegawai')
		->group_by('YEAR(tanggal_pinjam),MONTH(tanggal_pinjam)')
		->get($this->tbl_peminjam);
		$this->load->library('chart');
		$bulan=$this->chart->get_chart();
		for ($i=0; $i <=12; $i++) { 
					
					$cek=false;

				foreach ($return->result() as $key => $value) {
				if (date('F Y',strtotime($value->bulan))==$bulan[$i]) {

					$data['jumlah'][$i]=$value->jumlah;
					$data['bulan'][$i]=$bulan[$i];
					$cek=true;

				}
				}
				if ($cek== false) {
					$data['jumlah'][$i]=0;
					$data['bulan'][$i]=$bulan[$i];
										
				}

			}
			$data['last']=count($data['bulan']);
		return $data;

	}

	public function get_pengembalian($where)
	{
		$select=array('inventaris.nama','ruang.nama_ruang','peminjaman.kode_pinjam','detail_peminjaman.*','peminjaman.tanggal_pinjam','peminjaman.tanggal_kembali','peminjaman.status_peminjaman','pegawai.nama_pegawai','peminjaman.end','peminjaman.start','peminjaman.outstanding_barang');

		$return=$this->db
		->select($select)
		->join('detail_peminjaman','detail_peminjaman.id_peminjaman=peminjaman.id_peminjaman','inner')
		->join('inventaris','inventaris.id_inventaris=detail_peminjaman.id_inventaris','LEFT')
		->join('pegawai','pegawai.id_pegawai=peminjaman.id_pegawai','LEFT')
		->join('ruang','ruang.id_ruang=inventaris.id_ruang','LEFT')
		->where('peminjaman.status_peminjaman !=', 'RETURNED')
		->where($where)
		->group_by('detail_peminjaman.id_detail_peminjaman')
		->get($this->tbl_peminjam);
		return $return;
	}

	 public function get_laporan($where)
	{
		$select=array('inventaris.nama','inventaris.kode_inventaris','peminjaman.kode_pinjam','peminjaman.outstanding_barang','detail_peminjaman.*','pegawai.nama_pegawai','peminjaman.*','pegawai.id_pegawai','petugas.nama_petugas','customer.nama_customer');

		$this->db
		->select($select)
		->join('customer','customer.id_customer=peminjaman.id_customer','LEFT')
		->join('petugas','petugas.id_petugas=peminjaman.id_petugas','LEFT')
		->join('detail_peminjaman','detail_peminjaman.id_peminjaman=peminjaman.id_peminjaman','inner')
		->join('inventaris','inventaris.id_inventaris=detail_peminjaman.id_inventaris','LEFT')
		->join('pegawai','pegawai.id_pegawai=peminjaman.id_pegawai','LEFT')
		->group_by('detail_peminjaman.id_detail_peminjaman');
		if ($where != '') {

		$array_tanggal=explode('_', $where);
		$array_per_1=explode('-',$array_tanggal[0]);
		$array_per_2=explode('-',$array_tanggal[1]);
		$start=str_replace(' ','',$array_per_1[2].'-'.$array_per_1[0].'-'.$array_per_1[1]);
		$end=str_replace(' ','',$array_per_2[2].'-'.$array_per_2[0].'-'.$array_per_2[1]);
		$this->db->where('cast(peminjaman.tanggal_pinjam AS DATE) >=',$start);
		$this->db->where('cast(peminjaman.tanggal_pinjam AS DATE) <=',$end);
			
		}
		$return =$this->db->get($this->tbl_peminjam);
		return $return;
	}

	public function get_pinjam_detail($value='')
	{
		$select=array('inventaris.nama','peminjaman.kode_pinjam','detail_peminjaman.*','peminjaman.tanggal_pinjam','peminjaman.tanggal_kembali','peminjaman.status_peminjaman','pegawai.id_pegawai','pegawai.nama_pegawai','petugas.nama_petugas');

		$this->db
		->select($select)
		->join('petugas','petugas.id_petugas=peminjaman.id_petugas','LEFT')
		->join('detail_peminjaman','detail_peminjaman.id_peminjaman=peminjaman.id_peminjaman','inner')
		->join('inventaris','inventaris.id_inventaris=detail_peminjaman.id_inventaris','LEFT')
		->join('pegawai','pegawai.id_pegawai=peminjaman.id_pegawai','LEFT');
		if ($value!='') {
			$this->db->where('peminjaman.id_peminjaman',$value);
		}
		$return=$this->db->get($this->tbl_peminjam);
		return $return;
	}
	public function get_pinjam($value='')
	{
		$select=array('inventaris.nama', 'peminjaman.outstanding_barang','peminjaman.kode_pinjam','detail_peminjaman.*','peminjaman.tanggal_pinjam','peminjaman.tanggal_kembali','peminjaman.status_peminjaman','pegawai.id_pegawai','pegawai.nama_pegawai','petugas.nama_petugas','peminjaman.denda','peminjaman.start','peminjaman.end');

		$this->db
		->select($select)
		->join('petugas','petugas.id_petugas=peminjaman.id_petugas','LEFT')
		->join('detail_peminjaman','detail_peminjaman.id_peminjaman=peminjaman.id_peminjaman','inner')
		->join('inventaris','inventaris.id_inventaris=detail_peminjaman.id_inventaris','LEFT')
		->join('pegawai','pegawai.id_pegawai=peminjaman.id_pegawai','LEFT')
		->group_by('peminjaman.id_peminjaman')
		->order_by('peminjaman.id_peminjaman','DESC');
		if ($value!='') {
			$this->db->where('peminjaman.id_peminjaman',$value);
		}
		$return=$this->db->get($this->tbl_peminjam);
		return $return;
	}
	public function get_pinjam_peminjam($value='')
	{
		$select=array('inventaris.nama','peminjaman.*','detail_peminjaman.*','pegawai.id_pegawai','pegawai.nama_pegawai','petugas.nama_petugas','customer.*');

		$this->db
		->select($select)
		->join('customer','customer.id_customer=peminjaman.id_customer','LEFT')
		->join('petugas','petugas.id_petugas=peminjaman.id_petugas','LEFT')
		->join('detail_peminjaman','detail_peminjaman.id_peminjaman=peminjaman.id_peminjaman','inner')
		->join('inventaris','inventaris.id_inventaris=detail_peminjaman.id_inventaris','LEFT')
		->join('pegawai','pegawai.id_pegawai=peminjaman.id_pegawai','LEFT')
		->where('pegawai.id_pegawai',$this->session->id_pegawai)
		->group_by('peminjaman.id_peminjaman');
		if ($value!='') {
			$this->db->where('peminjaman.id_peminjaman',$value);
		}
		$return=$this->db->get($this->tbl_peminjam);
		return $return;
	}
	public function get_pinjam_detail_ruang($value='')
	{
		$this->db
		->join('pegawai','pegawai.id_pegawai=peminjaman.id_pegawai','LEFT')
		->join('customer','customer.id_customer=peminjaman.id_customer','LEFT');
		if ($value!='') {
			$this->db->where('peminjaman.id_peminjaman',$value);
		}
		return $this->db->get('peminjaman')->row();
	}
	public function get($where='')
	{
		$select=array('inventaris.*','ruang.nama_ruang','jenis.nama_jenis','supplier.nama_supplier');

		$this->db
		->select($select)
		->join($this->tbl_jenis,$this->tbl_jenis.'.id_jenis='.$this->tbl.'.id_jenis','INNER')
		->join($this->tbl_ruang,$this->tbl_ruang.'.id_ruang='.$this->tbl.'.id_ruang','INNER')
		->join('detail_supply ds','ds.id_inventaris=inventaris.id_inventaris','LEFT')
		->join('supplier','supplier.id_supplier=ds.id_supplier','LEFT')
		->group_by('inventaris.id_inventaris')
		->order_by('inventaris.kode_inventaris','DESC');
		if ($where != '') {

		$array_tanggal=explode('_', $where);
		$array_per_1=explode('-',$array_tanggal[0]);
		$array_per_2=explode('-',$array_tanggal[1]);
		$start=str_replace(' ','',$array_per_1[2].'-'.$array_per_1[0].'-'.$array_per_1[1]);
		$end=str_replace(' ','',$array_per_2[2].'-'.$array_per_2[0].'-'.$array_per_2[1]);
		$this->db->where('cast(inventaris.tanggal_register AS DATE) >=',$start);
		$this->db->where('cast(inventaris.tanggal_register AS DATE) <=',$end);
			
		}

		$return=$this->db->get($this->tbl);
		return $return;
	}

	public function edit($set,$where)
	{
		$this->db
	->where($where)
	->set($set)
	->update($this->tbl);
	$this->berhasil();

	}

	public function edit_supplier($set,$where)
	{

	$this->db
	->where($where)
	->set($set)
	->update('supplier');
	$this->berhasil();

	}

	public function edit_peminjaman($set,$where)
	{
	
	$this->db
	->where($where)
	->set($set)
	->update($this->tbl_peminjam);
	$this->berhasil();
	$select=array('inventaris.nama','detail_peminjaman.*','ruang.nama_ruang','peminjaman.id_peminjaman');

		$this->db
		->select($select)
		->join('detail_peminjaman','detail_peminjaman.id_peminjaman=peminjaman.id_peminjaman','inner')
		->join('inventaris','inventaris.id_inventaris=detail_peminjaman.id_inventaris','LEFT')
		->group_by('detail_peminjaman.id_detail_peminjaman')
		->join('ruang','ruang.id_ruang=inventaris.id_ruang','LEFT');
		if (isset($where['id_peminjaman'])) {
			$this->db->where('peminjaman.id_peminjaman',$where['id_peminjaman']);
			# code...
		}
	return $return=$this->db->get($this->tbl_peminjam);

	}
	public function edit_detail($set,$where)
	{
	$this->db
	->where('id_peminjaman', $where)
	->set($set)
	->update($this->tbl_detail_peminjam);
	
	$this->berhasil();

	}
	public function edit_detail_peminjaman($set,$where)
	{
	
	$this->db
	->where($where)
	->set($set)
	->update($this->tbl_detail_peminjam);
	$this->kurang_barang($set['jumlah'],$set['id_inventaris']);
	
	$this->berhasil();

	}
	public function edit_ruangan($set,$where)
	{
		$this->db
	->where($where)
	->set($set)
	->update($this->tbl_ruang);
	$this->berhasil();

	}
	public function edit_jenis($set,$where)
	{
		$this->db
	->where($where)
	->set($set)
	->update($this->tbl_jenis);
	$this->berhasil();

	}
	public function tambah_ruangan($insert)
	{
	$insert['kode_ruang']=$this->get_kode('ruang','kode_ruang','id_ruang','RNG');
	
	$this->db->insert($this->tbl_ruang,$insert);
	$this->berhasil();
	
	

	}
	public function tambah_supplier($insert)
	{
		$this->db->insert('supplier', $insert);
	}

	public function tambah($insert)
	{

	$insert['kode_inventaris']=$this->get_kode('inventaris','kode_inventaris','id_inventaris','INV');
	
	
	$this->db->insert($this->tbl,$insert);
	return $this->db->insert_id();
	$this->berhasil();
	
	

	}

	public function tambah_jenis($insert,$if)
	{

	$if=$this->db->get_where($this->tbl_jenis,$if)->num_rows();
	$insert['kode_jenis']=$this->get_kode('jenis','kode_jenis','id_jenis','JNS');
	
	if ($if < 1) {
	
	$this->db->insert($this->tbl_jenis,$insert);
	$this->berhasil();
	
	}else{
	$this->sudah_ada();
	}
	

	}

	public function get_edit($where)
	{
		return $this->db->get_where($this->tbl,$where);
	}
	public function get_edit_supplier($where)
	{
		return $this->db->get_where('supplier',$where);
	}
	public function get_edit_ruangan($where)
	{
		return $this->db->get_where($this->tbl_ruang,$where);
	}
	public function get_detail_pinjaman($value='')
	{
		$select=array('inventaris.nama','inventaris.kode_inventaris','detail_peminjaman.*','ruang.nama_ruang','peminjaman.id_peminjaman');

		$return=$this->db
		->select($select)
		->join('detail_peminjaman','detail_peminjaman.id_peminjaman=peminjaman.id_peminjaman','inner')
		->join('inventaris','inventaris.id_inventaris=detail_peminjaman.id_inventaris','LEFT')
		->group_by('detail_peminjaman.id_detail_peminjaman')
		->join('ruang','ruang.id_ruang=inventaris.id_ruang','LEFT')
		->where('peminjaman.id_peminjaman',$value)
		->get($this->tbl_peminjam);
		return $return;
	}

	public function get_edit_detail($where)
	{
		return $this->db->get_where($this->tbl_detail_peminjam,$where);
	}


	public function get_edit_jenis($where)
	{
		return $this->db->get_where($this->tbl_jenis,$where);
	}
	public function hapus_ruangan($value)
	{
		$cek=$this->db->get_where($this->tbl,$value)->num_rows();
		if ($cek < 1) {
		
		$if=$this->db->delete($this->tbl_ruang,$value);
		if ($if) {
			$this->berhasil();
		}else{
			$this->sudah_ada();
		}

		}else{
			$this->warning();
		}
	}
	public function hapus_detail($value)
	{
		$if=$this->db->delete($this->tbl_detail_peminjam,$value);
		$if=$this->db->delete($this->tbl_peminjam,$value);
		if ($if) {
			$this->berhasil();
		}else{
			$this->sudah_ada();
		}
	}
	public function hapus_supplier($value)
	{
		$if=$this->db->delete('supplier',$value);
		if ($if) {
			$this->berhasil();
		}else{
			$this->sudah_ada();
		}
	}
	public function hapus($value)
	{
		$if=$this->db->delete('detail_peminjaman',$value);
		$if=$this->db->delete($this->tbl,$value);
		if ($if) {
			$this->berhasil();
		}else{
			$this->sudah_ada();
		}
	}
	public function hapus_jenis($value)
	{

		$cek=$this->db->get_where($this->tbl,$value)->num_rows();
		if ($cek < 1) {
		$if=$this->db->delete($this->tbl_jenis,$value);
		if ($if) {
			$this->berhasil();
		}else{
			$this->sudah_ada();
		}
		
		}else{
			$this->warning();
		}
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

	private function warning()
	{
		$this->session->set_flashdata('pesan', '
	                            <div class="alert alert-warning alert-dismissible alert-mg-b-0" role="alert">
	                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true"><i class="notika-icon notika-close"></i></span></button>Error!
	                            </div>');	
	}
}

/* End of file m_barang.php */
/* Location: ./application/models/m_barang.php */ ?>