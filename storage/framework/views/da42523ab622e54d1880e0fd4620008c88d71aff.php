<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <?php echo session('success'); ?>

    </div>
<?php endif; ?>


<?php if(session('fail')): ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
       <?php echo session('fail'); ?>

    </div>
<?php endif; ?>

<?php /**PATH C:\Users\md\Desktop\digital signture\dsc-demo1\resources\views/message/flash.blade.php ENDPATH**/ ?>