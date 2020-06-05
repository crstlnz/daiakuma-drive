<div class="cover-container d-flex h-100 mx-auto flex-column">

    <header class="masthead mb-auto">

        <div class="inner">

            <h3 class="masthead-brand"><a href="/">Daiakuma Drive</a></h3>

            <nav class="nav nav-masthead justify-content-center">

                <a class="nav-link" href="<?= base_url();?>">Home</a>

                <a class="nav-link" href="<?= base_url('features');?>">Features</a>

                <a class="nav-link active" href="#">File Manager</a>

                <?php if($isAdmin){ ?>
                <a class="nav-link" href="<?= base_url('admin')?>">Admin</a>
                <?php } ?>

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

        <br>

        <!-- <br> -->



        <table id="filemanager" class="table table-dark table-sm filemanager">

            <thead>

                <tr>

                    <th scope="col"></th>

                    <th scope="col"><?= lang('tabelNama');?></th>

                    <!-- <th scope="col">Waktu Pembuatan</th> -->

                    <th scope="col"><?= lang('tabelUkuran');?></th>

                    <th scope="col"><?= lang('tabelAksi');?></th>

                </tr>

            </thead>

        </table>

        <div class="bottomNav">

            <button id="refresh-btn" class="btn btn-dark btn-kecil">Refresh</button>

            <span id="right" class="driveusage"><?= $limitString;?></span>

            <span id="kecilin">* <?=lang("filemanagerAlert");?></span>

        </div>

        <br>

    </main>



    <div class="toast">

        <div class="toast-body">

            <?= $this->session->flashdata("url");?><?= $this->session->flashdata("error");?>

        </div>

    </div>



    <div class="toast-js">

        <div class="toast-bodyJs">

        </div>

    </div>



    <!-- <footer class="mastfoot mt-auto">

        <div class="inner">

          <p>Daiakuma Drive powered by <a href="#">Segiempat PTK</a></p>

        </div>

      </footer>

    </div> -->