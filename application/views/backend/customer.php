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
            <button type="button" class="btn btn-success success-icon-notika waves-effect"data-toggle="tooltip" data-placement="top" title="Tambah Pegawai"><span data-href="<?php echo site_url("pegawai/tambah_customer"); ?>"  id="btn-tambah" class="fa fa-plus"  data-toggle="modal" data-target="#myModalone"></span></button> 
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
          </div>
        </div>
        <div class="box-body">
        <div class="table-responsive">
                            <table id="datatable" class="table table-striped">
                                <thead>

                                    <tr>
                                    <th width="10px">No.</th>
                                        <th>Nama</th>
                                        <th>No. Telp</th>
                                        <th>Alamat</th>
                                        <th>Nama Pic</th>

                                        <th width="100px">action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no=1; 
                                    foreach ($pegawai->result() as $key => $value) {
                                     ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $value->nama_customer; ?></td>
                                        <td><?php echo $value->tlp_customer; ?></td>
                                        <td><?php echo $value->alamat_customer; ?></td>
                                        <td><?php echo $value->nama_pic; ?></td>
                                        <td class="button-icon-btn button-icon-btn-cl sm-res-mg-t-30">
                                            <button data-id="<?php echo $value->id_customer; ?>" data-toggle="modal" data-target="#myModalone" data-href="<?php echo site_url('pegawai/edit_customer/'.$value->id_customer); ?>" class="btn-edit btn btn-warning warning-icon-notika btn-reco-mg btn-button-mg waves-effect">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <a  id="" href="<?php echo site_url('pegawai/hapus_customer/'.$value->id_customer); ?>" class="sa-warning btn btn-danger danger-icon-notika btn-reco-mg btn-button-mg waves-effect" >
                                                <i class="fa fa-trash"></i>
                                            </a>

                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
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
                                            <div class="modal-header text-center"><h5  id="title-modal">Tambah Pegawai</h5><button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <?php  echo form_open_multipart('','id="tambah_pegawai"'); ?>
                                            <div class="modal-body text-center">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                              
                                
                                <div class="form-group ic-cmp-int float-lb floating-lb">
                                    <div class="form-ic-cmp">
                                        <i class="notika-icon notika-support"></i>
                                    </div>
                                    <div class="nk-int-st">
                                        <input required  type="text" class="form-control" name="nama" id="nama" placeholder="Nama">
                                    </div>
                                    
                                </div>

                                <div class="form-group ic-cmp-int float-lb floating-lb">
                                    <div class="form-ic-cmp">
                                        <i class="notika-icon notika-support"></i>
                                    </div>
                                    <div class="nk-int-st">
                                        <input required  type="text" class="form-control" name="no" id="no" placeholder="No. Telp">
                                    </div>
                                    
                                </div>

                                <div class="form-group ic-cmp-int float-lb floating-lb">
                                    <div class="form-ic-cmp">
                                        <i class="notika-icon notika-map"></i>
                                    </div>
                                    <div class="nk-int-st">
                                        <input required  type="text" class="form-control" name="alamat" id="alamat" placeholder="Alamat">
                                    </div>
                                    
                                </div>

                                <div class="form-group ic-cmp-int float-lb floating-lb">
                                    <div class="form-ic-cmp">
                                        <i class="notika-icon notika-support"></i>
                                    </div>
                                    <div class="nk-int-st">
                                        <input required  type="text" class="form-control" name="pic" id="pic" placeholder="Nama Pic">
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
            $('#title-modal').html('Tambah Customer');
            $('#tambah_pegawai').attr('action',link).trigger('reset');
        });

        $('.btn-edit').on('click', function(){
            link=$(this).data('href');
            id=$(this).data('id');
            $('#tambah_pegawai').attr('action',link);
            $('#title-modal').html('Edit Pegawai');
            $.ajax({
              url:"<?php echo site_url('pegawai/get_edit_customer'); ?>",
              method:"POST",
              dataType: 'json',
              data:{id:id},
              success:function(data){
                    $('#nama').val(data.nama_customer);
                    $('#no').val(data.tlp_customer);
                    $('#alamat').val(data.alamat_customer);
                    $('#pic').val(data.nama_pic);
              }
            })
        });
        $('#datatable').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false
        });
    </script>
