<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h1 class="h3 mb-4 mt-4 text-gray-800">
                <?= $title ?>
            </h1>
            <div class="row">
                <div class="col-md-4">
                    <div class="content bg-white p-3">
                        <h3 class="h5 text-gray-600">
                            Gambar
                        </h3>

                        <form action="<?= base_url('upload/add_file/pic') ?>" method="post" enctype="multipart/form-data">
                            <fieldset>
                                <?= form_error('file_title', '<small class="text-danger pl-3">', '</small>') ?>
                                <br>
                                <input name="file_title" type="text" class="form-control mb-3" />
                                <?= form_error('picture', '<small class="text-danger pl-3">', '</small>') ?>
                                <input name="picture" id="img" type="file" class=" mb-3" />
                                <br>
                                <button type='submit' class='btn btn-block btn-sm btn-warning text-black'>Tambah Gambar</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="content bg-white p-3">
                        <h3 class="h5 text-gray-600">
                            Video
                        </h3>

                        <form action="<?= base_url('upload/add_file/vid') ?>" method="post" enctype="multipart/form-data">
                            <fieldset>
                                <?= form_error('file_title', '<small class="text-danger pl-3">', '</small>') ?>
                                <br>
                                <input name="file_title" type="text" class="form-control mb-3" required />
                                <?= form_error('video', '<small class="text-danger pl-3">', '</small>') ?>
                                <input name="video" id="vid" type="file" class=" mb-3" required />
                                <br>
                                <button type='submit' class='btn btn-block btn-sm btn-warning text-black'>Tambah Video</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>