<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="content bg-white p-3">
                <h3 class="h5 text-gray-600 mb-4">
                    Request Sampah
                </h3>

                <form action="" method="post" enctype="multipart/form-data">
                    <label for="">Jenis Sampah</label>
                    <?= form_error('fk_garbage', '<small class="text-danger pl-3">', '</small>') ?>
                    <select name="fk_garbage" class="form-control mb-3">
                        <?php foreach ($listSampah as $sampah) : ?>
                            <option value="<?= $sampah->_id ?>"><?= $sampah->j_name ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label for="">Nasabah</label>
                    <?= form_error('fk_nasabah', '<small class="text-danger pl-3">', '</small>') ?>
                    <select name="fk_nasabah" class="form-control js-example-basic-single">
                        <?php foreach ($listNasabah as $nasabah) : ?>
                            <option value="<?= $nasabah->_id ?>"><?= $nasabah->n_name ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label for="" class="mt-3">Admin Induk</label>
                    <?= form_error('fk_admin', '<small class="text-danger pl-3">', '</small>') ?>
                    <select name="fk_admin" class="form-control js-example-basic-single">
                        <?php foreach ($listAdmin as $admin) : ?>
                            <option value="<?= $admin->_id ?>"><?= $admin->un_name ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label for="" class="mt-3">Berat Barang (jumlah berat minimal  <?= $min ?> kg) </label>
                    <?= form_error('r_weight', '<small class="text-danger pl-3">', '</small>') ?>
                    <input name="r_weight" type="number" min="<?= $min ?>" step="0.01" class="form-control mb-3">
                    <label for="">Jadwal Sampah</label>
                    <?= form_error('fk_jadwal', '<small class="text-danger pl-3">', '</small>') ?>
                    <select name="fk_jadwal" class="form-control mb-3">
                        <?php foreach ($listJadwal as $jadwal) : ?>
                            <option value="<?= $jadwal->_id ?>"><?= xss($jadwal->s_day) ?>, <?= xss($jadwal->s_time) ?> - <?= xss($jadwal->s_weather) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label for="">Gambar</label>
                    <?= form_error('r_image', '<small class="text-danger pl-3">', '</small>') ?>
                    <br>
                    <input name="r_image" id="img" type="file" class="form-control mb-3">
                    <br>
                    <button type="submit" class="btn btn-block btn-sm btn-warning text-black">Tambah Jenis Sampah</button>
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