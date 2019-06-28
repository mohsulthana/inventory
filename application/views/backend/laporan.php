  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"><?= $title; ?></h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
              <div class="form-group">
                  <input type="text" name="range" id="range" class="form-control text-center" style="color:#00c292;" autocomplete="false" placeholder="Ketik tanggal">
              </div>
              <button class="btn btn-success notika-btn-success waves-effect" id="btn-cari">Cari</button>
              </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->

      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"><?= $title; ?></h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
        <div class="accordion-wn-wp">
                        <div class="accordion-stn">
                        <div class="panel-group"  data-collapse-color="nk-green" id="accordionGreen">
                         <div class="panel panel-collapse notika-accrodion-cus">
                                            <div class="panel-heading" role="tab">
                                                <h4 class="panel-title">
                                                    
                                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordionGreen" href="#accordionGreen-two" aria-expanded="false">+ Barang (<?php echo $barang->num_rows(); ?>)
                                                        </a>
                                                </h4>
                                            </div>
                                            <div class="pull-right" style="margin-top: -35px;">
                                            <a href="<?php echo site_url('barang/export/'.$date) ?>" class="btn btn-success notika-btn-success waves-effect" >Export Excel</a>
                                            <a href="<?php echo site_url('barang/export_pdf/'.$date) ?>" class="btn btn-success notika-btn-success waves-effect"  >Export Pdf</a>
                                        </div>
                                            <div id="accordionGreen-two" class="collapse" role="tabpanel">
                                              <div class="table-responsive">
                           <table id="datatable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th width="10px">Kode Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Kondisi</th>
                                        <th>Qty</th>
                                        <th>Keterangan</th>
                                        <th>Ruangan</th>
                                        <th>Jenis</th>
                                        <th>Tanggal Masuk</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no=1; 
                                    foreach ($barang->result() as $key => $value) {
                                    
                                     ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $value->nama; ?></td>
                                        <td><?php echo $value->kondisi; ?></td>
                                        <td><?php echo $value->jumlah; ?></td>
                                        <td><?php echo $value->keterangan; ?></td>
                                        <td><?php echo $value->nama_ruang; ?></td>
                                        <td><?php echo $value->nama_jenis; ?></td>
                                        <td><?php echo date("d / F / Y",strtotime($value->tanggal_register)); ?></td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                                <tfoot>
                                    
                                    <tr>
                                        <th width="10px">Kode Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Kondisi</th>
                                        <th>Qty</th>
                                        <th>Keterangan</th>
                                        <th>Ruangan</th>
                                        <th>Jenis</th>
                                        <th>Tanggal Masuk</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                                            </div>
                                        </div>
                    </div>
        </div>
        <!-- /.box-body -->

      <!-- /.box2 -->

        <div class="accordion-wn-wp">
                        <div class="accordion-stn">
                        <div class="panel-group"  data-collapse-color="nk-green" id="accordionGreen">
                         <div class="panel panel-collapse notika-accrodion-cus">

                                            <div class="panel-heading" role="tab">
                                                <h4 class="panel-title">
                                                    
                                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordionGreen" href="#accordionGreen-three" aria-expanded="false">
                                                        + Peminjaman  Barang (<?php echo $peminjaman->num_rows(); ?>)
                                                        </a>

                                                        
                                                </h4>
                                                 
                                            </div>

                         
                          <div class="pull-right" style="margin-top: -35px;">
                                            <a href="<?php echo site_url('barang/peminjaman_export/'.$date) ?>" class="btn btn-success notika-btn-success waves-effect" >Export Excel</a>
                                            <a href="<?php echo site_url('barang/peminjaman_export_pdf/'.$date) ?>" class="btn btn-success notika-btn-success waves-effect"  >Export Pdf</a>
                                        </div>

                                            <div id="accordionGreen-three" class="collapse" role="tabpanel">
                                              <div class="table-responsive">
                            <table id="datatable" class="table table-striped data-table-basic">
                                <thead>
                                      <tr>
                                        <th>No.</th>
                                        <th width="10px">Kode Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Qty</th>
                                        <th>Peminjam</th>
                                        <th>Petugas</th>
                                        <th>Status</th>
                                        <th>Tanggal Pinjam</th>
                                        <th>Tanggal Kembali</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no=1; 
                                    foreach ($peminjaman->result() as $key => $value) {
                                        # code...
                                     ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $value->kode_pinjam; ?></td>
                                        <td><?php echo $value->nama; ?></td>
                                        <td><?php echo $value->jumlah; ?></td>
                                        <td><?php echo $value->nama_pegawai; ?></td>
                                        <td><?php echo ($value->nama_petugas != '' ? $value->nama_petugas:'-'); ?></td>
                                        <td><?php echo $value->status_peminjaman; ?></td>

                                        <td><?php echo date("d / F / Y",strtotime($value->tanggal_pinjam)); ?></td>
                                        <td><?php echo $value->tanggal_kembali =='' ? ' - ':date("d / F / Y",strtotime($value->tanggal_kembali)); ?></td>
                                                                         </tr>
                                <?php } ?>
                                </tbody>
                                    <tfoot>
                                        <tr>
                                        <th>No.</th>
                                        <th width="10px">Kode Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Qty</th>
                                        <th>Peminjam</th>
                                        <th>Petugas</th>
                                        <th>Status</th>
                                        <th>Tanggal Pinjam</th>
                                        <th>Tanggal Kembali</th>
                                    </tr>
                                </tfoot>

                            </table>
                        </div>
                     </div>
                                        </div>
                    </div>
        </div>
        <!-- /.box-body -->

      <!-- /.box3 -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


    <script type="text/javascript">
        
        $(document).on('click','#btn-cari', function(){
            val=$('#range').val()
            val=val.replace(/\-/g,'_')
            val=val.replace(/\//g,'-')
            val=val.replace(/ /g,'')
            window.location.href='<?php echo site_url('admin/laporan/'); ?>'+val;
        });
        $('#range').daterangepicker({
    "ranges": {
        "Today": [
            moment(),
            moment(),
        ],
        "Yesterday": [
            moment().subtract(1,'days'),
            moment().subtract(1,'days')


        ],
        "Last 7 Days": [
            moment().subtract(7,'days'),
            moment()
        ],
        "Last 30 Days": [
            moment().subtract(30,'days'),
            moment()

        ],
        "This Month": [
            moment().startOf('month'),
            moment().endOf('month')
        ],
        "Last Month": [
            moment().subtract(1,'month').startOf('month'),
            moment().subtract(1,'month').endOf('month')

        ]
    },
    "linkedCalendars": false,
    "startDate": "<?php echo date('m/d/Y'); ?>",
    "endDate": "<?php echo date('m/d/Y'); ?>"
}, function(start, end, label) {
  console.log("New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')");
});
        
        </script>