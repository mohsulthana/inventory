<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Barang extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_barang');
		$this->load->model('M_pegawai');
		$this->load->library('Excel');
		if (!isset($this->session->level) || !isset($this->session->status)) {
			
			redirect('Auth');

		}
	}
	public function approve($value)
	{
		$array =$this->input->post('id');
		$jml =$this->input->post('qty');
		$inventaris=$this->input->post('id_inventaris');
		$update_peminjaman = array(
			'id_petugas' => $this->session->id_petugas,
			'status_peminjaman' => 'APPROVED',
			 );
		$where_id['id_peminjaman']=$value;
		$this->M_barang->edit_peminjaman($update_peminjaman,$where_id);
		foreach ($array as $key => $value) {

			$update = array(
			'id_inventaris' => $inventaris[$key],
			'jumlah' => $jml[$key], 
			);
			$if=$this->M_barang->cek_qty($update);
			if ($if < 1) {
			$where['id_detail_peminjaman']=$value;
			$this->M_barang->edit_detail_peminjaman($update,$where);
			}

		}
		
		if($this->session->level=='admin'){
		redirect('Admin/request','refresh');
		}elseif ($this->session->level=='operator') {
		redirect('Operator/request','refresh');
		}
	}
	public function get_approve($value)
	{	
		$cek=$this->db->get('peminjaman',['id_peminjaman'=> $value])->row();
		$peminjaman=$this->M_barang->get_pinjam_detail($value);
		$list='<div class="bsc-tbl-hvr">
							<label> Dari - Sampai : '.date('Y / F / d ',strtotime($cek->start)).' - '.date('Y / F / d ',strtotime($cek->end)).'</label>
                            <table class="table table-hover text-center">
                                       <thead>
                                    <tr>
                                        <th width="10px">No.</th>
                                        <th>Nama Barang</th>
                                        <th>Qty</th>
                                    </tr>
                                </thead>
                                <tbody class="list-detail">';
        $no=1;
        foreach ($peminjaman->result() as $key => $value) {
        $option='<div class="form-group float-lb floating-lb"><div class="nk-int-st" ><input type="hidden" value="'.$value->id_inventaris.'" name="id_inventaris[]"><input type="hidden" name="id[]" value="'.$value->id_detail_peminjaman.'"><select required="" name="qty[]" class="form-control" ><option></option>';
       	for ($i=0; $i <=$value->jumlah ; $i++) { 
       	$option.='<option value='.$i.'>'.$i.'</option>';
       	}
       	$option.='</select><label class="nk-label">Qty</label></div></div>';
    	$list .= '<tr><td>'.$no++.'</td>
    			<td>'.$value->nama.'</td>
    			<td>'.$option.'</td>
    			</tr>';

        }
        $list.='</tbody></table></div>';
        echo json_encode($list);
	}
	public function peminjaman_print($value)
	{
		$data['detail']=$this->M_barang->get_pinjam_detail_ruang($value);
		$data['peminjaman']=$this->M_barang->get_detail_pinjaman($value);
		$this->pdf->load_view('backend/export_pdf_peminjaman_detail',$data);
		$this->pdf->render();	
		$this->pdf->stream("Laporan peminjaman ".date("Y M d").".pdf");
	}
	public function get_ruang($value)
	{
		$detail=$this->M_barang->get_pinjam_detail_ruang($value);
		$peminjaman=$this->M_barang->get_detail_pinjaman($value);
		$list='
		<div>
		<div style="margin-top:25px;margin-bottom:25px; border-bottom:1px solid black; padding-bottom:20px;" class="text-left">
	
	<table width="100%" ">
		<tr>
			<th style="width:20%; padding:5px;" >Order Ref</th>
			<td style="width:30%; padding:5px;">: '.$detail->other_ref.'</td>
			<th style="width:20%;padding:5px;">Customer</th>
			<td style="width:30%;padding:5px;">: '.$detail->nama_customer.'</td>
		</tr>
		<tr>
			<th style="padding:5px;">Manual Ref</th>
			<td style="padding:5px;">: '.$detail->manual_ref.'</td>
			<th style="padding:5px;">Alamat</th>
			<td style="padding:5px;">: '.$detail->alamat_customer.'</td>
		</tr>
		<tr>
			<th style="padding:5px;">Note</th>
			<td style="padding:5px;">: '.$detail->note.'</td>
			<th style="padding:5px;">Peminjam</th>
			<td style="padding:5px;">: '.$detail->nama_pegawai.'</td>
		</tr >
	</table>

	</div>
		<div class="bsc-tbl-hvr">
			<table class="table table-hover">
				<thead>
					<tr>
						<th width="10px">No.</th>
						<th>Kode Barang</th>
						<th>Nama Barang</th>
						<th>Qty</th>
						<th>Qty Rusak</th>
						<th>Qty Kembali</th>
						<th>Qty Outstanding</th>
						<th>Ruangan</th>
					</tr>
				</thead>
				<tbody>';
        	$no=1;
        	foreach ($peminjaman->result() as $key => $value) {
						$list .= '
						<tr><td><input type="hidden" value="'.$value->id_peminjaman.'" name="id_peminjaman">'.$no++.'</td>
							<td align="left">'.$value->kode_inventaris.'</td>
							<td align="left">'.$value->nama.'</td>
							<td align="left">'.$value->jumlah.'</td>
							<td align="left">'.$value->rusak.'</td>
							<td align="left">'.$value->kembali.'</td>
							<td align="left">'.$value->outsanding_barang.'</td>
							<td align="left">'.$value->nama_ruang.'</td>
						</tr>';
        	}
        	$list.='
				</tbody>
			</table>
		</div>
	</div>
	<div class="modal-footer">
    <a href="'.site_url('barang/peminjaman_print/'.$detail->id_peminjaman).'" class="btn btn-default btn-print ">Print</a>'.($detail->status_peminjaman!="RETURNED" ? '<button class="btn btn-default btn-simpan">Ambil Barang</button>' :'').'
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
  </div>';
	echo json_encode($list);
	}
	
	public function reject($value)
	{	
		$update = array(
			'status_peminjaman' => 'REJECTED',
			'id_petugas' => $this->session->id_petugas,
			 );
		$where['id_peminjaman']=$value;
		$this->M_barang->edit_peminjaman($update,$where);
		
		if($this->session->level=='admin'){
		redirect('admin/request','refresh');
		}
	}
	public function ambil()
	{	
		$update = array(
			'status_peminjaman' => 'TAKEN',
			 );
		$where['id_peminjaman']=$this->input->post('id_peminjaman');
		$this->M_barang->edit_peminjaman($update,$where);
		
		if($this->session->level=='admin'){
		redirect('Admin/peminjaman','refresh');
		}elseif($this->session->level=='operator'){
		redirect('Operator/peminjaman');
		}
		elseif($this->session->level=='peminjam'){
		redirect('Peminjam/peminjaman');
		}
	}
	public function notification()
	{
		$data['list']='';
		$notif=$this->M_barang->get_notif();
		$data['row']=$notif->num_rows();
		if ($data['row'] > 0) {
			# code...
		
		foreach ($notif->result() as $key => $value) {
			$data['list'].='<a href="'.site_url('admin/request/'.$value->id_peminjaman).'">
                                            <div class="hd-message-sn">
                                                
                                                <div class="hd-mg-ctn">
                                                    <h3>'.$value->nama_pegawai.' <span class="badge badge-warning">'.$value->status_peminjaman.'</span></h3>
                                                    <p><small>'.date("d / F / Y",strtotime($value->tanggal_pinjam)).'</small></p>
                                                </div>
                                            </div>
                                        </a>';
			}
		}else {
			$data['list']="<div class='hd-message-sn '><div class='hd-mg-ctn '>No Data</div></div>";
		}
		echo json_encode($data);

	}
	public function peminjaman_export_pdf($value='')
	{

		$data['peminjaman']=$this->M_barang->get_laporan($value);
		$this->pdf->load_view('backend/export_pdf_peminjaman',$data);
		$this->pdf->render();	
		$this->pdf->stream("Laporan peminjaman ".date("Y M d").".pdf");
	}
	public function export_pdf($value='')
	{

		$data['barang']=$this->M_barang->get($value);
		$this->pdf->load_view('backend/export_pdf_barang',$data);
		$this->pdf->render();	
		$this->pdf->stream("Barang ".date("Y M d").".pdf");
	}
	public function peminjaman_export($value='')
	{
			$select = $this->M_barang->get_laporan($value);
        $objPHPExcel=new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(17);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(17);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(17);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(17);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(17);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getStyle(1)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle(2)->getFont()->setBold(true);
        $center = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
         );
        $center = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
        );
        $header = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'font' => array(
                'bold' => true,
                'name' => 'calibri'
            )
        );
        $footer = array(
            
            'font' => array(
                'bold' => true,
                'name' => 'calibri'
            )
        );
        $objPHPExcel->getActiveSheet()->getStyle("A1:J2")
            ->applyFromArray($header)
            ->getFont()->setSize(11);
        $objPHPExcel->getActiveSheet()->mergeCells('A1:S1');
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Laporan Peminjaman Barang'.date('Y F d'))
            ->setCellValue('B2', 'No.')
            ->setCellValue('B2', 'Kode Pinjam')
            ->setCellValue('C2','Other Ref')
            ->setCellValue('D2','Manual Ref')
            ->setCellValue('E2','Customer')
            ->setCellValue('F2','Kode Barang')
            ->setCellValue('G2', 'Nama Barang')
            ->setCellValue('H2', 'Qty')
            ->setCellValue('I2', 'Qty Rusak')
            ->setCellValue('J2', 'Qty Outstanding')
            ->setCellValue('K2', 'Rusak Setelah Pinjam')
            ->setCellValue('L2', 'Peminjam')
            ->setCellValue('M2', 'Petugas')
            ->setCellValue('N2', 'Status')
            ->setCellValue('O2', 'Tanggal Pinjam')
            ->setCellValue('P2', 'Tanggal Kembali')
            ->setCellValue('Q2','Pinjam Dari - Sampai')
            ->setCellValue('R2','Denda')
            ->setCellValue('S2','Note');
        $ex = $objPHPExcel->setActiveSheetIndex(0);
        $no = 1;
        $counter = 3;
        $total=0;
       if ($select->num_rows() > 0) {
        foreach ($select->result() as $row){
            $ex->setCellValue('A'.$counter, $no++);
            $ex->setCellValue('B'.$counter, $row->kode_pinjam);
            $ex->setCellValue('C'.$counter, $row->other_ref);
            $ex->setCellValue('D'.$counter, $row->manual_ref);
            $ex->setCellValue('E'.$counter, $row->nama_customer);
            $ex->setCellValue('F'.$counter, $row->kode_inventaris);
            $ex->setCellValue('G'.$counter, $row->nama);
            $ex->setCellValue('H'.$counter, $row->jumlah);
            $ex->setCellValue('I'.$counter, $row->rusak);
            $ex->setCellValue('J'.$counter, $row->outstanding_barang);
            $ex->setCellValue('K'.$counter, $row->nama_pegawai);
            $ex->setCellValue('L'.$counter, ($row->nama_petugas !='' ? $row->nama_petugas : '-' ));
            $ex->setCellValue('M'.$counter, $row->status_peminjaman);
            $ex->setCellValue('N'.$counter, $row->tanggal_pinjam);
            $ex->setCellValue('O'.$counter, ($row->tanggal_kembali !='' ? $row->tanggal_kembali :'-' ));
            $ex->setCellValue('P'.$counter, $row->start.' - '.$row->end);
            $ex->setCellValue('Q'.$counter, $row->denda);
            $ex->setCellValue('R'.$counter, $row->note);
            $counter++;
        	}
    	}else{
        $objPHPExcel->getActiveSheet()->mergeCells('A'.$counter.':I'.$counter);
        $ex->setCellValue('A'.$counter,'No Data');
        $objPHPExcel->getActiveSheet()->getStyle('A'.$counter,':I'.$counter)->applyFromArray($center);
		}
        $objWriter  = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Laporan Peminjaman '.date('Ymd').'.xlsx"');
        // ob_end_clean();
        $objWriter->save('php://output');
	}
	public function export($value='')
	{
		$select = $this->M_barang->get($value);
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(17);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(17);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(17);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(17);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(17);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getStyle(1)->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle(2)->getFont()->setBold(true);
        $center = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            )
         );
        $header = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ),
            'font' => array(
                'bold' => true,
                'name' => 'calibri'
            )
        );
        $footer = array(
            'font' => array(
                'bold' => true,
                'name' => 'calibri'
            )
        );
        $objPHPExcel->getActiveSheet()->getStyle("A1:H2")
                ->applyFromArray($header)
                ->getFont()->setSize(11);
        $objPHPExcel->getActiveSheet()->mergeCells('A1:H1');
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Laporan Barang '. date('Y F d'))
            ->setCellValue('A2', 'No.')
            ->setCellValue('B2', 'Nama Barang')
            ->setCellValue('C2', 'Kondisi')
            ->setCellValue('D2', 'Qty')
            ->setCellValue('E2', 'Keterangan')
            ->setCellValue('F2', 'Jenis')
            ->setCellValue('G2', 'Ruangan');
        $ex = $objPHPExcel->setActiveSheetIndex(0);
        $no = 1;
        $counter = 3;
        $total=0;
        foreach ($select->result() as $row){
            $ex->setCellValue('A'.$counter, $no++);
            $ex->setCellValue('B'.$counter, $row->nama);
            $ex->setCellValue('C'.$counter, $row->kondisi);
            $ex->setCellValue('D'.$counter, $row->jumlah_all);
            $ex->setCellValue('E'.$counter, $row->keterangan);
            $ex->setCellValue('F'.$counter, $row->nama_jenis);
            $ex->setCellValue('G'.$counter, $row->nama_ruang);
            $counter++;
}
        $objWriter  = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
        // header('Last-Modified:'. gmdate("D, d M Y H:i:s").'GMT');
        // header('Chace-Control: no-store, no-cache, must-revalation');
        // header('Chace-Control: post-check=0, pre-check=0', FALSE);
        // header('Pragma: no-cache');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Barang '.date('Ymd').'.xlsx"');
        // ob_end_clean();
        $objWriter->save('php://output');
	}

	public function edit($value)
	{

		$data=array(
			
			'nama' => $this->input->post('nama'),
			'kondisi' => $this->input->post('kondisi'),
			'keterangan' => $this->input->post('ket'),
			'jumlah' => $this->input->post('qty'),
			'id_ruang' => $this->input->post('ruang'),
			'id_jenis'=> $this->input->post('jenis'),
			'id_petugas'=> $this->session->id_pegawai,
			
			 );
		$where['id_inventaris']=$value;

		$this->M_barang->edit($data,$where);
		

		
		if($this->session->level=='admin'){
		redirect('Admin/barang');
		}
	}

	public function edit_detail($value)
	{
		$tgl=str_replace(' ','', $this->input->post('range'));
        $array_tgl=explode('-', $tgl);
        $start=str_replace('/', '-', $array_tgl[0]);
        $end=str_replace('/', '-', $array_tgl[1]);
		$array=$this->input->post('id_detail');
		$qty=$this->input->post('qty');
		$barang=$this->input->post('nama');
        $update_peminjam=array(
                    'other_ref'=>$this->input->post('other_ref'),
                    'manual_ref' => $this->input->post('manual_ref'),
                    'note' => $this->input->post('note'),
                    'address' => $this->input->post('address'),
                    'start' => $start,
                    'end' => $end,
                    'id_customer' => $this->input->post('customer'),
                );
        $this->db
        ->where(['id_peminjaman'=> $value])
        ->set($update_peminjam)
        ->update('peminjaman');
		foreach ($array as $key => $value) {
		$data=array(
			
			'id_inventaris' => $barang[$key],
			'jumlah'		=> $qty[$key],
			 );
		$where['id_detail_peminjaman']=$value;
		$this->M_barang->edit_detail_peminjaman($data,$where);
		
		}

		
		if($this->session->level=='admin'){
		redirect('admin/peminjaman');
		}elseif($this->session->level=='operator'){
		redirect('operator/peminjaman');
		}elseif($this->session->level=='peminjam'){
		redirect('peminjam/peminjaman');
		}
	}
	public function edit_ruangan($value)
	{

		$data=array(

			'nama_ruang' => $this->input->post('nama'),
			
			 );
		$where['id_ruang']=$value;

		$this->M_barang->edit_ruangan($data,$where);
		

		
		if($this->session->level=='admin'){
		redirect('admin/ruangan');
		}
	}

	public function returned($value)
	{

		$data=array(
			'tanggal_kembali' => date('Y-m-d'),
			'status_peminjaman' =>'RETURNED',
			 );
		$where['id_peminjaman']=$value;

		$array=$this->M_barang->edit_peminjaman($data,$where);
		
		foreach ($array->result() as $key => $value) {
			$update = $value->jumlah;
			$where_inventaris=$value->id_inventaris;
			$this->M_barang->tambah_qty($update,$where_inventaris);
		}
		

		
		if($this->session->level=='admin'){
		redirect('Admin/peminjaman');
		}elseif($this->session->level=='operator'){
		redirect('Operator/peminjaman');
		}
	}
	public function pengembalian()
	{
		$array=$this->input->post('id');
		$id_peminjaman=$this->input->post('id_peminjaman');
		$qty=$this->input->post('qty');
		// $detail=$this->input->post('detail');
		// $details=$this->input->post('details');
		
		$rusak_awal = $this->db->select('rusak')->from('detail_peminjaman')->where('id_peminjaman', $id_peminjaman)->get()->result();
		$rusak_akhir=$this->input->post('rusak');
		$rusak = ($rusak_awal[0]->rusak + $rusak_akhir[0]);

		$kembali_awal = $this->db->select('kembali')->from('detail_peminjaman')->where('id_peminjaman', $id_peminjaman)->get()->result();
		$kembali_akhir=$this->input->post('kembali');
		$kembali = ($kembali_awal[0]->kembali + $kembali_akhir[0]);
		
		foreach ($array as $key => $value) {
			$update = $qty[$key];
			$where_inventaris=$value;
			$edit['kembali']=$kembali;

			$rusak_db = $this->db->select('rusak')->from('detail_peminjaman')->where('id_peminjaman', $id_peminjaman)->get()->result_array();
			$jumlah_db = $this->db->select('jumlah')->from('detail_peminjaman')->where('id_peminjaman', $id_peminjaman)->get()->result_array();

			if ($rusak_db[0]['rusak'] === NULL) {
				$edit['rusak'] = $rusak;
			} else if ($rusak_akhir >= $jumlah_db[0]['jumlah']) {
				$edit['rusak'] = $jumlah_db[0]['jumlah'];				
			}
			$whereid=$id_peminjaman;
			$this->M_barang->tambah_qty($update,$where_inventaris);
			$this->M_barang->edit_detail($edit,$whereid);
		}
		$cek_status = $this->db->select('outstanding_barang')->from('peminjaman')->where('id_peminjaman', $id_peminjaman)->get()->result();
		
		foreach($cek_status as $value) {
			if ($value->outstanding_barang === '0') {
				$data=array(
					'denda'=> $this->input->post('denda'),
					'tanggal_kembali' => date('Y-m-d'),
					'status_peminjaman' =>'RETURNED'
				);
			} else {
				$data=array(
					'denda'=> $this->input->post('denda'),
					'tanggal_kembali' => date('Y-m-d'),
					'status_peminjaman' =>'OUTSTANDING'
				);
			}
		}

		$where['kode_pinjam']=$this->input->post('kode');
		$this->M_barang->edit_peminjaman($data,$where);

		if($this->session->level=='admin'){
		redirect('Admin/pengembalian');
		}
	}
	public function edit_jenis($value)
	{

		$data=array(

			'nama_jenis' => $this->input->post('nama'),
			'keterangan' => $this->input->post('ket'),

			 );
		$where['id_jenis']=$value;
		$this->M_barang->edit_jenis($data,$where);
		
		if($this->session->level=='admin'){
		redirect('Admin/jenis');
		}
	}
	public function get_edit_ruangan()
	{
		$where['id_ruang']=$this->input->post("id");
		$json=$this->M_barang->get_edit_ruangan($where)->row();
		echo json_encode($json);
	}
	public function get_pengembalian()
	{
		$cek_jml=$this->db->get('setting');
		if ($cek_jml->num_rows()>0) {
			$jml_denda=$cek_jml->row()->denda;
		}else{
			$jml_denda=0;
		}
		$where['peminjaman.kode_pinjam']=$this->input->post('code');
		$json=$this->M_barang->get_pengembalian($where);
		$list='';
		$no=1;
		$total=0;
		if ($json->num_rows() < 1) {
			
			$list.='<tr class="text-center"><td colspan="6" class="cek">No Data</td></tr>';
		}else{
			foreach ($json->result() as $key => $value) {
				$start=date_create(date('Y-m-d'));
				$end=date_create(date('Y-m-d',strtotime($value->end)));
				if (strtotime(date('Y-m-d')) > strtotime($value->end)) {
					$diff=date_diff($start,$end);
					$denda=$diff->days;
				}else{
					$denda=0;
				}				
				$option='<div class="form-group float-lb floating-lb"><div class="nk-int-st" ><select required="" name="kembali[]" class="form-control" >';
				$options='<div class="form-group float-lb floating-lb"><div class="nk-int-st" ><select required="" name="rusak[]" class="form-control" >';
				
				if ($value->jumlah !== $value->outstanding_barang) {
					for ($i=0; $i <=$value->outstanding_barang ; $i++) {
						$option.='<option value='.$i.'>'.$i.'</option>';
					}
					for ($i=0; $i <=$value->outstanding_barang ; $i++) {
						$options.='<option value='.$i.'>'.$i.'</option>';
				 	}
				} else {
					for ($i=0; $i <=$value->jumlah ; $i++) {
						$option.='<option value='.$i.'>'.$i.'</option>';
				 	}
				 	for ($i=0; $i <=$value->jumlah ; $i++) {
						$options.='<option value='.$i.'>'.$i.'</option>';
					}
				}
						 $total=$denda*$jml_denda;
						 // $value->id_detail_peminjaman
       			$option.='</select></div></div>';
       			$options.='</select></div></div>';
				$list.='<tr class="order" data-index="2">
											<td>'.$no++.'</td>
						 // $value->id_detail_peminjaman
											<td><input type="hidden" name="id_peminjaman" value="'.$value->id_peminjaman.'">'.$value->nama_pegawai.'</td>
											<td><input type="hidden" name="id[]" value="'.$value->id_inventaris.'">'.$value->nama.'</td>';
											if ($value->jumlah !== $value->outstanding_barang) {
												$list.='<td><input type="hidden" name="qty[]" value="'.$value->outstanding_barang.'">'.$value->outstanding_barang.'</td>';
											} else {
												$list.='<td><input type="hidden" name="qty[]" value="'.$value->jumlah.'">'.$value->jumlah.'</td>';					
											}
				$list.='<td>'.$value->nama_ruang.'</td>
											<td><input type="hidden" name="kembali">'.$option.'</td>
	                    <td><input type="hidden" name="rusak">'.$options.'</td>
	                    <td>'.$denda.' hari X Rp. '. number_format($jml_denda).' = Rp. '.number_format($total).'</td>
	                    </tr>';
			}
			$list.='<tr><b><th colspan="4">Jumlah Denda</th><th colspan="3"><input type="hidden" value="'.$total.'" name="denda">Rp. '.number_format($total).'</th></b></tr>';
		}
		echo json_encode($list);
	}


	public function get_edit_detail()
	{
	    $id=$this->input->post('id');
        $customer=$this->M_pegawai->get_customer();
        $detail=$this->M_barang->get_pinjam_detail_ruang($id);     
				$cust='<input class="form-control" list="customer">
				<datalist data-live-search="true" name="customer" id="customer_edit"><option></option>';
				foreach ($customer->result() as $key => $value) {
            $cust.='<option value="'.$value->id_customer.'" id="customer-'.$value->id_customer.'" data-alamat="'.$value->alamat_customer.'" '.($detail->id_customer==$value->id_customer ? 'selected' : '').'>'. $value->nama_customer.'</option>';
        }
        $cust.='</datalist>';
        $tgl=str_replace('-', '/', $detail->start).' - '.str_replace('-', '/', $detail->end);

		$inventaris=$this->M_barang->get();
		$peminjaman=$this->M_barang->get_pinjam_detail($id);
		$list='
        <div>
            <div style="margin-top:25px;margin-bottom:25px; border-bottom:1px solid black; padding-bottom:20px;" class="text-left">
    
    <table width="100%" >
    <tr>
        <th style="width:20%; padding:5px;" >Order Ref :</th>
        <td style="width:30%;"> <input type="text" class="form-control " value="'.$detail->other_ref.'" name="other_ref"></td>
        <th style="width:20%;padding:5px;">Customer :</th>
        <td style="width:30%;">'.$cust.'</td>
    </tr>
    <tr>
        <th style="padding:5px;">Manual Ref :</th>
        <td style=""><input type="text" class="form-control " value="'.$detail->manual_ref.'" name="manual_ref"></td>
        <th style="padding:5px;">Alamat :</th>
        <td style=""><input type="text" class="form-control " value="'.$detail->alamat_customer.'" name="address" id="address_edit"></td>
    </tr>
    <tr>
        <th style="padding:5px;">Note :</th>
        <td style=""><input type="text" class="form-control " value="'.$detail->note.'" name="note"></td>
        <th style="padding:5px;">Tanggal Pinjam :</th>
        <td style="padding:5px;"> <input type="text" name="range" id="range_pinjam_edit" class="form-control text-center" style="color:#00c292; " autocomplete="false" value="'.$tgl.'"></td>
    </tr >
    

</table>

</div>
        <div class="bsc-tbl-hvr">
                            <table class="table table-hover text-center">
                                       <thead>
                                    <tr>
                                        <th width="10px">No.</th>
                                        <th>Nama Barang</th>
                                        <th>Qty</th>
                                    </tr>
                                </thead>
                                <tbody class="list-detail">';
        $no=1;
        foreach ($peminjaman->result() as $key => $value) {
        $option='<div class="form-group float-lb floating-lb"><div class="nk-int-st" ><input type="number" name="qty[]" value="'.$value->jumlah.'" class="form-control"></div></div>';
        $barang='<div class="form-group float-lb floating-lb"><div class="nk-int-st" >
        <input type="hidden" name="id_detail[]" value="'.$value->id_detail_peminjaman.'" ><input value="'.$value->nama.'" class="form-control" list="nama"><datalist id="nama" required="" name="nama[]"><option></option>';
        foreach ($inventaris->result() as $key_b => $value_b) {
        	$barang .='<option value="'.$value_b->id_inventaris.'" '. ($value->id_inventaris == $value_b->id_inventaris ? 'selected' : '') .'>'.$value_b->nama.'</option>';
        }
        $barang.='</datalist></div></div>';
    	$list .= '<tr><td>'.$no++.'</td>
    			<td>'.$barang.'</td>
    			<td>'.$option.'</td>
    			</tr>';

        }
        $list.='</tbody></table></div></div>
        <div class="modal-footer">
            <button class="btn btn-default btn-simpan">Update</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
        <script>
        $("#customer_edit").on("change",function() {
    address=$("#customer-"+$(this).val()).data("alamat")
    $("#address_edit").val(address)
})
var prev_date = new Date();
$("#range_pinjam_edit").daterangepicker({
    locale:{
        format:"YYYY/MM/DD",
		},
		opens: "right",
    minDate: prev_date,
});
</script>
        ';
        echo json_encode($list);
	
	}
	public function get_edit()
	{
		$where['id_inventaris']=$this->input->post("id");
		$json=$this->M_barang->get_edit($where)->row();
		echo json_encode($json);
	}

	public function get_edit_supplier()
	{
		$where['id_supplier']=$this->input->post("id");
		$json=$this->M_barang->get_edit_supplier($where)->row();
		echo json_encode($json);
	}

	public function get_edit_jenis()
	{
		$where['id_jenis']=$this->input->post("id");
		$json=$this->M_barang->get_edit_jenis($where)->row();
		echo json_encode($json);
	}

	public function tambah_supplier()
	{
		$insert=array(
			'nama_supplier' => $this->input->post('nama'),
			'alamat_supplier' => $this->input->post('alamat'),
			'nm_perusahaan' => $this->input->post('per'),

			);

		$this->M_barang->tambah_supplier($insert);
		
		if($this->session->level=='admin'){
		redirect('Admin/supplier','refresh');
		}
		
	}

	public function edit_supplier($id)
	{
		$insert=array(
			'nama_supplier' => $this->input->post('nama'),
			'alamat_supplier' => $this->input->post('alamat'),
			'nm_perusahaan' => $this->input->post('per'),

			);
		$where['id_supplier']=$id;
		$this->M_barang->edit_supplier($insert,$where);
		
		if($this->session->level=='admin'){
		redirect('Admin/supplier','refresh');
		}
		
	}
	public function tambah()
	{
		$insert=array(
			'nama' => $this->input->post('nama'),
			'kondisi' => $this->input->post('kondisi'),
			'keterangan' => $this->input->post('ket'),
			'jumlah' => $this->input->post('qty'),
			'jumlah_all' => $this->input->post('qty'),
			'tanggal_register' => date('Y-m-d'),
			'id_ruang' => $this->input->post('ruang'),
			'id_jenis'=> $this->input->post('jenis'),
			'id_petugas'=> $this->session->id_petugas,

			);

		$id=$this->M_barang->tambah($insert);
		
		$insert_detail=array(
			'jumlah' =>$insert['jumlah'],
			'id_inventaris' =>$id,
			'id_supplier' => $this->input->post('supplier'),
			'ket' => $insert['keterangan'],
			'kondisi' => $insert['kondisi'],
		);
		$this->M_barang->tambah_supply('detail_supply',$insert_detail);
		
		if($this->session->level=='admin'){
		redirect('Admin/barang','refresh');
		}
		
	}
	public function tambah_ada()
	{
		$insert=array(
			'jumlah' =>$this->input->post('qty'),
			'id_inventaris' =>$this->input->post('barang'),
			'id_supplier' => $this->input->post('supplier'),
			'ket' => $this->input->post('ket'),
			'kondisi' => $this->input->post('kondisi'),
		);
		$this->M_barang->tambah_supply('detail_supply',$insert,'ada');
		redirect('Admin/barang','refresh');
	}
	public function tambah_ruangan()
	{
		$insert=array(
			
			'nama_ruang' => $this->input->post('nama'),
		
		);

		$this->M_barang->tambah_ruangan($insert);
		
		if($this->session->level=='admin'){
		redirect('admin/ruangan','refresh');
		}elseif($this->session->level=='operator'){
		redirect('Operator/');
		}
		
	}
	public function tambah_jenis()
	{
		$insert=array(
			
			'nama_jenis' => $this->input->post('nama'),
			'keterangan' => $this->input->post('ket'),
		
		);
		$where['kode_jenis']=$insert['kode_jenis'];

		$this->M_barang->tambah_jenis($insert,$where);
		
		if($this->session->level=='admin'){
		redirect('Admin/jenis','refresh');
		}
		
	}
	public function pinjam($value='')
	{
		$tgl=str_replace(' ','', $this->input->post('range'));
		$array_tgl=explode('-', $tgl);
		$start=str_replace('/', '-', $array_tgl[0]);
		$end=str_replace('/', '-', $array_tgl[1]);
		$array=$this->input->post("id");
		$array_qty=$this->input->post('jumlah');
		$no=0;
		foreach ($array as $key => $value) {
			$where_qty = array(
				'jumlah >=' => $array_qty[$key] ,
				'id_inventaris'=> $value, );
			$if=$this->M_barang->cek_qty($where_qty);
			if ($if > 0) {
				
				// if ($this->input->post('pegawai')!=null) {
				// $id_p=$this->input->post('pegawai');
				// }else{
				$id_p=$this->session->id_pegawai;
				// }

				 $id_petugas=($this->session->level =="admin" || $this->session->level =="operator" ? $this->session->id_petugas : NULL );
				
				if ($no < 1) {
				$request=($this->session->level =="admin" || $this->session->level =="operator" ? 'TAKEN' : 'REQUESTED');
				$insert_peminjam=array(
					'other_ref'=>$this->input->post('other_ref'),
					'manual_ref' => $this->input->post('manual_ref'),
					'note' => $this->input->post('note'),
					'address' => $this->input->post('address'),
					'start' => $start,
					'end' => $end,
					'id_customer' => $this->input->post('pegawai'),
					'id_pegawai' => $id_p,
					'tanggal_pinjam' => date('Y-m-d'),
					'status_peminjaman' => $request,
					'kode_pinjam' => random_string('numeric',10),
					'id_petugas' => $id_petugas,
				);

				$id_peminjaman = $this->M_barang->tambah_peminjam($insert_peminjam);
				
				}
				$no++;
				
				$insert=array(
					'id_inventaris' => $value,
					'id_peminjaman' => $id_peminjaman,
					'jumlah'		=> $array_qty[$key],
				);
				$this->M_barang->tambah_detail($insert);
				}
			}
		
		
		if ($this->session->level == 'admin'){
		redirect('Admin/peminjaman');
		}elseif($this->session->level=='operator'){
		redirect('Operator/peminjaman');
		}elseif($this->session->level=='peminjam'){
		redirect('Peminjam/peminjaman');
		}
	}

	public function hapus_pinjam($id)
	{
		$where['id_peminjaman']=$id;
		$this->M_barang->hapus_detail($where);
		
		if($this->session->level=='admin'){
		redirect('Admin/peminjaman','refresh');
		}elseif($this->session->level=='operator'){
		redirect('Operator/peminjaman');
		}
		elseif($this->session->level=='operator'){
		redirect('Peminjam/peminjaman');
		}
	}
	public function hapus_ruangan($id)
	{
		$where['id_ruang']=$id;
		$this->M_barang->hapus_ruangan($where);
		
		if($this->session->level=='admin'){
		redirect('Admin/ruangan','refresh');
		}
	}

	public function hapus($id)
	{
		$where['id_inventaris']=$id;
		$this->M_barang->hapus($where);
		
		if($this->session->level=='admin'){
		redirect('Admin/barang','refresh');
		}
	}
	public function hapus_supplier($id)
	{
		$where['id_supplier']=$id;
		$this->M_barang->hapus_supplier($where);
		redirect('Admin/supplier','refresh');
	}

	public function hapus_jenis($id)
	{
		$where['id_jenis']=$id;
		$this->M_barang->hapus_jenis($where);
		
		if($this->session->level=='admin'){
		redirect('Admin/jenis','refresh');
		}
	}
	public function ubah_denda()
	{
        $cek=$this->db->get('setting');
        if ($cek->num_rows() > 0) {
            $this->db->update('setting', ['denda'=> $this->input->post('denda')]);
        } else {
            $this->db->insert('setting', ['denda' => $this->input->post('denda')]);
        }

        if ($this->session->level=='admin') {
            redirect('Admin/setting', 'refresh');
        }
    }

}