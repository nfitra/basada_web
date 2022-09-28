<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="content bg-white p-3">
                <h1 class="h5 text-gray-600 mb-4">
                    Ubah Menu
                </h1>
                <form action="<?= base_url('menu/update_data/menu/').$menu->_id ?>" method="post">
                    <?= form_error('m_name','<small class="text-danger pl-3">','</small>') ?>
                    <label for="">Nama Menu</label>
                    <input required value="<?= xss($menu->m_name) ?>" type="text" class="form-control mb-3" name="m_name" placeholder="ex : Admin">
                    <?= form_error('m_order','<small class="text-danger pl-3">','</small>') ?>
                    <label for="">Urutan</label>
                    <input type="number" required value="<?= xss($menu->m_order) ?>" min=0 class="form-control mb-3" name="m_order" placeholder="ex : 3">
                    <button type="submit" class="btn btn-sm btn-block btn-warning text-black" >Ubah Menu</button>
                    
                </form>
            </div>
            
        </div>
    </div>
</div>