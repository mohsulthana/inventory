<!DOCTYPE html>
<html>
	<head>
		<title>Laporan Peminjaman</title>
		<link href="<?php echo base_url('assets/dashboard/');?>css/bootstrap.min.css" rel="stylesheet" />
	</head>
	<body>
		
		<div>
			<div  class="text-left border-bottom">
				<label class="col-md-12 text-center"><h4>Peminjaman Barang</h4></label>
				<table width="100%" >
					<tr>
						<th  class="header-content" >Order Ref</th>
						<td class="content">: <?= $detail->other_ref ?></td>
						<th class="header-content">Customer</th>
						<td class="content>">: <?= $detail->nama_customer ?></td>
					</tr>
					<tr>
						<th class="header-content">Manual Ref</th>
						<td class="content">: <?= $detail->manual_ref ?></td>
						<th class="header-content">Alamat</th>
						<td class="content">: <?= $detail->alamat_customer ?></td>
					</tr>
					<tr>
						<th class="header-content">Note</th>
						<td class="content">: <?= $detail->note ?></td>
						<th class="header-content">Peminjam</th>
						<td class="content">: <?= $detail->nama_pegawai ?></td>
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
							<th>Ruangan</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$no=1;
						foreach ($peminjaman->result() as $key => $value) {
						?>
						<tr>
							<td><input type="hidden" value="'.$value->id_peminjaman.'" name="id_peminjaman"><?= $no++ ?></td>
							<td align="left"><?= $value->kode_inventaris ?> </td>
							<td align="left"><?= $value->nama ?></td>
							<td align="left"><?= $value->jumlah ?></td>
							<td align="left"><?= $value->nama_ruang ?></td>
						</tr>
						<?php
						} ?>
					</tbody>
				</table>
			</div>
		</div>
	</body>
</html>
<style type="text/css">
.p-5{
	padding: 5;
}
	.content{
		width:30%; 
		padding:5px;
	}
	.header-content{
style="width:20%; padding:5px;"
	}
	.border-bottom
	{
		margin-top:25px;
		margin-bottom:25px; 
		border-bottom:1px solid black; 
		padding-bottom:20px;
	}
</style>