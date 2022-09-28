<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="content bg-white p-3">
                <h1 class="h5 text-gray-600 mb-4">
                    Ubah Data Pengeluaran
                </h1>
                <form action="" method="post">
                    <?= form_error('pk_bulan', '<small class="text-danger pl-3">', '</small>') ?>
                    <label for="">Bulan</label>
                    <input required type="date" class="form-control mb-3" name="pk_bulan" value="<?= $pengeluaran->pk_bulan ?>">

                    <?= form_error('pk_jenis', '<small class="text-danger pl-3">', '</small>') ?>
                    <label for="">Jenis Pengeluaran</label>
                    <input required type="text" class="form-control mb-3" name="pk_jenis" value="<?= $pengeluaran->pk_jenis ?>">

                    <?= form_error('pk_jumlah', '<small class="text-danger pl-3">', '</small>') ?>
                    <label for="">Jumlah</label>
                    <input required type="number" class="form-control mb-3" name="pk_jumlah" min="0" id="jumlah" value="<?= $pengeluaran->pk_jumlah ?>">

                    <?= form_error('pk_harga', '<small class="text-danger pl-3">', '</small>') ?>
                    <label for="">Harga Satuan</label>
                    <input required type="number" class="form-control mb-3" name="pk_harga" min="0" step="100" id="harga" value="<?= $pengeluaran->pk_harga ?>">

                    <label for="">Total</label>
                    <input required type="text" class="form-control mb-3" name="pk_total" id="total" readonly value="<?= $pengeluaran->pk_total ?>">

                    <?= form_error('fk_admin', '<small class="text-danger pl-3">', '</small>') ?>
                    <label for="">Bank Unit</label>
                    <select class="form-control mb-3" name="fk_admin">
                        <option value="<?= $user->fk_auth ?>" <?= ($user->fk_auth == $pengeluaran->fk_admin)?"selected":"" ?>><?= $user->un_name ?></option>
                        <?php foreach($listUnit as $unit) : ?>
                        <option value="<?= $unit->fk_auth ?>" <?= ($unit->fk_auth == $pengeluaran->fk_admin)?"selected":"" ?>><?= $unit->un_name ?></option>
                        <?php endforeach; ?>
                    </select>

                    <label for="">Keterangan</label>
                    <textarea name="pk_keterangan" class="form-control mb-3" rows="5" style="resize: none"><?= $pengeluaran->pk_keterangan ?></textarea>

                    <button type="submit" class="btn btn-sm btn-block btn-warning text-black">Ubah Pengeluaran</button>
                </form>
            </div>
        </div>
        <div class="col-md-4">
            <div class="content bg-white p-3">
                <h3 class="h5 text-gray-600 mb-4">
                    Ubah Gambar
                </h3>
                <form action="<?= base_url('pengeluaran/update_gambar/') . $pengeluaran->_id ?>" method="post" enctype="multipart/form-data">
                    <label for="">Saat ini </label>
                    <img class=" mb-3" style="width:100%; background:#eee; padding:10px;" src="<?= base_url($pengeluaran->pk_bukti) ?>" alt="">
                    <br>
                    <label for="">Gambar</label>
                    <br>
                    <input name="pk_bukti" id="img" required type="file" class=" mb-3" value="<?= $pengeluaran->pk_bukti ?>">
                    <br>
                    <button type="submit" name="update_img" class="btn btn-block btn-sm btn-outline-warning text-black">Ubah Foto</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const harga = document.getElementById("harga");
    const jumlah = document.getElementById("jumlah");
    const total = document.getElementById("total");
    harga.addEventListener('keyup', () => {
        changeTotal();
    })
    jumlah.addEventListener('keyup', () => {
        changeTotal();
    })

    const changeTotal = () => {
        if (harga.value != "" && jumlah.value != "")
            total.value = harga.value * jumlah.value;
        else
            total.value = "0";
    }
</script>