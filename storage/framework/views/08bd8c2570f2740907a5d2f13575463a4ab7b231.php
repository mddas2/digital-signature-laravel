<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title>DSC Enrollment</title>
    <style>
        @font-face {
            font-family: preeti;
            src: url('PREETI.ttf');
        }
    </style>
    <!-- Scripts -->
    <script src="<?php echo e(asset('js/app.js')); ?>" defer></script>	

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Styles -->
    <link href="<?php echo e(URL::asset('css/app.css')); ?>" rel="stylesheet">
    <script type="text/javascript">
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
</head>
<body>
    <div id="app">
       
        <main class="py-4">
            <?php echo $__env->yieldContent('content'); ?>
        </main>
    </div>
    <script src="<?php echo e(asset('js/wss_connection.js')); ?>"></script>
    <script src="<?php echo e(asset('js/sign_data.js')); ?>"></script>
    <?php echo $__env->yieldContent('js_scripts'); ?>;
</body>
</html>
<?php /**PATH C:\Users\md\Desktop\digital signture\dsc-demo1\resources\views/layouts/login.blade.php ENDPATH**/ ?>