<?php
if (isset($activity)) {
    $id = $activity['activity_id'];
    $TitleValue = $activity['activity_title'];
} else {
    $TitleValue = set_value('activity_title');
}
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Jenis Kegiatan
            <small><?php echo $operation; ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li>Jenis Kegiatan</li>
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
                        <?php if (isset($activity)) { ?>
                            <input type="hidden" name="activity_id" value="<?php echo $activity['activity_id']; ?>">
                        <?php } ?>
                        <div class="form-group">
                            <label>Judul Kegiatan <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
                            <input name="activity_title" type="text" class="form-control" value="<?php echo $TitleValue ?>" placeholder="Nama pelanggaran">
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
                        <a href="<?php echo site_url('admin/activities'); ?>" class="btn btn-flat btn-block btn-info"><span class="fa fa-arrow-circle-left"></span> Batal</a>
                        <?php if (isset($activity)) { ?>
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
    <?php if (isset($activity)) { ?>
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
                        <?php echo form_open('admin/activities/delete/' . $activity['activity_id']); ?>
                        <input type="hidden" name="delName" value="<?php echo $activity['instance_id']; ?>">
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
