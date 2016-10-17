<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Instansi
            <small>Detail</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Instansi</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="col-md-10 col-sm-12 col-xs-12 pull-left">
                            <h4>
                                <small>
                                    <strong class="tgl-dftr"><span class="fa fa-calendar"></span></strong>
                                    <em><?php echo pretty_date($instance['instance_input_date']) ?></em>
                                </small>
                            </h4>
                            <table class="table table-condensed">
                                <tbody>
                                    <tr>
                                        <td>Nama</td>
                                        <td>:</td>
                                        <td><?php echo $instance['instance_name'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>No. Telepon</td>
                                        <td>:</td>
                                        <td><?php echo $instance['instance_phone'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td>:</td>
                                        <td><?php echo $instance['instance_email'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Alamat</td>
                                        <td>:</td>
                                        <td><?php echo $instance['instance_address'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Penulis</td>
                                        <td>:</td>
                                        <td><?php echo $instance['user_full_name'] ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-2">
                            <a href="<?php echo site_url('admin/Instances') ?>" class="btn btn-app">
                                <i class="fa fa-arrow-circle-o-left"></i> Batal
                            </a>
                            <?php if ($this->session->userdata('uroleid') == ROLE_STAFF) { ?>
                                <a href="<?php echo site_url('admin/Instances/edit/' . $instance['instance_id']) ?>" class="btn btn-app">
                                    <i class="fa fa-edit"></i> Edit
                                </a>
                                <a href="#delModal" data-toggle="modal" class="btn btn-app">
                                    <i class="fa fa-trash"></i> Hapus
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
        <!-- /.row -->

    </section>
    <!-- /.content -->

    <div class="modal modal-danger fade" id="delModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title"><span class="fa fa-warning"></span> Konfirmasi penghapusan</h3>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin akan menghapus data ini?</p>
                </div>
                <div class="modal-footer">
                    <?php echo form_open('admin/Instances/delete/' . $instance['instance_id']); ?>
                    <input type="hidden" name="delName" value="<?php echo $instance['instance_name']; ?>">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span> Batal</button>
                    <button type="submit" class="btn btn-outline"><span class="fa fa-check"></span> Hapus</button>
                    <?php echo form_close(); ?>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>