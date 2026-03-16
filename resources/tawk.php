<?php if (config('services.tawk.site-id')) { ?>
<script type="text/javascript">
            var Tawk_API=Tawk_API || {};
            var Tawk_LoadStart=new Date();

            <?php if (auth()->check()) { ?>
            Tawk_API.visitor = {
                name  : '<?php echo e(auth()->user()->name) ?>',
                email : '<?php echo e(auth()->user()->email) ?>',
                hash  : '<?php echo hash_hmac("sha256", auth()->user()->email, config("services.tawk.api-key")) ?>'
            };
            <?php } ?>
            (function(){
                var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
                s1.async=true;
                s1.src='https://embed.tawk.to/<?php echo e(config("services.tawk.site-id")) ?>/default';
                s1.charset='UTF-8';
                s1.setAttribute('crossorigin','*');
                s0.parentNode.insertBefore(s1,s0);
            })();
        </script>
<?php if (config('services.tawk.capture-console')) { ?>
<script type="text/javascript">
<?php echo file_get_contents(__DIR__ . '/js/tawk-console-capture.js'); ?>
</script>
<?php } ?>
<?php } elseif (config('app.debug')) { ?>
<!-- Tawk.to: TAWK_SITE_ID is not configured. Set TAWK_SITE_ID in your .env file. -->
<?php } ?>
