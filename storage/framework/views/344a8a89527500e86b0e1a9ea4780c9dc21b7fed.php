<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Analytics Dashboard - This is an example dashboard created using build-in elements and components.</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="This is an example dashboard created using build-in elements and components.">
    <meta name="msapplication-tap-highlight" content="no">
	<link href="<?php echo e(asset('css/main.css')); ?>" rel="stylesheet"></head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript">
        var uniqueId = "<?php echo Auth::user()->unique_id; ?>";
        var channelId = "<?php echo env('CHANNEL_ID'); ?>";
        var gemRandomNoUrl = "<?php echo URL::to("user/generateRandomNo");?>";
        $(document).ready(function(){
             $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
           
            startConnection();
        });
    </script>
<body>
	<div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header"><?php /**PATH C:\Users\md\Desktop\digital signture\dsc-demo1\resources\views/layouts/head.blade.php ENDPATH**/ ?>