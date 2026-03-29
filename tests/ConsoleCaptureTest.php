<?php

namespace GeneaLabs\LaravelTawk\Tests;

use GeneaLabs\LaravelTawk\Providers\Service;
use Illuminate\Support\Facades\Blade;
use Orchestra\Testbench\TestCase;

class ConsoleCaptureTest extends TestCase
{
    protected function getPackageProviders($app): array
    {
        return [Service::class];
    }

    protected function renderTawkDirective(): string
    {
        return Blade::render('@tawk');
    }

    public function test_console_capture_uses_callback_chaining(): void
    {
        config([
            'services.tawk.site-id' => 'test-site-id',
            'services.tawk.capture-console' => true,
        ]);

        $output = $this->renderTawkDirective();

        $this->assertStringContainsString('previousOnChatStarted', $output);
    }

    public function test_screenshot_uses_callback_chaining(): void
    {
        config([
            'services.tawk.site-id' => 'test-site-id',
            'services.tawk.capture-screenshot' => true,
        ]);

        $output = $this->renderTawkDirective();

        $this->assertStringContainsString('previousOnChatStarted', $output);
    }

    public function test_both_features_enabled_includes_chaining_in_both(): void
    {
        config([
            'services.tawk.site-id' => 'test-site-id',
            'services.tawk.capture-console' => true,
            'services.tawk.capture-screenshot' => true,
        ]);

        $output = $this->renderTawkDirective();

        $this->assertGreaterThanOrEqual(
            2,
            substr_count($output, 'previousOnChatStarted'),
            'Both console and screenshot scripts should chain the onChatStarted callback'
        );
    }
}
