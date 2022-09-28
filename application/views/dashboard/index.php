<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md">
            <div class="card bg-success text-white h-100 overflow-hidden">
                <div class="card-body bg-danger">
                    <div class="rotate">
                        <i class="fa fa-user fa-8x"></i>
                    </div>
                    <h6 class="text-uppercase">Total Nasabah</h6>
                    <h1 class="display-4"><?= $nasabah ?></h1>
                </div>
            </div>
        </div>
        <div class="col-md">
            <div class="card bg-success text-white h-100 overflow-hidden">
                <div class="card-body bg-primary">
                    <div class="rotate">
                        <i class="fa fa-people-carry fa-7x"></i>
                    </div>
                    <h6 class="text-uppercase">Total Unit</h6>
                    <h1 class="display-4"><?= $unit ?></h1>
                </div>
            </div>
        </div>
        <div class="col-md">
            <div class="card bg-success text-white h-100 overflow-hidden">
                <div class="card-body bg-success">
                    <div class="rotate">
                        <i class="fa fa-dollar-sign fa-8x"></i>
                    </div>
                    <h6 class="text-uppercase">Total Omset</h6>
                    <h1 class="display-4"><?= $omset ?></h1>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->