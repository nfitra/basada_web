<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="content bg-white p-3">
                <h1 class="h5 text-gray-600 mb-4">
                    Tambah Data Pemasukan
                </h1>
                <form action="" method="post">
                    <?= form_error('fk_garbage', '<small class="text-danger pl-3">', '</small>') ?>
                    <label for="">Jenis Sampah</label>
                    <select required class="form-control mb-3" name="fk_garbage" id="sampah">
                        <option value="">------Pilih Jenis Sampah------</option>
                        <?php foreach ($listSampah as $sampah) : ?>
                            <option value="<?= $sampah->_id ?>"><?= $sampah->j_name ?></option>
                        <?php endforeach; ?>
                    </select>

                    <?= form_error('pm_jumlah', '<small class="text-danger pl-3">', '</small>') ?>
                    <label for="">Jumlah</label>
                    <input required type="number" class="form-control mb-3" name="pm_jumlah" min="1" id="jumlah">

                    <?= form_error('pm_total', '<small class="text-danger pl-3">', '</small>') ?>
                    <label for="">Total</label>
                    <input required readonly type="number" class="form-control mb-3" name="pm_total" min="1" id="total">

                    <?= form_error('fk_pelapak', '<small class="text-danger pl-3">', '</small>') ?>
                    <label for="">Pelapak</label>
                    <select required type="date" class="form-control mb-3" name="fk_pelapak">
                        <?php foreach ($listPelapak as $pelapak) : ?>
                            <option value="<?= $pelapak->_id ?>"><?= $pelapak->p_nama ?></option>
                        <?php endforeach; ?>
                    </select>

                    <?= form_error('pm_created_at', '<small class="text-danger pl-3">', '</small>') ?>
                    <label for="">Tanggal Penjualan</label>
                    <input required type="date" class="form-control mb-3" name="pm_created_at" />

                    <?= form_error('pm_hasil', '<small class="text-danger pl-3">', '</small>') ?>
                    <label for="">Keterangan</label>
                    <textarea required class="form-control mb-3" name="pm_hasil"></textarea>

                    <button type="submit" class="btn btn-sm btn-block btn-warning text-black">Tambah Pemasukan</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    const harga = document.getElementById("sampah");
    const jumlah = document.getElementById("jumlah");
    const total = document.getElementById("total");
    let hargaSampah = 0;
    harga.addEventListener('change', (e) => {
        if (e.target.value !== "") {
            fetch(`<?= base_url() ?>pemasukan/get_harga_by_id/${e.target.value}`)
                .then(res => res.json())
                .then((result) => {
                    hargaSampah = result.harga_pelapak;
                    total.value = hargaSampah * jumlah.value;
                });
        } else
            total.value = "0";
    })
    jumlah.addEventListener('keyup', () => {
        calc()
    });
    jumlah.addEventListener('input', () => {
        calc()
    });
    const calc = () => {
        if (hargaSampah != 0 && jumlah.value != "")
            total.value = hargaSampah * jumlah.value;
        else
            total.value = "0";
    }
</script>