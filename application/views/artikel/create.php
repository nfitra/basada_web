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
                    <input required name="a_title" id="a_title" type="text" class="form-control mb-3" value="<?= set_value('a_title') ?>" >
                    <br>
                    <label for="">Isi Artikel</label>
                    <?= form_error('a_content','<small class="text-danger pl-3">','</small>') ?>
                    <br>
                    <textarea name="a_content" id="editor1"></textarea>
                    <label for="" class="mt-3">Kategori</label>
                    <?= form_error('fk_kategori','<small class="text-danger pl-3">','</small>') ?>
                    <select required class="form-control mb-3" name="fk_kategori" id="fk_kategori">
                        <option value="">----- Pilih Kategori -----</option>
                        <?php foreach($categories as $category) : ?>
                            <option value="<?= $category->_id ?>"><?= $category->k_name ?></option>
                        <?php endforeach;    ?>
                    </select>
                    <label for="">Tipe File</label>
                    <br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="a_file_type" value="picture" checked>
                        <label class="form-check-label" for="inlineRadio1">Gambar</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="a_file_type" value="video">
                        <label class="form-check-label" for="inlineRadio2">Video</label>
                    </div>
                    <br>
                    <label for="" class="mt-3">File</label>
                    <?= form_error('a_file','<small class="text-danger pl-3">','</small>') ?>
                    <br>
                    <input required name="a_file" id="img" type="file" class="mb-3" value="<?= set_value('a_image') ?>" >
                    <br>
                    <button type="submit" class="btn btn-block btn-sm btn-warning text-black">Tambah Artikel</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url() ?>/assets/vendor/ckeditor/ckeditor.js"></script>
<script>
    CKEDITOR.replace('editor1')
</script>