  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data <?= $title; ?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><?= $title; ?></li>
      </ol>
    </section>

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
        <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php echo $this->session->pesan; ?>
                    <div class="form-example-wrap mg-t-30">
                        <div class="cmp-tb-hd cmp-int-hd">
                            <h4 class="panel-title">Pengembalian Barang</h4>
                        </div>
                        <div class="row text-center">
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                <div class="form-group ic-cmp-int float-lb floating-lb">
                                    
                                    <div class="nk-int-st">
                                        <input type="number" class="form-control" id="kode">
                                        <label class="nk-label">Kode Peminjaman</label>
                                    </div>
                                </div>
                            </div>
                           <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">

                                <div class="form-example-int">
                                    <button class="btn btn-success notika-btn-success" data-toggle="tooltip" data-placement="top" title="Cek data Pinjaman" id="cek"><span data-toggle="modal" data-target="#detail_peminjam">Cek</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

     <div class="modal fade" id="detail_peminjam" role="dialog">
                                    <div class="modal-dialog modals-default">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="text-center">Detail Pinjaman</h5>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                               <div class="bsc-tbl-hvr">
                                                
                                                  <?php echo form_open('barang/pengembalian','id="kembalikan"' ); ?>
                            <table class="table table-hover">
                                 <thead>
                                    <tr>
                                        <th width="10px">No.</th>
                                        <th>Peminjam</th>
                                        <th>Nama Barang</th>
                                        <th>Qty</th>
                                        <th>Nama Ruang</th>
                                        <th>Qty Kembalikan</th>
                                        <th>Qty Rusak</th>
                                        <th>Denda</th>
                                    </tr>
                                </thead>
                                <tbody class="list-detail"></tbody>
                            </table>
                        </div>
                                            </div>
                                            <div class="modal-footer">
                        <input type='hidden' name="kode" id="kode_2">
                                                <button  class="btn btn-default btn-kembali" >Kembalikan</button>
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <?php echo form_close(); ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    $('#kembalikan').submit(function(e){
                                        list=$('.cek').html();
                                            if (list=="No Data") {
                                                e.preventDefault();
                                                swal({
                                                    title:"Tidak bisa Mengembalikan",
                                                    type :"warning",
                                                })
                                            }
                                    })
                                    $('#cek').on('click',function(){
                                    code=$('#kode').val()
                                    $.ajax({
                                      url:"<?php echo site_url('barang/get_pengembalian'); ?>",
                                      method:"POST",
                                      dataType: 'json',
                                      data:{code:code},
                                      success:function(data){
                                        $('#kode_2').val(code);
                                        $('.list-detail').html(data);

                                      }
                                    })
                                    })
                                </script>