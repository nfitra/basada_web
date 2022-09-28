<div class="container-fluid">
    
    <div class="row">
        <div class="col-md-6">
            <div class="content bg-white p-3">
                <h3 class="h5 text-gray-600 mb-4">
                    Ubah Sub Menu
                </h3>
                <form action="<?= base_url('menu/update_data/subMenu/').$subMenu->_id ?>" method="post">
                    <label for="">Parent Menu</label> 
                    <?= form_error('fk_menu','<small class="text-danger pl-3">','</small>') ?>
                    <select required name="fk_menu" id="fk_menu" class="form-control mb-3">
                        <option value="<?= $subMenu->fk_menu ?>"><?= xss($subMenu->m_name) ?></option>
                        
                        <?php foreach($listMenu as $menu) : ?>
                            <?php if($menu->_id !== $subMenu->fk_menu) : ?>
                                <option value="<?= $menu->_id ?>"><?= xss($menu->m_name) ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                    
                    <label for="">Sub Menu</label> 
                    <?= form_error('sm_title','<small class="text-danger pl-3">','</small>') ?>
                    <input required type="text" value="<?= $subMenu->sm_title ?>" class="form-control mb-3" name="sm_title" placeholder="ex : Dashboard">
                    <label for="">URL</label>
                    <?= form_error('sm_url','<small class="text-danger pl-3">','</small>') ?>
                    <input required type="text" value="<?= $subMenu->sm_url ?>" class="form-control mb-3" name="sm_url" placeholder="ex : admin/dashboard">
                    <label for="">Icon</label>
                    <?= form_error('sm_icon','<small class="text-danger pl-3">','</small>') ?>
                    <input required type="text" value="<?= $subMenu->sm_icon ?>" class="form-control mb-3" name="sm_icon" placeholder="ex : fa-user">
                    <label for="">Urutan</label> 
                    <?= form_error('sm_order','<small class="text-danger pl-3">','</small>') ?>
                    <input required value="<?= $subMenu->sm_order ?>" type="number" min=0 class="form-control mb-3" name="sm_order" placeholder="ex : 3">
                    <button type="submit" class="btn btn-sm btn-block btn-warning text-black" >Ubah Data Sub Menu</button>
                
                </form>
            </div>
        </div>
    </div>
</div>