<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-bottom-primary">
            <div class="card-header bg-white py-3">
                <div class="row">
                    <div class="col">
                        <h4 class="h5 align-middle m-0 font-weight-bold text-primary">
                            Input Penjualan
                        </h4>
                    </div>
                    <div class="col-auto">
                        <a href="<?= base_url('barangkeluar') ?>" class="btn btn-sm btn-secondary btn-icon-split">
                            <span class="icon">
                                <i class="fa fa-arrow-left"></i>
                            </span>
                            <span class="text">
                                Kembali
                            </span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <?= $this->session->flashdata('pesan'); ?>
                <form action="<?php echo base_url('barangkeluar/add_to_cart'); ?>" method="post">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                    <div class="row form-group">
                        <label class="col-md-4 text-md-right" for="barang_id">Barang</label>
                        <div class="col-md-5">
                            <div class="input-group">
                                <select name="barang_id" id="barang_id" class="custom-select">
                                    <option value="" selected disabled>Pilih Barang</option>
                                    <?php foreach ($barang as $b) : ?>
                                        <option value="<?= $b['id_barang'] ?>"><?= $b['id_barang'] . ' | ' . $b['nama_barang'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="input-group-append">
                                    <a class="btn btn-primary" href="<?= base_url('barang/add'); ?>"><i class="fa fa-plus"></i></a>
                                </div>
                            </div>
                            <?= form_error('barang_id', '<small class="text-danger">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-4 text-md-right" for="harga">Harga</label>
                        <div class="col-md-5">
                            <input readonly="readonly" id="harga" name="harga" type="number" class="form-control">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-4 text-md-right" for="stok">Stok</label>
                        <div class="col-md-5">
                            <input readonly="readonly" id="stok" name="stok" type="number" class="form-control">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-4 text-md-right" for="jumlah_keluar">Jumlah Keluar</label>
                        <div class="col-md-5">
                            <div class="input-group">
                                <input value="<?= set_value('jumlah_keluar'); ?>" name="jumlah_keluar" id="jumlah_keluar" type="number" min="0" value="0" step="0.1" class="form-control" placeholder="Jumlah Keluar...">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="satuan">Satuan</span>
                                </div>
                            </div>
                            <?= form_error('jumlah_keluar', '<small class="text-danger">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-4 text-md-right" for="total_stok">Total Stok</label>
                        <div class="col-md-5">
                            <input readonly="readonly" id="total_stok" type="number" class="form-control">
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-4 text-md-right" for="total_nominal">Total Nominal</label>
                        <div class="col-md-5">
                            <div class="input-group">
                                <div class="input-group-append">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input readonly="readonly" name="total_nominal" id="total_nominal" type="number" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col offset-md-4">
                            <button type="submit" class="btn btn-info btn-sm btn-icon-split">
                                <span class="icon">
                                    <i class="fa fa-shopping-cart"></i>
                                </span>
                                <span class="text">
                                    Simpan
                                </span>
                            </button>
                        </div>
                    </div>
                    <table class="table table-hover table-bordered" style="font-size:12px;margin-top:10px;">
                        <thead>
                            <tr>
                                <th style="text-align:center;">Barang</th>
                                <th style="text-align:center;">Harga(Rp)</th>
                                <th style="text-align:center;">Jumlah Keluar</th>
                                <th style="text-align:center;">Sub Total</th>
                                <th style="width:100px;text-align:center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($this->cart->contents() as $items) : ?>
                                <?php echo form_hidden($i . '[rowid]', $items['rowid']); ?>
                                <tr>
                                    <td style="text-align:center;"><?= $items['id']; ?> | <?= $items['name']; ?></td>
                                    <td style="text-align:center;"><?php echo number_format($items['amount']); ?></td>
                                    <td style="text-align:center;"><?php echo number_format($items['qty'], 1); ?></td>
                                    <td style="text-align:center;"><?php echo number_format($items['subtotal']); ?></td>

                                    <td style="text-align:center;"><a href="<?php echo base_url() . 'Barangkeluar/remove/' . $items['rowid']; ?>" class="btn btn-danger btn-sm"><span class="fa fa-window-close text-warning"></span> Batal</a></td>
                                </tr>

                                <?php $i++; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </form>
            </div>

            <div class="card-header bg-white py-3">
                <div class="row">
                    <div class="col">
                        <h4 class="h5 align-middle m-0 font-weight-bold text-primary">
                            Form Input Penjualan
                        </h4>
                    </div>
                    <div class="col-auto">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <!-- <?= form_open('', [], ['id_barang_penjualan' => $id_barang_penjualan, 'user_id' => $this->session->userdata('login_session')['user']]); ?> -->
                <form action="<?php echo base_url('barangkeluar/add'); ?>" method="post">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                    <input type="hidden" name="id_barang_penjualan" value="<?php echo $id_barang_penjualan; ?>">
                    <input type="hidden" name="user_id" value="<?php echo $this->session->userdata('login_session')['user']; ?>">
                    <div class="row form-group">
                        <label class="col-md-4 text-md-right" for="id_barang_penjualan">ID Transaksi Barang Keluar</label>
                        <div class="col-md-4">
                            <input value="<?= $id_barang_penjualan; ?>" type="text" readonly="readonly" class="form-control">
                            <?= form_error('id_barang_penjualan', '<small class="text-danger">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-4 text-md-right" for="tanggal_keluar">Tanggal Keluar</label>
                        <div class="col-md-4">
                            <input value="<?= set_value('tanggal_keluar', date('Y-m-d')); ?>" name="tanggal_keluar" id="tanggal_keluar" type="text" class="form-control date" placeholder="Tanggal Keluar...">
                            <?= form_error('tanggal_keluar', '<small class="text-danger">', '</small>'); ?>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-4 text-md-right" for="pelanggan_id">Pelanggan</label>
                        <div class="col-md-5">
                            <div class="input-group">
                                <select name="pelanggan_id" id="pelanggan_id" class="custom-select">
                                    <option value="" selected disabled>Pilih Pelanggan</option>
                                    <?php foreach ($pelanggan as $s) : ?>
                                        <option <?= set_select('pelanggan_id', $s['id_pelanggan']) ?> value="<?= $s['id_pelanggan'] ?>"><?= $s['nama_pelanggan'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="input-group-append">
                                    <a class="btn btn-primary" href="<?= base_url('pelanggan/add'); ?>"><i class="fa fa-plus"></i></a>
                                </div>
                            </div>
                            <?= form_error('pelanggan_id', '<small class="text-danger">', '</small>'); ?>
                        </div>
                    </div>

                    <div class="row form-group">
                        <label class="col-md-4 text-md-right" for="diskon">Diskon</label>
                        <div class="col-md-5">
                            <div class="input-group">
                                <div class="input-group-append">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input name="diskon" id="diskon" type="number" class="form-control" min="0" max="999999999" maxlength="9" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                <?= form_error('diskon', '<small class="text-danger">', '</small>'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <label class="col-md-4 text-md-right" for="total_nominal">Total</label>
                        <div class="col-md-5">
                            <div class="input-group">
                                <div class="input-group-append">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input readonly="readonly" name="total_nominal" id="total_nominal_cart" value="<?php echo $this->cart->total(); ?>" type="number" class="form-control">
                            </div>
                        </div>
                    </div>


                    <div class="row form-group">
                        <label class="col-md-4 text-md-right" for="grand_total">Grand Total</label>
                        <div class="col-md-5">
                            <div class="input-group">
                                <div class="input-group-append">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input readonly="readonly" name="grand_total" id="grand_total" placeholder="<?php echo $this->cart->total(); ?>" type="number" class="form-control">
                                <input name="grand_total_hidden" value="<?php echo $this->cart->total(); ?>" type="hidden" class="form-control">
                            </div>
                        </div>

                    </div>

                    <div class="row form-group">
                        <label class="col-md-4 text-md-right" for="u_pelanggan">Tunai</label>
                        <div class="col-md-5">
                            <div class="input-group">
                                <div class="input-group-append">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input name="u_pelanggan" id="u_pelanggan" type="number" class="form-control" min="1" max="999999999" maxlength="9" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);hitungKembalian();">
                                <?= form_error('diskon', '<small class="text-danger">', '</small>'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <label class="col-md-4 text-md-right" for="kembalian">kembalian</label>
                        <div class="col-md-5">
                            <div class="input-group">
                                <div class="input-group-append">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input readonly="readonly" name="kembalian" id="kembalian" placeholder="Kembalian..." type="number" class="form-control">

                            </div>
                        </div>
                    </div>



                    <div class="row form-group">
                        <div class="col offset-md-4">
                            <button type="submit" class="btn btn-primary">Bayar</button>
                            <button type="reset" class="btn btn-secondary">Reset</button>
                        </div>
                    </div>
                </form>
                <!-- <?= form_close(); ?> -->
            </div>

        </div>
    </div>
</div>

<!-- Menghilangkan panah di form type number -->
<style type="text/css">
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }
</style>

<!-- Bootstrap core JavaScript-->
<script src="<?= base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?= base_url(); ?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="<?= base_url(); ?>assets/js/sb-admin-2.min.js"></script>

<!-- Datepicker -->
<script src="<?= base_url(); ?>assets/vendor/daterangepicker/moment.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/daterangepicker/daterangepicker.min.js"></script>

<!-- Page level plugins -->
<script src="<?= base_url(); ?>assets/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/datatables/buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/datatables/buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/datatables/jszip/jszip.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/datatables/pdfmake/pdfmake.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/datatables/pdfmake/vfs_fonts.js"></script>
<script src="<?= base_url(); ?>assets/vendor/datatables/buttons/js/buttons.html5.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/datatables/buttons/js/buttons.print.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/datatables/buttons/js/buttons.colVis.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/datatables/responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url(); ?>assets/vendor/datatables/responsive/js/responsive.bootstrap4.min.js"></script>

<script src="<?= base_url(); ?>assets/vendor/gijgo/js/gijgo.min.js"></script>
<script>
    // Fungsi untuk menghitung kembalian
    function hitungKembalian() {
        var uangPelanggan = parseInt(document.getElementById('u_pelanggan').value);
        var totalSetelahDiskon = parseInt(document.getElementById('grand_total').value);

        var kembalian = uangPelanggan - totalSetelahDiskon;
        document.getElementById('kembalian').value = kembalian;
    }
</script>