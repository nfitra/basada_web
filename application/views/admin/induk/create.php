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
                                <?= form_error('un_name', '<small class="text-danger pl-3">', '</small>') ?>
                                <input type="text" placeholder="ex: Your Name" class="form-control mb-3" name="un_name" />
                                <label for="">Tahun Berdiri</label>
                                <input type="text" placeholder="ex: 2018" class="form-control mb-3" name="un_est" />
                                <label for="">No SK</label>
                                <input type="text" placeholder="ex: KTPS/97/SS/SKLXI/2018" class="form-control mb-3" name="un_sk" />
                                <label for="">Status</label>
                                <select class="form-control mb-3" name="un_status">
                                    <option value=""></option>
                                    <option value="Aktif">Aktif</option>
                                    <option value="Tidak Aktif">Tidak Aktif</option>
                                </select>
                                <label for="">No Hp</label>
                                <input type="text" placeholder="ex: 081234567890" class="form-control mb-3" name="un_contact" />
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="border p-3 rounded">
                                <h3 class="h5 mb-4 text-gray-800">
                                    Data Diri 2
                                </h3>
                                <label for="">Jumlah Karyawan</label>
                                <input type="number" class="form-control mb-3" name="un_employees" />
                                <label for="">Nama Pengelola</label>
                                <input type="text" placeholder="ex: Your Manager Name" class="form-control mb-3" name="un_manager" />
                                <label for="">Alamat</label>
                                <input type="text" placeholder="ex: Your Address" class="form-control mb-3" name="un_address" />
                                <label for="">Kecamatan</label>
                                <input type="text" placeholder="ex: Payung Sekaki" class="form-control mb-3" name="un_district" />
                                <label for="">Location</label>
                                <input type="text" placeholder="ex: 101, 0.1" class="form-control mb-3" name="un_location" />
                            </div>
                        </div>
                    </div>
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
                                <?= form_error('email', '<small class="text-danger pl-3">', '</small>') ?>
                                <input type="email" placeholder="ex: your@email.com" class="form-control mb-3" name="email" />

                                <label for="">Password *</label>
                                <?= form_error('password', '<small class="text-danger pl-3">', '</small>') ?>
                                <input type="password" placeholder="Ketikkan passwordnya disini" class="form-control mb-3" name="password" />

                                <label for="">Konfirmasi Password *</label>
                                <?= form_error('confPass', '<small class="text-danger pl-3">', '</small>') ?>
                                <input type="password" placeholder="Ketik ulang passwordnya" class="form-control mb-3" name="confPass" />
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <button class="btn btn-warning text-black btn-block">Tambah Induk</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>