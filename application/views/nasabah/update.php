<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="content bg-white p-3">
                <!-- Page Heading -->
                <h1 class="h3 mb-4 text-gray-800">
                    <?= $title ?>
                </h1>
                <form action="" method="POST">
                    <?php
                    $message = $this->session->flashdata('message');
                    if (isset($message)) {
                        echo $message;
                    }
                    ?>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="border p-3 rounded">
                                <label for="">Nama Lengkap</label>
                                <?= form_error('n_name', '<small class="text-danger pl-3">', '</small>') ?>
                                <input type="text" placeholder="ex: Suprakto" class="form-control mb-3" name="n_name" value="<?= $nasabah->n_name ?>" />
                                <label for="">Tanggal Lahir</label>
                                <?= form_error('n_dob', '<small class="text-danger pl-3">', '</small>') ?>
                                <input type="date" class="form-control mb-3" name="n_dob" value="<?= $nasabah->n_dob ?>" />
                                <label for="">No Hp</label>
                                <?= form_error('n_contact', '<small class="text-danger pl-3">', '</small>') ?>
                                <input type="text" placeholder="ex: 081234567890" class="form-control mb-3" name="n_contact" value="<?= $nasabah->n_contact ?>" />
                                <label for="">Saldo</label>
                                <?= form_error('n_balance', '<small class="text-danger pl-3">', '</small>') ?>
                                <input type="number" min="0" placeholder="10000" class="form-control mb-3" name="n_balance" value="<?= $nasabah->n_balance ?>" />
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="border p-3 rounded">
                                <label for="">Alamat</label>
                                <?= form_error('n_address', '<small class="text-danger pl-3">', '</small>') ?>
                                <input type="text" placeholder="ex: Jl. Jendral Sudirman no 20" class="form-control mb-3" name="n_address" value="<?= $nasabah->n_contact ?>" />
                                <label for="">Kota</label>
                                <?= form_error('n_city', '<small class="text-danger pl-3">', '</small>') ?>
                                <input type="text" placeholder="ex: Pekanbaru" class="form-control mb-3" name="n_city" value="<?= $nasabah->n_city ?>" />
                                <label for="">Provinsi</label>
                                <?= form_error('n_province', '<small class="text-danger pl-3">', '</small>') ?>
                                <input type="text" placeholder="ex: Riau" class="form-control mb-3" name="n_province" value="<?= $nasabah->n_province ?>" />
                                <label for="">Kode Pos</label>
                                <?= form_error('n_postcode', '<small class="text-danger pl-3">', '</small>') ?>
                                <input type="text" placeholder="ex: 27891" class="form-control mb-3" name="n_postcode" value="<?= $nasabah->n_postcode ?>" />
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <button class="btn btn-warning text-black btn-block">Update Data Nasabah</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-12">
            <div class="content bg-white p-3">
                <form action="<?= base_url('nasabah/update_auth/') . $nasabah->_id ?>" method="post">
                    <?php
                    $message = $this->session->flashdata('message2');
                    if (isset($message)) {
                        echo $message;
                    }
                    ?>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <div class="border p-3 rounded">
                                <h3 class="h5 mb-4 text-gray-800">
                                    Akun
                                </h3>
                                <label for="">Email</label>
                                <input type="email" placeholder="ex: your@email.com" class="form-control mb-3" name="email" value="<?= $nasabah->fk_auth ?>" disabled />

                                <label for="">Password</label>
                                <?= form_error('password', '<small class="text-danger pl-3">', '</small>') ?>
                                <input type="password" placeholder="Ketikkan passwordnya disini" class="form-control mb-3" name="password" />

                                <label for="">Konfirmasi Password</label>
                                <?= form_error('cpassword', '<small class="text-danger pl-3">', '</small>') ?>
                                <input type="password" placeholder="Ketik ulang passwordnya" class="form-control mb-3" name="cpassword" />
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <button class="btn btn-outline-warning text-black btn-block">Ubah Password</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>