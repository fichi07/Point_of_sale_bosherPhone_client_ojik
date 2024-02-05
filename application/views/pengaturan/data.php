<?= $this->session->flashdata('pesan'); ?>
<div class="card shadow-sm mb-4 border-bottom-primary">
    <div class="card-header bg-white py-3">
        <div class="row">
            <div class="col">
                <h4 class="h5 align-middle m-0 font-weight-bold text-primary">
                    Data
                </h4>
            </div>

        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped dt-responsive nowrap" id="dataTable">
            <thead>
                <tr>
                    <th width="30">No.</th>
                    <th>Nama Toko</th>
                    <th>Alamat Toko</th>
                    <th>Aksi</th>

                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                if ($pengaturan) :
                    foreach ($pengaturan as $pengaturan) :
                ?>
                        <tr>
                            <td><?= $no++; ?></td>

                            <td><?= $pengaturan['nama_toko']; ?></td>
                            <td><?= $pengaturan['alamat']; ?></td>

                            <td>
                                <a href="<?= base_url('pengaturan/edit/') . $pengaturan['id_pengaturan'] ?>" class="btn btn-circle btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                                <a onclick="return confirm('Yakin ingin hapus?')" href="<?= base_url('pengaturan/delete/') . $pengaturan['id_pengaturan'] ?>" class="btn btn-circle btn-danger btn-sm"><i class="fa fa-trash"></i></a>

                            </td>
                        </tr>
                    <?php endforeach;
                else : ?>
                    <tr>
                        <td colspan="8" class="text-center">Silahkan tambahkan pengaturan baru</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>