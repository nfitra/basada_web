<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="content bg-white p-3">
                <h3 class="h5 text-gray-600 mb-4">
                    Tambah Jenis Sampah
                </h3>

                <form action="" method="post" enctype="multipart/form-data">
                    <label for="">Jenis Sampah</label>
                    <?= form_error('j_name', '<small class="text-danger pl-3">', '</small>') ?>
                    <input name="j_name" type="text" class="form-control mb-3" value="<?= set_value('j_name') ?>">
                    <label for="">Satuan</label>
                    <?= form_error('j_satuan', '<small class="text-danger pl-3">', '</small>') ?>
                    <input name="j_satuan" type="text" class="form-control mb-3" value="<?= set_value('j_satuan') ?>">
                    <label for="">Harga</label>
                    <?= form_error('j_price', '<small class="text-danger pl-3">', '</small>') ?>
                    <input name="j_price" type="number" step="1" class="form-control mb-3" value="<?= set_value('j_price') ?>">
                    <label for="">Harga Pelapak</label>
                    <?= form_error('harga_pelapak', '<small class="text-danger pl-3">', '</small>') ?>
                    <input name="harga_pelapak" type="number" step="1" class="form-control mb-3" value="<?= set_value('harga_pelapak') ?>">
                    <label for="">Kategori</label>
                    <?= form_error('fk_kategori', '<small class="text-danger pl-3">', '</small>') ?>
                    <select name="fk_kategori" class="form-control mb-3" required>
                        <?php foreach ($listKategori as $kategori) : ?>
                            <option value="<?= $kategori->_id ?>"><?= $kategori->k_name ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label for="">Gambar</label>
                    <?= form_error('j_img', '<small class="text-danger pl-3">', '</small>') ?>
                    <br>
                    <input name="j_img" id="img" type="file" class=" mb-3" value="<?= set_value('j_img') ?>">
                    <br>
                    <button type="submit" class="btn btn-block btn-sm btn-warning text-black">Tambah Jenis Sampah</button>
                </form>
            </div>
        </div>
    </div>
</div>