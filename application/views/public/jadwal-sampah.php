<section class="home-slider ftco-degree-bg">
	<div class="slider-item bread-wrap" style="
	        background-image: url('images/bg_1.jpg'); 
	        min-height:100px; 
	        height:calc(10vh - 50px)" data-stellar-background-ratio="0.5">
		<div class="overlay"></div>
		<div class="container">
			<div class="row slider-text justify-content-center align-items-center">
				<div class="col-md-10 col-sm-12 ftco-animate mb-4 text-center">
					<p class="breadcrumbs">
						<span class="mr-2">
							<a href="<?= base_url('home') ?>">Home</a>
						</span>
						<span class="mr-2">
							<a>Sampah</a>
						</span>
						<span>Jadwal</span>
					</p>
					<h1 class="mb-3 bread">Jadwal Pengangkutan Sampah</h1>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="ftco-section ftco-degree-bg">
	<div class="container">
		<div class="row justify-content-center mb-5 pb-5">
			<div class="col-md-10 text-center heading-section ftco-animate">
				<span class="subheading">Peta</span>
				<h2>Peta Lokasi Bank Sampah Induk dan Unit</h2>
			</div>
		</div>
		<div class="row">
			<div class="col">
				<div id="map" style="height: 700px"></div>
			</div>
		</div>
	</div>
</section>

<section class="ftco-section contact-section ftco-degree-bg">
	<div class="container" style="padding: 0;">
		<div class="row justify-content-center mb-5 pb-5">
			<div class="col-md-7 text-center heading-section ftco-animate">
				<span class="subheading">Jadwal</span>
				<h2>Jadwal Pengangkutan Sampah</h2>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="content bg-white">
					<table id="table-jadwal-sampah" class="table table-hover table-bordered">
						<thead>
							<tr>
								<th>No</th>
								<th>Hari</th>
								<th>Jam</th>
								<th>Cuaca</th>
							</tr>
						</thead>
						<tbody>
							<?php $no = 1; ?>
							<?php foreach ($listSampah as $sampah) : ?>
								<tr>
									<td class="pl-4">
										<h6><?= $no++ ?></h6>
									</td>
									<td>
										<h6><?= xss($sampah->s_day) ?></h6>
									</td>
									<td>
										<h6><?= xss($sampah->s_time) ?></h6>
									</td>
									<td>
										<h6><?= xss($sampah->s_weather) ?></h6>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>

<script src="<?= base_url('assets/js/map.js') ?>"></script>