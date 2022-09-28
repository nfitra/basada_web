<?php
$fn = $this->router->fetch_method();
?>
<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar" style="z-index:10000">
	<div class="container">
		<a class="navbar-brand" href="<?= base_url('home/index') ?>">BASADA</a>
		<button
			class="navbar-toggler"
			type="button"
			data-toggle="collapse"
			data-target="#ftco-nav"
			aria-controls="ftco-nav"
			aria-expanded="false"
			aria-label="Toggle navigation"
		>
			<span class="oi oi-menu" title="icon name" aria-hidden="true"></span>Menu
		</button>
		<div class="collapse navbar-collapse" id="ftco-nav">
			<ul class="navbar-nav ml-auto">
				<li class="nav-item <?= ( $fn=="index"||$fn=="")?"active":"" ?>">
					<a href="<?= base_url('home/index') ?>" class="nav-link">Home</a>
				</li>
				<li class="nav-item <?= ( $fn=="artikel")?"active":"" ?>">
					<a href="<?= base_url('home/artikel') ?>" class="nav-link">Artikel</a>
				</li>
				<li class="nav-item <?= ( $fn=="tutorial")?"active":"" ?>">
					<a href="<?= base_url('home/tutorial') ?>" class="nav-link">Tutorial</a>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Sampah
                    </a>
					<div class="dropdown-menu" aria-labelledby="dropdown04">
						<a class="dropdown-item" href="<?= base_url('home/sampah') ?>">List Sampah</a>
						<a class="dropdown-item" href="<?= base_url('home/jadwal_sampah') ?>">Jadwal Pengangkutan Sampah</a>
					</div>
				</li>
				<li class="nav-item <?= ( $fn=="login")?"active":"" ?>">
					<a href="<?= base_url('auth') ?>" class="nav-link">Login</a>
				</li>
			</ul>
		</div>
	</div>
</nav>