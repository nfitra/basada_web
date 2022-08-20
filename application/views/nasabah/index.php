<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h1 class="h3 mb-4 mt-4 text-gray-800">
                <?= $title ?>
            </h1>
            <div class="content bg-white p-3">
                <a href="<?= base_url('nasabah/create') ?>" class="btn btn-sm btn-warning text-black mb-4"> <i class="fas fa-fw fa-plus-circle"></i> Tambah Nasabah</a>
                <?php
                    $message = $this->session->flashdata('message');
                    if (isset($message)) {
                        echo $message;
                    }
                ?>
                <table id="table-balance" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Tanggal Lahir</th>
                            <th>Alamat</th>
                            <th>Kota</th>
                            <th>Provinsi</th>
                            <th>Kode Pos</th>
                            <th>Kontak</th>
                            <th>Status</th>
                            <th>Balance</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($listNasabah as $nasabah) : ?>
                            <tr>
                                <th><?= $no++ ?></th>
                                <td><?= xss($nasabah->n_name) ?></td>
                                <td><?= xss($nasabah->n_dob) ?></td>
                                <td><?= xss($nasabah->n_address) ?></td>
                                <td><?= xss($nasabah->n_city) ?></td>
                                <td><?= xss($nasabah->n_province) ?></td>
                                <td><?= xss($nasabah->n_postcode) ?></td>
                                <td><?= xss($nasabah->n_contact) ?></td>
                                <td><?= xss($nasabah->n_status) == "offline" ? '<badge class="badge badge-danger text-white"> Offline </badge>' : '<badge class="badge badge-success text-white"> Online </badge>' ?></td>
                                <td><?= xss($nasabah->n_balance) ?></td>
                                <td>
                                    <?= ($user->r_name == "Admin Induk") ?
                                        '<a href="' . base_url("nasabah/get_mutasi_nasabah/") . $nasabah->_id . '" class="btn btn-sm btn-warning text-black">
                                            <i class="fas fa-fw fa-credit-card"></i> Lihat Mutasi
                                        </a>' :
                                        ""
                                    ?>
                                    <a href="<?= base_url('nasabah/update/') . $nasabah->_id ?>" class="btn btn-sm btn-warning text-black">
                                        <i class="fas fa-fw fa-edit"></i> Ubah Data
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
<!-- <a href="#" class="btn btn-sm btn-outline-danger" onclick="$
                                            confirm(" Apakah Anda ingin menghapus data ini?")===true ? window.location.href="' . base_url('nasabah/delete/') . $nasabah->_id . '" : console.log(false) ">
                                            <i class=" fas fa-fw fa-trash"></i> Hapus Data
</a> -->