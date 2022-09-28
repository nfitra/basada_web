<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="content bg-white p-3">
                <h1 class="h5 text-gray-600 mb-4">
                    <?= $title ?>
                </h1>
                <form action="" method="post">
                    <label for="">Hari</label>
                    <?= form_error('s_day', '<small class="text-danger pl-3">', '</small>') ?>
                    <?php $day = ['Senin', "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu"]; ?>
                    <select name="s_day" class="form-control mb-3">
                        <?php foreach ($day as $d) : ?>
                            <option value="<?= $d ?>"><?= $d ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label for="">Jam</label>
                    <?= form_error('s_time', '<small class="text-danger pl-3">', '</small>') ?>
                    <input required type="text" class="form-control mb-3" name="s_time" placeholder="ex : 07.00 - 09.00">
                    <label for="">Cuaca</label>
                    <?= form_error('s_weather', '<small class="text-danger pl-3">', '</small>') ?>
                    <input required type="text" class="form-control mb-3" name="s_weather" placeholder="ex : Mendung">
                    <label for="">Icon</label>
                    <?= form_error('s_weather_icon', '<small class="text-danger pl-3">', '</small>') ?>
                    <input required type="text" class="form-control mb-3" name="s_weather_icon" placeholder="ex : fa-sun">

                    <button type="submit" class="btn btn-sm btn-block btn-warning text-black">Tambah Jadwal</button>
                </form>
            </div>

        </div>
    </div>
</div>