<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="content bg-white p-3">
                <h1 class="h5 text-gray-600 mb-4">
                    <?= $title ?>
                </h1>
                <form action="" method="post">
                    <label for="">Nama</label>
                    <?= form_error('p_nama', '<small class="text-danger pl-3">', '</small>') ?>
                    <input required type="text" class="form-control mb-3" name="p_nama" placeholder="ex : Nama Pelapak">
                    <label for="">Alamat</label>
                    <?= form_error('p_alamat', '<small class="text-danger pl-3">', '</small>') ?>
                    <input required type="text" class="form-control mb-3" name="p_alamat" placeholder="ex : Alamat Pelapak">
                    <label for="">Kontak</label>
                    <?= form_error('p_kontak', '<small class="text-danger pl-3">', '</small>') ?>
                    <input required type="text" class="form-control mb-3" name="p_kontak" placeholder="ex : Kontak Pelapak">

                    <button type="submit" class="btn btn-sm btn-block btn-warning text-black">Tambah Pelapak</button>
                </form>
            </div>
        </div>
    </div>
</div>