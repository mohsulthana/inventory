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
            <button type="button"   class="btn btn-success success-icon-notika waves-effect"data-toggle="tooltip" data-placement="top" title="Tambah Ruangan"><span data-href="<?php echo site_url("barang/tambah_ruangan"); ?>"  id="btn-tambah" class="fa fa-plus"  data-toggle="modal" data-target="#myModalone"></span></button> 
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
        <div class="table-responsive">
                            <table id="data-table-basic" class="table table-striped">
                                <thead>

                                    <tr>
                                    <th width="10px">No.</th>
                                        <th>Kode Ruang</th>
                                        <th>Nama Ruang</th>
                                        <th width="100px">action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no=1; 
                                    foreach ($ruang->result() as $key => $value) {
                                     ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $value->kode_ruang; ?></td>
                                        <td><?php echo $value->nama_ruang; ?></td>
                                        <td class="button-icon-btn button-icon-btn-cl sm-res-mg-t-30">
                                            <button data-id="<?php echo $value->id_ruang; ?>" data-toggle="modal" data-target="#myModalone" data-href="<?php echo site_url('barang/edit_ruangan/'.$value->id_ruang); ?>" class="btn-edit btn btn-warning warning-icon-notika btn-reco-mg btn-button-mg waves-effect">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <a  id="" href="<?php echo site_url('barang/hapus_ruangan/'.$value->id_ruang); ?>" class="sa-warning btn btn-danger danger-icon-notika btn-reco-mg btn-button-mg waves-effect" >
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                                <tfoot>
                                    <th width="10px">No.</th>
                                        <th>Kode Ruang</th>
                                        <th>Nama Ruang</th>
                                        <th width="100px">action</th>
                                </tfoot>
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
                                            <div class="modal-header text-center" ><h5 id="title-modal">Tambah Pegawai</h5><button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <?php  echo form_open_multipart('','id="tambah_ruangan"'); ?>
                                            <div class="modal-body text-center">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                              
                                       
                                <div class="form-group  float-lb floating-lb mg-tb-30">
                                    
                                    <div class="nk-int-st">

                                        <input required  type="text" class="form-control" name="nama" id="nama" placeholder="Nama Ruangan">
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
            $('#title-modal').html('Tambah Ruangan');
            $('#tambah_ruangan').attr('action',link).trigger('reset');

        
        })

        $('.btn-edit').on('click', function(){
            
            link=$(this).data('href');
            id=$(this).data('id');
            $('#tambah_ruangan').attr('action',link);
            $('#title-modal').html('Edit ruangan');
            alert(id);
            $.ajax({
              url:"<?php echo site_url('barang/get_edit_ruangan'); ?>",
              method:"POST",
              dataType: 'json',
              data:{id:id},
              success:function(data){

                    $('#kode').val(data.kode_ruang);
                    $('#nama').val(data.nama_ruang);

              }
            })
            
        })
    </script>
