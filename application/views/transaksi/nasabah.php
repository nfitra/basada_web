<div class="container-fluid">
    <div class="row">
        <div class="col-md">
            <h1 class="h3 mb-4 mt-4 text-gray-800">
                Daftar Request Sampah yang Selesai
            </h1>
            <div class="row">
                <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
                    <div class="content bg-white p-3">
                        <?php if ($user->r_name == "Admin Induk") : ?>
                            <a href="<?= base_url('transaksiNasabah/take_balance') ?>" class="btn btn-sm btn-warning text-black mb-4"> <i class="fas fa-fw fa-dollar-sign"></i> Tarik Saldo&nbsp;</a>
                        <?php endif; ?>
                        <?php
                        $message = $this->session->flashdata('message');
                        if (isset($message)) {
                            echo $message;
                        }
                        ?>
                        <table id="table-request" class=" mt-3 mb-3 table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Nasabah</th>
                                    <th>Jenis sampah</th>
                                    <th>Berat</th>
                                    <th>Harga</th>
                                    <th>Gambar</th>
                                    <th style="width: 30%;">Catatan</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($requests as $request) : ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td>
                                            <a href="" data-toggle="modal" data-target="#userModal" onclick="showData('<?= xss($request->id_nasabah) ?>')">
                                                <?= xss($request->n_name) ?>
                                            </a>
                                        </td>
                                        <td><?= xss($request->j_name) ?></td>
                                        <td><?= xss($request->r_weight) ?></td>
                                        <td><?= xss($request->harga) ?></td>
                                        <td><img style="width:10em; background:#eee; padding:10px" src="<?= base_url(xss($request->r_image)) ?>" alt="<?= xss($request->r_image) ?>"></td>
                                        <td><?= xss($request->r_notes) ?></td>
                                        <td><?= xss($request->r_date) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Data Nasabah</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="col-form-label">Nama:</label>
                    <input type="text" class="form-control" id="nasabah" readonly>
                </div>
                <div class="form-group">
                    <label class="col-form-label">Alamat:</label>
                    <textarea class="form-control" id="alamat" style="resize: none;" readonly></textarea>
                </div>
                <div class="form-group">
                    <label class="col-form-label">Nomor Kontak:</label>
                    <input type="text" class="form-control" id="kontak" readonly>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="button" data-dismiss="modal">Okay</button>
            </div>
        </div>
    </div>
</div>

<script>
    const showData = (id) => {
        const nasabah = document.getElementById('nasabah');
        const alamat = document.getElementById('alamat');
        const url = `<?= base_url("nasabah/get_data") ?>/${id}`;
        fetch(url)
            .then(res => res.json())
            .then(result => {
                nasabah.value = result[0].n_name
                alamat.innerText = `${result[0].n_address}, ${result[0].n_city}, ${result[0].n_province} ${result[0].n_postcode}`
                kontak.value = result[0].n_contact
            });
    }
</script>