<div class="container-fluid">
    <div class="row">
        <div class="col-md">
            <h1 class="h3 mb-4 mt-4 text-gray-800">
                Laporan
            </h1>
            <div class="row">
                <div class="mb-3 col-lg-4 col-md-6 col-sm-6">
                    <div class="content pt-3">
                        <?php
                        $message = $this->session->flashdata('message');
                        if (isset($message)) {
                            echo $message;
                        }
                        ?>
                        <form method="post" action="">
                            <label for="">Rentang Waktu</label>
                            <?= form_error('date', '<small class="text-danger pl-3">', '</small>') ?>
                            <input type="date" class="form-control mb-3" name="date" />
                            <?= form_error('date2', '<small class="text-danger pl-3">', '</small>') ?>
                            <input type="date" class="form-control mb-3" name="date2" />

                            <label for="">Laporan</label>
                            <?= form_error('laporan', '<small class="text-danger pl-3">', '</small>') ?>
                            <select name="laporan" class="form-control mb-3" id="stat">
                                <option value="">------ Pilih Laporan ------</option>
                                <option value="Nasabah">Nasabah</option>
                                <option value="Pemasukan">Pemasukan</option>
                                <option value="Pengeluaran">Pengeluaran</option>
                                <option value="Transaksi">Transaksi</option>
                            </select>

                            <div id="status" style="display: none">
                                <label for="">Status</label>
                                <select name="status" class="form-control mb-3">
                                    <option value="Semua">Semua</option>
                                    <option value="Offline">Offline</option>
                                    <option value="Online">Online</option>s
                                </select>
                            </div>

                            <div id="kategori" style="display: none">
                                <label for="">Kategori Sampah</label>
                                <select name="kategori" class="form-control mb-3">
                                    <option value="Semua">Semua</option>
                                    <?php foreach ($listKategori as $kategori) : ?>
                                        <option value="<?= $kategori->_id ?>"><?= $kategori->k_name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <label for="">Jenis File</label>
                            <?= form_error('jenis', '<small class="text-danger pl-3">', '</small>') ?>
                            <select name="jenis" class="form-control mb-3">
                                <option value="">------ Pilih Jenis File ------</option>
                                <option value="excel">Excel</option>
                                <option value="pdf">PDF</option>
                            </select>
                            <input type="submit" class="btn btn-warning text-black mb-5" value="Download" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    const stat = document.getElementById('stat');
    stat.addEventListener('change', (e) => {
        addStatus(e)
    })
    stat.addEventListener('click', (e) => {
        addStatus(e)
    })

    const addStatus = (e) => {
        const value = e.target.value;
        const status = document.getElementById('status');
        const kategori = document.getElementById('kategori');
        if (value == "Nasabah") {
            status.style.display = "block";
            kategori.style.display = "none";
        } else if (value == "Transaksi") {
            kategori.style.display = "block";
            status.style.display = "none";
        } else {
            status.style.display = "none";
            kategori.style.display = "none";
        }
    }
</script>