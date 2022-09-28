<body class="bg-gradient-success">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-6 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-md-12 pt-3 pb-3 pl-5 pr-5">
                <h2 class="text-title text-center text-gray-900">Selamat Datang</h2>
                <hr class="mb-4">
                
                <form class="user" action="" method="POST">
                  <?php 
                    $message = $this->session->flashdata('message'); 
                    if(isset($message)) {
                      echo $message;
                    }
                  ?>
                  
                  <?= form_error('email','<small class="text-danger pl-3">','</small>') ?>
                  <input type="email" required autofocus class="form-control form-control-user mb-3" placeholder="Masukkan email kamu disini" id="email" value="<?= set_value('email') ?>" name="email">
                  <?= form_error('password','<small class="text-danger pl-3">','</small>') ?>
                  <input type="password" required class="form-control form-control-user mb-1" id="password" placeholder="Password kamu disini" name="password">
                  <a href="#" class="small p-3">Lupa password ?</a>
                  <button class="mt-3 btn btn-warning text-black btn-user btn-block mb-3">Login</button>
                </form>
                
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>