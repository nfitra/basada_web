<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="content bg-white p-3">
                <h3 class="h5 text-gray-600 mb-4">
                    Tambah Jenis Sampah
                </h3>
                <form action="" method="post" enctype="multipart/form-data">
                    <label for="">Jenis Sampah</label>
                    <?= form_error('j_name','<small class="text-danger pl-3">','</small>') ?>
                    <input name="j_name" type="text" class="form-control mb-3" value="<?= $thing->j_name ?>" >
                    <label for="">Satuan</label>
                    <?= form_error('j_satuan','<small class="text-danger pl-3">','</small>') ?>
                    <input name="j_satuan" type="text" class="form-control mb-3" value="<?= $thing->satuan ?>" >
                    <label for="">Harga</label>
                    <?= form_error('j_price','<small class="text-danger pl-3">','</small>') ?>
                    <input name="j_price" type="number" step="100" class="form-control mb-3" value="<?= $thing->j_price ?>" >
                    <label for="">Harga Pelapak</label>
                    <?= form_error('harga_pelapak','<small class="text-danger pl-3">','</small>') ?>
                    <input name="harga_pelapak" type="number" step="100" class="form-control mb-3" value="<?= $thing->harga_pelapak ?>" >
                    <label for="">Kategori</label>
                    <?= form_error('fk_kategori','<small class="text-danger pl-3">','</small>') ?>
                    <select name="fk_kategori" class="form-control mb-3" required>
                        <?php foreach($listKategori as $kategori) : ?>
                        <option value="<?= $kategori->_id ?>" <?= ($kategori->_id == $thing->fk_kategori) ? "selected" : "" ?>><?= $kategori->k_name ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" class="btn btn-block btn-sm btn-warning text-black">Ubah Jenis Sampah</button>
                </form>
            </div>
        </div>
        <div class="col-md-4">
            <div class="content bg-white p-3">
                <h3 class="h5 text-gray-600 mb-4">
                    Ubah Gambar
                </h3>
                <form action="<?= base_url('sampah/update_gambar/').$thing->_id ?>" method="post" enctype="multipart/form-data">
                    <label for="">Saat ini </label>
                    <img class=" mb-3"  style="width:100%; background:#eee; padding:10px;" src="<?= base_url($thing->j_image) ?>" alt="">
                    <br>
                    <label for="">Gambar</label>
                    <br>
                    <input name="j_img" id="img" required type="file" class=" mb-3" value="<?= $thing->j_image ?>" >
                    <br>
                    <button type="submit" name="update_img" class="btn btn-block btn-sm btn-outline-warning text-black">Ubah Foto</button>
                </form>
            </div>
        </div>
    </div>
</div>