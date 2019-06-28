  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"><?= $title; ?></h3>
          <?php echo $this->session->pesan; ?>
          <div class="box-tools pull-right">
            <button type="button"   class="btn btn-success success-icon-notika waves-effect"data-toggle="tooltip" data-placement="top" title="Tambah Jenis"><span data-href="<?php echo site_url("barang/tambah_jenis"); ?>"  id="btn-tambah" class="fa fa-plus"  data-toggle="modal" data-target="#myModalone"></span></button> 
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <div class="table-responsive">
                            <table id="datatable" class="table table-striped">
                                <thead>
                                    <tr>
                                    <th width="10px">No.</th>
                                        <th>Kode Jenis</th>
                                        <th>Nama Jenis</th>
                                        <th>Keterangan</th>
                                        <th width="100px">action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no=1; 
                                    foreach ($jenis->result() as $key => $value) {
                                     ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $value->kode_jenis; ?></td>
                                        <td><?php echo $value->nama_jenis; ?></td>
                                        <td><?php echo $value->keterangan; ?></td>
                                        <td class="button-icon-btn button-icon-btn-cl sm-res-mg-t-30">
                                            <button data-id="<?php echo $value->id_jenis; ?>" data-toggle="modal" data-target="#myModalone" data-href="<?php echo site_url('barang/edit_jenis/'.$value->id_jenis); ?>" class="btn-edit btn btn-warning warning-icon-notika btn-reco-mg btn-button-mg waves-effect">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <a  id="" href="<?php echo site_url('barang/hapus_jenis/'.$value->id_jenis); ?>" class="sa-warning btn btn-danger danger-icon-notika btn-reco-mg btn-button-mg waves-effect" >
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


      <!-- modal area Start-->
<div class="modal fade" id="myModalone" role="dialog">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-header text-center" ><h5 id="title-modal"></h5><button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <?php  echo form_open_multipart('','id="tambah_jenis"'); ?>
                                            <div class="modal-body text-center">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                              
                                      
                                <div class="form-group  float-lb floating-lb mg-tb-30">
                                    
                                    <div class="nk-int-st">

                                        <label class="nk-label">Nama Jenis</label>
                                        <input required  type="text" class="form-control" name="nama" id="nama" >
                                    </div>

                                </div>
                                <div class="form-group  float-lb floating-lb mg-tb-30">
                                    
                                    <div class="nk-int-st">

                                        <label class="nk-label">Keterangan</label>
                                        <textarea required  type="text" class="form-control" name="ket" id="ket" ></textarea>
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
            $('#title-modal').html('Tambah Jenis');
            $('#tambah_jenis').attr('action',link).trigger('reset');
        });

        $('#datatable').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false
        });

        $('.btn-edit').on('click', function(){
            link=$(this).data('href');
            id=$(this).data('id');
            $('#tambah_jenis').attr('action',link);
            $('#title-modal').html('Edit Jenis');
            $.ajax({
              url:"<?php echo site_url('barang/get_edit_jenis'); ?>",
              method:"POST",
              dataType: 'json',
              data:{id:id},
              success:function(data){

                    $('#kode').val(data.kode_jenis);
                    $('#nama').val(data.nama_jenis);
                    $('#ket').val(data.keterangan);

              }
            })
            
        })
    </script>
