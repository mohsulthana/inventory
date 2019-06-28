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
        <li <?php echo $title=='Peminjaman' ? 'class="active"':''; ?>>
          <a href="<?= base_url('peminjam/peminjaman');?>">
            <i class="fa fa-dashboard"></i> <span>Peminjaman</span>
          </a>
        </li>
        <li <?php echo $title=='Setting' ? 'class="active"':''; ?>>
          <a href="<?= base_url('peminjam/setting');?>">
            <i class="fa fa-dashboard"></i> <span>Setting</span>
          </a>
        </li>
        <li>
          <a href="<?= base_url('auth/keluar');?>">
            <i class="fa fa-dashboard"></i> <span>Logout</span>
          </a>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- =============================================== -->