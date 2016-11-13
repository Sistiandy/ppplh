<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>SI-SADLH</title>
        <style type="text/css">
            table {
                font-family: verdana,arial,sans-serif;
                font-size:11px;
                color:#333333;
                border-width: 1px;
                border-color: #666666;
                border-collapse: collapse;
                width: 100%;
            }

            th {
                border-width: 1px;
                padding: 8px;
                border-style: solid;
                border-color: #666666;
                background-color: #dedede;
            }

            td {
                border-width: 1px;
                padding: 8px;
                border-style: solid;
                border-color: #666666;
                background-color: #ffffff;
            }
        </style>
    </head>
    <body>
    <center>
        <h2>Daftar <?php echo $title ?></h2>
    </center>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>NO.</th>
                <th>NAMA KEGIATAN</th>
                <th>JENIS KEGIATAN</th>
                <th>ALAMAT</th>
                <th>WILAYAH</th>
                <th>PELIMPAHAN</th>
                <th>POSISI</th>
                <th>TANGGAL</th>
                <th>STATUS</th>
            </tr>
        </thead>
        <?php
        $x = 1;
        foreach ($cases as $row) {
            ?>
            <tbody>
                <tr>
                    <td ><?php echo $x; ?></td>
                    <td><?php echo $row['instance_name']; ?></td>
                    <td><?php echo $row['activity_title']; ?></td>
                    <td><?php echo $row['case_address']; ?></td>
                    <td><?php echo $row['case_region']; ?></td>
                    <td><?php echo $row['channel_name']; ?></td>
                    <td><?php echo ($row['stage_id'] == STAGE_STAFF) ? 'Staff' : 'Analis' ?></td>
                    <td><?php echo pretty_date($row['case_date'], 'l, d F Y', FALSE); ?></td>
                    <td><b>
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
                </tr>
            </tbody>
            <?php
            $x++;
        }
        ?>
    </table>


</body>
</html>
