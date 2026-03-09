<?php $__env->startSection('content'); ?>

    <ol class="breadcrumb">
        <li class="breadcrumb-item"> Trang chủ</li>
        <li class="breadcrumb-item"><a href="">ONDDRIVE </a>
        </li>
    </ol>

    <div class="row container-fluid">
        <div class="col-xs-12 col-sm-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <?php if(Session::has('errorDetail')): ?>
                                <div class="alert alert-warning">
                                    <?php echo e(Session::get('errorDetail')); ?>

                                </div>
                            <?php endif; ?>
                            <p>Vui lòng đăng nhập ONEDRIVE để xử lý các file biên dịch. </p>
                            <a href="<?php echo e($url); ?>" class="btn btn-primary" data-dismiss="modal">ĐĂNG NHẬP ONEDRIVE </a>
                        </div>
                    </div>

                </div>
            </div>


        </div>


    </div>


    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection("script_js"); ?>
    <script type="text/javascript">

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make("admin.admin", \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>