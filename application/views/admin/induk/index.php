<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h1 class="h3 mb-4 mt-4 text-gray-800">
                <?= $title ?>
            </h1>
            <div class="content bg-white p-3">
                <!-- Page Heading -->

                <a href="<?= base_url('dataInduk/create') ?>" class="btn btn-sm btn-warning text-black mb-4"> <i class="fas fa-fw fa-plus-circle"></i> Tambah Admin</a>

                <?php
                $message = $this->session->flashdata('message');
                if (isset($message)) {
                    echo $message;
                }
                ?>
                <table id="table-admin-induk" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Admin</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($listAdmin as $admin) : ?>
                            <?php $label = $admin->isActive == 1 ? '<badge class="badge badge-warning text-black"> active </badge>' : '<badge class="badge badge-danger"> inactive </badge>' ?>
                            <tr>
                                <th><?= $no++ ?></th>
                                <td><?= xss($admin->un_name) ?></td>
                                <td><?= xss($admin->fk_auth) ?></td>
                                <td><?= $label ?></td>
                                <td>
                                    <a href="<?= base_url('dataInduk/update/') . $admin->_id ?>" class="btn btn-sm btn-warning text-black">
                                        <i class="fas fa-fw fa-edit"></i> Ubah Data
                                    </a>
                                    <a href="#" class="btn btn-sm btn-outline-danger" onclick="$
                                    confirm('Apakah Anda ingin menghapus data ini?') === true 
                                        ? window.location.href= '<?= base_url('dataInduk/delete/') . $admin->_id ?>'
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
<!-- /.container-fluid -->