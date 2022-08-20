<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="content bg-white p-3">
                <h1 class="h5 text-gray-600 mb-4">
                    Tambah Data Pengeluaran
                </h1>
                <form action="" method="post" enctype="multipart/form-data">
                    <?= form_error('pk_bulan', '<small class="text-danger pl-3">', '</small>') ?>
                    <label for="">Tanggal</label>
                    <input type="date" class="form-control mb-3" name="pk_bulan">

                    <?= form_error('pk_jenis', '<small class="text-danger pl-3">', '</small>') ?>
                    <label for="">Jenis Pengeluaran</label>
                    <input type="text" class="form-control mb-3" name="pk_jenis">

                    <?= form_error('pk_jumlah', '<small class="text-danger pl-3">', '</small>') ?>
                    <label for="">Jumlah</label>
                    <input type="number" class="form-control mb-3" name="pk_jumlah" min="0" id="jumlah">

                    <?= form_error('pk_harga', '<small class="text-danger pl-3">', '</small>') ?>
                    <label for="">Harga Satuan</label>
                    <input type="number" class="form-control mb-3" name="pk_harga" min="0" id="harga">

                    <label for="">Total</label>
                    <input required type="text" class="form-control mb-3" name="pk_total" id="total" readonly>

                    <?= form_error('fk_admin', '<small class="text-danger pl-3">', '</small>') ?>
                    <label for="">Bank Unit</label>
                    <select class="form-control mb-3" name="fk_admin">
                        <option value="<?= $user->fk_auth ?>"><?= $user->un_name ?></option>
                        <?php foreach($listUnit as $unit) : ?>
                        <option value="<?= $unit->fk_auth ?>"><?= $unit->un_name ?></option>
                        <?php endforeach; ?>
                    </select>

                    <label for="">Bukti Pengeluaran</label>
                    <input required name="pk_bukti" type="file" id="img" class="form-control mb-3" />

                    <label for="">Keterangan</label>
                    <textarea name="pk_keterangan" class="form-control mb-3" rows="5" style="resize: none"></textarea>

                    <button type="submit" class="btn btn-sm btn-block btn-warning text-black">Tambah Pengeluaran</button>
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