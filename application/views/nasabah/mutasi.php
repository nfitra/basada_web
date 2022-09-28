<div class="container-fluid">
    <div class="row">
        <div class="col-md-9">
            <h1 class="h3 mb-4 mt-4 text-gray-800">
                <?= $title ?>
            </h1>
            <div class="content bg-white p-3">
                <table id="table-mutasi" class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Jumlah Satuan</th>
                            <th>Debit</th>
                            <th>Kredit</th>
                            <th>Informasi</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($listMutasi as $mutasi) : ?>
                            <tr>
                                <th><?= $no++ ?></th>
                                <th><?= xss($mutasi->kode) ? xss($mutasi->kode) : "-" ?></th>
                                <td><?= xss($mutasi->m_satuan) ?></td>
                                <td>Rp.<?= $mutasi->m_type == "Debit" ? number_format(xss($mutasi->m_amount), 2, ',', '.') : "-" ?></td>
                                <td>Rp.<?= $mutasi->m_type == "Kredit" ?   number_format(xss($mutasi->m_amount), 2, ',', '.') : "-" ?></td>
                                <td><?= xss($mutasi->m_information) ?></td>
                                <td><?= xss($mutasi->m_created_at) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>