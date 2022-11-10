<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md">
            <div class="card bg-success text-white h-100 overflow-hidden">
                <div class="card-body bg-danger">
                    <div class="rotate">
                        <i class="fa fa-user fa-8x"></i>
                    </div>
                    <h6 class="text-uppercase">Total Nasabah</h6>
                    <h1 class="display-4"><?= $nasabah ?></h1>
                </div>
            </div>
        </div>
        <div class="col-md">
            <div class="card bg-success text-white h-100 overflow-hidden">
                <div class="card-body bg-primary">
                    <div class="rotate">
                        <i class="fa fa-people-carry fa-7x"></i>
                    </div>
                    <h6 class="text-uppercase">Total Unit</h6>
                    <h1 class="display-4"><?= $unit ?></h1>
                </div>
            </div>
        </div>
        <div class="col-md">
            <div class="card bg-success text-white h-100 overflow-hidden">
                <div class="card-body bg-success">
                    <div class="rotate">
                        <i class="fa fa-dollar-sign fa-8x"></i>
                    </div>
                    <h6 class="text-uppercase">Total Omset</h6>
                    <h1 class="display-4"><?= $omset ?></h1>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md">
            <div class="card">
                <div class="card-body">
                    <h1 class="h3 mb-4 mt-4 text-gray-800">
                        Daftar Request Sampah
                    </h1>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="content bg-white p-3">
                                <div class="row">
                                    <?php foreach ($listSampah as $sampah) : ?>
                                        <div class="col-md-3 mb-4">
                                            <div class="card h-100 overflow-hidden">
                                                <div class="card-body">
                                                    <div class="rotate">
                                                        <i class="fa fa-trash fa-8x"></i>
                                                    </div>
                                                    <h6 class="text-uppercase"><?= $sampah->j_name ?></h6>
                                                    <h1 class="display-4"><?= $sampah->berat_total ?> kg</h1>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="mb-4" />
                    <div class="row">
                        <div class="mb-3 col-lg-12 col-md-12 col-sm-12">
                            <div class="content bg-white p-3">
                                <a href="<?= base_url('induk/create') ?>" class="btn btn-sm btn-warning text-black mb-4"> <i class="fas fa-fw fa-plus-circle"></i> Tambah Request Sampah</a>
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
                                            <th>Kontak</th>
                                            <th>Jenis sampah</th>
                                            <th>Berat</th>
                                            <th>Harga</th>
                                            <th>Jadwal</th>
                                            <th>Tanggal Request</th>
                                            <th>Catatan</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; ?>
                                        <?php foreach ($requests as $request) : ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td>
                                                    <a class="text-warning" href="" data-toggle="modal" data-target="#userModal" onclick="showData('<?= xss($request->id_nasabah) ?>')">
                                                        <?= xss($request->n_name) ?>
                                                    </a>
                                                </td>
                                                <td><?= xss($request->n_contact) ?></td>
                                                <td><?= xss($request->j_name) ?></td>
                                                <td><?= xss($request->r_weight) ?></td>
                                                <td><?= xss($request->harga) ?></td>
                                                <td><?= xss($request->s_day) ?>, <?= xss($request->s_time) ?> - <?= xss($request->s_weather) ?></td>
                                                <td><?= xss($request->r_date) ?></td>
                                                <td><?= xss($request->r_notes) ?></td>
                                                <td>
                                                    <a href="<?= base_url('induk/update/') . $request->_id ?>" class="btn btn-sm btn-warning text-black">
                                                        <i class="fas fa-fw fa-edit"></i>
                                                    </a>
                                                    <?php if ($request->r_status == 0) : ?>
                                                        <a href="#" class="btn btn-sm btn-danger" onclick="$
                                                        confirm('Apakah Anda ingin membatalkan request sampah ini?') === true ? window.location.href= '<?= base_url('induk/cancel_request/') . $request->_id ?>' : console.log(false)">
                                                            <i class="fas fa-times"></i>
                                                        </a>
                                                        <a href="#" class="btn btn-sm btn-warning" onclick="$
                                                        confirm('Apakah Anda ingin mengonfirmasi request sampah ini?') === true ? window.location.href= '<?= base_url('induk/accept_request/') . $request->_id ?>' : console.log(false)">
                                                            <i class="fas fa-check"></i>
                                                        </a>
                                                    <?php elseif ($request->r_status == 1) : ?>
                                                        <a href="#" class="btn btn-sm btn-success" onclick="$
                                                        confirm('Apakah Anda ingin mencairkan uang ini?') === true ? window.location.href= '<?= base_url('induk/finish_request/') . $request->_id ?>' : console.log(false)">
                                                            <i class="fas fa-dollar-sign"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                </td>
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
                <button class="btn btn-warning text-black" type="button" data-dismiss="modal">Okay</button>
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