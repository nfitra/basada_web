


<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="row">
        <div class="col-md-12">
            <h1 class="h3 mb-4 mt-4 text-gray-800">
                <?= $title ?>
            </h1>
            <?php 
                $message = $this->session->flashdata('message'); 
                if(isset($message)) {
                    echo $message;
                }
            ?>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="content bg-white p-3">
                        <h1 class="h5 mb-2 text-gray-600">
                            List Menu
                        </h1>
                        <a href="<?= base_url('menu/create/menu') ?>"  class="btn btn-warning text-black mb-4 btn-sm">
                            <i class="fas fa-fw fa-plus-circle"></i>
                            Tambah Menu
                        </a>
                        <?php 
                            $menu = $this->session->flashdata('menu'); 
                            if(isset($menu)) {
                                echo $menu;
                            }
                        ?>
                        <table class="table table-hover table-bordered" id="table-menu">
                            <thead>
                                <th>No</th>
                                <th>Nama Menu</th>
                                <th>Urutan</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach($listMenu as $menu) : ?>
                                    <tr>
                                        <th><?= $no++ ?></th>
                                        <td><?= xss($menu->m_name) ?></td>
                                        <td><?= xss($menu->m_order) ?></td>
                                        <td>
                                            <a href="<?= base_url('menu/update/menu/'.$menu->_id) ?>" class="btn btn-warning text-black btn-sm">
                                                <i class="fas fa-fw fa-edit"></i>
                                            </a>
                                            <a href="#" class="btn btn-outline-danger btn-sm">
                                                <i class="fas fa-fw fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-8 mb-3">
                    <div class="content bg-white p-3">
                        <h1 class="h5 mb-2 text-gray-600">
                            List Sub Menu
                        </h1>
                        <a href="<?= base_url('menu/create/subMenu') ?>""  class="btn btn-warning text-black mb-4 btn-sm">
                            <i class="fas fa-fw fa-plus-circle"></i>
                            Tambah Sub Menu
                        </a>
                        <?php 
                            $subMenu = $this->session->flashdata('subMenu'); 
                            if(isset($subMenu)) {
                                echo $subMenu;
                            }
                        ?>
                        <table class="table table-hover table-bordered" id="table-sub-menu">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Sub Menu</th>
                                    <th>Parent Menu</th>
                                    <th>URL</th>
                                    <th>Icon</th>
                                    <th>Urutan</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $no = 1; ?>
                                <?php foreach($listSubMenu as $subMenu) : ?>
                                    <?php $label = $subMenu->sm_isActive == 1 
                                        ? "<span class='badge badge-warning'>active</span>" 
                                        : "<span class='badge badge-warning text-black'>inactive</span>" ?>
                                    <tr>
                                        <th><?= $no++ ?></th>
                                        <td><?= xss($subMenu->sm_title) ?></td>
                                        <td><?= xss($subMenu->m_name) ?></td>
                                        <td><?= xss($subMenu->sm_url) ?></td>
                                        <td>
                                            [ <i class="fas fa-fw <?= xss($subMenu->sm_icon) ?>"></i> ]
                                            <!-- <?= xss($subMenu->sm_icon) ?>  -->
                                        </td>
                                        <td><?= xss($subMenu->sm_order) ?></td>
                                        <td><?= $label ?></td>
                                        <td>
                                            <a href="<?= base_url('menu/update/subMenu/'.$subMenu->_id) ?>" class="btn btn-warning text-black btn-sm">
                                                <i class="fas fa-fw fa-edit"></i>
                                            </a>
                                            <a href="#" class="btn btn-outline-danger btn-sm">
                                                <i class="fas fa-fw fa-trash"></i>
                                            </a>
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
<!-- /.container-fluid -->
      