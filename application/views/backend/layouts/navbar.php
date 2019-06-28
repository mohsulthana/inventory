<body class="hold-transition skin-blue sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <header class="main-header">

    <!-- PHP Script -->
      <?php
      $row = $this->db->select('status_peminjaman')->from('peminjaman')->where('status_peminjaman', 'REQUESTED')->get()->num_rows(); 
      
      // Get Customer
      $this->db->join('customer', 'customer.id_customer = peminjaman.id_customer', 'inner');
      $this->db->where('status_peminjaman', 'REQUESTED');
      $customer = $this->db->get('peminjaman')->result();
      ?>
    <!-- ./ PHP Script -->
    <!-- Logo -->
    <a href="<?= base_url();?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>Inv</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Dashboard</b> Inventaris</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning"><?= $row; ?></span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have <?= $row; ?> notifications</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li>
                    <?php foreach($customer as $value) { ?>
                    <a href="<?= base_url();?>admin/request">
                      <i class="fa fa-users text-aqua"></i> <?= $value->nama_customer ?> <p>Meminta permintaan peminjaman barang.</p>
                    </a>
                    <?php }; ?>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="#">View all</a></li>
            </ul>
          </li>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <img src="<?= asset_url();?>admin/dist/img/user2-160x160.jpg" class="img-circle user-image" alt="User Image">
              <span class="hidden-xs"><?php $row = $this->db->select('nama_petugas')->from('petugas')->where('id_petugas', $this->session->userdata('id_pegawai'))->get()->result(); echo $row[0]->nama_petugas;?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?= asset_url();?>admin/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                <p>
                  <p><?php $row = $this->db->select('nama_petugas')->from('petugas')->where('id_petugas', $this->session->userdata('id_pegawai'))->get()->result(); echo $row[0]->nama_petugas;?></p>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-right">
                  <a href="<?= base_url();?>auth/keluar" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>