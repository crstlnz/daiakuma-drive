<div class="cover-container d-flex h-100 mx-auto flex-column">
    <header class="masthead mb-auto">
        <div class="inner">
            <h3 class="masthead-brand">Daiakuma Drive</h3>
            <nav class="nav nav-masthead justify-content-center">
                <a class="nav-link active" href="<?= base_url();?>">Home</a>
                <a class="nav-link" href="<?= base_url('features');?>">Features</a>
                <a class="nav-link" href="<?= base_url('filemanager')?>">File Manager</a>
                <b class="username nav-link"><?php echo $username;?></b>
                <div class="nav-link dropdown">
                    <a class="imageDropdown dropdown-toggle" href="#" id="imageDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img class="userimage rounded-circle" src="<?php echo $picture;?>">
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="imageDropdown">
                            <a class="imageDropdownItem text-dark" href="?logout">Logout</a>
                        </div>
                    </a>
                </div>
            </nav>
        </div>
    </header>

    <main role="main" class="inner cover">
        <h3 class="cover-heading">Masukkan Urlnya kesini.</h3>
        <br>
        <!-- <div class="container"> -->
        <div class="row">
            <div class="col kiri">
                <div class="spoiler-btn">
                    Apa itu Daiakuma Drive?
                </div>
                <div class="spoiler">
                    <div class="isi">Daiakuma Drive adalah aplikasi yang memudahkan kita dalam mengatasi limit Google
                        Drive.</div>
                </div>
                <div class="spoiler-btn">
                    Apa dilakukan Daiakuma Drive?
                </div>
                <div class="spoiler">
                    <div class="isi">Daiakuma Drive akan mengakses layanan Google Drivemu untuk membuat salinan dari
                        file yang terlimit oleh Google agar bisa di download kembali.</div>
                </div>
                <div class="spoiler-btn">
                    Kenapa memakai Daiakuma Drive?
                </div>
                <div class="spoiler">
                    <div class="isi">
                        Link dari Google Drive biasanya akan memiliki limit, dengan Daiakuma Drive limit itu dapat
                        diatasi dengan mudah tanpa melakukan trik manual.
                    </div>
                </div>
                <div class="spoiler-btn">
                    Apakah layanan Daiakuma Drive gratis?
                </div>
                <div class="spoiler">
                    <div class="isi">
                        <b>Iya.</b> Layanan Daiakuma Drive sepenuhnya tidak dipungut biaya apapun. Kami mungkin hanya
                        akan memasang banner iklan di website kami.
                    </div>
                </div>
            </div>

            <div class="col kanan">
                <div class="spoiler-btn">
                    Apa saja yang bisa diupload?
                </div>
                <div class="spoiler">
                    <div class="isi">
                        Umumnya semua link Google Drive bisa kamu Upload, karena Daiakuma Drive hanya melakukan upload
                        ke Google Drivemu sendiri.
                    </div>
                </div>
                <div class="spoiler-btn">
                    Mengapa memerlukan akses Google Drive?
                </div>
                <div class="spoiler">
                    <div class="isi">
                        Karena untuk mengatasi limit dari Google Drive, kami membutuhkan akses dari Google Drive kamu
                        agar bisa mengatasi limit tersebut.
                    </div>
                </div>
                <div class="spoiler-btn">
                    Mengapa saya tidak bisa mengupload file?
                </div>
                <div class="spoiler">
                    <div class="isi">
                        Kemungkinan Google Drivemu sudah penuh atau file tidak ditemukan. Jika masih mengalami
                        kesulitan, silahkan hubungi admin@daiakuma.me
                    </div>
                </div>
                <div class="spoiler-btn">
                    Saya masi ingin bertanya, apa yang bisa saya hubungi?
                </div>
                <div class="spoiler">
                    <div class="isi">
                        Jika kamu memiliki pertanyaan, kritik, ataupun saran, kamu bisa menghubungi kami melalui email
                        admin@daiakuma.me
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div class="toast">
        <div class="toast-body">
            <?= form_error('url', '<div>', '</div>');?><?= $this->session->flashdata("url");?><?= $this->session->flashdata("error");
            $this->session->set_flashdata("error", null);?>
        </div>
    </div>

    <!-- <footer class="mastfoot mt-auto">
        <div class="inner">
          <p>Daiakuma Drive powered by <a href="#">Segiempat PTK</a></p>
        </div>
      </footer>
    </div> -->
    <script src="assets/jquery.min.js"></script>
    <?php if(!empty(form_error('url')))
    { ?>
    <script>
    $(document).ready(function() {
        $('.toast').toast({
            delay: 3000
        });
        $('.toast').toast('show');
    });
    </script>
    <?php } else if (!empty($this->session->flashdata('error'))) { ?>
    <script>
    $(document).ready(function() {
        $('.toast').toast({
            delay: 3000
        });
        $('.toast').toast('show');
    });
    </script>
    <?php } else if (!empty($this->session->flashdata('url'))) { ?>
    <script>
    $(document).ready(function() {
        $('.toast').toast({
            delay: 3000
        });
        $('.toast').toast('show');
    });
    </script>
    <?php } ?>