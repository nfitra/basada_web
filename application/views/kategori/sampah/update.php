<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="content bg-white p-3">
                <h1 class="h5 text-gray-600 mb-4">
                    Ubah Kategori
                </h1>
                <form action="" method="post">
                    <?= form_error('k_name','<small class="text-danger pl-3">','</small>') ?>
                    <label for="">Nama Kategori</label>
                    <input required type="text" class="form-control mb-3" name="k_name" value="<?= xss($dataKategori->k_name) ?>" placeholder="ex : Pendidikan">
                    
                    <button type="submit" class="btn btn-sm btn-block btn-warning text-black">Ubah Kategori</button>
                </form>
            </div>
        </div>
    </div>
</div>
