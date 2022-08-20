<section class="home-slider ftco-degree-bg">
	<div 
	    class="slider-item bread-wrap" 
	    style="
	        background-image: url('images/bg_1.jpg'); 
	        min-height:100px; 
	        height:calc(10vh - 50px)" 
	    data-stellar-background-ratio="0.5">
	    
		<div class="overlay"></div>
		<!--<div class="container">
			<div class="row slider-text justify-content-center align-items-center">
				<div class="col-md-10 col-sm-12 ftco-animate mb-4 text-center">
					<p class="breadcrumbs">
						<span class="mr-2">
							<a href="<?= base_url('home') ?>">Home</a>
						</span>
						<span class="mr-2">
							<a>Sampah</a>
						</span>
						<span>List Sampah</span>
					</p>
					<h1 class="mb-3 bread">List Jenis Sampah</h1>
				</div>
			</div>
		</div>-->
	</div>
</section>


<section class="ftco-section contact-section ftco-degree-bg">
	<div class="container" style="padding: 0;">
		<form action="" method="get">
			<div class="row">
				<div class="col-md-6 ftco-animate">
					<input type="text" class="form-control" name="search" value="<?= $_GET ? $_GET['search'] : "" ?>" placeholder="Masukkan nama sampahnya..." />
				</div>
				<div class="col-md-4 ftco-animate">
					<select name="kategori" class="form-control">
						<option value="all">Semua</option>
						<?php foreach($listKategori as $k) : ?>
						<option value="<?= $k->_id ?>" <?= $_GET && $k->_id == $_GET['kategori'] ? "selected":"" ?>><?= $k->k_name ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="col-md-2 ftco-animate d-flex align-content-center">
					<button type="submit" class="btn btn-primary">Search</button>
				</div>
			</div>
		</form>
	</div>
</section>
<section class="ftco-section contact-section ftco-degree-bg">
	<div class="container" style="padding: 0;">
		<?php if(count($category) != 0) : ?>
			<?php foreach($category as $kategori) : ?>
				<div class="row justify-content-center mb-5">
					<div class="col-md-7 text-center heading-section ftco-animate">
						<span class="subheading">Kategori Sampah</span>
						<h2><?= $kategori->k_name ?></h2>
					</div>
				</div>
				<div class="row">
				<?php foreach($listSampah as $sampah) : ?>
					<?php if($kategori->_id == $sampah->fk_kategori) : ?>
					<div class="col-md-4 ftco-animate">
						<div class="blog-entry" data-aos-delay="100">
							<span class="block-20" style="background-image: url('<?= base_url($sampah->j_image) ?>');"></span>
							<div class="text p-4">
								<h3 class="heading">
									<p href="">
										Nama  : <?= $sampah->j_name ?><br/>
										Harga : <?= $sampah->j_price."/".$sampah->satuan ?>
									</p>
								</h3>
							</div>
						</div>
					</div>
					<?php endif; ?>
				<?php endforeach; ?>
				</div>
			<?php endforeach; ?>
		<?php else : ?>
		<h1 align="center">Tidak ditemukan hasilnya</h1>
		<?php endif; ?>
		</div>
</section>