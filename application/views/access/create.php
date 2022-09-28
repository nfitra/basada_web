<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="content bg-white p-3">
                <h3 class="h5 text-gray-600 mb-4">
                    Tambah Role Access
                </h3>

                <?php if( form_error('role') !== "" || 
                    form_error('access') !== "") : ?>
                    <div class="alert alert-danger">
                        Tambah Data Gagal !
                    </div>
                <?php endif; ?>
                
                <form action="" method="post">
                    <label for="">Nama Role</label>

                    <?= form_error('role','<small class="text-warning text-black pl-3">','</small>') ?>
                    <select class="form-control mb-3" name="role" id="role">
                        <option value="">----- Pilih Role -----</option>
                        <?php foreach($roles as $role) : ?>
                            <option value="<?= $role->_id ?>"><?= $role->r_name ?></option>
                        <?php endforeach;    ?>
                    </select>

                    <label for="">Access Sub Menu</label>

                    <?= form_error('access','<small class="text-warning text-black pl-3">','</small>') ?>
                    <select name="access" id="access" class="form-control mb-3" disabled>
                        <option value="">----- Pilih Role Terlebih Dahulu -----</option>
                    </select>

                    <button class="btn btn-sm btn-warning text-black btn-block">
                        Tambah Access
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(()=>{
        $("#role").on("change",async (e)=>{
            const id = e.target.value;
            const url = "<?= base_url('access/get_json_sub_menu_byRole/') ?>"+id
            const dataSubMenu = await get_data(url);

            add_to_select(dataSubMenu);
        })
    })

    const add_to_select=(dataSubMenu)=>{
        $("#access").html("");
        $("#access").attr("disabled",false);
        if(dataSubMenu.length > 0){

            $("#access").append(`<option value="">----- Pilih Sub Menu -----</option>`);

            dataSubMenu.map((menu)=>{
                const option = `<option value="${menu._id}">${menu.sm_title}</option>`
                $("#access").append(option);
            })    
        } else {
            const option = `<option value="">Seluruh Izin Akses telah Digunakan</option>`
            $("#access").append(option);
        }
        
    }

    const get_data=(url)=>{
        return new Promise((resolve,reject)=>{
            try{
                $.ajax({
                    url,
                    success:(res)=>{
                        console.log(res)
                        resolve(JSON.parse(res))
                    }
                })
            } catch(err){
                console.log(err)
            }
        })
    }
</script>