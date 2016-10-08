<?php
if (isset($institution)) {
    $id = $institution['institution_id'];
    $NameValue = $institution['institution_name'];
    $AddressValue = $institution['institution_address'];
    $EmailValue = $institution['institution_email'];
    $PhoneValue = $institution['institution_phone'];
} else {
    $NameValue = set_value('institution_name');
    $AddressValue = set_value('institution_address');
    $EmailValue = set_value('institution_email');
    $PhoneValue = set_value('institution_phone');
}
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Institusi
            <small><?php echo $operation; ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('admin') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li>Institusi</li>
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
                        <?php if (isset($institution)) { ?>
                            <input type="hidden" name="institution_id" value="<?php echo $institution['institution_id']; ?>">
                        <?php } ?>
                        <div class="form-group">
                            <label>Nama Institusi <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
                            <input name="institution_name" type="text" class="form-control" value="<?php echo $NameValue ?>" placeholder="Nama">
                        </div>

                        <div class="form-group">
                            <label>Alamat <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
                            <textarea name="institution_address" type="text" class="form-control" placeholder="Alamat"><?php echo $AddressValue ?></textarea>
                        </div>

                        <div class="form-group">
                            <label>No. Telepon <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
                            <input name="institution_phone" type="text" class="form-control" value="<?php echo $PhoneValue ?>" placeholder="No. Telepon">
                        </div>      

                        <div class="form-group">
                            <label>Email </label>
                            <input name="institution_email" type="email" class="form-control" value="<?php echo $EmailValue ?>" placeholder="Email">
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
                        <a href="<?php echo site_url('admin/institutions'); ?>" class="btn btn-flat btn-block btn-info"><span class="fa fa-arrow-circle-left"></span> Batal</a>
                        <?php if (isset($institution)) { ?>
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
    <?php if (isset($institution)) { ?>
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
                        <?php echo form_open('admin/institutions/delete/' . $institution['institution_id']); ?>
                        <input type="hidden" name="delName" value="<?php echo $institution['institution_name']; ?>">
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