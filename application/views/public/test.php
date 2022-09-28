<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title><?= $title ?></title>
		<link
			href="<?= base_url() ?>/assets/vendor/fontawesome-free/css/all.min.css"
			rel="stylesheet"
			type="text/css"
		/>
		<link
			href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
			rel="stylesheet"
		/>

		<!-- Custom styles for this template-->
		<link
			href="<?= base_url() ?>/assets/css/sb-admin-2.min.css"
			rel="stylesheet"
		/>
		<link href="<?= base_url() ?>/assets/css/public.css" rel="stylesheet" />

		<script src="<?= base_url() ?>/assets/vendor/jquery/jquery.min.js"></script>
	</head>
	<body id="page-top">
		<nav
			class="navbar navbar-expand-lg navbar-light bg-light fixed-top"
		>
			<div class="container">
				<a class="navbar-brand" href="#">
					<h1 style="margin: 0">BASADA</h1>
				</a>
				<button
					class="navbar-toggler"
					type="button"
					data-toggle="collapse"
					data-target="#navbarSupportedContent"
					aria-controls="navbarSupportedContent"
					aria-expanded="false"
					aria-label="Toggle navigation"
				>
					<span class="navbar-toggler-icon"></span>
				</button>

				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav ml-auto">
						<li class="nav-item active">
							<a class="nav-link" href="#"
								>Home <span class="sr-only">(current)</span></a
							>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#">Artikel</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#">Sampah</a>
						</li>
						<li class="nav-item dropdown">
							<a
								class="nav-link dropdown-toggle"
								href="#"
								id="navbarDropdown"
								role="button"
								data-toggle="dropdown"
								aria-haspopup="true"
								aria-expanded="false"
							>
								Login/Daftar
							</a>
							<div class="dropdown-menu" aria-labelledby="navbarDropdown">
								<a class="dropdown-item" href="<?= base_url('auth') ?>"
									>Login</a
								>
								<a class="dropdown-item" href="<?= base_url('auth') ?>"">Daftar</a>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</nav>
		<!-- Header -->
		<header id="hero">
			<div class="container d-flex h-100">
				<div class="row justify-content-center align-items-center">
					<div class="col-md-6">
						<h1>
							Ayo kita menabung sampah<br>di BASADA
                        </h1>
                        <a class="btn btn-info text-white mt-4">
                            <h4 style="margin: 0;">Buka Rekening</h4>
                        </a>
					</div>
					<div class="col-md-6">
						<img
							src="<?= base_url() ?>/assets/img/undraw_Throw_away_re_x60k.svg"
							alt=""
							class="img-fluid"
						/>
					</div>
				</div>
			</div>
		</header>
		<section class="bg-info">
            <div class="container text-center text-white">
                <h1 class="mb-5">Tutorial</h1>
                <iframe width="90%" height="530" src="https://www.youtube.com/embed/ApuDawJmYdw" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
        </section>
		<section class="bg-light">
            <div class="container">
                <div class="row">
					<div class="col-sm-6">
						<h1>Hello</h1>
						<p>
							Lorem ipsum, dolor sit amet consectetur adipisicing elit. At, dolor 
							cumque recusandae itaque a perferendis ullam dolores dolore fugiat 
							dignissimos iusto libero impedit asperiores rerum nulla voluptate 
							quaerat assumenda nobis!
						</p>
					</div>
					<div class="col-sm-6">
						<h1>Hello</h1>
						<p>
							Lorem, ipsum dolor sit amet consectetur adipisicing elit. Placeat
							neque mollitia recusandae cupiditate itaque, et eos accusamus odit
							architecto consequuntur eveniet repellat similique est nisi dolor
							beatae sint excepturi quia at suscipit enim saepe hic. Tenetur
							pariatur culpa ratione ullam reprehenderit. Odio cupiditate magnam
							iure accusamus, iste sapiente placeat, deserunt, accusantium eius
							odit molestiae debitis ipsa provident in at! Ratione mollitia
							ipsum quisquam optio porro molestias, aspernatur doloremque
							impedit rem, expedita vero nemo quo! Reprehenderit rerum sequi
							animi facilis aliquam! Quaerat, vitae reprehenderit. Autem, saepe
							reiciendis! Fugit ducimus assumenda voluptatem labore aperiam
							quisquam, ipsa, repellendus nisi, doloremque quibusdam officia
							qui.
						</p>
					</div>
				</div>  
            </div>
        </section>
		<footer class="bg-dark">
			<div class="container">
				<div
					class="row justify-content-center w-100 text-white"
				>
					<div class="col-md-4">
						<h3>Quick Link</h3>
						<hr>
						<ul class="footer-lists">
							<li><a href="#">Home</a></li>
							<li><a href="#">Artikel</a></li>
							<li><a href="#">Sampah</a></li>
							<li><a href="#">Tutorial</a></li>
						</ul>
					</div>
					<div class="col-md-4">
						<h3>Kontak Kami</h3>
						<hr>
						<p>Alamat: PCR</p>
						<p>No Handphone: 081234567890</p>
					</div>
					<div class="col-md-4">
						<h3>Social Media</h3>
						<hr>
						<p><a href="">IG</a></p>
						<p><a href="">WA</a></p>
					</div>
				</div>
			</div>
		</footer>
		<a
			class="scroll-to-top rounded js-scroll-trigger"
			href="#page-top"
			style="display: inline"
		>
			<i class="fas fa-angle-up"></i>
		</a>
	</body>
	<!-- Bootstrap core JavaScript-->
	<script src="<?= base_url() ?>/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

	<!-- Core plugin JavaScript-->
	<script src="<?= base_url() ?>/assets/vendor/jquery-easing/jquery.easing.min.js"></script>

	<script src="<?= base_url() ?>assets/vendor/datatables/jquery.dataTables.min.js"></script>
	<script src="<?= base_url() ?>assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>
	<script src="<?= base_url() ?>/assets/js/scriptAdmin.js"></script>
</html>
