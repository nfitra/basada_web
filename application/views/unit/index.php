<!-- Begin Page Content -->
<div class="container-fluid">
  <div class="row">
      <div class="col-md-12">
        <h1 class="h3 mb-4 mt-4 text-gray-800">
            <?= $title ?>
        </h1>
        <div class="content bg-white p-3">
            <!-- Page Heading -->

            <a href="<?= base_url('dataUnit/create') ?>" class="btn btn-sm btn-warning text-black mb-4"> <i class="fas fa-fw fa-plus-circle"></i> Tambah Unit</a>

            <?php 
                $message = $this->session->flashdata('message'); 
                if(isset($message)) {
                    echo $message;
                }
            ?>
            <table id="table-daftar-unit" class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Email</th>
                        <th>Nama Unit</th>
                        <th>Alamat Unit</th>
                        <th>Kecamatan</th>
                        <th>No Hp</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; ?>
                    <?php foreach($listUnit as $unit) : ?>
                        <tr>
                            <th><?= $no++ ?></th>
                            <td><?= xss($unit->fk_auth) ?></td>
                            <td><?= xss($unit->un_name) ?></td>
                            <td><?= xss($unit->un_address) ?></td>
                            <td><?= xss($unit->un_district) ?></td>
                            <td><?= xss($unit->un_contact) ?></td>
                            <td><?= xss($unit->un_status) ?></td>
                            <td>
                                <a href="<?= base_url('dataUnit/update/').$unit->_id ?>" class="btn btn-sm btn-warning text-black">
                                    <i class="fas fa-fw fa-edit"></i>
                                </a>
                                <a  href="<?= base_url('dataUnit/delete/').$unit->_id ?>" class="btn btn-sm btn-warning text-black" onclick="$
                                    confirm('Apakah Anda ingin menghapus data ini?') === true 
                                        ? window.location.href= '<?= base_url('dataUnit/delete/').$unit->_id ?>'
                                        : console.log(false)
                                ">
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
<!-- /.container-fluid -->