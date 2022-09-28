<!-- Begin Page Content -->
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
                            Artikel
                        </h1>
                        <a href="<?= base_url('artikel/create') ?>" class="btn btn-sm btn-warning text-black mb-4"> <i class="fas fa-fw fa-plus-circle"></i> Tambah artikel</a>

                        <?php 
                            $message = $this->session->flashdata('message'); 
                            if(isset($message)) {
                                echo $message;
                            }
                        ?>
                        <table id="table-artikel" class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th style="width: 40%;">Artikel</th>
                                    <th>Kategori</th>
                                    <th style="width: 10%;">Gambar</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no=1; ?>
                                <?php foreach($listArtikel as $artikel) : ?>
                                    <tr>
                                        <th><?= $no++ ?></th>
                                        <td><?= xss($artikel->a_title) ?></td>
                                        <td class="ellipsis"><span><?= strlen(strip_tags($artikel->a_content))<500 ? $artikel->a_content : (substr(strip_tags($artikel->a_content),0,500)." ...") ?><span></td>
                                        <td><?= xss($artikel->k_name) ?></td>
                                        <td>
                                            <?php if($artikel->a_file_type == "picture") : ?>
                                            <img src="<?= base_url(xss($artikel->a_file)) ?>" height="150px" width="200px" alt="<?= xss($artikel->a_file) ?>" />
                                            <?php else : ?>
                                            <video height="150" width="100%" controls>
                                                <source src="<?= base_url($artikel->a_file) ?>">
                                                Your browser does not support the video tag.
                                            </video>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?= base_url('artikel/update/').$artikel->_id ?>" class="btn btn-sm btn-warning text-black">
                                                <i class="fas fa-fw fa-edit"></i> Ubah Data
                                            </a>
                                            <a  href="#" class="btn btn-sm btn-outline-danger" onclick="$
                                                confirm('Apakah Anda ingin menghapus data ini?') === true 
                                                    ? window.location.href= '<?= base_url('artikel/delete/').$artikel->_id ?>'
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
                <div class="mb-3 col-lg-4 col-md-4 col-sm-12">
                    <div class="content bg-white p-3">
                        <h1 class="h5 mb-2 text-gray-600">
                            Kategori Artikel
                        </h1>
                        <a href="<?= base_url('kategori/create') ?>" class="btn btn-sm btn-warning text-black mb-4"> <i class="fas fa-fw fa-plus-circle"></i> Tambah kategori</a>
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
                                            <a href="<?= base_url('kategori/update/').$category->_id ?>" class="btn btn-sm btn-warning text-black">
                                                <i class="fas fa-fw fa-edit"></i> Ubah Data
                                            </a>
                                            <a  href="#" class="btn btn-sm btn-outline-danger" onclick="$
                                                confirm('Apakah Anda ingin menghapus data ini?') === true 
                                                    ? window.location.href= '<?= base_url('kategori/delete/').$category->_id ?>'
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
<!-- /.container-fluid -->