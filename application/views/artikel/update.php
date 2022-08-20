<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="content bg-white p-3">
                <h3 class="h5 text-gray-600 mb-4">
                    Tambah Artikel
                </h3>

                <form action="" method="post" enctype="multipart/form-data">
                    <label for="">Judul Artikel</label>
                    <?= form_error('a_title','<small class="text-danger pl-3">','</small>') ?>
                    <br>
                    <input name="a_title" id="a_title" type="text" class="form-control mb-3" value="<?= $dataArtikel->a_title ?>" >
                    <br>
                    <label for="">Isi Artikel</label>
                    <?= form_error('a_content','<small class="text-danger pl-3">','</small>') ?>
                    <textarea name="a_content" id="editor1">
                        <?= $dataArtikel->a_content ?>
                    </textarea>
                    <label for="" class="mt-3">Kategori</label>
                    <?= form_error('fk_kategori','<small class="text-danger pl-3">','</small>') ?>
                    <select required class="form-control mb-3" name="fk_kategori" id="fk_kategori">
                        <option value="">----- Pilih Kategori -----</option>
                        <?php foreach($categories as $category) : ?>
                            <option value="<?= $category->_id ?>" <?= ($dataArtikel->fk_kategori == $category->_id)?"selected":"" ?>><?= $category->k_name ?></option>
                        <?php endforeach; ?>
                    </select>
                    <br>
                    <button type="submit" class="btn btn-block btn-sm btn-warning text-black">Ubah Artikel</button>
                </form>
            </div>
        </div>
        <div class="col-md-4">
            <div class="content bg-white p-3">
                <h3 class="h5 text-gray-600 mb-4">
                    Ubah File
                </h3>
                <form action="<?= base_url('artikel/update_gambar/').$dataArtikel->_id ?>" method="post" enctype="multipart/form-data">
                    <label for="">Saat ini </label>
                    <?php if($dataArtikel->a_file_type == "picture") : ?>
                    <img class=" mb-3"  style="width:100%; background:#eee; padding:10px;" src="<?= base_url($dataArtikel->a_file) ?>" alt="<?= $dataArtikel->a_file ?>">
                    <?php else : ?>
                    <video height="250" width="100%" controls>
                        <source src="<?= base_url($dataArtikel->a_file) ?>">
                        Your browser does not support the video tag.
                    </video>
                    <?php endif; ?>
                    <br>
                    <label for="">Tipe File</label>
                    <br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="a_file_type" value="picture" <?= $dataArtikel->a_file_type == "picture" ? "checked" : "" ?>>
                        <label class="form-check-label" for="inlineRadio1">Gambar</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="a_file_type" value="video" <?= $dataArtikel->a_file_type == "video" ? "checked" : "" ?>>
                        <label class="form-check-label" for="inlineRadio2">Video</label>
                    </div>
                    <br>
                    <label for="">File</label>
                    <br>
                    <input name="a_file" id="img" required type="file" class=" mb-3" >
                    <br>
                    <button type="submit" name="update_file" class="btn btn-block btn-sm btn-outline-warning text-black">Ubah File</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url() ?>/assets/vendor/ckeditor/ckeditor.js"></script>
<script>
    CKEDITOR.replace('editor1')
</script>