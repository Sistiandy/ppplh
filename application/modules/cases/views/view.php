<div class="content-wrapper" ng-controller="casesCtrl">
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
                                        <td>Posisi</td>
                                        <td>:</td>
                                        <td><?php echo ($case['stage_id'] == STAGE_STAFF) ? 'Sfaff' : 'Analis'; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Daftar Pelanggaran</td>
                                        <td>:</td>
                                        <td>
                                            <?php if (count($casesDisposisi) > 0 AND $this->session->userdata('uroleid') == ROLE_ANALIS) { ?>
                                                <i class="text-muted" ng-show="verifyTrue < 1">Pelanggaran harus diverifikasi terlebih dahulu </i> <i ng-show="animateViolation" class="fa fa-spin fa-spinner"></i>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <div class="col-md-12">
                                                <?php if (count($casesDisposisi) > 0 AND $this->session->userdata('uroleid') == ROLE_ANALIS) { ?>
                                                    <div class="col-md-12">
                                                        <div class="row" ng-repeat="item in violations">
                                                            <div class="col-md-12">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <b>{{ $index + 1}}. {{ item.violation_title}}</b>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <span ng-show="item.verification_by_analis == null">
                                                                                <div class="col-md-8">
                                                                                    <p>--- Verifikasi pelanggaran: </p>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <div class="btn-group pull-right">
                                                                                        <button class="btn btn-sm btn-success" ng-click="verifyViolationYes(item.cases_has_violations_id)">Ya</button>
                                                                                        <button class="btn btn-sm btn-warning" ng-click="verifyViolationNo(item.cases_has_violations_id)">Tidak</button>
                                                                                    </div>
                                                                                </div>
                                                                            </span>
                                                                            <span ng-show="item.verification_by_analis == true">
                                                                                <div class="col-md-8">
                                                                                    <p> --- Verifikasi pelanggaran oleh analis </p>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <p >Ya</p>
                                                                                </div>
                                                                                <div class="col-md-8">
                                                                                    <p>--- Waktu jatuh tempo penerapan sanksi (Hari Kalender): </p>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <div ng-show="item.sanksi_periode == null" class="input-group input-group-sm">
                                                                                        <input type="number" class="form-control" ng-model="itemViolation.sanksi_periode">
                                                                                        <input type="hidden" class="form-control" ng-model="itemViolation.cases_has_violations_id" ng-value="item.cases_has_violations_id" ng-init="itemViolation.cases_has_violations_id = item.cases_has_violations_id">
                                                                                        <span class="input-group-btn">
                                                                                            <button class="btn btn-success" ng-disabled="itemViolation.sanksi_periode == null" ng-click="addSanksiPeriode(itemViolation)"> Simpan</button>
                                                                                        </span>
                                                                                    </div>
                                                                                    <p ng-show="item.sanksi_periode != null">{{ item.sanksi_periode}} Hari</p>
                                                                                </div>
                                                                            </span>
                                                                            <span ng-show="item.verification_by_analis == false">
                                                                                <div class="col-md-8">
                                                                                    <p> --- Verifikasi pelanggaran oleh analis </p>
                                                                                </div>
                                                                                <div class="col-md-3">
                                                                                    <p> Tidak </p>
                                                                                </div>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row" ng-show="item.verification_sanksi1 != null">
                                                                        <div class="col-md-12">
                                                                            <div class="col-md-8">
                                                                                <p> --- Verifikasi lapangan terhadap pelaksanaan isi sanksi pertama:
                                                                            </div>
                                                                            <div class="col-md-2">
                                                                                <p><label class="label label-success" ng-show="item.verification_sanksi1 == true">Sudah</label> <label class="label label-danger" ng-show="item.verification_sanksi1 == false">Belum</label></p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row" ng-show="item.verification_sanksi2 != null">
                                                                        <div class="col-md-12">
                                                                            <div class="col-md-8">
                                                                                <p> --- Verifikasi lapangan terhadap pelaksanaan isi sanksi kedua:
                                                                            </div>
                                                                            <div class="col-md-2">
                                                                                <p><label class="label label-success" ng-show="item.verification_sanksi2 == true">Sudah</label> <label class="label label-danger" ng-show="item.verification_sanksi2 == false">Belum</label></p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row" ng-show="item.verification_sanksi3 != null">
                                                                        <div class="col-md-12">
                                                                            <div class="col-md-8">
                                                                                <p> --- Verifikasi lapangan terhadap pelaksanaan isi sanksi ketiga:
                                                                            </div>
                                                                            <div class="col-md-2">
                                                                                <p><label class="label label-success" ng-show="item.verification_sanksi3 == true">Sudah</label> <label class="label label-danger" ng-show="item.verification_sanksi3 == false">Belum</label></p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row" ng-show="item.verification_sanksi4 != null">
                                                                        <div class="col-md-12">
                                                                            <div class="col-md-8">
                                                                                <p> --- Verifikasi lapangan terhadap pelaksanaan isi sanksi keempat:
                                                                            </div>
                                                                            <div class="col-md-2">
                                                                                <p><label class="label label-success" ng-show="item.verification_sanksi4 == true">Sudah</label> <label class="label label-danger" ng-show="item.verification_sanksi4 == false">Belum</label></p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row" ng-show="item.verification_sanksi5 != null">
                                                                        <div class="col-md-12">
                                                                            <div class="col-md-8">
                                                                                <p> --- Verifikasi lapangan terhadap pelaksanaan isi sanksi kelima:
                                                                            </div>
                                                                            <div class="col-md-2">
                                                                                <p><label class="label label-success" ng-show="item.verification_sanksi5 == true">Sudah</label> <label class="label label-danger" ng-show="item.verification_sanksi5 == false">Belum</label></p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } elseif (count($casesDisposisi) > 0) { ?>
                                                    <div class="col-md-12">
                                                        <div class="row" ng-repeat="item in violations">
                                                            <div class="col-md-12">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <b>{{ $index + 1}}. {{ item.violation_title}}</b>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <span ng-show="item.verification_by_analis == true">
                                                                            <div class="col-md-8">
                                                                                <p> --- Verifikasi pelanggaran oleh analis </p>
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                <p >Ya</p>
                                                                            </div>
                                                                            <div class="col-md-8">
                                                                                <p>--- Waktu jatuh tempo penerapan sanksi (Hari Kalender): </p>
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                <p ng-show="item.sanksi_periode != null">{{ item.sanksi_periode}} Hari</p>
                                                                            </div>
                                                                        </span>
                                                                        <span ng-show="item.verification_by_analis == false">
                                                                            <div class="col-md-8">
                                                                                <p> --- Verifikasi pelanggaran oleh analis </p>
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                <p> Tidak </p>
                                                                            </div>
                                                                        </span>
                                                                        <span ng-show="item.verification_by_analis == null">
                                                                            <div class="col-md-8">
                                                                                <p> --- ( Belum diverifikasi oleh analis ) </p>
                                                                            </div>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="row" ng-show="item.verification_sanksi1 != null">
                                                                    <div class="col-md-12">
                                                                        <div class="col-md-8">
                                                                            <p> --- Verifikasi lapangan terhadap pelaksanaan isi sanksi pertama:
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <p><label class="label label-success" ng-show="item.verification_sanksi1 == true">Sudah</label> <label class="label label-danger" ng-show="item.verification_sanksi1 == false">Belum</label></p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row" ng-show="item.verification_sanksi2 != null">
                                                                    <div class="col-md-12">
                                                                        <div class="col-md-8">
                                                                            <p> --- Verifikasi lapangan terhadap pelaksanaan isi sanksi kedua:
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <p><label class="label label-success" ng-show="item.verification_sanksi2 == true">Sudah</label> <label class="label label-danger" ng-show="item.verification_sanksi2 == false">Belum</label></p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row" ng-show="item.verification_sanksi3 != null">
                                                                    <div class="col-md-12">
                                                                        <div class="col-md-8">
                                                                            <p> --- Verifikasi lapangan terhadap pelaksanaan isi sanksi ketiga:
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <p><label class="label label-success" ng-show="item.verification_sanksi3 == true">Sudah</label> <label class="label label-danger" ng-show="item.verification_sanksi3 == false">Belum</label></p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row" ng-show="item.verification_sanksi4 != null">
                                                                    <div class="col-md-12">
                                                                        <div class="col-md-8">
                                                                            <p> --- Verifikasi lapangan terhadap pelaksanaan isi sanksi keempat:
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <p><label class="label label-success" ng-show="item.verification_sanksi4 == true">Sudah</label> <label class="label label-danger" ng-show="item.verification_sanksi4 == false">Belum</label></p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row" ng-show="item.verification_sanksi5 != null">
                                                                    <div class="col-md-12">
                                                                        <div class="col-md-8">
                                                                            <p> --- Verifikasi lapangan terhadap pelaksanaan isi sanksi kelima:
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <p><label class="label label-success" ng-show="item.verification_sanksi5 == true">Sudah</label> <label class="label label-danger" ng-show="item.verification_sanksi5 == false">Belum</label></p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } else { ?>
                                                    <p ng-repeat="item in violations">{{ $index + 1}}. {{ item.violation_title}}</p>
                                                <?php } ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Jumlah Pelanggaran Yang Diverifikasi</td>
                                        <td>:</td>
                                        <td>{{ verifyTrue}}</td>
                                    </tr>
                                    <tr>
                                        <td>Jumlah Perbaikan Terhadap Verifikasi Lapangan Tahap 1</td>
                                        <td>:</td>
                                        <td>{{ verifyTrue1}}</td>
                                    </tr>
                                    <tr>
                                        <td>Jumlah Perbaikan Terhadap Verifikasi Lapangan Tahap 2</td>
                                        <td>:</td>
                                        <td>{{ verifyTrue2}}</td>
                                    </tr>
                                    <tr>
                                        <td>Daftar Pasal Yang Dilanggar</td>
                                        <td>:</td>
                                        <td> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <div class="col-md-12">
                                                <?php
                                                $i = 1;
                                                foreach ($casesPasal as $row) {
                                                    ?>
                                                    <p>
                                                        <?php echo $i . '. ' . $row['pasal_title'] ?>
                                                    </p>
                                                    <?php
                                                    $i++;
                                                }
                                                ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Memperhatikan</td>
                                        <td>:</td>
                                        <td> </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"><?php echo $case['case_note'] ?></td>
                                    </tr>
                                    <?php if ($case['sanksi_type'] != NULL) { ?>
                                        <tr>
                                            <td>Jenis Sanksi</td>
                                            <td>:</td>
                                            <td><label class="label label-warning"><?php echo $case['sanksi_type'] ?></label></td>
                                        </tr>
                                    <?php } ?>
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
                                    <?php if ($case['case_for_draft'] != NULL) { ?>
                                        <tr>
                                            <td>Buat Draft UDM Dan Sanksi ADM</td>
                                            <td>:</td>
                                            <td><?php echo ($case['case_for_draft'] == TRUE) ? 'Ya' : 'Tidak'; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Tanda Tangan</td>
                                            <td>:</td>
                                            <td><?php echo ($case['case_is_signatured'] == TRUE) ? 'Ya' : 'Tidak'; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Kirim undangan rapat pemberian sanksi</td>
                                            <td>:</td>
                                            <td><?php echo ($case['sent_meeting_invitation'] == TRUE) ? 'Sudah' : 'Belum'; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Berita acara pemanggilan</td>
                                            <td>:</td>
                                            <td><?php echo ($case['berita_acara_pemanggilan'] == TRUE) ? 'Sudah' : 'Belum'; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Publikasi media Jakarta</td>
                                            <td>:</td>
                                            <td><?php echo ($case['case_is_published'] == TRUE) ? 'Sudah' : 'Belum'; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Buat surat tugas verifikasi lapangan</td>
                                            <td>:</td>
                                            <td><?php echo ($case['create_assignment_verification_letter'] == TRUE) ? 'Sudah' : 'Belum'; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Kirim laporan oleh penanggung jawab perusahaan</td>
                                            <td>:</td>
                                            <td><?php echo ($case['sent_report'] == TRUE) ? 'Sudah' : 'Belum'; ?></td>
                                        </tr>
                                    <?php } ?>
                                    <?php if ($case['case_evaluation1_note'] != NULL) { ?>
                                        <tr>
                                            <td>Catatan Evaluasi 1</td>
                                            <td>:</td>
                                            <td><?php echo $case['case_evaluation1_note']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Status Sementara Evaluasi 1</td>
                                            <td>:</td>
                                            <td><?php echo $case['case_evaluation1_status']; ?></td>
                                        </tr>
                                    <?php } ?>
                                    <?php if ($case['case_evaluation2_note'] != NULL) { ?>
                                        <tr>
                                            <td>Catatan Evaluasi 2</td>
                                            <td>:</td>
                                            <td><?php echo $case['case_evaluation2_note']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Status Sementara Evaluasi 2</td>
                                            <td>:</td>
                                            <td><?php echo $case['case_evaluation2_status']; ?></td>
                                        </tr>
                                    <?php } ?>
                                    <?php if ($case['case_evaluation3_note'] != NULL) { ?>
                                        <tr>
                                            <td>Catatan Evaluasi 3</td>
                                            <td>:</td>
                                            <td><?php echo $case['case_evaluation3_note']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Status Sementara Evaluasi 3</td>
                                            <td>:</td>
                                            <td><?php echo $case['case_evaluation3_status']; ?></td>
                                        </tr>
                                    <?php } ?>
                                    <?php if ($case['case_evaluation4_note'] != NULL) { ?>
                                        <tr>
                                            <td>Catatan Evaluasi 4</td>
                                            <td>:</td>
                                            <td><?php echo $case['case_evaluation4_note']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Status Sementara Evaluasi 4</td>
                                            <td>:</td>
                                            <td><?php echo $case['case_evaluation4_status']; ?></td>
                                        </tr>
                                    <?php } ?>
                                    <?php if ($case['case_evaluation5_note'] != NULL) { ?>
                                        <tr>
                                            <td>Catatan Evaluasi 5</td>
                                            <td>:</td>
                                            <td><?php echo $case['case_evaluation5_note']; ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <?php
                            if ($this->session->userdata('uroleid') == ROLE_STAFF) {
                                if ($case['stage_id'] == STAGE_STAFF AND $case['sanksi_type'] == NULL) {
                                    ?>
                                    <button type="button" class="btn btn-lg btn-block btn-success" data-toggle="modal" data-target="#disposisiModal"><i class="fa fa-mail-forward"></i> Disposisi ke Analis</button>
                                <?php } elseif ($case['stage_id'] == STAGE_ANALIS AND $case['sanksi_type'] == NULL) { ?>
                                    <div class="alert alert-info"><center><i class="fa fa-check-circle"></i> Kasus ini sudah di disposisikan</center></div>
                                    <?php
                                }
                            } elseif ($this->session->userdata('uroleid') == ROLE_ANALIS) {
                                if ($case['sanksi_type'] == NULL) {
                                    ?>
                                    <button type="button" class="btn btn-lg btn-block btn-warning" data-toggle="modal" data-target="#sanksiA"><i class="fa fa-edit"></i> Teguran Tertulis</button>
                                    <button type="button" class="btn btn-lg btn-block btn-warning" data-toggle="modal" data-target="#sanksiB"><i class="fa fa-edit"></i> Paksaan Pemerintah</button>
                                    <?php
                                }
                            }
                            ?>
                            <?php if (count($casesViolationsVerify) > 0 AND $case['case_for_draft'] == NULL AND $case['stage_id'] == STAGE_STAFF AND $this->session->userdata('uroleid') == ROLE_STAFF AND $case['case_evaluation1_note'] == NULL) { ?>
                                <div class="col-md-12">
                                    <?php echo form_open_multipart('admin/cases/first_verification/' . $case['case_id']) ?>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <b>Buat Draft UDM Dan Sanksi ADM:</b>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="radio" style="margin-top: 0px">
                                                <label><input type="radio" required="" name="case_for_draft" value="1">Ya</label> <label><input required="" type="radio" name="case_for_draft" value="0">Tidak</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <b>Tanda tangan:</b>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="radio" style="margin-top: 0px">
                                                <label><input type="radio" required="" name="case_is_signatured" value="1">Ya</label> <label><input type="radio" required="" name="case_is_signatured" value="0">Tidak</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <b>Kirim undangan rapat pemberian sanksi:</b>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="radio" style="margin-top: 0px">
                                                <label><input required="" type="radio" name="sent_meeting_invitation" value="1">Sudah</label> <label><input required="" type="radio" name="sent_meeting_invitation" value="0">Belum</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <b>Berita acara pemanggilan:</b>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="radio" style="margin-top: 0px">
                                                <label><input required="" type="radio" name="berita_acara_pemanggilan" value="1">Sudah</label> <label><input required="" type="radio" name="berita_acara_pemanggilan" value="0">Belum</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <b>Publikasi media jakarta:</b>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="radio" style="margin-top: 0px">
                                                <label><input required="" type="radio" name="case_is_published" value="1">Sudah</label> <label><input required="" type="radio" name="case_is_published" value="0">Belum</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <b>Buat surat tugas verifikasi lapangan:</b>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="radio" style="margin-top: 0px">
                                                <label><input required="" type="radio" name="create_assignment_verification_letter" value="1">Sudah</label> <label><input required="" type="radio" name="create_assignment_verification_letter" value="0">Belum</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <b>Kirim laporan oleh penanggung jawab perusahaan:</b>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="radio" style="margin-top: 0px">
                                                <label><input required="" type="radio" name="sent_report" value="1">Sudah</label> <label><input required="" type="radio" name="sent_report" value="0">Belum</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <b>------ VERIFIKASI LAPANGAN TERHADAP PELAKSANAAN ISI SANKSI PERTAMA ------</b>
                                        </div>
                                    </div>
                                    <?php
                                    $i = 1;
                                    foreach ($casesViolationsVerify as $row):
                                        ?>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <?php echo $i . '. ' . $row['violation_title'] ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="radio" style="margin-top: 0px">
                                                    <input type="hidden" name="cases_has_violations_id[]" value="<?php echo $row['cases_has_violations_id'] ?>">
                                                    <label><input required="" type="radio" name="verification_sanksi_<?php echo $row['cases_has_violations_id'] ?>" value="1">SUDAH </label> <label> <input required="" type="radio" name="verification_sanksi_<?php echo $row['cases_has_violations_id'] ?>" value="0">BELUM</label>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        $i++;
                                    endforeach;
                                    ?>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <input type="submit" class="btn btn-success btn-flat btn-block" value="Simpan">
                                        </div>
                                    </div>
                                    <?php echo form_close(); ?>
                                </div>
                            <?php } ?>
                            <?php if ($case['case_for_draft'] != NULL AND $case['stage_id'] == STAGE_ANALIS AND $this->session->userdata('uroleid') == ROLE_ANALIS AND $case['case_evaluation1_note'] == NULL) { ?>
                                <?php echo form_open('admin/cases/first_evaluation/' . $case['case_id']) ?>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Catatan Evaluasi Pertama:</label>
                                        <textarea required="" name="case_evaluation1_note" placeholder="Catatan Evaluasi Pertama" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Status:</label>
                                        <div class="radio">
                                            <label><input required="" type="radio" name="case_evaluation1_status" value="Taat">TAAT </label> <label> <input required="" type="radio" name="case_evaluation1_status" value="Belum Taat">BELUM TAAT</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <input type="submit" class="btn btn-block btn-success btn-flat" value="Simpan">
                                </div>
                                <?php echo form_close() ?>
                            <?php } ?>


                            <?php if ($case['case_evaluation1_note'] != NULL AND $case['stage_id'] == STAGE_STAFF AND $this->session->userdata('uroleid') == ROLE_STAFF AND $case['case_evaluation2_note'] == NULL) { ?>
                                <div class="col-md-12">
                                    <?php echo form_open_multipart('admin/cases/second_verification/' . $case['case_id']) ?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <b>------ VERIFIKASI LAPANGAN TERHADAP PELAKSANAAN ISI SANKSI KEDUA ------</b>
                                        </div>
                                    </div>
                                    <?php
                                    $i = 1;
                                    foreach ($casesViolations as $row):
                                        if ($row['verification_sanksi1'] == 0 AND $row['verification_sanksi1'] != NULL) {
                                            ?>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <?php echo $i . '. ' . $row['violation_title'] ?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="radio" style="margin-top: 0px">
                                                        <input type="hidden" name="cases_has_violations_id[]" value="<?php echo $row['cases_has_violations_id'] ?>">
                                                        <label><input required="" type="radio" name="verification_sanksi_<?php echo $row['cases_has_violations_id'] ?>" value="1">SUDAH </label> <label> <input required="" type="radio" name="verification_sanksi_<?php echo $row['cases_has_violations_id'] ?>" value="0">BELUM</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            $i++;
                                        } elseif ($row['verification_sanksi1'] == TRUE) {
                                            ?>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <input type="hidden" name="cases_has_violations_id[]" value="<?php echo $row['cases_has_violations_id'] ?>">
                                                    <input type="hidden" name="verification_sanksi_<?php echo $row['cases_has_violations_id'] ?>" value="1">
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    endforeach;
                                    ?>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <input type="submit" class="btn btn-success btn-flat btn-block" value="Simpan">
                                        </div>
                                    </div>
                                    <?php echo form_close(); ?>
                                </div>
                            <?php } ?>
                            <?php if ($case['case_evaluation1_note'] != NULL AND $case['stage_id'] == STAGE_ANALIS AND $this->session->userdata('uroleid') == ROLE_ANALIS AND $case['case_evaluation2_note'] == NULL) { ?>
                                <?php echo form_open('admin/cases/second_evaluation/' . $case['case_id']) ?>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Catatan Evaluasi Kedua:</label>
                                        <textarea required="" name="case_evaluation2_note" placeholder="Catatan Evaluasi Kedua" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Status:</label>
                                        <div class="radio">
                                            <label><input required="" type="radio" name="case_evaluation2_status" value="Taat">TAAT </label> <label> <input required="" type="radio" name="case_evaluation2_status" value="Belum Taat">BELUM TAAT</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <input type="submit" class="btn btn-block btn-success btn-flat" value="Simpan">
                                </div>
                                <?php echo form_close() ?>
                            <?php } ?>

                            <?php if ($case['case_evaluation2_note'] != NULL AND $case['stage_id'] == STAGE_STAFF AND $this->session->userdata('uroleid') == ROLE_STAFF AND $case['case_evaluation3_note'] == NULL) { ?>
                                <div class="col-md-12">
                                    <?php echo form_open_multipart('admin/cases/third_verification/' . $case['case_id']) ?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <b>------ VERIFIKASI LAPANGAN TERHADAP PELAKSANAAN ISI SANKSI KETIGA ------</b>
                                        </div>
                                    </div>
                                    <?php
                                    $i = 1;
                                    foreach ($casesViolations as $row):
                                        if ($row['verification_sanksi2'] == 0 AND $row['verification_sanksi2'] != NULL) {
                                            ?>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <?php echo $i . '. ' . $row['violation_title'] ?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="radio" style="margin-top: 0px">
                                                        <input type="hidden" name="cases_has_violations_id[]" value="<?php echo $row['cases_has_violations_id'] ?>">
                                                        <label><input required="" type="radio" name="verification_sanksi_<?php echo $row['cases_has_violations_id'] ?>" value="1">SUDAH </label> <label> <input required="" type="radio" name="verification_sanksi_<?php echo $row['cases_has_violations_id'] ?>" value="0">BELUM</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            $i++;
                                        } elseif ($row['verification_sanksi2'] == TRUE) {
                                            ?>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <input type="hidden" name="cases_has_violations_id[]" value="<?php echo $row['cases_has_violations_id'] ?>">
                                                    <input type="hidden" name="verification_sanksi_<?php echo $row['cases_has_violations_id'] ?>" value="1">
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    endforeach;
                                    ?>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <input type="submit" class="btn btn-success btn-flat btn-block" value="Simpan">
                                        </div>
                                    </div>
                                    <?php echo form_close(); ?>
                                </div>
                            <?php } ?>
                            <?php if ($case['case_evaluation2_note'] != NULL AND $case['stage_id'] == STAGE_ANALIS AND $this->session->userdata('uroleid') == ROLE_ANALIS AND $case['case_evaluation3_note'] == NULL) { ?>
                                <?php echo form_open('admin/cases/third_evaluation/' . $case['case_id']) ?>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Catatan Evaluasi Ketiga:</label>
                                        <textarea required="" name="case_evaluation3_note" placeholder="Catatan Evaluasi Ketiga" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Status:</label>
                                        <div class="radio">
                                            <label><input required="" type="radio" name="case_evaluation3_status" value="Taat">TAAT </label> <label> <input required="" type="radio" name="case_evaluation3_status" value="Belum Taat">BELUM TAAT</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <input type="submit" class="btn btn-block btn-success btn-flat" value="Simpan">
                                </div>
                                <?php echo form_close() ?>
                            <?php } ?>

                            <?php if ($case['case_evaluation3_note'] != NULL AND $case['stage_id'] == STAGE_STAFF AND $this->session->userdata('uroleid') == ROLE_STAFF AND $case['case_evaluation4_note'] == NULL) { ?>
                                <div class="col-md-12">
                                    <?php echo form_open_multipart('admin/cases/fourth_verification/' . $case['case_id']) ?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <b>------ VERIFIKASI LAPANGAN TERHADAP PELAKSANAAN ISI SANKSI KEEMPAT ------</b>
                                        </div>
                                    </div>
                                    <?php
                                    $i = 1;
                                    foreach ($casesViolations as $row):
                                        if ($row['verification_sanksi3'] == 0 AND $row['verification_sanksi3'] != NULL) {
                                            ?>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <?php echo $i . '. ' . $row['violation_title'] ?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="radio" style="margin-top: 0px">
                                                        <input type="hidden" name="cases_has_violations_id[]" value="<?php echo $row['cases_has_violations_id'] ?>">
                                                        <label><input required="" type="radio" name="verification_sanksi_<?php echo $row['cases_has_violations_id'] ?>" value="1">SUDAH </label> <label> <input required="" type="radio" name="verification_sanksi_<?php echo $row['cases_has_violations_id'] ?>" value="0">BELUM</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            $i++;
                                        } elseif ($row['verification_sanksi3'] == TRUE) {
                                            ?>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <input type="hidden" name="cases_has_violations_id[]" value="<?php echo $row['cases_has_violations_id'] ?>">
                                                    <input type="hidden" name="verification_sanksi_<?php echo $row['cases_has_violations_id'] ?>" value="1">
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    endforeach;
                                    ?>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <input type="submit" class="btn btn-success btn-flat btn-block" value="Simpan">
                                        </div>
                                    </div>
                                    <?php echo form_close(); ?>
                                </div>
                            <?php } ?>
                            <?php if ($case['case_evaluation3_note'] != NULL AND $case['stage_id'] == STAGE_ANALIS AND $this->session->userdata('uroleid') == ROLE_ANALIS AND $case['case_evaluation4_note'] == NULL) { ?>
                                <?php echo form_open('admin/cases/fourth_evaluation/' . $case['case_id']) ?>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Catatan Evaluasi Keempat:</label>
                                        <textarea required="" name="case_evaluation4_note" placeholder="Catatan Evaluasi Keempat" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Status:</label>
                                        <div class="radio">
                                            <label><input required="" type="radio" name="case_evaluation4_status" value="Taat">TAAT </label> <label> <input required="" type="radio" name="case_evaluation4_status" value="Belum Taat">BELUM TAAT</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <input type="submit" class="btn btn-block btn-success btn-flat" value="Simpan">
                                </div>
                                <?php echo form_close() ?>
                            <?php } ?>

                            <?php if ($case['case_evaluation4_note'] != NULL AND $case['stage_id'] == STAGE_STAFF AND $this->session->userdata('uroleid') == ROLE_STAFF AND $case['case_evaluation5_note'] == NULL) { ?>
                                <div class="col-md-12">
                                    <?php echo form_open_multipart('admin/cases/fifth_verification/' . $case['case_id']) ?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <b>------ VERIFIKASI LAPANGAN TERHADAP PELAKSANAAN ISI SANKSI KELIMA ------</b>
                                        </div>
                                    </div>
                                    <?php
                                    $i = 1;
                                    foreach ($casesViolations as $row):
                                        if ($row['verification_sanksi4'] == 0 AND $row['verification_sanksi4'] != NULL) {
                                            ?>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <?php echo $i . '. ' . $row['violation_title'] ?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="radio" style="margin-top: 0px">
                                                        <input type="hidden" name="cases_has_violations_id[]" value="<?php echo $row['cases_has_violations_id'] ?>">
                                                        <label><input required="" type="radio" name="verification_sanksi_<?php echo $row['cases_has_violations_id'] ?>" value="1">SUDAH </label> <label> <input required="" type="radio" name="verification_sanksi_<?php echo $row['cases_has_violations_id'] ?>" value="0">BELUM</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            $i++;
                                        } elseif ($row['verification_sanksi4'] == TRUE) {
                                            ?>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <input type="hidden" name="cases_has_violations_id[]" value="<?php echo $row['cases_has_violations_id'] ?>">
                                                    <input type="hidden" name="verification_sanksi_<?php echo $row['cases_has_violations_id'] ?>" value="1">
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    endforeach;
                                    ?>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <input type="submit" class="btn btn-success btn-flat btn-block" value="Simpan">
                                        </div>
                                    </div>
                                    <?php echo form_close(); ?>
                                </div>
                            <?php } ?>
                            <?php if ($case['case_evaluation4_note'] != NULL AND $case['stage_id'] == STAGE_ANALIS AND $this->session->userdata('uroleid') == ROLE_ANALIS AND $case['case_evaluation5_note'] == NULL) { ?>
                                <?php echo form_open('admin/cases/fifth_evaluation/' . $case['case_id']) ?>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Catatan Evaluasi Kelima:</label>
                                        <textarea required="" name="case_evaluation5_note" placeholder="Catatan Evaluasi Kelima" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <input type="submit" class="btn btn-block btn-success btn-flat" value="Simpan">
                                </div>
                                <?php echo form_close() ?>
                            <?php } ?>
                            <?php if ($case['stage_id'] == STAGE_ANALIS AND $this->session->userdata('uroleid') == ROLE_ANALIS AND $case['case_evaluation4_status'] == 'Belum Taat' AND $case['case_evaluation5_note'] != NULL  AND $case['case_final_status'] == NULL) { ?>
                                <button type="button" class="btn btn-lg btn-block btn-warning" data-toggle="modal" data-target="#statusTaat"><i class="fa fa-check"></i> TAAT</button>
                                <button type="button" class="btn btn-lg btn-block btn-warning" data-toggle="modal" data-target="#statusTidakTaat"><i class="fa fa-close"></i> TIDAK TAAT</button>
                            <?php } ?>
                            <?php if ($case['case_final_status'] == 'Taat') { ?>
                                <div class="alert alert-success"><center><b>Kasus ini dinyatakan <?php echo $case['case_final_status'] ?></b></center></div>
                            <?php } ?>
                            <?php if ($case['case_final_status'] == 'Tidak Taat') { ?>
                                <div class="alert alert-danger"><center><b>Kasus ini dinyatakan <?php echo $case['case_final_status'] ?></b></center></div>
                            <?php } ?>
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

    <!--Modal taat -->
    <div class="modal fade" id="statusTaat">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title"><span class="fa fa-edit"></span> Konfirmasi Pemberian Status</h3>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin akan menyatakan kasus ini Taat?</p>
                </div>
                <div class="modal-footer">
                    <?php echo form_open('admin/cases/status/' . $case['case_id']); ?>
                    <input type="hidden" name="case_final_status" value="Taat">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> Batal</button>
                    <button type="submit" class="btn btn-success"><span class="fa fa-check"></span> Simpan</button>
                    <?php echo form_close() ?>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!--Modal tidak taat -->
    <div class="modal fade" id="statusTidakTaat">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title"><span class="fa fa-edit"></span> Konfirmasi Pemberian Status</h3>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin akan menyatakan kasus ini Tidak Taat?</p>
                </div>
                <div class="modal-footer">
                    <?php echo form_open('admin/cases/status/' . $case['case_id']); ?>
                    <input type="hidden" name="case_final_status" value="Tidak Taat">
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

<script>
    var app = angular.module("app", []);
    var BASEURL = '<?php echo site_url(); ?>';
    app.controller('casesCtrl', function ($scope, $http) {
        $scope.violations = [];
        $scope.verifyTrue = 0;
        $scope.verifyTrue1 = 0;
        $scope.verifyTrue2 = 0;
        $scope.animateviolations = false;
        $scope.getViolations = function () {

            var url = BASEURL + 'api/getViolationsByCase/<?php echo $case['case_id'] ?>';
            $http.get(url).then(function (response) {
                $scope.verifyTrue = 0;
                $scope.verifyTrue1 = 0;
                $scope.verifyTrue2 = 0;
                $scope.violations = response.data;
                angular.forEach($scope.violations, function (value) {
                    if (value.verification_by_analis == true) {
                        $scope.verifyTrue++;
                    }
                    if (value.verification_sanksi1 == true) {
                        $scope.verifyTrue1++;
                    }
                    if (value.verification_sanksi2 == true) {
                        $scope.verifyTrue2++;
                    }
                });
            })
        };
        $scope.verifyViolationYes = function (data) {
            $scope.animateViolation = true;
            var postData = $.param({
                cases_has_violations_id: data,
                desc: 'yes'
            });
            $.ajax({
                method: "POST",
                url: BASEURL + "admin/cases/verifyViolations",
                data: postData,
                success: function (response) {
                    $scope.animateViolation = false;
                    $scope.getViolations();
                }
            });
        };
        $scope.verifyViolationNo = function (data) {
            $scope.animateViolation = true;
            var postData = $.param({
                cases_has_violations_id: data,
                desc: 'no'
            });
            $.ajax({
                method: "POST",
                url: BASEURL + "admin/cases/verifyViolations",
                data: postData,
                success: function (response) {
                    $scope.animateViolation = false;
                    $scope.getViolations();
                }
            });
        };
        $scope.addSanksiPeriode = function (data) {
            $scope.animateViolation = true;
            var postData = $.param(data);
            $.ajax({
                method: "POST",
                url: BASEURL + "admin/cases/addSanksiPeriode",
                data: postData,
                success: function (response) {
                    $scope.animateViolation = false;
                    $scope.getViolations();
                }
            });
        };
        angular.element(document).ready(function () {
            $scope.getViolations();
        });
    });
</script>
