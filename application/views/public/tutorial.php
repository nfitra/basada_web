<section class="home-slider ftco-degree-bg">
	<div 
	    class="slider-item bread-wrap" 
	    style="
	        background-image: url('images/bg_1.jpg'); 
	        min-height:100px; 
	        height:calc(10vh - 50px)" 
	    data-stellar-background-ratio="0.5"
    >
		<div class="overlay"></div>
		<div class="container">
			<div class="row slider-text justify-content-center align-items-center">
				<div class="col-md-10 col-sm-12 ftco-animate mb-4 text-center">
					<p class="breadcrumbs">
						<span class="mr-2"><a href="index.html">Home</a></span>
						<span>Tutorial</span>
					</p>
					<h1 class="mb-3 bread">Tutorial</h1>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="ftco-section contact-section ftco-degree-bg">
	<?php $no = 1 ?>
	<?php foreach($listTutorial as $tutorial) : ?>
	<div class="container bg-light">
		
		<?= $no++ > 1 ? "<hr style='height:5px; background: #ddd;'>" : "" ?>
		<div class="row justify-content-center mb-5 pb-5">
			<div class="col-md-7 text-center heading-section ftco-animate">
				<span class="subheading">Tutorial</span>
				<h2><?= $tutorial->file_title ?></h2>
			</div>
		</div>
		<div class="row">
			<div class="col text-center">
				<?php if($tutorial->file_type == "picture") : ?>
				<img src="<?= base_url($tutorial->file_name) ?>" alt="<?= $tutorial->file_name ?>" class="img-fluid">
				<?php else : ?>
				<video height="550" width="100%" controls>
					<source src="<?= base_url($tutorial->file_name) ?>">
					Your browser does not support the video tag.
				</video>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<?php endforeach; ?>
</section>
