<?php
?>

<head>
    <title>Daiakuma Drive | <?=$file->fileName?></title>
<script src="https://kit.fontawesome.com/4446a480a3.js" crossorigin="anonymous"></script>
</head>

<body class="text-center bg-dark">
<div class="cover-container d-flex h-100 mx-auto flex-column">

    <header class="masthead mb-auto">

        <div class="inner">

            <h3 class="masthead-brand"><a href="/">Daiakuma Drive</a></h3>

            <nav class="nav nav-masthead justify-content-center">

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

    <main role="main" class="inner cover">
        <div>
        <h3><b><?=$file->fileName?></b></h3>
            <div class="containerMaxWidth">
                <div class="downloadInfo">
                    <div class="kiri">
                        <span><?=lang('fileSize')?></span>
                        <span class="kanan"><?=$this->googlebase->getSize($file->size)?></span>
                    </div>

                    <div class="line"></div>

                    <div class="kiri">
                        <span><?=lang('fileType')?></span>
                        <span class="kanan"><?=$file->mimeType?></span>
                    </div>

                    <div class="line"></div>

                    <div class="kiri">
                        <span><?=lang('dateCreated')?></span>
                        <span class="kanan"><?=date("Y-m-d",strtotime($file->createdTime))?></span>
                    </div>      
                </div>
            </div> 
            <!-- end containerMaxWidth -->

            <form method="post">
                <input type="hidden" name="download" id="download" value='true'>
            <button class="downloadFileBtn btn btn-primary">Download<?php if(!isset($username)) : echo "<span id='cumatextlogin'> (Login)</span>"; endif;?> <div class="spinner"></div></button>
            </form>




            <div class="toast">
                <div class="toast-body">
                    <?php
                    if(isset($error)){
                        echo $error;
                    }
                    ?>
                </div>
            </div>

        </div>
    </main>

    <script src="assets/jquery.min.js"></script>

    <script>
        //  $('.spinner').css('display', 'inline-block');
    $('form').submit(function() {
        $('#cumatextlogin').css('display','none');
        $('.spinner').css('display', 'inline-block');
        $(this).find('button[type=submit]').prop('disabled', true);
    });

    <?php
    if(isset($error)) : ?>
        $(document).ready(function() {
            $('.toast').toast({
                delay: 5000
            });
            $('.toast').toast('show');
        });
    <?php endif;?>

    </script>

