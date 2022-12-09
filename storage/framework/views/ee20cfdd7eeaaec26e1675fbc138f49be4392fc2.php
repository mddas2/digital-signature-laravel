<?php $__env->startSection('content'); ?>
<div class="app-main__inner">
	<div class="row">
	    <div class="col-md-12">
	        <div class="main-card mb-3 card">
	            <div class="card-header">Account Summary</div>
	            <div class="card-body">
	            	<h5 class="card-title">List Of Transactions</h5>
                    <table class="mb-0 table table-bordered table-hover">
                        <thead>
	                        <tr>
	                            <th>Date</th>
	                            <th>Payee</th>
	                            <th>Transferred To</th>
	                         	<th>Account Number</th>
	                            <th>Remarks</th>
	                            <th>Action</th>
	                        </tr>
                        </thead>
                        <tbody>
                        	<?php $__currentLoopData = $funds_transfered; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $funds): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		                    <tr>
		                        <td><?php echo e($funds->created_at); ?></td>
		                        <td><?php echo e($payee_list[$funds->payee_id]); ?></td>
		                        <td><?php echo e($funds->name); ?></td>
		                        <td><?php echo e($funds->account_no); ?></td>
		                        <td><?php echo e($funds->remarks); ?></td>
		                        <td><a href="<?php echo e(route('account_details',$funds->id)); ?>" class="btn btn-default">View</td>
		                    </tr>
		                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
	        </div>
	    </div>
	</div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\md\Desktop\digital signture\dsc-demo1\resources\views/pages/accounts/account_summary.blade.php ENDPATH**/ ?>