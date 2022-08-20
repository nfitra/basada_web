<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="content bg-white p-3">
                <h3 class="h5 text-gray-600 mb-4">
                    Tarik Saldo
                </h3>
                <form action="" method="post">
                    <label for="">Nama Nasabah</label>
                    <?= form_error('fk_nasabah', '<small class="text-danger pl-3">', '</small>') ?>
                    <select name="fk_nasabah" class="form-control mb-3">
                        <option value="">------ Pilih Nama Nasabah ------ </option>
                        <?php foreach ($listNasabah as $nasabah) : ?>
                            <option value="<?= $nasabah->_id ?>"><?= xss($nasabah->n_name) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label for="">Jumlah Saldo</label>
                    <?= form_error('m_amount', '<small class="text-danger pl-3">', '</small>') ?>
                    <input type="number" class="form-control mb-3" min="0" name="m_amount" placeholder="ex : 10000">
                    <button type="submit" class="btn btn-sm btn-block btn-warning text-black">Tarik Saldo</button>
                </form>
            </div>
        </div>
    </div>
</div>