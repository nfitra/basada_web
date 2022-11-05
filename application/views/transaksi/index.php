<div class="container-fluid">
    <div class="row">
        <div class="col-md">
            <h1 class="h3 mb-4 mt-4 text-gray-800">
                Daftar Keuangan
            </h1>
            <div class="row">
                <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
                    <div class="content bg-white p-3">
                        <a href="<?= base_url('Transaksi') ?>" class="btn btn-lg btn-warning text-black mr-4 active">Data Pemasukan</a>
                        <a href="<?= base_url('Pengeluaran') ?>" class="btn btn-lg btn-outline-warning text-black mr-4">Data Pengeluaran</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
                    <div class="content bg-white p-3">
                        <a href="<?= base_url('pemasukan/create') ?>" class="btn btn-sm btn-warning text-black mb-4"> <i class="fas fa-fw fa-plus-circle"></i> Tambah pemasukan</a>
                        <?php
                        $message = $this->session->flashdata('message');
                        if (isset($message)) {
                            echo $message;
                        }
                        ?>
                        <table id="table-pemasukan" class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Jenis Sampah</th>
                                    <th>Jumlah</th>
                                    <th>Total (Rp)</th>
                                    <th>Pelapak</th>
                                    <th>Tanggal Jual</th>
                                    <th>Keterangan</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($listPemasukan as $pemasukan) : ?>
                                    <tr>
                                        <td> <?= $no++ ?> </td>
                                        <td> <?= xss($pemasukan->j_name) ?> </td>
                                        <td> <?= xss($pemasukan->pm_jumlah) ?> </td>
                                        <td> <?= xss($pemasukan->pm_total) ?> </td>
                                        <td> <?= xss($pemasukan->p_nama) ?> </td>
                                        <td> <?= xss($pemasukan->pm_created_at) ?> </td>
                                        <td> <?= xss($pemasukan->pm_hasil) ?> </td>
                                        <td>
                                            <a href="<?= base_url('pemasukan/update/') . $pemasukan->_id ?>" class="btn btn-sm btn-warning text-black">
                                                <i class="fas fa-fw fa-edit"></i> Ubah Data
                                            </a>
                                            <a href="#" class="btn btn-sm btn-outline-danger" onclick="$
                                                confirm('Apakah Anda ingin menghapus data ini?') === true 
                                                    ? window.location.href= '<?= base_url('pemasukan/delete/') . $pemasukan->_id ?>'
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