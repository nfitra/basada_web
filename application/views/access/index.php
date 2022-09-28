<div class="container-fluid">
    <div class="row">
        <div class="col-md">
            <h1 class="h3 mb-4 mt-4 text-gray-800">
                <?= $title ?>
            </h1>

            <div class="row">

                <div class="mb-3 col-lg-4 col-md-4 col-sm-12">
                    <div class="content bg-white p-3">
                        <h1 class="h5 mb-2 text-gray-600">
                            List Role
                        </h1>

                        <table id="table-role" class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Role</th>
                                </tr>
                            </thead> 
                            <tbody>
                                <?php $no=1; ?>
                                <?php foreach($roles as $role) : ?>
                                    <tr>
                                        <td> <?= $no++ ?> </td>
                                        <td> <?= $role->r_name ?> </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="mb-3 col-lg-8 col-md-8 col-sm-12">
                    <div class="content bg-white p-3">
                        <h1 class="h5 mb-2 text-gray-600">
                            List Access
                        </h1>
                        <a href="<?= base_url('access/create') ?>" class="btn btn-sm mb-4 btn-warning text-black">
                            <i class="fas fa-plus-circle"></i>
                            Tambah Access
                        </a>
                        <?php 
                            $message = $this->session->flashdata('message'); 
                            if(isset($message)) {
                                echo $message;
                            }
                        ?>
                        <table id="table-access" class=" mt-3 mb-3 table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Role</th>
                                    <th>Akses Menu</th>
                                    <th>URL</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach($accesses as $access) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= xss($access->r_name) ?></td>
                                        <td><?= xss($access->sm_title) ?></td>
                                        <td><?= xss($access->sm_url) ?></td>
                                        <td>
                                            <a href="<?= base_url('access/update/').$access->_id ?>" class="btn btn-sm btn-warning text-black">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="#" class="btn btn-sm btn-outline-danger" onclick="$
                                                confirm('Apakah Anda ingin menghapus data ini?') === true ? window.location.href= '<?= base_url('access/delete/').$access->_id ?>' : console.log(false)">
                                                <i class="fas fa-trash"></i>
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