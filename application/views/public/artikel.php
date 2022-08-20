<section class="home-slider ftco-degree-bg">
    <div class="slider-item bread-wrap" style="background-image: url('images/bg_1.jpg'); min-height:100px; height:calc(10vh - 50px)" data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <!--<div class="container">-->
        <!--    <div class="row slider-text justify-content-center align-items-center">-->
        <!--        <div class="col-md-10 col-sm-12 ftco-animate mb-4 text-center">-->
        <!--            <p class="breadcrumbs"><span class="mr-2"><a href="<?= base_url('home') ?>">Home</a></span> <span>Artikel</span></p>-->
        <!--            <h1 class="mb-3 bread">Bacalah Artikel Kami</h1>-->
        <!--        </div>-->
        <!--    </div>-->
        <!--</div>-->
    </div>
</section>

<section class="ftco-section ftco-degree-bg">
    <div class="container">
        <div class="row justify-content-center mb-5 pb-5">
            <div class="col-md-7 text-center heading-section ftco-animate">
                <span class="subheading">Artikel</span>
                <h2>Artikel Terbaru</h2>
            </div>
        </div>
        <div class="row">
            <?php $no=1; ?>
            <?php foreach($listArtikel as $artikel) : ?>
            <div class="col-md-4 ftco-animate">
                <div class="blog-entry">
                <?php if($artikel->a_file_type=="picture") : ?>
                <div class="block-20" style="background-image: url('<?= base_url(xss($artikel->a_file)) ?>'); height: 200px"></div>
                <?php else : ?>
                
                <div class="block-20" style="height: 200px">
                    <div class="d-flex justify-content-center align-items-center h-100">
                    <h1>Video</h1>
                    </div>
                </div>
                <?php endif; ?>
                    <div class="text p-4 d-block">
                        <div class="meta mb-3">
                            <h5><?= $artikel->a_title ?></h5>
                        </div>
                        <h6 class=""><a class="ellipsis"><span><?= strlen(strip_tags($artikel->a_content))<20 ? $artikel->a_content : (substr(strip_tags($artikel->a_content),0,100)." ...") ?><span></a></h6>
                        <a href="<?= base_url('home/detail_artikel/'.$artikel->_id) ?>" class="btn btn-info">Baca Lebih Lanjut</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="row mt-5">
            <div class="col text-center">
                <div class="block-27">
                    <?= $pagination ?>
                    <!-- <ul>
                    <li><a href="#">&lt;</a></li>
                    <li class="active"><span>1</span></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">4</a></li>
                    <li><a href="#">5</a></li>
                    <li><a href="#">&gt;</a></li>
                    </ul> -->
                </div>
            </div>
        </div>
    </div>
</section>