<footer class="mastfoot mt-auto">

    <div class="inner">

        <div class="lang">

            <?php if ($this->config->item('language') == "indonesian") : ?>

                <a>Indonesia</a>

                |

                <a href="?lang=en">English</a>

            <?php elseif ($this->config->item('language') == "english") : ?>

                <a>English</a>

                |

                <a href="?lang=id">Indonesian</a>

            <?php endif ?>



        </div>
        <a href="<?= base_url('terms'); ?>"><?= lang('terms'); ?></a>&nbsp;&nbsp;&nbsp;&nbsp;

        <a href="<?= base_url('privacy'); ?>"><?= lang('privacyPolicy'); ?></a>

        <p>Daiakuma Drive powered by <a href="#">Segiempat PTK</a></p>

    </div>
</footer>

</div>



<script src="assets/jquery.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jq-3.3.1/dt-1.10.18/b-1.5.6/sc-2.0.0/datatables.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.19/sorting/file-size.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>

<script src="vendor/bootstrap/js/bootstrap.min.js"></script>





<!-- The Modal -->

<div class="modal" id="alertdelete">

    <div class="modal-dialog">

        <div class="modal-content">



            <!-- Modal Header -->

            <div class="modal-header">

                <h4 class="modal-title"><?= lang('modalHapusTitle'); ?></h4>

                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>



            <!-- Modal body -->

            <div class="modal-body">

                <div class="namafile">



                </div>

                <?= lang('modalHapusTeks'); ?>

            </div>



            <!-- Modal footer -->

            <div class="modal-footer">

                <button type="button" class="hapus-btn btn btn-danger" data-dismiss="modal"><?= lang('hapusAction'); ?></button>

                <button type="button" class="btn btn-primary" data-dismiss="modal"><?= lang('tutupAction'); ?></button>

            </div>



        </div>

    </div>

</div>





<script>
    $(document).ready(function() {

        var table = $('.filemanager').DataTable({

            ajax: {

                url: '/filemanager/filedata',

                type: 'post',

                async: false,

                contentType: "application/json"

            },

            info: false,

            processing: true,

            language: {

                'loadingRecords': '<b class="loadtext">Loading...</b>',

                'processing': '<b class="loadtext">Loading...</b>',

                "zeroRecords": "No matching records found",

                "emptyTable": "No file..."

            },

            // bServerSide: true,

            scrollY: 340,

            scroller: true,

            columnDefs: [{

                    "targets": -1,

                    "data": null,

                    "orderable": false,

                    render: function(data, type, row)

                    {

                        return "<button class='delete-btn btn btn-kecil btn-danger btn-sm' data-toggle='modal' data-target='#alertdelete'><?= lang('hapusAction'); ?></button><a class='btn btn-sm btn-kecil btn-primary' target='_blank' href='https://drive.google.com/file/d/" +
                            data.id + "/view'><?= lang('bukaAction'); ?></a>";

                    },

                },

                {

                    type: 'file-size',

                    targets: -2

                }

                // "defaultContent": "<button class='delete-btn btn btn-danger btn-sm' data-toggle='modal' data-target='#alertdelete'>Hapus</button>"

            ],

            columns: [

                {
                    "data": "id"
                },

                {
                    "data": "name"
                },

                // { "data": "createdTime" },

                {
                    "data": "size"
                },

                {
                    "data": null
                }

            ]

        });





        $('#alertdelete').on('shown.bs.modal', function(element) {
            var data = table.row($(element.relatedTarget.parentNode).parents('tr')).data();

            $('.namafile').html(data['name']);

            var id = data['id'];

            $('.hapus-btn').off().on('click', function() {

                // table.clear().draw();
                // element.attr("disabled", true);
                $(element.relatedTarget).attr("disabled", true);

                $.post("https://drive.daiakuma.me/filemanager/delete", {
                    ids: id
                }, function(data) {

                    table.ajax.reload();

                    // table.row( row ).delete();

                    $.post("https://drive.daiakuma.me/filemanager/getlimit", function(
                        data) {

                        $(".bottomNav span").html(data);

                    });

                    $('.toast-body').html(data);

                    $('.toast').toast({

                        delay: 3000

                    });

                    $('.toast').toast('show');

                });

            });

        });



        $("#refresh-btn").on("click", function() {

            table.clear().draw();

            table.ajax.reload();

            $.post("https://drive.daiakuma.me/filemanager/getlimit", function(data) {

                $(".bottomNav span.driveusage").html(data);

            });

        });





        //   $('.hapus-btn').on('click', function(){

        //     $.post("https://drive.daiakuma.me/filemanager/delete", { ids: id }, function( data ) {

        //         table.ajax.reload();

        //         // table.row( row ).delete();

        //         alert(data);

        //     });

        //     // table.row( row ).remove();



        //       row=null;

        //       id=null;

        //   });



        //   $('#filemanager tbody').on( 'click', 'button', function () {

        //     var data = table.row( $(this).parents('tr') ).data();

        //     id =data['id'];

        //     table.row($(this).parents('tr') ).remove();

        //     row = this;

        //     });



    });
</script>

<?php if (!empty($this->session->flashdata('error'))) { ?>

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







<script>
    if (window.history.replaceState) {

        window.history.replaceState(null, null, window.location.href);

    }
</script>



</body>

</html>