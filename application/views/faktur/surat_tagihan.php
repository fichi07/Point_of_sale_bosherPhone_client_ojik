<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $title; ?> | Aplikasi </title>

  <!-- Custom fonts for this template-->
  <link href="<?= base_url(); ?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="<?= base_url(); ?>assets/css/fonts.min.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="<?= base_url(); ?>assets/css/sb-admin-2.min.css" rel="stylesheet">

  <!-- Datepicker -->
  <link href="<?= base_url(); ?>assets/vendor/daterangepicker/daterangepicker.css" rel="stylesheet">

  <!-- DataTables -->
  <link href="<?= base_url(); ?>assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link href="<?= base_url(); ?>assets/vendor/datatables/buttons/css/buttons.bootstrap4.min.css" rel="stylesheet">
  <link href="<?= base_url(); ?>assets/vendor/datatables/responsive/css/responsive.bootstrap4.min.css" rel="stylesheet">
  <link href="<?= base_url(); ?>assets/vendor/gijgo/css/gijgo.min.css" rel="stylesheet">
</head>

<body>
  <div class="wrapper">
    <!-- Main content -->
    <section class="invoice">
      <?php
      $b = $data->row_array();
      ?>
      <!-- title row -->
      <div class="row">
        <div class="col-10">
          <h2 class="page-header">
            <i class="fas fa-book"></i> Nota Penjualan
            <small class="float-right"><b>Invoice #<?php echo $b['id_barang_penjualan']; ?></b></small>
          </h2>
        </div>
        <!-- /.col -->
      </div><br />
      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
          <table align="left" style="border:none;">
            <tr>
              <th>Nomor </th>
              <th>: <?php echo $b['id_barang_penjualan']; ?></th>
            </tr>
            <tr>
              <th>Tanggal </th>
              <th>: <?php echo date('d F Y', strtotime($b['tanggal_keluar'])); ?></th>
            </tr>
            <tr>
              <th>Pihak Toko </th>
              <th>: <?php echo $b['nama']; ?></th>
            </tr>
            <?php
            foreach ($pengaturan as $p) :
            ?>
              <tr>
                <th>Nama Toko </th>
                <th>: <?php echo $p['nama_toko']; ?></th>
              </tr> <?php endforeach; ?>
            <tr>
              <th>Pelanggan </th>
              <th>: <?php echo $b['nama_pelanggan']; ?></th>
            </tr>



          </table>
        </div>
        <!-- /.col -->
        <!--       <div class="col-sm-6 invoice-col">
        <table align="left" style="border:none;">
            <tr>
                <th>Kepada Yth </th>
                <th>: <?php echo $b['nama_pelanggan']; ?></th>
            </tr>
            <tr>
                <th>Dikirim Ke </th>
                <th>: <?php echo $b['nama_pelanggan']; ?></th>
            </tr>
            <tr>
                <th></th>
                <th>&nbsp;<?php echo $b['alamat']; ?></th>
            </tr>
        </table>
      </div> -->
      </div><br /><br />
      <!-- Table row -->
      <div class="row">
        <div class="col-11 table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Nama Barang</th>
                <th>Jenis Barang</th>
                <th>Satuan</th>
                <th>Jumlah Keluar</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 0;
              $qtyw = 0;
              foreach ($data->result_array() as $i) {
                $barang = $i['nama_barang'];
                $jenis = $i['nama_jenis'];
                $satuan = $i['nama_satuan'];
                $keluar = $i['jumlah_keluar'] . ' ' . $i['nama_satuan'];
                $total = $i['total_nominal_dtl'];
              ?>
                <tr>
                  <td style="text-align:left;"><?php echo $barang; ?></td>
                  <td style="text-align:left;"><?php echo $jenis; ?></td>
                  <td style="text-align:left;"><?php echo $satuan; ?></td>
                  <td style="text-align:left;"><?php echo $keluar; ?></td>
                  <td style="text-align:left;"><?php echo 'Rp ' . number_format($total); ?></td>
                </tr>
              <?php } ?>
            </tbody>
            <thead>
              <tr>
                <th colspan="4">Sub Total</th>
                <th><?php echo 'Rp ' . number_format($b['total_nominal']); ?></th>
              </tr>
              <tr>
                <th colspan="4">Diskon</th>
                <th><?php echo 'Rp ' . number_format($b['kembalian']); ?></th>
              </tr>
            </thead>
            <?php if ($b['diskon'] > 0) : ?>
              <thead>
                <tr>
                  <th colspan="4">Grand Total</th>
                  <th><?php echo 'Rp ' . number_format($b['grand_total']); ?></th>
                </tr>
              </thead>
            <?php endif ?>
            <thead>
              <tr>
                <th colspan="4">Tunai</th>
                <th><?php echo 'Rp ' . number_format($b['u_pelanggan']); ?></th>
              </tr>
              <thead>
                <tr>
                  <th colspan="4">Kembalian</th>
                  <th><?php echo 'Rp ' . number_format($b['diskon']); ?></th>
                </tr>
              </thead>
          </table><br /><br />
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
        <!-- accepted payments column -->
        <div class="col-9">
          <br />
        </div>
        <!-- /.col -->
        <div class="col-3">
          <!-- <p class="lead">Amount Due 2/22/2014</p> -->


        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- ./wrapper -->
  <!-- Page specific script -->
  <script>
    window.addEventListener("load", window.print());
  </script>
</body>

</html>