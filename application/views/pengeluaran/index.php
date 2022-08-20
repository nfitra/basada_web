<div class="container-fluid">
    <div class="row">
        <div class="col-md">
            <h1 class="h3 mb-4 mt-4 text-gray-800">
                <?= $title ?>
            </h1>

            <div class="row">
                <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
                    <div class="content bg-white p-3">
                        <a href="<?= base_url('pengeluaran/create') ?>" class="btn btn-sm btn-warning text-black mb-4"> <i class="fas fa-fw fa-plus-circle"></i> Tambah pengeluaran</a>
                        <?php
                        $message = $this->session->flashdata('message');
                        if (isset($message)) {
                            echo $message;
                        }
                        ?>
                        <table id="table-pengeluaran" class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Bulan</th>
                                    <th>Jenis Pengeluaran</th>
                                    <th>Jumlah</th>
                                    <th>Harga Satuan (Rp)</th>
                                    <th>Total (Rp)</th>
                                    <th>Bukti</th>
                                    <th>Unit</th>
                                    <th>Keterangan</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($listPengeluaran as $pengeluaran) : ?>
                                    <tr>
                                        <td> <?= $no++ ?> </td>
                                        <td> <?= xss($pengeluaran->pk_bulan) ?> </td>
                                        <td> <?= xss($pengeluaran->pk_jenis) ?> </td>
                                        <td> <?= xss($pengeluaran->pk_jumlah) ?> </td>
                                        <td> <?= xss($pengeluaran->pk_harga) ?> </td>
                                        <td> <?= xss($pengeluaran->pk_total) ?> </td>
                                        <td><img src="<?= base_url(xss($pengeluaran->pk_bukti)) ?>" height="150px" width="200px" alt="<?= xss($pengeluaran->pk_bukti) ?>" /></td>
                                        <td> <?= xss($pengeluaran->un_name) ?> </td>
                                        <td> <?= xss($pengeluaran->pk_keterangan) ?> </td>
                                        <td>
                                            <a href="<?= base_url('pengeluaran/update/') . $pengeluaran->_id ?>" class="btn btn-sm btn-warning text-black">
                                                <i class="fas fa-fw fa-edit"></i> Ubah Data
                                            </a>
                                            <a href="#" class="btn btn-sm btn-outline-danger" onclick="$
                                                confirm('Apakah Anda ingin menghapus data ini?') === true 
                                                    ? window.location.href= '<?= base_url('pengeluaran/delete/') . $pengeluaran->_id ?>'
                                                    : console.log(false)
                                            ">
                                                <i class="fas fa-fw fa-trash"></i> Hapus Data
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>