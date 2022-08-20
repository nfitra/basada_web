<section class="home-slider ftco-degree-bg">
	<div
		class="slider-item bread-wrap"
		style="background-image: url('images/bg_1.jpg')"
		data-stellar-background-ratio="0.5"
	>
		<div class="overlay"></div>
		<div class="container">
			<div class="row slider-text justify-content-center align-items-center">
				<div class="col-md-10 col-sm-12 ftco-animate mb-4 text-center">
					<p class="breadcrumbs">
						<span class="mr-2"><a href="index.html">Home</a></span>
						<span>Rekening</span>
					</p>
					<h1 class="mb-3 bread">Buka Rekening</h1>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="ftco-section contact-section ftco-degree-bg">
	<div class="container bg-light">
		<div class="row d-flex mb-5 contact-info">
			<div class="col-md-12 mb-4">
				<h2 class="h4">Info Kontak</h2>
			</div>
			<div class="w-100"></div>
			<div class="col-md-3">
				<p>
					<span>Alamat:</span> Jl. Umban Sari (Patin) No. 1 Rumbai, Pekanbaru-Riau 28265
				</p>
			</div>
			<div class="col-md-3">
				<p><span>Phone:</span> <a href="tel://1234567920">(0761) - 53939</a></p>
			</div>
			<div class="col-md-3">
				<p>
					<span>Email:</span>
					<a href="mailto:info@yoursite.com">info@yoursite.com</a>
				</p>
			</div>
			<div class="col-md-3">
				<p><span>Website</span> <a href="#">yoursite.com</a></p>
			</div>
		</div>
		<div class="row block-9">
			<div class="col">
				<form action="" method="post">
					<?= form_error('email','<small class="text-danger pl-3">','</small>') ?>
					<div class="form-group">
						<input type="email" class="form-control" name="email" placeholder="Email Anda" />
					</div>
					<?= form_error('password','<small class="text-danger pl-3">','</small>') ?>
					<div class="form-group">
						<input type="password" class="form-control" name="password" placeholder="Password Anda" />
					</div>
					<?= form_error('n_name','<small class="text-danger pl-3">','</small>') ?>
					<div class="form-group">
						<input type="text" class="form-control" name="n_name" placeholder="Nama Lengkap" />
					</div>
					<?= form_error('n_address','<small class="text-danger pl-3">','</small>') ?>
					<div class="form-group">
						<textarea
							name="n_address"
							cols="30"
							rows="4"
							class="form-control"
							placeholder="Alamat Anda"
						></textarea>
					</div>
					<div class="form-row">
						<div class="col">
							<?= form_error('n_city','<small class="text-danger pl-3">','</small>') ?>
							<div class="form-group">
								<input type="text" class="form-control" name="n_city" placeholder="Kota Anda" />
							</div>
						</div>
						<div class="col">
							<?= form_error('n_province','<small class="text-danger pl-3">','</small>') ?>
							<div class="form-group">
								<input type="text" class="form-control" name="n_province" placeholder="Provinsi Anda" />
							</div>
						</div>
					</div>
					<div class="form-row">
						<div class="col">
							<?= form_error('n_postcode','<small class="text-danger pl-3">','</small>') ?>
							<div class="form-group">
								<input type="text" class="form-control" name="n_postcode" placeholder="Kode Pos Anda" />
							</div>
						</div>
						<div class="col">
							<?= form_error('n_contact','<small class="text-danger pl-3">','</small>') ?>
							<div class="form-group">
								<input type="text" class="form-control" name="n_contact" placeholder="Nomor Handphone" />
							</div>
						</div>
					</div>
					
					
					
					
					<div class="form-group">
						<input
							type="submit"
							value="Buat Rekening"
							class="btn btn-primary py-3 px-5 mt-4"
						/>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
