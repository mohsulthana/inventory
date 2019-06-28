    <!DOCTYPE html>
    <html>
    <head>
        <title>Laporan Peminjaman</title>
    <link href="<?php echo base_url('assets/dashboard/');?>css/bootstrap.min.css" rel="stylesheet" />

    </head>
    <body>
<table>
    <label class="text-center" style="color: black !important; margin-bottom:20px;   font-family: calibri !important; font-size: 15px !important;"><h1>Laporan Peminjaman Barang</h1></label>
</table>
  <table id="" class="table table-striped data-table-basic">

                                <thead class="text-center">

                                      <tr>

                                        <th width="5px">No.</th>
                                        <th >Kode Pinjam</th>
                                        <th >Other Ref</th>
                                        <th >Manual Ref</th>
                                        <th >Customer</th>
                                        <th >Kode Barang</th>

                                        <th>Nama Barang</th>
                                        <th width="5px">Qty</th>
                                        <th width="5px">Rusak Setelah Pinjam</th>
                                        <th>Peminjam</th>
                                        <th>Petugas</th>
                                        <th>Status</th>
                                        <th class="text-center">Tanggal Pinjam</th>
                                        <th class="text-center">Tanggal Kembali</th>
                                        <th>Pinjam Dari - Sampai</th>
                                        <th>Denda</th>
                                        <th>Note</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no=1; 
                                    foreach ($peminjaman->result() as $key => $value) {
                                     ?>
                                    <tr>
                                        <td class="text-center"><?php echo $no++; ?></td>
                                        <td><?php echo $value->kode_pinjam; ?></td>
                                        <td><?php echo $value->other_ref; ?></td>
                                        <td><?php echo $value->manual_ref; ?></td>
                                        <td><?php echo $value->nama_customer; ?></td>
                                        <td><?php echo $value->kode_inventaris; ?></td>
                                        <td><?php echo $value->nama; ?></td>
                                        <td  class="text-center"><?php echo $value->jumlah; ?></td>
                                        <td  class="text-center"><?php echo $value->rusak; ?></td>
                                        <td><?php echo $value->nama_pegawai; ?></td>
                                        <td><?php echo ($value->nama_petugas != '' ? $value->nama_petugas:'-'); ?></td>
                                        <td><?php echo $value->status_peminjaman; ?></td>

                                        <td  class="text-center"><?php echo date("d / F / Y",strtotime($value->tanggal_pinjam)); ?></td>
                                        <td  class="text-center"><?php echo $value->tanggal_kembali
                                         =='' ? ' - ':date("d / F / Y",strtotime($value->tanggal_kembali)); ?></td>
                                                                         

                                        <td  class="text-center"><?php echo date("d / F / Y",strtotime($value->start)).' - '.date("d / F / Y",strtotime($value->end)); ?></td>
                                        <td><?php echo $value->denda ?></td>
                                        <td><?php echo $value->note ?></td>
                                                                         </tr>

                                <?php } ?>
                                </tbody>
                                   

                            </table>
              
    
    </body>
    </html>              <style type="text/css">
                                *{
                                    font-size: 8px;    
                                }
                            </style>