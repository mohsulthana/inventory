  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
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
        <table class="table table-hover data-table-basic">
                                <thead>
                                    <tr>
                                        
                                        <th width="10px">No.</th>
                                        <th>Kode Pinjam</th>
                                        <th>Nama Peminjam</th>
                                        <th>Tanggal Pinjam</th>
                                        <th>Status</th>
                                        <th width="150px">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="list-pinjaman">
                                    <?php
                                    $no=1; 
                                    foreach ($pinjam->result() as $key => $value) {
                                        $if=$value->status_peminjaman; 
                                        if ($if=='REQUESTED') {
                                        $badge='info';
                                        }elseif ($if=='APPROVED' || $if == 'OUTSTANDING') {
                                        $badge='success';
                                        }elseif ($if=='REJECTED') {
                                        $badge='danger';
                                        }elseif ($if=='TAKEN') {
                                        $badge='warning';
                                        }elseif ($if=='RETURNED') {
                                        $badge='secondary';
                                        }?>
                                        <tr>
                                            <td><?php echo $no++; ?></td>
                                            <td><?php echo $value->kode_pinjam; ?></td>
                                            <td><?php echo $value->nama_pegawai; ?></td>
                                            <td><?php echo date("d / F / Y",strtotime($value->tanggal_pinjam)); ?></td>
                                            <td><?php echo "<span class='badge badge-".$badge."'>".$if."</span>"; ?></td>
                                            <td class="">
                                                <?php if ($value->status_peminjaman == 'REQUESTED') {?>
                                                <button class="btn-edit btn btn-success success-icon-notika btn-button-mg waves-effect" data-toggle="modal" data-target=".myModalone" data-pinjam='<?php echo $value->id_peminjaman; ?>' data-qty='<?php echo $value->jumlah; ?>' data-href="<?php echo site_url('barang/approve/'.$value->id_peminjaman); ?>"" data-id="<?php echo $value->id_peminjaman; ?>">APPROVE</button>
                                                <a class="btn btn-reject btn-danger danger-icon-notika btn-reco-mg btn-button-mg waves-effect sa-warning"  href="<?php echo site_url('barang/reject/'.$value->id_peminjaman); ?>">REJECT</a>
                                            <?php } ?>
                                            </td>

                                        </tr>
                                        <?php
                                    } ?>
                                </tbody>
                            </table>          
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->



  <!-- modal -->

  <div class="modal fade myModalone" role="dialog">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-header text-center" ><h5 id="title-modal">Approve</h5><button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <?php  echo form_open('','id="edit_detail"'); ?>
                                            <div class="modal-body text-center">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                              
                                
                               

                              

                                <d   iv class="form-group float-lb floating-lb">
                                    
                                    <div class="nk-int-st" id="qty">
                                        
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
<script type="text/javascript">
    $(document).on('click','.btn-edit', function(){
        $('#title-modal').html('APPROVE')
       id=$(this).data('pinjam')
       qty=$(this).data('qty');
       link=$(this).data("href");
       $('#edit_detail').attr('action',link);
        $.ajax({
          url:"<?php echo site_url('barang/get_approve/'); ?>"+id,
          method:"POST",
          dataType: 'json',
          data:{},
          success:function(data){
            $('.modal-body').html(data);

          }
        })

    })
    // $(document).on("click",'.btn-reject', function(){
    //     link=$(this).data("href");
    //    $('#edit_detail').attr('action',link);
    //     $('#title-modal').html('REJECT')
    //     ket='<div class="form-group float-lb floating-lb"><div class="nk-int-st" id="qty"><label class="nk-label">Keterangan</label><input type="text" name="ket" id="ket" class="form-control" ></div></div>';
    //     $('.modal-body').html(ket);
    // })
</script>