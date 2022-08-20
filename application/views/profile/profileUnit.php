<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="content bg-white p-3">
                <!-- Page Heading -->
                <h1 class="h3 mb-4 text-gray-800">
                    <?= $title ?>
                </h1>
                <?php
                $message = $this->session->flashdata('message');
                if (isset($message)) {
                    echo $message;
                }
                ?>
                <form action="" method="POST">
                    <?php if (form_error('u_name') !== "") : ?>
                        <div class="alert alert-danger">
                            Ubah Data Gagal !
                        </div>
                    <?php endif; ?>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="border p-3 rounded">
                                <h3 class="h5 mb-4 text-gray-800">
                                    Data Diri 1
                                </h3>
                                <label for="">Nama Lengkap * </label>
                                <input type="text" placeholder="ex: Your Name" value="<?= $user->un_name ?>" class="form-control mb-3" name="un_name" />
                                <label for="">Tahun Berdiri</label>
                                <input type="text" placeholder="ex: 2018" class="form-control mb-3" name="un_est" value="<?= $user->un_est ?>" />
                                <label for="">No SK</label>
                                <input type="text" placeholder="ex: KTPS/97/SS/SKLXI/2018" class="form-control mb-3" name="un_sk" value="<?= $user->un_sk ?>" />
                                <label for="">Status</label>
                                <select class="form-control mb-3" name="un_status">
                                    <option value="" <?= $user->un_status == "" ? "selected" : "" ?>></option>
                                    <option value="Aktif" <?= $user->un_status == "Aktif" ? "selected" : "" ?>>Aktif</option>
                                    <option value="Tidak Aktif" <?= $user->un_status == "Tidak Aktif" ? "selected" : "" ?>>Tidak Aktif</option>
                                </select>
                                <label for="">No Hp</label>
                                <input type="text" placeholder="ex: 081234567890" class="form-control mb-3" name="un_contact" value="<?= $user->un_contact ?>" />
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="border p-3 rounded">
                                <h3 class="h5 mb-4 text-gray-800">
                                    Data Diri 2
                                </h3>
                                <label for="">Jumlah Karyawan</label>
                                <input type="number" class="form-control mb-3" name="un_employees" value="<?= $user->un_employees ?>" />
                                <label for="">Nama Pengelola</label>
                                <input type="text" placeholder="ex: Your Manager Name" class="form-control mb-3" name="un_manager" value="<?= $user->un_manager ?>" />
                                <label for="">Alamat</label>
                                <input type="text" placeholder="ex: Your Address" class="form-control mb-3" name="un_address" value="<?= $user->un_address ?>" />
                                <label for="">Kecamatan</label>
                                <input type="text" placeholder="ex: Payung Sekaki" class="form-control mb-3" name="un_district" value="<?= $user->un_district ?>" />
                                <label for="">Location</label>
                                <input type="text" placeholder="ex: 101, 0.1" class="form-control mb-3" name="un_location" value="<?= $user->un_location ?>" />
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <button class="btn btn-warning text-black btn-block">Ubah Data Diri</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-12">
            <div class="content bg-white p-3">
                <form action="<?= base_url('profile/update_auth/') . $user->_id ?>" method="post">
                    <?php if (form_error('password') !== "") : ?>
                        <div class="alert alert-danger">
                            Ubah Akun Gagal !
                        </div>
                    <?php endif; ?>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <div class="border p-3 rounded">
                                <h3 class="h5 mb-4 text-gray-800">
                                    Akun
                                </h3>
                                <?php
                                $message = $this->session->flashdata('message2');
                                if (isset($message)) {
                                    echo $message;
                                }
                                ?>
                                <label for="">Email *</label>
                                <input type="email" placeholder="ex: your@email.com" class="form-control mb-3" name="email" value="<?= $user->fk_auth ?>" disabled />

                                <label for="">Password *</label>
                                <?= form_error('password', '<small class="text-danger pl-3">', '</small>') ?>
                                <input type="password" placeholder="Ketikkan passwordnya disini" class="form-control mb-3" name="password" />

                                <label for="">Konfirmasi Password *</label>
                                <?= form_error('confPass', '<small class="text-danger pl-3">', '</small>') ?>
                                <input type="password" placeholder="Ketik ulang passwordnya" class="form-control mb-3" name="confPass" />
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