<?php

namespace GeneaLabs\LaravelTawk\Tests;

use GeneaLabs\LaravelTawk\Providers\Service;
use Illuminate\Support\Facades\Blade;
use Orchestra\Testbench\TestCase;

class ScreenshotFeatureTest extends TestCase
{
    protected function getPackageProviders($app): array
    {
        return [Service::class];
    }

    protected function renderTawkDirective(): string
    {
        return Blade::render('@tawk');
    }

    public function test_capture_screenshot_config_key_exists_and_defaults_to_false(): void
    {
        $this->assertFalse(config('services.tawk.capture-screenshot'));
    }

    public function test_html2canvas_url_config_key_exists_with_default(): void
    {
        $this->assertNotNull(config('services.tawk.html2canvas-url'));
        $this->assertStringContainsString('html2canvas', config('services.tawk.html2canvas-url'));
    }

    public function test_directive_includes_screenshot_js_when_enabled(): void
    {
        config([
            'services.tawk.site-id' => 'test-site-id',
            'services.tawk.capture-screenshot' => true,
        ]);

        $output = $this->renderTawkDirective();

        $this->assertStringContainsString('captureScreenshot', $output);
        $this->assertStringContainsString('html2canvas', $output);
        $this->assertStringContainsString('tawkHtml2canvasUrl', $output);
    }

    public function test_directive_excludes_screenshot_js_when_disabled(): void
    {
        config([
            'services.tawk.site-id' => 'test-site-id',
            'services.tawk.capture-screenshot' => false,
        ]);

        $output = $this->renderTawkDirective();

        $this->assertStringNotContainsString('captureScreenshot', $output);
    }

    public function test_directive_excludes_screenshot_js_when_no_site_id(): void
    {
        config([
            'services.tawk.site-id' => null,
            'services.tawk.capture-screenshot' => true,
        ]);

        $output = $this->renderTawkDirective();

        $this->assertStringNotContainsString('captureScreenshot', $output);
    }

    public function test_custom_html2canvas_url_is_injected_into_output(): void
    {
        config([
            'services.tawk.site-id' => 'test-site-id',
            'services.tawk.capture-screenshot' => true,
            'services.tawk.html2canvas-url' => 'https://custom-cdn.example.com/html2canvas.min.js',
        ]);

        $output = $this->renderTawkDirective();

        $this->assertStringContainsString('custom-cdn.example.com', $output);
    }
}
