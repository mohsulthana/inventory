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

          <!-- box 2 -->
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
          <?php echo $this->session->pesan; ?>
          <?php echo form_open('barang/pinjam','id="submit"'); ?>
          
          <!-- Form -->
          <div class="cmp-tb-hd cmp-int-hd">
                        <h4 class="panel-title text-center">FORM PEMINJAMAN/PENGAJUAN BARANG
                        </h4>
                    </div>
                    <div class="basic-tb-hd">
                        <h4 class="panel-title">Tanggal Pengajuan - <?php echo date('d / F / Y');?></h4>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-xs-12">
                            <div class="form-group">
                                <label>Other Ref :</label>
                                <input type="text" class="form-control" required name="other_ref">
                            </div>
                        </div>
                        <div class="col-lg-6 col-xs-12">
                            <div class="form-group">
                                <label>Manual Ref :</label>
                                <input type="text" class="form-control" required name="manual_ref">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-xs-12">
                          <div class="form-group">
                            <label>Note :</label>
                            <textarea name="note" id="" cols="10" rows="1" class="form-control" ></textarea>
                          </div>
                        </div>
                        <div class="col-lg-6 col-xs-12">
                            <div class="form-group">
                                <label>Customer :</label>
                                <div class="bootstrap-select">
                                    <input list="pegawai" class="form-control" name="pegawai">
                                    <datalist class="selectpicker col-sm-6 custom-select custom-select-sm" data-live-search="true" id="pegawai">
                                        <option></option>
                                        <?php foreach ($customer->result() as $key => $value) {?>
                                        <option value="<?= $value->id_customer ?>" id="pegawai-<?= $value->id_customer; ?>" data-alamat="<?= $value->alamat_customer ?>" ><?php echo $value->nama_customer; ?></option>
                                        <?php } ?>
                                    </datalist>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-xs-12">
                            <div class="form-group">
                                <label>Address :</label>
                                <textarea name="address" id="address" cols="10" rows="5" class="form-control" required></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xs-12">
                            <div class="form-group">
                                <label>Barang :</label>
                                <div class="bootstrap-select">
                                    <input list="barang" class="form-control" name="barang">
                                    <datalist class="selectpicker" data-live-search="true" id="barang">
                                     <?php foreach ($barang->result() as $key => $value) {?>
                                        <option value="<?php echo $value->nama ?>" name="brg" data-id="<?php echo $value->id_inventaris; ?>" data-barang="<?= $value->nama.' | tersedia '.$value->jumlah; ?>" data-kode="<?= $value->kode_inventaris ?>"><?php echo $value->kode_inventaris .' | '.$value->nama.' | tersedia '.$value->jumlah; ?></option>
                                    <?php } ?>
                                    </datalist>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-xs-12 mt-10 mb-10">
                            <div class="form-group ic-cmp-int float-lb floating-lb">
                                <label >Qty :</label>
                                <div class="nk-int-st">
                                    <input type="number" class="form-control" id="qty">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <div class="form-group ic-cmp-int float-lb floating-lb">
                                <label >Tanggal :</label>
                                <div class="nk-int-st">
                                    <input type="text" name="range_pinjam" id="range_pinjam" class="range_pinjam form-control text-center" style="color:#00c292; " autocomplete="false">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <div class="form-group " style="padding-top: 15px;">
                                <button type="button" class="btn btn-success notika-btn-success" data-toggle="tooltip" data-placement="top" title="Tambahkan" id="tambah_pinjaman"><i class="fa fa-plus"></i></button>
                                <button class="btn btn-success notika-btn-success"><?= ($this->session->level=="admin" || $this->session->level=="operator" ? 'Pinjam' : 'Ajukan' ); ?></button>
                            </div>
                        </div>
                    </div>
                    <div class="table-hover" style="margin-top: 25px;">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th width="10px">No.</th>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Qty</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        <tbody class="list-detail"></tbody>
                    </table>
                </div>
            <?php echo form_close(); ?>

          <!-- /. Form -->
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box 2 -->

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
                                                <th>Peminjam</th>
                                                <th>Tgl Pengajuan</th>
                                                <th>Tgl Kembali</th>
                                                <th>Dari</th>
                                                <th>Sampai</th>
                                                <th>Denda</th>
                                                <th>Status</th>
                                                <th>Petugas</th>
                                               
                                               
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
                                            }elseif ($if=='APPROVED') {
                                            $badge='success';
                                            }elseif ($if=='REJECTED') {
                                            $badge='danger';
                                            }elseif ($if=='TAKEN') {
                                            $badge='warning';
                                            }elseif ($if=='RETURNED') {
                                            $badge='secondary';
                                            }elseif ($if=='OUTSTANDING') {
                                            $badge='warning';
                                            }
                                            ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td><?php echo $value->kode_pinjam; ?></td>
                                                <td><?php echo $value->nama_pegawai; ?></td>
                                                <td><?php echo date("d/F/Y",strtotime($value->tanggal_pinjam)); ?></td>
                                                <td><?php echo $value->tanggal_kembali =='' ? ' - ':date("d/F/Y",strtotime($value->tanggal_kembali)); ?></td>
                                                <td><?= date("d/F/Y",strtotime($value->start))?></td>
                                                <td><?= date("d/F/Y",strtotime($value->end)); ?></td>
                                                <td><?php echo $value->denda != '' ? 'Rp. '.$value->denda : '-' ; ?></td>
                                                <td><?php echo "<span class='badge badge-".$badge."'>".$if."</span>"; ?></td>
                                                <td><?php echo $value->nama_petugas != '' ? $value->nama_petugas : '-' ; ?></td>
                                                <td class="button-icon-btn button-icon-btn-cl sm-res-mg-t-30 text-center">                                                    
                                                    <?php if ($if=='REQUESTED' || $if=='OUTSTANDING'): ?>
                                                    <button class="btn-edit btn btn-warning warning-icon-notika btn-reco-mg btn-button-mg waves-effect" data-toggle="modal" data-target="#myModalone" data-href="<?php echo site_url('barang/edit_detail/'.$value->id_peminjaman); ?>" data-id="<?php echo $value->id_peminjaman; ?>"><i class="fa fa-edit"></i></button>
                                                    <a class="btn btn-danger danger-icon-notika btn-reco-mg btn-button-mg waves-effect sa-warning"  id="" href="<?php echo site_url('barang/hapus_pinjam/'.$value->id_peminjaman); ?>"><i class="fa fa-trash"></i></a>
                                                    <?php endif ?>

                                                    <?php if ($if=="APPROVED" || $if=="TAKEN" || $if=="RETURNED"): ?>
                                                    <button class="btn-ruang btn btn-success success-icon-notika btn-reco-mg btn-button-mg waves-effect" data-toggle="tooltip" data-placement="top" title="Lihat Detail"  data-href="<?php echo site_url('barang/get_ruang/'.$value->id_peminjaman); ?>" data-id="<?php echo $value->id_detail_peminjaman; ?>"><i class="fa fa-eye" data-toggle="modal" data-target="#myModalone"></i></button>
                                                    <?php endif ?>

                                                    <?php if ($if=="TAKEN" && ($this->session->level=="admin" || $this->session->level=="operator")) {?>
                                                    <a class=" btn btn-success success-icon-notika  sa-warning" data-toggle="tooltip" data-placement="top" title="Kembalikan Barang"  href="<?php echo site_url('barang/returned/'.$value->id_peminjaman); ?>"><i class="fa fa-arrow-left"></i></a>
                                                    <?php
                                                    } ?>
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

<div class="modal fade" id="myModalone" role="dialog">
    <div class="modal-dialog modals-default">
    <div class="modal-content">
        <div class="modal-header text-center" ><h5 id="title-modal">Edit Detail Peminjaman</h5><button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <?php echo form_open_multipart('','id="edit_detail"'); ?>
        <div class="modal-body text-center">
            
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
</div>

<script>
$('[name="pegawai"]').on('change',function() {
    address=$('#pegawai-'+$(this).val()).data('alamat')
    $('#address').val(address)
});
$('.btn-edit').on('click', function(){
    $('#title-modal').html('Edit Detail Peminjaman')
    link=$(this).data('href')
    $('.btn-simpan').html('Update')
    $('#edit_detail').attr('action',link)
    id=$(this).data("id")
    $.ajax({
        url:"<?php echo site_url('barang/get_edit_detail'); ?>",
        method:"POST",
        dataType: 'json',
        data:{id:id},
        success:function(data){
            $('.modal-body').html(data)
        }
    })
})
$('.btn-ruang').on('click', function(){
    link=$(this).data('href')
    link2="<?php echo site_url('barang/ambil/'); ?>"
    $('#title-modal').html("Peminjaman Barang")
    $('.btn-simpan').html("Ambil Barang")
    id=$(this).data("id")
    $('#edit_detail').attr('action',link2)
    $.ajax({
        url:link,
        method:"POST",
        dataType: 'json',
        data:{id:id},
        success:function(data){
            $('.modal-body').html(data)
        }
    })
})

no=0;
$('#tambah_pinjaman').on('click', function(){
    no++;
    id = $('[name="brg"]').data('id');
    nama=$('[name="brg"]').data('barang');
    kode=$('[name="brg"]').data('kode');
    qty=$('#qty').val();
    if (qty < 1) {
        swal({
        title:"Qty Tidak bisa kurang dari 1",
        type :"warning",
        })
    } else{
        append = '<tr class="order" data-index="'+ no +'" id="'+no+'" ><td id="no-'+no+'">sjgjd'+no+'</td><td>'+kode+'</td><td>'+nama+'</td><td>'+qty+'</td><td width="10px" class="button-icon-btn button-icon-btn-cl sm-res-mg-t-30"><button class="btn btn-danger list-delete danger-icon-notika btn-reco-mg btn-button-mg waves-effect" data-id='+no+'><i class="fa fa-trash"></i></button><input type="hidden" name="id[]" value="'+id+'"><input type="hidden" name="jumlah[]" value="'+qty+'"></td></tr>';
        $('.list-detail').append(append);
        ordering();
        numbering();
    }
})

$(document).on('click','.list-delete',function(){
    no=$(this).data('id');
    $('#'+no).remove();
    ordering()
    numbering()
})

function ordering(){
    $('.list-detail').each(function(){
        var $this = $(this)
        $this.append($this.find('.order').get().sort(function(a,b){
            return $(a).data('index') - $(b).data('index');
        }));
    });
}

function numbering() {
    no=1;
    $('.order').each(function(){
        index=$(this).data('index');
        cek=$(this).html();
        if ( cek != '') {
            $(this).find('#no-'+index).html(no++)
        }
    })
}
$('#submit').submit(function(e){
    list=$('.list-detail').html();
    if (list=="") {
        e.preventDefault();
        swal({
            title:"Detail Pinjaman Tidak Boleh Kosong",
            type :"warning",
        })
    }
})
</script>