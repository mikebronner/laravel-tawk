<?php

namespace GeneaLabs\LaravelTawk\Tests;

use GeneaLabs\LaravelTawk\Providers\Service;
use Orchestra\Testbench\TestCase;

class ServiceProviderTest extends TestCase
{
    protected function getPackageProviders($app): array
    {
        return [Service::class];
    }

    public function test_service_provider_is_registered(): void
    {
        $this->assertTrue(
            $this->app->providerIsLoaded(Service::class)
        );
    }

    public function test_tawk_config_is_merged(): void
    {
        $this->assertNotNull(config('services.tawk'));
        $this->assertArrayHasKey('api-key', config('services.tawk'));
        $this->assertArrayHasKey('site-id', config('services.tawk'));
    }

    public function test_tawk_blade_directive_is_registered(): void
    {
        $directives = $this->app->make('blade.compiler')->getCustomDirectives();

        $this->assertArrayHasKey('tawk', $directives);
    }

    public function test_tawk_directive_outputs_script(): void
    {
        $directives = $this->app->make('blade.compiler')->getCustomDirectives();
        $output = call_user_func($directives['tawk']);

        $this->assertStringContainsString('embed.tawk.to', $output);
        $this->assertStringContainsString('Tawk_API', $output);
    }
}
