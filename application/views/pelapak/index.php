<div class="container-fluid">
    <div class="row">
        <div class="col-md">
            <h1 class="h3 mb-4 mt-4 text-gray-800">
                <?= $title ?>
            </h1>

            <div class="row">
                <div class="mb-3 col-lg-9 col-md-9 col-sm-12">
                    <div class="content bg-white p-3">
                        <a href="<?= base_url('pelapak/create') ?>" class="btn btn-sm btn-warning text-black mb-4"> <i class="fas fa-fw fa-plus-circle"></i> Tambah Pelapak</a>
                        <?php
                        $message = $this->session->flashdata('message');
                        if (isset($message)) {
                            echo $message;
                        }
                        ?>
                        <table id="table-pelapak" class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Alamat</th>
                                    <th>Kontak</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($listPelapak as $pelapak) : ?>
                                    <tr>
                                        <td><?= $no++ ?> </td>
                                        <td><?= xss($pelapak->p_nama) ?></td>
                                        <td><?= xss($pelapak->p_alamat) ?></td>
                                        <td><?= xss($pelapak->p_kontak) ?></td>
                                        <td>
                                            <a href="<?= base_url('pelapak/update/') . $pelapak->_id ?>" class="btn btn-sm btn-warning text-black">
                                                <i class="fas fa-fw fa-edit"></i> Ubah Data
                                            </a>
                                            <a href="#" class="btn btn-sm btn-outline-danger" onclick="$
                                                confirm('Apakah Anda ingin menghapus data ini?') === true 
                                                    ? window.location.href= '<?= base_url('pelapak/delete/') . $pelapak->_id ?>'
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