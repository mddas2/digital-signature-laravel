<?php $__env->startSection('content'); ?>
<div class="app-main__inner">
	<div class="row">
	    <div class="col-md-12">
            <?php echo $__env->make('message.flash', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	        <div class="main-card mb-3 card">
	            <div class="card-header">
	            	Upload File
	           </div>
	            <div class="card-body">
	            	<form action="<?php echo e(route('temp.upload')); ?>" method="POST" id="fundsTransfer" enctype="multipart/form-data">
                        <?php echo e(csrf_field()); ?>

                        <!-- <input name="signature" type="hidden" class="signedData"> -->
                        <div class="position-relative form-group">
                        	<label class="">Select File To Upload</label>
                        	<input type="file" id="document" name="file" class="btn btn-default btn-file"> 
                        	<!-- <input type="hidden" id="tempdoc" name="tempdoc">
                        	<input type="hidden" id="signeddoc" name="signature">
                        	<br>
                        	<button id="sign-doc" class="btn btn-info" type="button">Sign it</button>
                        	<span id="docinfo"></span> -->

                        </div>
                     	<button class="btn btn-primary" type="submit" id="formSigning">Upload File</button>
                        <a href="<?php echo e(route('restart-emsigner')); ?>" class="btn btn-success" target="_blank">Restart EmSigner</a>
                	</form>
	            </div>
	        </div>
	    </div>
	</div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\md\Desktop\digital signture\dsc-demo1\resources\views/pages/uploads/add.blade.php ENDPATH**/ ?>