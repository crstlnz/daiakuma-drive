<div class="cover-container d-flex h-100 mx-auto flex-column">

    <header class="masthead mb-auto">

        <div class="inner">

            <h3 class="masthead-brand"><a href="/">Daiakuma Drive</a></h3> 

            <nav class="nav nav-masthead justify-content-center">

                <a class="nav-link" href="<?= base_url();?>">Home</a>

                <a class="nav-link" href="<?= base_url('features');?>">Features</a>

                <?php if(isset($username)) : ?>

                <a class="nav-link" href="<?= base_url('filemanager')?>">File Manager</a>

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

                <?php else : ?>

                <a href="<?= $authUrl;?>" class="nav-link">Login</a>

                <?php endif ?>

            </nav>

        </div>

    </header>



    <div class="policy">

        <?= lang('policy_text');?>

    </div>



    <!-- <footer class="mastfoot mt-auto">

        <div class="inner">

          <p>Daiakuma Drive powered by <a href="#">Segiempat PTK</a></p>

        </div>

      </footer>

    </div> -->