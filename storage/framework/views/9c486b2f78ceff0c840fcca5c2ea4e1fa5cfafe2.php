<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title'); ?> - AdminPanel </title>
    <link rel="shortcut icon" href="<?php echo e(asset('assets/admin/media/favicons/favicon.png')); ?>">
    <link rel="icon" type="image/png" sizes="192x192"
        href="<?php echo e(asset('assets/admin/media/favicons/favicon-192x192.png')); ?>">
    <link rel="apple-touch-icon" sizes="180x180"
        href="<?php echo e(asset('assets/admin/media/favicons/apple-touch-icon-180x180.png')); ?>">
    <link rel="stylesheet" id="css-main" href=" <?php echo e(asset('assets/admin/css/oneui.min.css')); ?>">
    
    <?php echo notifyCss(); ?>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    
    <link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('new/jquery.dataTables.min.css')); ?>" />
    <link href='https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css' rel='stylesheet'
        type='text/css'>
    

    
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/admin/custome/custome.css')); ?>" />
    
    <?php echo $__env->yieldContent('styles'); ?>
</head>
<?php /**PATH D:\laravel_panel\resources\views/backend/theme/headerStyle.blade.php ENDPATH**/ ?>