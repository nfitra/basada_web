<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h1 class="h3 mb-4 mt-4 text-gray-800">
                <?= $title ?>
            </h1>
            <div class="row">
                <?php if($data->file_type=="picture"){ ?>
                <div class="col-md-4">
                    <div class="content bg-white p-3">
                        <h3 class="h5 text-gray-600">
                            Gambar
                        </h3>

                        <form action="<?= base_url('upload/change_file/pic/'.$data->_id) ?>" method="post" enctype="multipart/form-data">
                            <?= form_error('file_title','<small class="text-danger pl-3">','</small>') ?>
                            <input name="file_title" type="text" class="form-control mb-3" value="<?= $data->file_title ?>" required />
                            <?= form_error('picture','<small class="text-danger pl-3">','</small>') ?>
                            <input name="picture" id="img" type="file" class=" mb-3" required />
                            <br>
                            <button type='submit' class='btn btn-block btn-sm btn-warning text-black'>Ubah Gambar</button>
                        </form>
                    </div>
                </div>
                <?php } else { ?>
                <div class="col-md-4">
                    <div class="content bg-white p-3">
                        <h3 class="h5 text-gray-600">
                            Video
                        </h3>
                        <form action="<?= base_url('upload/change_file/vid/'.$data->_id) ?>" method="post" enctype="multipart/form-data">
                            <?= form_error('file_title','<small class="text-danger pl-3">','</small>') ?>
                            <input name="file_title" type="text" class="form-control mb-3" value="<?= $data->file_title ?>" required />
                            <?= form_error('video','<small class="text-danger pl-3">','</small>') ?>
                            <input name="video" id="vid" type="file" class=" mb-3" required />
                            <br>
                            <button type='submit' class='btn btn-block btn-sm btn-warning text-black'>Ubah Video</button>
                        </form>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>