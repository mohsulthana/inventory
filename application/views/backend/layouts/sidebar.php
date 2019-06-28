  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?= asset_url();?>admin/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php $row = $this->db->select('nama_petugas')->from('petugas')->where('id_petugas', $this->session->userdata('id_pegawai'))->get()->result(); echo $row[0]->nama_petugas;?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li <?php echo $title=='Dashboard' ? 'class="active"':''; ?>>
          <a href="<?= base_url('admin');?>">
            <i class="fa fa-fw fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
        <li <?php echo $title=='Pegawai' ? 'class="active"':''; ?>>
          <a href="<?= base_url('admin/pegawai');?>">
            <i class="fa fa-fw fa-user"></i> <span>Pegawai</span>
          </a>
        </li>
        <li <?php echo $title=='Customer' ? 'class="active"':''; ?>>
          <a href="<?= base_url('admin/customer');?>">
            <i class="fa fa-fw fa-users"></i> <span>Customer</span>
          </a>
        </li>
        <li <?php echo $title=='Barang' ? 'class="active"':''; ?>>
          <a href="<?= base_url('admin/barang');?>">
            <i class="fa fa-fw fa-square"></i> <span>Barang</span>
          </a>
        </li>
        <li>
          <a href="<?= base_url('admin/supplier');?>">
            <i class="fa fa-fw fa-user-plus"></i> <span>Supplier</span>
          </a>
        </li>
        <li <?php echo $title=='Peminjaman' ? 'class="active"': ''; ?>>
          <a href="<?= base_url('admin/peminjaman');?>">
            <i class="fa fa-fw fa-trophy"></i> <span>Peminjaman</span>
          </a>
        </li>
        <li <?php echo $title=='Pengembalian' ? 'class="active"':''; ?>>
          <a href="<?= base_url('admin/pengembalian');?>">
            <i class="fa fa-fw fa-unlock"></i> <span>Pengembalian</span>
          </a>
        </li>
        <li <?php echo $title=='Request' ? 'class="active"':''; ?>>
          <a href="<?= base_url('admin/request');?>">
            <i class="fa fa-fw fa-plus-square"></i> <span>Request</span>
          </a>
        </li>
        <li <?php echo $title=='Laporan' ? 'class="active"':''; ?>>
          <a href="<?= base_url('admin/laporan');?>">
            <i class="fa fa-fw fa-paperclip"></i> <span>Laporan</span>
          </a>
        </li>
        <li <?php echo $title=='Setting' ? 'class="active"':''; ?>>
          <a href="<?= base_url('admin/setting');?>">
            <i class="fa fa-gears"></i> <span>Setting</span>
          </a>
        </li>
        <li>
          <a href="<?= base_url('auth/keluar');?>">
            <i class="fa fa-fw fa-sign-out"></i> <span>Logout</span>
          </a>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- =============================================== -->