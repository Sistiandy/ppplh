<?php
if (isset($case)) {
    $id = $case['case_id'];
    $ActivityValue = $case['activities_activity_id'];
    $InstanceValue = $case['instances_instance_id'];
    $RegionValue = $case['case_region'];
    $ChannelValue = $case['channels_channel_id'];
    $DateValue = $case['case_date'];
    $NoteValue = $case['case_note'];
} else {
    $ActivityValue = set_value('activity_id');
    $InstanceValue = set_value('instance_id');
    $RegionValue = set_value('case_region');
    $ChannelValue = set_value('channel_id');
    $DateValue = set_value('case_date');
    $NoteValue = set_value('case_note');
}
?>

<div class="content-wrapper" ng-controller="casesCtrl">
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
        <?php echo form_open_multipart(current_url()); ?>
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
                            <select name="instance_id" ng-model="instanceModel" class="form-control autocomplete">
                                <option value="">- Pilih Instansi -</option>
                                <option ng-repeat="item in instances" value="{{ item.instance_id}}" >{{ item.instance_name}}</option>
                            </select>
                            <a href="#addInstance" data-toggle="modal" ><i class="fa fa-plus-circle"></i> Tambah instansi baru</a>
                        </div>
                        <div class="form-group">
                            <label>Jenis Kegiatan <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
                            <select name="activity_id" ng-model="activityModel" class="form-control autocomplete">
                                <option value="">- Pilih Jenis Kegiatan -</option>
                                <option ng-repeat="activityItem in activities" value="{{ activityItem.activity_id}}" >{{ activityItem.activity_title}}</option>
                            </select>
                            <a href="#addActivity" data-toggle="modal" ><i class="fa fa-plus-circle"></i> Tambah jenis kegiatan baru</a>
                        </div>
                        <div class="form-group">
                            <label>Wilayah <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
                            <select name="case_region" class="form-control">
                                <option value="">- Pilih Wilayah -</option>
                                <option value="Jakarta Pusat" <?php echo ($RegionValue == 'Jakarta Pusat') ? 'selected' : null ?>>Jakarta Pusat</option>
                                <option value="Jakarta Selatan" <?php echo ($RegionValue == 'Jakarta Selatan') ? 'selected' : null ?>>Jakarta Selatan</option>
                                <option value="Jakarta Timur" <?php echo ($RegionValue == 'Jakarta Timur') ? 'selected' : null ?>>Jakarta Timur</option>
                                <option value="Jakarta Barat" <?php echo ($RegionValue == 'Jakarta Barat') ? 'selected' : null ?>>Jakarta Barat</option>
                                <option value="Jakarta Utara" <?php echo ($RegionValue == 'Jakarta Utara') ? 'selected' : null ?>>Jakarta Utara</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Pelimpahan <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
                            <select name="channel_id" class="form-control">
                                <option value="">- Pilih Pelimpahan -</option>
                                <?php foreach ($channels as $row): ?>
                                    <option value="<?php echo $row['channel_id'] ?>" <?php echo ($ChannelValue == $row['channel_id']) ? 'selected' : null ?>><?php echo $row['channel_name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Pelimpahan <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
                            <input type="text" placeholder="Tanggal" class="form-control datepicker" name="case_date" value="<?php echo $DateValue ?>">
                        </div>
                        <div class="form-group">
                            <label>Memperhatikan <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
                            <textarea class="form-control textarea" placeholder="Memperhatikan" name="case_note"><?php echo $NoteValue ?></textarea>
                        </div>
                        <?php if (!isset($case)) { ?>
                            <div class="form-group" >
                                <label>Pilih Pelanggaran <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
                                <div class="col-md-12 pre-scrollable" style="max-height: 200px">
                                    <?php
                                    $i = 1;
                                    foreach ($violations as $row):
                                        ?>
                                        <div class="checkbox">
                                            <label>
                                                <?php echo $i . '. ' . $row['violation_title'] ?>
                                            </label>
                                            <span class="pull-right">
                                                <input name="violation_id[]" value="<?php echo $row['violation_id'] ?>" type="checkbox">
                                            </span>
                                        </div>
                                        <?php
                                        $i++;
                                    endforeach;
                                    ?>
                                </div>
                            </div>
                            <div class="form-group" >
                                <label>Pilih Pasal Yang Dilanggar <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
                                <div class="col-md-12 pre-scrollable" style="max-height: 200px">
                                    <?php
                                    $i = 1;
                                    foreach ($pasal as $row):
                                        ?>
                                        <div class="checkbox">
                                            <label>
                                                <?php echo $i . '. ' . $row['pasal_title'] ?>
                                            </label>
                                            <span class="pull-right">
                                                <input name="pasal_id[]" value="<?php echo $row['pasal_id'] ?>" type="checkbox">
                                            </span>
                                        </div>
                                        <?php
                                        $i++;
                                    endforeach;
                                    ?>
                                </div>
                            </div>
                        <?php } ?>
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
    <div class="modal modal-info fade" id="addInstance">
        <div class="modal-dialog">
            <div class="modal-content">
                <ng-form name="instanceForm">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title"><span class="fa fa-plus-circle"></span> Tambah instansi</h3>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Instansi <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
                            <input name="instance_name" type="text" ng-model="instance.name" required="" class="form-control" placeholder="Nama">
                        </div>

                        <div class="form-group">
                            <label>Alamat <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
                            <textarea name="instance_address" type="text" ng-model="instance.address" required="" class="form-control" placeholder="Alamat"></textarea>
                        </div>

                        <div class="form-group">
                            <label>No. Telepon <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
                            <input name="instance_phone" type="text" ng-model="instance.phone" required="" class="form-control" placeholder="No. Telepon">
                        </div>      

                        <div class="form-group">
                            <label>Email </label>
                            <input name="instance_email" type="email" ng-model="instance.email" class="form-control" placeholder="Email">
                        </div>  
                        <label>*) Kolom wajib diisi.</label>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" data-dismiss="modal"><span class="fa fa-close"></span> Batal</button>
                        <button type="submit" class="btn btn-outline" ng-disabled="instanceForm.$invalid" ng-click="addInstance(instance)"><span class="fa fa-check"></span> Simpan</button>
                    </div>
                </ng-form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <div class="modal modal-info fade" id="addActivity">
        <div class="modal-dialog">
            <div class="modal-content">
                <ng-form name="activityForm">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title"><span class="fa fa-plus-circle"></span> Tambah Jenis Kegiatan</h3>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Judul Kegiatan <small data-toggle="tooltip" title="Wajib diisi">*</small></label>
                            <input name="activity_title" type="text" ng-model="activity.title" required="" class="form-control" placeholder="Judul Kegiatan">
                        </div>
                        <label>*) Kolom wajib diisi.</label>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" data-dismiss="modal"><span class="fa fa-close"></span> Batal</button>
                        <button type="submit" class="btn btn-outline" ng-disabled="activityForm.$invalid" ng-click="addActivity(activity)"><span class="fa fa-check"></span> Simpan</button>
                    </div>
                </ng-form>
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
        $scope.instances = [];
        $scope.animateInstance = false;
        $scope.getInstance = function () {

            var url = BASEURL + 'api/getInstances';
            $http.get(url).then(function (response) {
                $scope.instances = response.data;
                $scope.instanceModel = '<?php echo $InstanceValue ?>';
            })
        };
        $scope.addInstance = function (data) {
            $scope.animateInstance = true;
            var postData = $.param({
                instance_name: data.name,
                instance_address: data.address,
                instance_phone: data.phone,
                instance_email: data.email
            });
            $.ajax({
                method: "POST",
                url: BASEURL + "admin/instances/add",
                data: postData,
                success: function (response) {
                    $('#addInstance').modal('toggle');
                    $scope.animateInstance = false;
                    $scope.getInstance();
                    $scope.instanceModel = response;
                    $scope.instance = null;
                }
            });
        };
        $scope.activities = [];
        $scope.animateActivity = false;
        $scope.getActivity = function () {

            var url = BASEURL + 'api/getActivities';
            $http.get(url).then(function (response) {
                $scope.activities = response.data;
                $scope.activityModel = '<?php echo $ActivityValue ?>';
            })
        };
        $scope.addActivity = function (data) {
            $scope.animateActivity = true;
            var postData = $.param({
                activity_title: data.title
            });
            $.ajax({
                method: "POST",
                url: BASEURL + "admin/activities/add",
                data: postData,
                success: function (response) {
                    $('#addActivity').modal('toggle');
                    $scope.animateActivity = false;
                    $scope.getActivity();
                    $scope.activityModel = response;
                    $scope.activity = null;
                }
            });
        };
        angular.element(document).ready(function () {
            $scope.getInstance();
            $scope.getActivity();
        });
    });
</script>
