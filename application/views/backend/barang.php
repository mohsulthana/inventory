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
            <button type="button"  class="btn btn-success success-icon-notika waves-effect"data-toggle="tooltip" data-placement="top" title="Tambah Barang Baru" ><span class="fa fa-plus" id="btn-tambah" data-toggle="modal" data-target="#myModalone" data-href="<?php echo site_url('barang/tambah'); ?>"></span></button> 
            <button type="button"  class="btn btn-success success-icon-notika waves-effect" data-toggle="tooltip" data-placement="top" title="Tambah Barang Sudah ada" ><span class="fa fa-plus" id="btn-tambah" data-toggle="modal" data-target="#myModalTwo" data-href="<?php echo site_url('barang/tambah'); ?>"></span></button> 
            <a href="<?php echo site_url('admin/ruangan'); ?>"  class="btn btn-success success-icon-notika waves-effect"data-toggle="tooltip" data-placement="top" title="Kelola Ruangan">Kelola Ruangan</span></a>
            <a href="<?php echo site_url('admin/jenis'); ?>"  class="btn btn-success success-icon-notika waves-effect"data-toggle="tooltip" data-placement="top" title="Kelola Jenis Barang">Kelola Jenis</span></a>
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
          </div>
        </div>
        <div class="box-body">
          <div class="table-responsive">
                            <table id="datatable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th width="10px">No.</th>
                                        <th>Supplier</th>
                                        <th >Kode Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Kondisi</th>
                                        <th>Qty</th>
                                        <th>Jumlah Keseluruhan</th>
                                        <th>Keterangan</th>
                                        <th>Ruangan</th>
                                        <th>Jenis</th>
                                        <th>Tanggal Masuk</th>
                                        <th width="100px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no=1; 
                                    foreach ($barang->result() as $key => $value) {
                                    
                                     ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $value->nama_supplier; ?></td>
                                        <td><?php echo $value->kode_inventaris; ?></td>
                                        <td><?php echo $value->nama; ?></td>
                                        <td><?php echo $value->kondisi; ?></td>
                                        <td><?php echo $value->jumlah; ?></td>
                                        <td><?php echo $value->jumlah_all; ?></td>
                                        <td><?php echo $value->keterangan; ?></td>
                                        <td><?php echo $value->nama_ruang; ?></td>
                                        <td><?php echo $value->nama_jenis; ?></td>
                                        <td><?php echo date("d / F / Y",strtotime($value->tanggal_register)); ?></td>
                                        <td class="button-icon-btn button-icon-btn-cl sm-res-mg-t-30"><button data-href="<?php echo site_url('barang/edit/'.$value->id_inventaris); ?>"  class="btn-edit btn btn-warning warning-icon-notika btn-reco-mg btn-button-mg waves-effect" data-toggle="modal" data-target="#myModalone" data-id="<?php echo $value->id_inventaris; ?>"><i class="fa fa-edit"></i></button><a class="btn btn-danger danger-icon-notika btn-reco-mg btn-button-mg waves-effect sa-warning" href="<?php echo site_url('barang/hapus/'.$value->id_inventaris); ?>" id=""><i class="fa fa-trash"></i></a></td>
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
                                        <th width="100px">Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


  <div class="modal fade" id="myModalone" role="dialog">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-header text-center"><h5 id="title-modal"></h5><button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <?php echo form_open('','id="tambah_barang"'); ?>
                                            <div class="modal-body text-center">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <div class="form-group  float-lb ">
                                    <div class="nk-int-st">
                                        <select required="" name="supplier" id="ruang2" class="form-control">

                                         <option value="">Supplier</option>
                                         <?php foreach ($supplier->result() as $key => $value) {
                                            ?>
                                            <option value="<?php echo $value->id_supplier; ?>"><?php echo $value->nama_supplier; ?></option>
                                            <?php
                                         } ?>
                                     </select>
                                    </div>
                                    
                                </div>
                            </div> 
                                                
                                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                <div class="form-group float-lb">
                                    <div class="nk-int-st">
                                        <input required type="text" class="form-control" id="nama" name="nama" placeholder="Nama Barang">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                <div class="form-group float-lb">
                                    <div class="nk-int-st">
                                        <input required type="number" class="form-control" name="qty" id="qty" placeholder="Qty">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <div class="form-group  float-lb ">
                                    <div class="nk-int-st">
                                        <select required="" name="kondisi" id="kondisi" class="form-control">

                                         <option value="">Kondisi</option>
                                         <option value="baik">baik</option>
                                         <option value="rusak">rusak</option>
                                     </select>
                                    </div>
                                    
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <div class="form-group  float-lb ">
                                    <div class="nk-int-st">
                                        <select required="" name="ruang" id="ruang" class="form-control">

                                         <option value="">Ruangan</option>
                                         <?php foreach ($ruang->result() as $key => $value) {
                                            ?>
                                            <option value="<?php echo $value->id_ruang; ?>"><?php echo $value->kode_ruang.' - '.$value->nama_ruang; ?></option>
                                            <?php
                                         } ?>
                                     </select>
                                    </div>
                                    
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <div class="form-group  float-lb ">
                                    <div class="nk-int-st">
                                        <select required="" name="jenis" id="jenis" class="form-control">

                                         <option value="">Jenis</option>
                                         <?php foreach ($jenis->result() as $key => $value) {
                                            ?>
                                            <option value="<?php echo $value->id_jenis; ?>"><?php echo $value->kode_jenis.' - '.$value->nama_jenis; ?></option>
                                            <?php
                                         } ?>
                                     </select>
                                    </div>
                                    
                                </div>
                            </div>
                                  
                                          <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group float-lb">
                                    <div class="nk-int-st">
                                        <input required type="text" class="form-control" id="ket" name="ket" placeholder="Keterangan">
                                    </div>
                                </div>
                            </div>




                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-default">Simpan</button>
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>
                                            <?php   echo form_close(); ?>
                                        </div>
                                    </div>
                                </div>
                                
	<!-- modal area End-->

  <script type="text/javascript">
        $('#btn-tambah').on('click', function(){
            
            link=$(this).data('href');
            $('#title-modal').html('Tambah Barang');
            $('#tambah_barang').attr('action',link).trigger('reset');
        });
        $(document).ready(function() {
          $('#datatable').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false
          });
        });
        $('.btn-edit').on('click', function(){
            link=$(this).data('href');
            id=$(this).data('id');
            $('#tambah_barang').attr('action',link);
            $('#title-modal').html('Edit Barang');
            $.ajax({
              url:"<?php echo site_url('barang/get_edit'); ?>",
              method:"POST",
              dataType: 'json',
              data:{id:id},
              success:function(data){
                    $('#kode').val(data.kode_inventaris);
                    $('#nama').val(data.nama);
                    $('#qty').val(data.jumlah);
                    $('#kondisi').val(data.kondisi);
                    $('#ruang').val(data.id_ruang);
                    $('#jenis').val(data.id_jenis);
                    $('#ket').val(data.keterangan);

              }
            })
        })
    </script>