<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?php echo media_url() ?>/img/user.png" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p><?php echo ucfirst($this->session->userdata('ufullname')); ?></p>
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
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li class="<?php echo ($this->uri->segment(2) == 'dashboard' OR $this->uri->segment(2) == NULL) ? 'active' : '' ?> treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php echo ($this->uri->segment(2) == 'dashboard' OR $this->uri->segment(2) == NULL) ? 'active' : '' ?>"><a href="<?php echo site_url('admin') ?>"><i class="fa <?php echo ($this->uri->segment(2) == 'dashboard' OR $this->uri->segment(2) == NULL) ? 'fa-dot-circle-o' : 'fa-circle-o' ?>"></i> Dashboard</a></li>
                </ul>
            </li>
            <li class="<?php echo ($this->uri->segment(2) == 'cases') ? 'active' : '' ?> treeview">
                <a href="#">
                    <i class="fa fa-balance-scale"></i> <span>Kasus Pelanggaran</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php echo ($this->uri->segment(2) == 'cases' AND $this->uri->segment(3) != 'add') ? 'active' : '' ?> ">
                        <a href="<?php echo site_url('admin/cases') ?>"><i class="fa  <?php echo ($this->uri->segment(2) == 'cases' AND $this->uri->segment(3) != 'add') ? 'fa-dot-circle-o' : 'fa-circle-o' ?>"></i> Daftar Kasus Pelanggaran</a>
                    </li>
                    <?php if ($this->session->userdata('uroleid') == ROLE_STAFF) { ?>
                        <li class="<?php echo ($this->uri->segment(2) == 'cases' AND $this->uri->segment(3) == 'add') ? 'active' : '' ?> ">
                            <a href="<?php echo site_url('admin/cases/add') ?>"><i class="fa  <?php echo ($this->uri->segment(2) == 'cases' AND $this->uri->segment(3) == 'add') ? 'fa-dot-circle-o' : 'fa-circle-o' ?>"></i> Tambah Kasus Pelanggaran</a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
            <li class="<?php echo ($this->uri->segment(2) == 'instances') ? 'active' : '' ?> treeview">
                <a href="#">
                    <i class="fa fa-bank"></i> <span>Instansi</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php echo ($this->uri->segment(2) == 'instances' AND $this->uri->segment(3) != 'add') ? 'active' : '' ?> ">
                        <a href="<?php echo site_url('admin/instances') ?>"><i class="fa  <?php echo ($this->uri->segment(2) == 'instances' AND $this->uri->segment(3) != 'add') ? 'fa-dot-circle-o' : 'fa-circle-o' ?>"></i> Daftar Instansi</a>
                    </li>
                    <?php if ($this->session->userdata('uroleid') == ROLE_STAFF) { ?>
                        <li class="<?php echo ($this->uri->segment(2) == 'instances' AND $this->uri->segment(3) == 'add') ? 'active' : '' ?> ">
                            <a href="<?php echo site_url('admin/instances/add') ?>"><i class="fa  <?php echo ($this->uri->segment(2) == 'instances' AND $this->uri->segment(3) == 'add') ? 'fa-dot-circle-o' : 'fa-circle-o' ?>"></i> Tambah Instansi</a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
            <li class="<?php echo ($this->uri->segment(2) == 'activities') ? 'active' : '' ?> treeview">
                <a href="#">
                    <i class="fa fa-book"></i> <span>Jenis Kegiatan</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php echo ($this->uri->segment(2) == 'activities' AND $this->uri->segment(3) != 'add') ? 'active' : '' ?> ">
                        <a href="<?php echo site_url('admin/activities') ?>"><i class="fa  <?php echo ($this->uri->segment(2) == 'activities' AND $this->uri->segment(3) != 'add') ? 'fa-dot-circle-o' : 'fa-circle-o' ?>"></i> Daftar Jenis Kegiatan</a>
                    </li>
                    <?php if ($this->session->userdata('uroleid') == ROLE_STAFF) { ?>
                        <li class="<?php echo ($this->uri->segment(2) == 'activities' AND $this->uri->segment(3) == 'add') ? 'active' : '' ?> ">
                            <a href="<?php echo site_url('admin/activities/add') ?>"><i class="fa  <?php echo ($this->uri->segment(2) == 'activities' AND $this->uri->segment(3) == 'add') ? 'fa-dot-circle-o' : 'fa-circle-o' ?>"></i> Tambah Jenis Kegiatan</a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
            <li class="<?php echo ($this->uri->segment(2) == 'violations') ? 'active' : '' ?> treeview">
                <a href="#">
                    <i class="fa fa-ban"></i> <span>Pelanggaran</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php echo ($this->uri->segment(2) == 'violations' AND $this->uri->segment(3) != 'add') ? 'active' : '' ?> ">
                        <a href="<?php echo site_url('admin/violations') ?>"><i class="fa  <?php echo ($this->uri->segment(2) == 'violations' AND $this->uri->segment(3) != 'add') ? 'fa-dot-circle-o' : 'fa-circle-o' ?>"></i> Daftar Pelanggaran</a>
                    </li>
                    <?php if ($this->session->userdata('uroleid') == ROLE_STAFF) { ?>
                        <li class="<?php echo ($this->uri->segment(2) == 'violations' AND $this->uri->segment(3) == 'add') ? 'active' : '' ?> ">
                            <a href="<?php echo site_url('admin/violations/add') ?>"><i class="fa  <?php echo ($this->uri->segment(2) == 'violations' AND $this->uri->segment(3) == 'add') ? 'fa-dot-circle-o' : 'fa-circle-o' ?>"></i> Tambah Pelanggaran</a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
            <li class="<?php echo ($this->uri->segment(2) == 'pasal') ? 'active' : '' ?> treeview">
                <a href="#">
                    <i class="fa fa-gavel"></i> <span>Pasal</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php echo ($this->uri->segment(2) == 'pasal' AND $this->uri->segment(3) != 'add') ? 'active' : '' ?> ">
                        <a href="<?php echo site_url('admin/pasal') ?>"><i class="fa  <?php echo ($this->uri->segment(2) == 'pasal' AND $this->uri->segment(3) != 'add') ? 'fa-dot-circle-o' : 'fa-circle-o' ?>"></i> Daftar Pasal</a>
                    </li>
                    <?php if ($this->session->userdata('uroleid') == ROLE_STAFF) { ?>
                        <li class="<?php echo ($this->uri->segment(2) == 'pasal' AND $this->uri->segment(3) == 'add') ? 'active' : '' ?> ">
                            <a href="<?php echo site_url('admin/pasal/add') ?>"><i class="fa  <?php echo ($this->uri->segment(2) == 'pasal' AND $this->uri->segment(3) == 'add') ? 'fa-dot-circle-o' : 'fa-circle-o' ?>"></i> Tambah Pasal</a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
            <li class="<?php echo ($this->uri->segment(2) == 'users') ? 'active' : '' ?> treeview">
                <a href="#">
                    <i class="fa fa-users"></i> <span>Pengguna</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php echo ($this->uri->segment(2) == 'users' AND $this->uri->segment(3) != 'add') ? 'active' : '' ?> ">
                        <a href="<?php echo site_url('admin/users') ?>"><i class="fa  <?php echo ($this->uri->segment(2) == 'users' AND $this->uri->segment(3) != 'add') ? 'fa-dot-circle-o' : 'fa-circle-o' ?>"></i> Daftar Pengguna</a>
                    </li>
                    <?php if ($this->session->userdata('uroleid') == ROLE_STAFF) { ?>
                        <li class="<?php echo ($this->uri->segment(2) == 'users' AND $this->uri->segment(3) == 'add') ? 'active' : '' ?> ">
                            <a href="<?php echo site_url('admin/users/add') ?>"><i class="fa  <?php echo ($this->uri->segment(2) == 'users' AND $this->uri->segment(3) == 'add') ? 'fa-dot-circle-o' : 'fa-circle-o' ?>"></i> Tambah Pengguna</a>
                        </li>
                    <?php } ?>
                </ul>
            </li>
            <li class="<?php echo ($this->uri->segment(2) == 'logs') ? 'active' : '' ?> treeview">
                <a href="#">
                    <i class="fa fa-history"></i> <span>Log Aktifitas</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="<?php echo ($this->uri->segment(2) == 'logs' AND $this->uri->segment(3) != 'add') ? 'active' : '' ?> ">
                        <a href="<?php echo site_url('admin/logs') ?>"><i class="fa  <?php echo ($this->uri->segment(2) == 'logs' AND $this->uri->segment(3) != 'add') ? 'fa-dot-circle-o' : 'fa-circle-o' ?>"></i> Daftar Log</a>
                    </li>
                </ul>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>