<div class="container-fluid">
    <div class="row">
        <div class="col-md">
            <h1 class="h3 mb-4 mt-4 text-gray-800">
                <?= $title ?>
            </h1>

            <div class="row">
                <div class="mb-3 col-lg-4 col-md-4 col-sm-12">
                    <div class="content bg-white p-3">
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
                </div>
            </div>
        </div>
    </div>
</div>