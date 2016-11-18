<div class="content-wrapper">
    <style>
        td i{
            color: black
        }
    </style>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo $title ?>
            <small>List</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active"><?php echo $title ?></li> &nbsp;
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->

        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <!-- /.box-header -->
                    <div class="box-header with-border">
                        <div class="row">
                            <?php echo form_open(current_url(), array('method' => 'get')) ?> 
                            <div class="col-md-3">
                                <select name="a" class="form-control autocomplete">
                                    <option value="">Berdasarkan jenis kegiatan..</option>
                                    <?php foreach ($types as $row): ?>
                                        <option value="<?php echo $row['activity_id'] ?>" ><?php echo $row['activity_title'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="r" class="form-control autocomplete">
                                    <option value="">Berdasarkan wilayah..</option>
                                    <option value="Jakarta Pusat" >Jakarta Pusat</option>
                                    <option value="Jakarta Selatan">Jakarta Selatan</option>
                                    <option value="Jakarta Timur">Jakarta Timur</option>
                                    <option value="Jakarta Barat">Jakarta Barat</option>
                                    <option value="Jakarta Utara">Jakarta Utara</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="text" placeholder="Dari Tanggal" class="form-control datepicker" name="ds">
                            </div>
                            <div class="col-md-2">
                                <input type="text" placeholder="Sampai Tanggal" class="form-control datepicker" name="de">
                            </div>
                            <div class="col-md-2">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-success btn-flat "><span class="fa fa-filter"></span> Filter</button>
                                    <a target="_blank" href="<?php echo site_url('admin/reports/pdf/' . $status . '?' . http_build_query($q)) ?>" class="btn btn-danger btn-flat"><span class="fa fa-print"></span> PDF</a>
                                </div>
                            </div>
                            <?php echo form_close() ?>
                        </div>
                    </div>
                    <div class=" box-body ">
                        <table class="table table-init table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th style=" min-width: 150px">Nama Kegiatan</th>
                                    <th style=" min-width: 150px">Jenis Kegiatan</th>
                                    <th style=" min-width: 150px">Alamat</th>
                                    <th style=" min-width: 100px">Wilayah</th>
                                    <th style=" min-width: 150px">Pelimpahan</th>
                                    <th>Posisi</th>
                                    <th style=" min-width: 130px">Tanggal</th>
                                    <th style=" min-width: 170px">Status</th>
                                    <th style=" min-width: 40px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($cases > 0) {
                                    $i = 1;
                                    foreach ($cases as $row):
                                        ?>
                                        <tr class="<?php
                                        if ($row['case_final_status'] == 'Taat') {
                                            echo 'tr_success';
                                        } elseif ($row['case_final_status'] == 'Tidak Taat') {
                                            echo 'tr_danger';
                                        } else {
                                            echo 'tr_proses';
                                        }
                                        ?>">
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $row['instance_name']; ?></td>
                                            <td><?php echo $row['activity_title']; ?></td>
                                            <td><?php echo $row['case_address']; ?></td>
                                            <td><?php echo $row['case_region']; ?></td>
                                            <td><?php echo $row['channel_name']; ?></td>
                                            <td><?php echo ($row['stage_id'] == STAGE_STAFF) ? 'Staff' : 'Analis' ?></td>
                                            <td><?php echo pretty_date($row['case_date'], 'l, d F Y', FALSE); ?></td>
                                            <td class="<?php
                                            if ($row['case_final_status'] == 'Taat') {
                                                echo 'bg-lime-active';
                                            } elseif ($row['case_final_status'] == 'Tidak Taat') {
                                                echo 'bg-red';
                                            } elseif ($row['case_evaluation1_status'] == 'Taat' AND $row['case_evaluation2_status'] == NULL AND $row['case_final_status'] == NULL) {
                                                echo 'bg-lime-active';
                                            } elseif ($row['case_evaluation1_status'] == 'Belum Taat' AND $row['case_evaluation2_status'] == NULL AND $row['case_final_status'] == NULL) {
                                                echo 'bg-red';
                                            } elseif ($row['case_evaluation2_status'] == 'Taat' AND $row['case_evaluation3_status'] == NULL AND $row['case_final_status'] == NULL) {
                                                echo 'bg-lime-active';
                                            } elseif ($row['case_evaluation2_status'] == 'Belum Taat' AND $row['case_evaluation3_status'] == NULL AND $row['case_final_status'] == NULL) {
                                                echo 'bg-red';
                                            } elseif ($row['case_evaluation3_status'] == 'Taat' AND $row['case_evaluation4_status'] == NULL AND $row['case_final_status'] == NULL) {
                                                echo 'bg-lime-active';
                                            } elseif ($row['case_evaluation3_status'] == 'Belum Taat' AND $row['case_evaluation4_status'] == NULL AND $row['case_final_status'] == NULL) {
                                                echo 'bg-red';
                                            } elseif ($row['case_evaluation4_status'] == 'Taat' AND $row['case_final_status'] == NULL AND $row['case_final_status'] == NULL) {
                                                echo 'bg-lime-active';
                                            } elseif ($row['case_evaluation4_status'] == 'Belum Taat' AND $row['case_final_status'] == NULL AND $row['case_final_status'] == NULL) {
                                                echo 'bg-red';
                                            } else {
                                                echo '';
                                            };
                                            ?>"><b>
                                                        <?php
                                                        if ($row['case_final_status'] == 'Taat') {
                                                            echo '<i class="">Hasil Akhir : Taat</i>';
                                                        } elseif ($row['case_final_status'] == 'Tidak Taat') {
                                                            echo '<i class="">Hasil Akhir : Dibekukan</i>';
                                                        } elseif ($row['case_evaluation1_status'] == 'Taat' AND $row['case_evaluation2_status'] == NULL AND $row['case_final_status'] == NULL) {
                                                            echo '<i class="">Hasil Evaluasi I : Taat</i>';
                                                        } elseif ($row['case_evaluation1_status'] == 'Belum Taat' AND $row['case_evaluation2_status'] == NULL AND $row['case_final_status'] == NULL) {
                                                            echo '<i class="">Hasil Evaluasi I : Belum Taat</i>';
                                                        } elseif ($row['case_evaluation2_status'] == 'Taat' AND $row['case_evaluation3_status'] == NULL AND $row['case_final_status'] == NULL) {
                                                            echo '<i class="">Hasil Evaluasi II : Taat</i>';
                                                        } elseif ($row['case_evaluation2_status'] == 'Belum Taat' AND $row['case_evaluation3_status'] == NULL AND $row['case_final_status'] == NULL) {
                                                            echo '<i class="">Hasil Evaluasi II : Belum Taat</i>';
                                                        } elseif ($row['case_evaluation3_status'] == 'Taat' AND $row['case_evaluation4_status'] == NULL AND $row['case_final_status'] == NULL) {
                                                            echo '<i class="">Hasil Evaluasi III : Taat</i>';
                                                        } elseif ($row['case_evaluation3_status'] == 'Belum Taat' AND $row['case_evaluation4_status'] == NULL AND $row['case_final_status'] == NULL) {
                                                            echo '<i class="">Hasil Evaluasi III : Belum Taat</i>';
                                                        } elseif ($row['case_evaluation4_status'] == 'Taat' AND $row['case_final_status'] == NULL AND $row['case_final_status'] == NULL) {
                                                            echo '<i class="">Hasil Evaluasi IV : Taat</i>';
                                                        } elseif ($row['case_evaluation4_status'] == 'Belum Taat' AND $row['case_final_status'] == NULL AND $row['case_final_status'] == NULL) {
                                                            echo '<i class="">Hasil Evaluasi IV : Belum Taat</i>';
                                                        } else {
                                                            echo '-';
                                                        };
                                                        ?></b></td>
                                            <td>
                                                <a href="<?php echo site_url('admin/cases/view/' . $row['case_id']) ?>" data-toggle="tooltip" title="Lihat" class="text-warning"><span class="fa fa-eye"></span></a> &nbsp;
                                            </td>
                                        </tr>
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