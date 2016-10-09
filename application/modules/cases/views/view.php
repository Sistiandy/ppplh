<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Kasus Pelanggaran
            <small>Detail</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Kasus Pelanggaran</li>
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
                                    <em><?php echo pretty_date($case['case_input_date']) ?></em>
                                </small>
                            </h4>
                            <table class="table table-condensed">
                                <tbody>
                                    <tr>
                                        <td>Nama Instansi</td>
                                        <td>:</td>
                                        <td><?php echo $case['instance_name'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Jenis Kegiatan</td>
                                        <td>:</td>
                                        <td><?php echo $case['activity_title'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Alamat</td>
                                        <td>:</td>
                                        <td><?php echo $case['case_address'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Wilayah</td>
                                        <td>:</td>
                                        <td><?php echo $case['case_region'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Pelimpahan</td>
                                        <td>:</td>
                                        <td><?php echo $case['channel_name'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Daftar Pelanggaran</td>
                                        <td>:</td>
                                        <td>
                                            <ul>
                                                <?php foreach ($casesViolations as $row) { ?>
                                                    <li>
                                                        <?php echo $row['violation_title'] ?>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal Pelimpahan</td>
                                        <td>:</td>
                                        <td><?php echo pretty_date($case['case_date'], 'l, d F Y', FALSE) ?></td>
                                    </tr>
                                    <tr>
                                        <td>Penulis</td>
                                        <td>:</td>
                                        <td><?php echo $case['user_full_name']; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <?php
                            if ($this->session->userdata('uroleid') == ROLE_STAFF) {
                                if ($case['stage_id'] == STAGE_STAFF) {
                                    ?>
                                    <button type="button" class="btn btn-lg btn-block btn-success" data-toggle="modal" data-target="#disposisiModal"><i class="fa fa-mail-forward"></i> Disposisi ke Analis</button>
                                <?php } else { ?>
                                    <div class="alert alert-info"><center><i class="fa fa-check-circle"></i> Kasus ini sudah di disposisikan</center></div>
                                    <?php
                                }
                            } elseif ($this->session->userdata('uroleid') == ROLE_ANALIS) {
                                if ($case['sanksi_type'] == NULL) {
                                ?>
                                <button type="button" class="btn btn-lg btn-block btn-warning" data-toggle="modal" data-target="#sanksiA"><i class="fa fa-edit"></i> Teguran Tertulis</button>
                                <button type="button" class="btn btn-lg btn-block btn-warning" data-toggle="modal" data-target="#sanksiB"><i class="fa fa-edit"></i> Paksaan Pemerintah</button>
                                <?php }else{ ?>
                                <div class="alert alert-warning"><center><h4>Jenis sanksi: <?php echo $case['sanksi_type']; ?></h4></center></div>
                            <?php } } ?>
                        </div>
                        <div class="col-md-2">
                            <a href="<?php echo site_url('admin/cases') ?>" class="btn btn-app">
                                <i class="fa fa-arrow-circle-o-left"></i> Batal
                            </a>
                            <a href="<?php echo site_url('admin/cases/edit/' . $case['case_id']) ?>" class="btn btn-app">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            <a href="#delModal" data-toggle="modal" class="btn btn-app">
                                <i class="fa fa-trash"></i> Hapus
                            </a>
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
                    <?php echo form_open('admin/cases/delete/' . $case['case_id']); ?>
                    <input type="hidden" name="delName" value="<?php echo $case['instances_instance_id']; ?>">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-close"></span> Batal</button>
                    <button type="submit" class="btn btn-outline"><span class="fa fa-check"></span> Hapus</button>
                    <?php echo form_close(); ?>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!--Modal disposisi-->
    <div class="modal fade" id="disposisiModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title"><span class="fa fa-mail-forward"></span> Konfirmasi Disposisi</h3>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin mendisposisikan kasus ini ke bagian analis?</p>
                </div>
                <div class="modal-footer">
                    <?php echo form_open('admin/cases/disposisi/' . $case['case_id']); ?>
                    <?php if ($this->session->userdata('uroleid') == ROLE_STAFF) { ?>
                        <input type="hidden" name="from_role_id" value="<?php echo ROLE_STAFF; ?>">
                        <input type="hidden" name="to_role_id" value="<?php echo ROLE_ANALIS; ?>">
                        <input type="hidden" name="stage_id" value="<?php echo STAGE_ANALIS; ?>">
                    <?php } ?>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> Batal</button>
                    <button type="submit" class="btn btn-success"><span class="fa fa-check"></span> Simpan</button>
                    <?php echo form_close() ?>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!--Modal penalty A-->
    <div class="modal fade" id="sanksiA">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title"><span class="fa fa-edit"></span> Konfirmasi Pemberian Sanksi</h3>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin akan memberi sanksi <b>Teguran Tertulis</b>?</p>
                </div>
                <div class="modal-footer">
                    <?php echo form_open('admin/cases/penalty/' . $case['case_id']); ?>
                    <input type="hidden" name="sanksi_type" value="Teguran Tertulis">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> Batal</button>
                    <button type="submit" class="btn btn-success"><span class="fa fa-check"></span> Simpan</button>
                    <?php echo form_close() ?>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!--Modal penalty B-->
    <div class="modal fade" id="sanksiB">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title"><span class="fa fa-edit"></span> Konfirmasi Pemberian Sanksi</h3>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin akan memberi sanksi <b>Paksaan Pemerintah</b>?</p>
                </div>
                <div class="modal-footer">
                    <?php echo form_open('admin/cases/penalty/' . $case['case_id']); ?>
                    <input type="hidden" name="sanksi_type" value="Paksaan Pemerintah">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> Batal</button>
                    <button type="submit" class="btn btn-success"><span class="fa fa-check"></span> Simpan</button>
                    <?php echo form_close() ?>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>