<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="content bg-white p-3">
                <h1 class="h5 text-gray-600 mb-4">
                    Tambah Menu
                </h1>
                <form action="<?= base_url('menu/create_data/menu') ?>" method="post">
                    
                        <label for="">Nama Menu</label>
                        <input required type="text" class="form-control mb-3" name="m_name" placeholder="ex : Admin">
                        <?= form_error('m_order','<small class="text-danger pl-3">','</small>') ?>
                        <label for="">Urutan</label>
                        <input type="number" required min=0 class="form-control mb-3" name="m_order" placeholder="ex : 3">
                    
                        <button type="submit" class="btn btn-sm btn-block btn-warning text-black" >Tambah Menu</button>
                    
                </form>
            </div>
            
        </div>
    </div>
</div>