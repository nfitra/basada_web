<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="content bg-white p-3">
                <!-- Page Heading -->
                <h1 class="h3 mb-4 text-gray-800">
                    <?= $title ?>
                </h1>
                <?php 
                    $message = $this->session->flashdata('message'); 
                    if(isset($message)) {
                        echo $message;
                    }
                ?>
                <form action="" method="POST">
                    <?php if(form_error('u_name') !== "" )  : ?>
                        <div class="alert alert-danger">
                            Ubah Data Gagal !
                        </div>
                    <?php endif; ?>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <div class="border p-3 rounded">
                                <h3 class="h5 mb-4 text-gray-800">
                                    Data Diri
                                </h3>
                                <label for="">Nama Lengkap * </label>
                                <input type="text" placeholder="ex: Your Name" value="<?= $user->u_name ?>" class="form-control mb-3" name="u_name" />
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <button class="btn btn-warning text-black btn-block">Ubah Data Diri</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-6">
            <div class="content bg-white p-3">
                <form action="<?= base_url('profile/update_auth/').$user->_id ?>" method="post">
                    <?php if(form_error('password') !== "") : ?>
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
                                    if(isset($message)) {
                                        echo $message;
                                    }
                                ?>
                                <label for="">Email *</label> 
                                <input type="email" placeholder="ex: your@email.com" class="form-control mb-3" name="email" value="<?= $user->fk_auth ?>" disabled />
                                
                                <label for="">Password *</label>
                                <?= form_error('password','<small class="text-danger pl-3">','</small>') ?>
                                <input type="password" placeholder="Ketikkan passwordnya disini" class="form-control mb-3" name="password" />

                                <label for="">Konfirmasi Password *</label>
                                <?= form_error('confPass','<small class="text-danger pl-3">','</small>') ?>
                                <input type="password" placeholder="Ketik ulang passwordnya" class="form-control mb-3" name="confPass" />
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <button class="btn btn-outline-warning text-blacks btn-block">Ubah Password</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>