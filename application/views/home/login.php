<div class="cover-container d-flex h-100 mx-auto flex-column">

    <header class="masthead mb-auto">

        <div class="inner">

            <h3 class="masthead-brand"><a href="/">Daiakuma Drive</a></h3>

            <nav class="nav nav-masthead justify-content-center">

                <a class="nav-link active" href="#">Home</a>

                <a class="nav-link" href="<?= base_url('features');?>">Features</a>

                <a href="<?= $authUrl;?>" class="nav-link">Login</a>

            </nav>

        </div>

    </header>



    <main role="main" class="inner cover">

        <h1 class="cover-heading">Daiakuma.</h1>

        <p id="typewrite" class="lead typewrite"></p>

        <p class="lead">

            <a href="<?= $authUrl;?>">

                <img src="assets/img/google-button.png" alt="">

            </a>

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

        <!-- </div> -->

    </main>



    <div class="toast">

        <div class="toast-body">

            <?= form_error('url', '<div>', '</div>');?>
            <?= $this->session->flashdata("url");?>
            <?= $this->session->flashdata("error");?>

        </div>

    </div>







    <script src="assets/jquery.min.js"></script>

    <script>
    $.wait = function(callback, seconds) {

        return window.setTimeout(callback, seconds * 1000);

    }



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
    </script>

    <script src="https://unpkg.com/typewriter-effect@latest/dist/core.js"></script>

    <script>
    var app = document.getElementById('typewrite');



    var typewriter = new Typewriter(app, {

        loop: false,

        delay: 80

    });



    typewriter.typeString('<?=lang('homeMessage1');?>')
        .changeDelay(35)
        .pauseFor(1500)
        .typeString("<?=lang('homeMessage2');?>")
        .pauseFor(1500)
        .deleteAll(20)
        .changeDelay(18)
        .typeString('<?=lang('homeMessage3');?>')
        .pauseFor(2500)
        .deleteAll(12)
        .typeString('<?=lang('homeMessage4');?>')
        .pauseFor(2000)
        .deleteAll(20)
        .typeString('<?=lang('homeMessage5');?>')
        .pauseFor(2000)
        .deleteAll(16)
        .typeString('<?=lang('homeMessage6');?>')
        .pauseFor(1000)
        .typeString('<?=lang('homeMessage7');?>')
        .start();
    </script>









    <?php
            //   $this->session->set_flashdata("error","wew");

     if ($this->session->flashdata('error')) { ?>

    <script>
    $(document).ready(function() {

        $('.toast').toast({

            delay: 3000

        });

        $('.toast').toast('show');

    });
    </script>

    <?php }?>





    <!-- <footer class="mastfoot mt-auto">

        <div class="inner">

          <p>Daiakuma Drive powered by <a href="#">Segiempat PTK</a></p>

        </div>

      </footer>

    </div> -->