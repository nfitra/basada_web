<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="content bg-white p-3">
                <h3 class="h5 text-gray-600 mb-4">
                    Update Request Sampah
                </h3>
                <form action="" method="post">
                    <label for="">Jenis Sampah</label>
                    <?= form_error('fk_garbage','<small class="text-danger pl-3">','</small>') ?>
                    <select name="fk_garbage" class="form-control mb-3" required>
                        <?php foreach($listSampah as $sampah) : ?>
                        <option value="<?= $sampah->_id ?>" <?= ($sampah->_id == $request->fk_garbage) ? "selected" : "" ?>><?= $sampah->j_name ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label for="">Nasabah</label>
                    <input type="text" class="form-control mb-3" value="<?= $request->nama_nasabah ?>" disabled>
                    <!-- <?= form_error('fk_nasabah', '<small class="text-danger pl-3">', '</small>') ?>
                    <select name="fk_nasabah" class="form-control js-example-basic-single">
                        <?php foreach ($listNasabah as $nasabah) : ?>
                            <option value="<?= $nasabah->_id ?>" <?= ($nasabah->_id == $request->fk_nasabah) ? "selected" : "" ?>><?= $nasabah->n_name ?></option>
                        <?php endforeach; ?>
                    </select> -->
                    <label for="" class="mt-3">Berat Sampah</label>
                    <?= form_error('r_weight','<small class="text-danger pl-3">','</small>') ?>
                    <input name="r_weight" type="text" class="form-control mb-3" value="<?= $request->r_weight ?>" >
                    
                    <button type="submit" class="btn btn-block btn-sm btn-warning text-black">Ubah Jenis Sampah</button>
                </form>
            </div>
        </div>
        <div class="col-md-4">
            <div class="content bg-white p-3">
                <h3 class="h5 text-gray-600 mb-4">
                    Ubah Gambar
                </h3>
                <form action="<?= base_url('unit/update_gambar/').$request->_id ?>" method="post" enctype="multipart/form-data">
                    <label for="">Saat ini </label>
                    <img class=" mb-3"  style="width:100%; background:#eee; padding:10px;" src="<?= base_url($request->r_image) ?>" alt="<?= base_url('uploads/mobile/').$request->r_image ?>">
                    <br>
                    <label for="">Gambar</label>
                    <br>
                    <input name="r_img" id="img" required type="file" class=" mb-3" value="<?= $request->r_image ?>" >
                    <br>
                    <button type="submit" name="update_img" class="btn btn-block btn-sm btn-outline-warning text-black">Ubah Foto</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    // In your Javascript (external .js resource or <script> tag)
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });
</script>