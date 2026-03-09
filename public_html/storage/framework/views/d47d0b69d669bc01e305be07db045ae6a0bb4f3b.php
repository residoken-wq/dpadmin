<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">

    
    <title> <?php echo $__env->yieldContent('title','PHẦN MỀM QUẢN LÝ PHIẾU DỊCH '); ?>    </title>

    <!-- Icons -->
    
    <link href="/css/app.css" rel="stylesheet">
    <link href="/admin/admin/css/font-awesome.min.css" rel="stylesheet">
    
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.5.5/css/simple-line-icons.min.css"
          integrity="sha512-QKC1UZ/ZHNgFzVKSAhV5v5j73eeL9EEN289eKAEFaAjgAiobVAnVv/AGuPbXsKl1dNoel3kNr6PYnSiTzVVBCw=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <!-- Main styles for this application -->
    <link href="/admin/admin/css/style.css" rel="stylesheet">
    <link href="/admin/admin/css/index.css" rel="stylesheet">


</head>
<body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">

<?php echo $__env->make("admin.main.header", \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>


<div class="app-body">
    <!-- SIDE -->
    <?php echo $__env->make("admin.main.side", \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <!-- Main content -->

    <main class="main" style="margin-top: 0px">
        <?php echo $__env->yieldContent('content'); ?>

    </main>

</div>


<?php echo $__env->make("admin.main.footer", \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<style>
    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }
</style>
<script type="text/javascript">
    $(document).ready(function () {

        $(".main_picture").change(function (evt) {
            var files = evt.target.files;
            var th = $(this);
            var span = '';

            for (var i = 0, f; f = files[i]; i++) {

                // Only process image files.
                if (!f.type.match('image.*')) {
                    continue;
                }

                var reader = new FileReader();


                reader.onload = (function (theFile) {
                    return function (e) {


                        span = span + "<img class='thumb' src='" + e.target.result + "' />";
                        console.log(e.target.result);
                        $(th).parent().children('.view_picture').html(span);
                    };
                })(f);


                reader.readAsDataURL(f);
            }
        });
        formatMoney = function (tt, c, d, t) {
            var n = tt,
                c = isNaN(c = Math.abs(c)) ? 2 : c,
                d = d == undefined ? "." : d,
                t = t == undefined ? "," : t,
                s = n < 0 ? "-" : "",
                i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "",
                j = (j = i.length) > 3 ? j % 3 : 0;
            return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
        }
        if ($("input").hasClass("my_price")) {

            update_total_price();
            $(".my_price").on('change mouseup mousedown mouseout keydown keyup', function () {

                $(this).parent().next(".view_myprice").html(formatMoney($(this).val(), 0, ".", ","));
                update_total_price();
            });
            $(".vat_price").on('change mouseup mousedown mouseout keydown keyup', function (event) {
                if ($(this).val() > 99) {
                    event.preventDefault();
                    $(this).val(99);

                }
                update_total_price();

            });
            $(".total_price").css("pointer-events", 'none');

        }
        if ($("input").hasClass("my_price_1")) {

            update_total_price_1();
            $(".my_price_1").on('change mouseup mousedown mouseout keydown keyup', function () {

                $(this).parent().next(".view_myprice").html(formatMoney($(this).val(), 0, ".", ","));
                update_total_price_1();

            });
            $(".phidichthuat_1").on('change mouseup mousedown mouseout keydown keyup', function () {

                $(this).parent().next(".view_myprice").html(formatMoney($(this).val(), 0, ".", ","));


            });

            $(".vat_price_1").on('change mouseup mousedown mouseout keydown keyup', function (event) {
                if ($(this).val() > 99) {
                    event.preventDefault();
                    $(this).val(99);

                }
                update_total_price_1();

            });
            $(".total_price_1").css("pointer-events", 'none');


            $(".conglai_price").css("pointer-events", 'none');


            if (parseInt($('.tamung_price').val()) > parseInt($('.total_price').val())) {
                $('.tamung_price').val($(".total_price").val());
            }
            $('.tamung_price').parent().next(".view_myprice").html(formatMoney($(".tamung_price").val(), 0, ".", ","));
            $(".conglai_price").val(parseInt($('.total_price').val()) - $('.tamung_price').val());

            $(".tamung_price").on('change mouseup mousedown mouseout keydown keyup', function () {

                if (parseInt($(this).val()) > parseInt($('.total_price').val())) {
                    $(this).val($(".total_price").val());
                }
                $(this).parent().next(".view_myprice").html(formatMoney($(this).val(), 0, ".", ","));
                $(".conglai_price").val(parseInt($('.total_price').val()) - $(this).val());

            });
        } else {
            $(".total_price_1").css("pointer-events", 'none');
            $(".total_price_1").parent().next(".view_myprice").html(formatMoney($(".total_price_1").val(), 0, ".", ","));
        }
    })

    function update_total_price() {
        var total = 0;
        $(".my_price").each(function () {
            if (parseInt($(this).val()) > 0) {
                total = total + parseInt($(this).val());
            }
        });


        if (parseInt($('.vat_price').val()) > 0 && total > 0) {
            total = Math.floor(total + total * (parseInt($('.vat_price').val()) / 100));
        }

        $(".total_price").val(total);
        $(".total_price").parent().next(".view_myprice").html(formatMoney(total, 0, ".", ","));
    }

    function update_total_price_1() {
        var total = 0;
        $(".my_price_1").each(function () {
            if (parseInt($(this).val()) > 0) {
                total = total + parseInt($(this).val());
            }
        });


        if (parseInt($('.vat_price_1').val()) > 0 && total > 0) {
            total = Math.floor(total + total * (parseInt($('.vat_price_1').val()) / 100));
        }

        $(".total_price_1").val(total);
        $(".total_price_1").parent().next(".view_myprice").html(formatMoney(total, 0, ".", ","));
    }
</script>

</body>

</html>
