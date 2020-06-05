<div class="cover-container d-flex h-100 mx-auto flex-column">
    <!-- <?=  $this->encryption->decrypt($this->input->cookie('token', false));?> -->
    <header class="masthead mb-auto">

        <div class="inner">

        <h3 class="masthead-brand"><a href="/">Daiakuma Drive</a></h3>
 
            <nav class="nav nav-masthead justify-content-center">

                <a class="nav-link active" href="<?= base_url();?>">Home</a>

                <a class="nav-link" href="<?= base_url('features');?>">Features</a>

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

            </nav>

        </div>

    </header>



    <main role="main" class="inner cover">

        <h3 class="cover-heading"><?= lang('uploadTitle');?></h3>

        <p class="lead">

            <form method="post" action="<?= base_url();?>">

                <p class="lead">

                    <input value="<?= set_value('url');?>" autocomplete="off" type="text" name="url" id="url"
                        class="form-control"
                        placeholder="https://drive.google.com/file/d/1goSrBfezdD0uyzK-qyh0zplQLBG3FSOk/view">

                </p>

                <p class="lead">

                    <button id="btn-upload" type="submit" class="btn btn-primary"><span class="uploadText">Upload</span>
                        <div class="spinner"></div>
                    </button>

                </p>

                <?= $this->session->flashdata("link");?>

                <!-- <div class='filelink'><span class='filename'>".$namaFidawdaefaefekafkokfaekfoakoakwfokawflkalfmklaekflaekfglaekgleakgleakgleakgleakvelakgleakglaekgleakglaekglaekglaegkleakgleakles."</span><a class='urlfiles' href='".$downloadUrl."'>Download</a></a></div> -->

            </form>

        </p>





        <br>

        <!-- <div class="container"> -->

        <div class="row">

            <div class="col kiri">

                <div class="spoiler-btn">

                    <?= lang('faqTitle1');?>

                </div>

                <div class="spoiler">

                    <div class="isi">

                        <?= lang('faqCon1');?>

                    </div>

                </div>

                <div class="spoiler-btn">

                    <?= lang('faqTitle2');?>

                </div>

                <div class="spoiler">

                    <div class="isi">

                        <?= lang('faqCon2');?>

                    </div>

                </div>

                <div class="spoiler-btn">

                    <?= lang('faqTitle3');?>

                </div>

                <div class="spoiler">

                    <div class="isi">

                        <?= lang('faqCon3');?>

                    </div>

                </div>

                <div class="spoiler-btn">

                    <?= lang('faqTitle4');?>

                </div>

                <div class="spoiler">

                    <div class="isi">

                        <?= lang('faqCon4');?>

                    </div>

                </div>

            </div>



            <div class="col kanan">

                <div class="spoiler-btn">

                    <?= lang('faqTitle5');?>

                </div>

                <div class="spoiler">

                    <div class="isi">

                        <?= lang('faqCon5');?>

                    </div>

                </div>

                <div class="spoiler-btn">

                    <?= lang('faqTitle6');?>

                </div>

                <div class="spoiler">

                    <div class="isi">

                        <?= lang('faqCon6');?>

                    </div>

                </div>

                <div class="spoiler-btn">

                    <?= lang('faqTitle7');?>

                </div>

                <div class="spoiler">

                    <div class="isi">

                        <?= lang('faqCon7');?>

                    </div>

                </div>

                <div class="spoiler-btn">

                    <?= lang('faqTitle8');?>

                </div>

                <div class="spoiler">

                    <div class="isi">

                        <?= lang('faqCon8');?>

                    </div>

                </div>

            </div>

        </div>





    </main>



    <div class="toast">

        <div class="toast-body">

            <?= form_error('url', '<div>', '</div>');?><?= $this->session->flashdata("url");?><?= $this->session->flashdata("error");?>

        </div>

    </div>



    <!-- <footer class="mastfoot mt-auto">

        <div class="inner">

          <p>Daiakuma Drive powered by <a href="#">Segiempat PTK</a></p>

        </div>

      </footer>

    </div> -->

    <script src="assets/jquery.min.js"></script>



    <script>
    $(document).ready(function() {

        // $('#btn-upload').on('click', function(){

        //     $(this).attr("disabled", true);

        // })



        $('form').submit(function() {

            $('.spinner').css('display', 'inline-block');

            $(this).find('button[type=submit]').prop('disabled', true);

        });







        function borderRadius(element) {

            $(element).css("border-radius", "5px 5px 5px 5px");

        };

        var prevClicked = [];

        $('.spoiler-btn').on('click', function() {

            // $('.spoiler').each(function(){

            //     if ($(this).attr('class')=="spoiler") {

            //         window.setTimeout( borderRadius.bind(null,this.prev()) , 500 );

            //         // $(".spoiler-btn").css("border-radius","5px 5px 5px 5px");

            //         // $.wait( function(){ $(".spoiler-btn").css("border-radius","5px 5px 5px 5px")}, 0.5);

            //         $(this).removeClass("open");

            //     }

            // });



            if ($(this).parent().attr('class') == 'col kiri') {

                val = 'kiri';

            } else { //col kanan

                val = 'kanan';

            }

            if (prevClicked[val] != null && prevClicked[val] != this) {

                window.setTimeout(borderRadius.bind(null, prevClicked), 500);

                // $(".spoiler-btn").css("border-radius","5px 5px 5px 5px");

                // $.wait( function(){ $(".spoiler-btn").css("border-radius","5px 5px 5px 5px")}, 0.5);

                $(prevClicked[val]).next().removeClass("open");

                $(prevClicked[val]).next().animate({

                    height: 0

                });

            }



            if ($(this).next().attr('class') == "spoiler") {

                prevClicked[val] = this;

                $(this).css("border-radius", "5px 5px 0 0");

                $(this).next().addClass("open");

                $(this).next().animate({

                    height: $(this).next().get(0).scrollHeight

                });

            } else {

                prevClicked[val] = null;

                window.setTimeout(borderRadius.bind(null, this), 500);

                // $(".spoiler-btn").css("border-radius","5px 5px 5px 5px");

                // $.wait( function(){ $(".spoiler-btn").css("border-radius","5px 5px 5px 5px")}, 0.5);

                $(this).next().removeClass("open");

                $(this).next().animate({

                    height: 0

                });

            }





        });

    })
    </script>



    <?php if(form_error('url'))

    { ?>

    <script>
    $(document).ready(function() {

        $('.toast').toast({

            delay: 3000

        });

        $('.toast').toast('show');

    });
    </script>

    <?php } else if ($this->session->flashdata('error')) { ?>

    <script>
    $(document).ready(function() {
        // console.log("wew")
        $('.toast').toast({

            delay: 3000

        });

        $('.toast').toast('show');

    });
    </script>

    <?php } else if ($this->session->flashdata('url')) { ?>

    <script>
    $(document).ready(function() {

        $('.toast').toast({

            delay: 3000

        });

        $('.toast').toast('show');

    });
    </script>

    <?php } ?>