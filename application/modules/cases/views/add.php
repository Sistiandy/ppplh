<?php
if (isset($case)) {
    $id = $case['case_id'];
    $ActivityValue = $case['activities_activity_id'];
    $InstanceValue = $case['instances_instance_id'];
    $AddressValue = $case['case_address'];
    $RegionValue = $case['case_region'];
    $ChannelValue = $case['channels_channel_id'];
    $DateValue = $case['case_date'];
} else {
    $ActivityValue = set_value('activity_id');
    $InstanceValue = set_value('instance_id');
    $AddressValue = set_value('case_address');
    $RegionValue = set_value('case_region');
    $ChannelValue = set_value('channel_id');
    $DateValue = set_value('case_date');
}
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Kasus Pelanggaran
            <small><?php echo $operation; ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li>Kasus Pelanggaran</li>
            <li class="active"><?php echo $operation; ?></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <?php echo form_open(current_url()); ?>
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-9">
                <div class="box box-primary">
                    <!-- /.box-header -->
                    <div class="box-body">
                        <?php echo validation_errors(); ?>
                        <?php if (isset($case)) { ?>
                            <input type="hidden" name="case_id" value="<?php echo $case['case_id']; ?>">
                        <?php } ?>
                        <div class="form-group">
                            <label>Instansi <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
                            <select name="instance_id" class="form-control autocomplete">
                                <option value="">- Pilih Instansi -</option>
                                <?php foreach ($instances as $row): ?>
                                    <option value="<?php echo $row['instance_id'] ?>" <?php echo ($InstanceValue == $row['instance_id'])? 'selected' : null ?>><?php echo $row['instance_name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Jenis Kegiatan <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
                            <select name="activity_id" class="form-control autocomplete">
                                <option value="">- Pilih Jenis Kegiatan -</option>
                                <?php foreach ($activities as $row): ?>
                                    <option value="<?php echo $row['activity_id'] ?>" <?php echo ($ActivityValue == $row['activity_id'])? 'selected' : null ?>><?php echo $row['activity_title'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Wilayah <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
                            <select name="case_region" class="form-control">
                                <option value="">- Pilih Wilayah -</option>
                                    <option value="Jakarta Pusat" <?php echo ($RegionValue == 'Jakarta Pusat')? 'selected' : null ?>>Jakarta Pusat</option>
                                    <option value="Jakarta Selatan" <?php echo ($RegionValue == 'Jakarta Selatan')? 'selected' : null ?>>Jakarta Selatan</option>
                                    <option value="Jakarta Timur" <?php echo ($RegionValue == 'Jakarta Timur')? 'selected' : null ?>>Jakarta Timur</option>
                                    <option value="Jakarta Barat" <?php echo ($RegionValue == 'Jakarta Barat')? 'selected' : null ?>>Jakarta Barat</option>
                                    <option value="Jakarta Utara" <?php echo ($RegionValue == 'Jakarta Utara')? 'selected' : null ?>>Jakarta Utara</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Alamat <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
                            <textarea class="form-control" placeholder="Alamat" name="case_address"><?php echo $AddressValue ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>Pelimpahan <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
                            <select name="channel_id" class="form-control">
                                <option value="">- Pilih Pelimpahan -</option>
                                <?php foreach ($channels as $row): ?>
                                    <option value="<?php echo $row['channel_id'] ?>" <?php echo ($ChannelValue == $row['channel_id'])? 'selected' : null ?>><?php echo $row['channel_name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Pelimpahan <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
                            <input type="text" placeholder="Tanggal" class="form-control datepicker" name="case_date" value="<?php echo $DateValue ?>">
                        </div>
                        <p class="text-muted">*) Kolom wajib diisi.</p>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
            <div class="col-md-3">
                <div class="box box-primary">
                    <!-- /.box-header -->
                    <div class="box-body">
                        <button type="submit" class="btn btn-flat btn-block btn-success"><span class="fa fa-check-circle"></span> Simpan</button>
                        <a href="<?php echo site_url('admin/cases'); ?>" class="btn btn-flat btn-block btn-info"><span class="fa fa-arrow-circle-left"></span> Batal</a>
                        <?php if (isset($case)) { ?>
                            <a href="#delModal" class="btn btn-flat btn-block btn-danger" data-toggle="modal" ><span class="fa fa-close"></span> Hapus</a>
                        <?php } ?>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
        <!-- /.row -->
    </section>
    <!-- /.content -->
    <?php if (isset($case)) { ?>
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
    <?php } ?>
</div>
