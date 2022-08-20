<div class="container-fluid">
    <div class="row">
        <div class="col-md">
            <h1 class="h3 mb-4 mt-4 text-gray-800">
                <?= $title ?>
            </h1>

            <div class="row">
                <div class="col-md-8">
                    <div class="content bg-white p-3">
                        <h1 class="h5 mb-2 text-gray-600">
                            Jenis Sampah
                        </h1>
                        <a href="<?= base_url('sampah/create/') ?>" class="btn mb-4 btn-sm btn-warning text-black">
                            <i class="fas fa-fw fa-plus-circle"></i>
                            Tambah Jenis Sampah
                        </a>

                        <?php 
                            $sampah = $this->session->flashdata('sampah'); 
                            if(isset($sampah)) {
                                echo $sampah;
                            }
                        ?>

                        <table id="table-jenis-sampah" class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Jenis Sampah</th>
                                    <th>Harga</th>
                                    <th>Harga Pelapak</th>
                                    <th>Kategori</th>
                                    <th>Gambar</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach($things as $thing) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= xss($thing->j_name) ?></td>
                                        <td><?= xss($thing->j_price) ?></td>
                                        <td><?= xss($thing->harga_pelapak) ?></td>
                                        <td><?= xss($thing->k_name) ?></td>
                                        <td>
                                            <img style="width:5em; background:#eee; padding:10px" src="<?= base_url(xss($thing->j_image)) ?>" alt="<?= xss($thing->j_name) ?>">
                                        </td>
                                        <td>
                                            <a href="<?= base_url('sampah/update/').$thing->_id ?>" class="btn btn-sm btn-warning text-black mb-3">
                                                <i class="fas fa-fw fa-edit"></i>
                                            </a>
                                            <a onclick="return confirm('Yakin ingin menghapus?')" href="<?= base_url("sampah/delete/").$thing->_id ?>" class="btn btn-sm btn-outline-danger mb-3">
                                                <i class="fas fa-fw fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="mb-3 col-lg-4 col-md-4 col-sm-12">
                    <div class="content bg-white p-3">
                        <h1 class="h5 mb-2 text-gray-600">
                            Kategori Sampah
                        </h1>
                        <a href="<?= base_url('kategoriSampah/create') ?>" class="btn btn-sm btn-warning text-black mb-4"> <i class="fas fa-fw fa-plus-circle"></i> Tambah kategori</a>
                        <?php 
                            $message = $this->session->flashdata('message'); 
                            if(isset($message)) {
                                echo $message;
                            }
                        ?>
                        <table id="table-kategori" class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Kategori</th>
                                    <th>Action</th>
                                </tr>
                            </thead> 
                            <tbody>
                                <?php $no=1; ?>
                                <?php foreach($listKategori as $category) : ?>
                                    <tr>
                                        <td> <?= $no++ ?> </td>
                                        <td> <?= xss($category->k_name) ?> </td>
                                        <td>
                                            <a href="<?= base_url('kategoriSampah/update/').$category->_id ?>" class="btn btn-sm btn-warning text-black">
                                                <i class="fas fa-fw fa-edit"></i> Ubah Data
                                            </a>
                                            <a  href="#" class="btn btn-sm btn-outline-danger" onclick="$
                                                confirm('Apakah Anda ingin menghapus data ini?') === true 
                                                    ? window.location.href= '<?= base_url('kategoriSampah/delete/').$category->_id ?>'
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
                    <hr>
                    <div class="content bg-white p-3">
                        <?php 
                            $message = $this->session->flashdata('minAngkut'); 
                            if(isset($message)) {
                                echo $message;
                            }
                        ?>
                        <table id="table-kategori" class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>Minimal Angkut Sampah (kg)</th>
                                    <th>Action</th>
                                </tr>
                            </thead> 
                            <tbody>
                                <tr>
                                    <td><?= $min ?></td>
                                    <td>
                                        <a class="btn btn-sm btn-warning text-black" data-toggle="modal" data-target="#editMinAngkut">
                                            <i class="fas fa-fw fa-edit"></i> Ubah Data
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div
    class="modal fade"
    id="editMinAngkut"
    tabindex="-1"
    role="dialog"
    aria-hidden="true"
>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?= base_url('sampah/editMin') ?>" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Minimal Angkut Sampahs</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-form-label">Minimal</label>
                        <input type="number" step="0.01" name="minimal" class="form-control" id="minimal">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <input type="submit" class="btn btn-primary" value="Edit" name="EditJadwalBus" />
                </div>
            </form>
        </div>
    </div>
</div>