<?php

namespace GeneaLabs\LaravelTawk\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;

class Service extends ServiceProvider
{
    protected $bladeCompiler;

    public function __construct(BladeCompiler $bladeCompiler)
    {
        $this->bladeCompiler = $bladeCompiler;
    }

    public function boot()
    {
        $this->bladeCompiler->directive("tawk", function () {
            $apiKey = config("services.tawk.api-key");
            $siteId = config("services.tawk.site-id");
            $result = <<<EOF
                <script type="text/javascript">
                    var Tawk_API=Tawk_API || {};
                    var Tawk_LoadStart=new Date();
            EOF;

            if (auth()->check()) {
                $hash = hash_hmac("sha256", auth()->user()->email, $apiKey);
                $result .= <<<EOF
                    Tawk_API.visitor = {
                        name  : '{auth()->user()->name}',
                        email : '{auth()->user()->email}',
                        hash  : '{$hash}'
                    };
                EOF;
            }

            $result .= <<<EOF
                    (function(){
                        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
                        s1.async=true;
                        s1.src='https://embed.tawk.to/{$siteId}/default';
                        s1.charset='UTF-8';
                        s1.setAttribute('crossorigin','*');
                        s0.parentNode.insertBefore(s1,s0);
                    })();
                </script>
            EOF;
    
            return $result;
        });
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . "../../config/services.php", "services");
    }

    public function provides()
    {
        
    }
}
