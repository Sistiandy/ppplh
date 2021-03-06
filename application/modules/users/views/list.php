<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Pengguna
            <small>List</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Pengguna</li>
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
                        <table class="table table-init table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Peran</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($users > 0) {
                                    $i = 1;
                                    foreach ($users as $row):
                                        ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $row['user_full_name']; ?></td>
                                            <td><?php echo $row['user_email']; ?></td>
                                            <td><?php echo $row['role_name']; ?></td>
                                            <td>
                                                <a href="<?php echo site_url('admin/users/view/' . $row['user_id']) ?>" data-toggle="tooltip" title="Lihat" class="text-warning"><span class="fa fa-eye"></span></a> &nbsp;
                                                <?php if ($this->session->userdata('uroleid') == ROLE_STAFF) { ?>
                                                    <a href="<?php echo site_url('admin/users/edit/' . $row['user_id']) ?>" data-toggle="tooltip" title="Sunting" class="text-success"><span class="fa fa-edit"></span></a> &nbsp;
                                                    <?php if ($row['user_id'] != $this->session->userdata('uid')) { ?>
                                                        <a href="#delModal<?php echo $row['user_id']; ?>" data-toggle="modal" class="text-danger"><span data-toggle="tooltip" title="Hapus" class="fa fa-trash"></span></a> &nbsp;
                                                    <?php } ?>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <div class="modal modal-danger fade" id="delModal<?php echo $row['user_id']; ?>">
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
                                                    <?php echo form_open('admin/users/delete/' . $row['user_id']); ?>
                                                    <input type="hidden" name="delName" value="<?php echo $row['user_full_name']; ?>">
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span> Batal</button>
                                                    <button type="submit" class="btn btn-outline"><span class="fa fa-check"></span> Hapus</button>
                                                    <?php echo form_close(); ?>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    <?php
                                    $i++;
                                endforeach;
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
        <!-- /.row -->

    </section>
    <!-- /.content -->
</div>