<?php

namespace Tests\Feature;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\File;
use Tests\TestCase;
use ErrorException;

class LegalDocumentTest extends TestCase
{
    public function test_guest_can_read_both_documents_without_session_cookies_and_query_cannot_select_a_file(): void
    {
        $privacy = $this->get(route('legal.privacy-policy', [], false).'?file=../../.env&document=terms-and-conditions.md');
        $privacy->assertOk()->assertSee('Kebijakan Privasi - Autoloker')->assertSee('Kebijakan Privasi', false)->assertDontSee('Syarat dan Ketentuan tentang Autoloker', false);
        $this->assertFalse($privacy->headers->has('Set-Cookie'));

        $terms = $this->get(route('legal.terms-and-conditions', [], false));
        $terms->assertOk()->assertSee('Syarat dan Ketentuan - Autoloker')->assertSee('17 Oktober 2026')->assertSee('dev.autoloker.com');
        $this->assertFalse($terms->headers->has('Set-Cookie'));
    }

    public function test_markdown_is_rendered_as_safe_structured_html(): void
    {
        $this->mockMarkdown("# Judul\n\n## Bagian\n\n### Subbagian\n\nParagraf **tebal** [HTTPS](https://example.com) [email](mailto:a@example.com).\n\n- Satu\n- Dua\n\n1. Pertama\n2. Kedua\n\n| A | B |\n|---|---|\n| x | y |\n");
        $response = $this->get(route('legal.privacy-policy', [], false));
        $response->assertOk()->assertSee('<h1>Judul</h1>', false)->assertSee('<h2>Bagian</h2>', false)->assertSee('<h3>Subbagian</h3>', false)->assertSee('<strong>tebal</strong>', false)->assertSee('href="https://example.com"', false)->assertSee('href="mailto:a@example.com"', false)->assertSee('class="legal-table-scroll"', false)->assertSee('<ol>', false)->assertSee('<ul>', false)->assertDontSee('# Judul');
    }

    public function test_markdown_raw_html_and_unsafe_links_are_not_executable(): void
    {
        $this->mockMarkdown("# Aman\n\n<script>alert(1)</script><img src=x onerror=alert(1)><iframe src=javascript:alert(1)></iframe>\n\n[unsafe](javascript:alert%281%29) [data](data:text/html;base64,PHNjcmlwdD4=) [HTTPS](https://example.com) [email](mailto:a@example.com)\n");
        $response = $this->get(route('legal.privacy-policy', [], false));
        $response->assertOk();
        $dom = new \DOMDocument();
        @$dom->loadHTML($response->getContent());
        $article = $dom->getElementsByTagName('article')->item(0);
        $this->assertNotNull($article);
        foreach (['script', 'img', 'iframe'] as $tag) {
            $this->assertSame(0, $article->getElementsByTagName($tag)->length);
        }
        foreach ($article->getElementsByTagName('*') as $element) {
            foreach ($element->attributes as $attribute) {
                $this->assertFalse(str_starts_with(strtolower($attribute->name), 'on'));
            }
        }
        foreach ($article->getElementsByTagName('a') as $link) {
            $href = strtolower($link->getAttribute('href'));
            $this->assertFalse(str_starts_with($href, 'javascript:') || str_starts_with($href, 'data:'));
        }
    }

    public function test_unavailable_documents_return_safe_503_for_both_routes(): void
    {
        $mock = File::partialMock();
        foreach ([
            ['legal.privacy-policy', 'privacy-policy.md', null, false],
            ['legal.terms-and-conditions', 'terms-and-conditions.md', null, true],
            ['legal.privacy-policy', 'privacy-policy.md', new FileNotFoundException('/fake/private/path'), null],
            ['legal.terms-and-conditions', 'terms-and-conditions.md', new ErrorException('/fake/private/path'), null],
            ['legal.privacy-policy', 'privacy-policy.md', '', null],
        ] as [$route, $filename, $failure, $file]) {
            $mock->shouldReceive('isFile')->with(resource_path('legal/'.$filename))->andReturn($file ?? true);
            $mock->shouldReceive('isReadable')->with(resource_path('legal/'.$filename))->andReturn($file ?? true);
            if ($failure !== null) {
                $mock->shouldReceive('get')->with(resource_path('legal/'.$filename))->andReturnUsing(static function () use ($failure) { throw $failure; });
            } elseif ($file !== false) {
                $mock->shouldReceive('get')->with(resource_path('legal/'.$filename))->andReturn($failure ?? '');
            }
            $response = $this->get(route($route, [], false));
            $response->assertStatus(503)->assertSee('Dokumen tidak tersedia')->assertSee('devautoloker@gmail.com')->assertDontSee('/fake/private/path')->assertDontSee('ErrorException');
        }
    }

    public function test_production_canonical_uses_configured_origin_not_request_host(): void
    {
        app()->detectEnvironment(fn () => 'production');
        config(['app.url' => 'https://autoloker.example/app']);
        $this->withServerVariables(['HTTP_HOST' => 'attacker.example'])->get('/privacy-policy?x=1')->assertSee('href="https://autoloker.example/app/privacy-policy"', false);
        config(['app.url' => 'https://dev.autoloker.com']);
        $this->get('/privacy-policy')->assertDontSee('rel="canonical"', false);
    }

    private function mockMarkdown(string $markdown): void
    {
        File::partialMock()->shouldReceive('isFile')->with(resource_path('legal/privacy-policy.md'))->andReturn(true);
        File::partialMock()->shouldReceive('isReadable')->with(resource_path('legal/privacy-policy.md'))->andReturn(true);
        File::partialMock()->shouldReceive('get')->with(resource_path('legal/privacy-policy.md'))->andReturn($markdown);
    }
}
