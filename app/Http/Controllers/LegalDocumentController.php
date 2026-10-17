<?php

namespace App\Http\Controllers;

use ErrorException;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class LegalDocumentController extends Controller
{
    public function privacyPolicy(): Response
    {
        return $this->show('privacy-policy.md', 'Kebijakan Privasi - Autoloker', 'Kebijakan Privasi Autoloker yang dikelola oleh PT Auto Talenta Nusantara.', 'legal.privacy-policy');
    }

    public function termsAndConditions(): Response
    {
        return $this->show('terms-and-conditions.md', 'Syarat dan Ketentuan - Autoloker', 'Syarat dan Ketentuan penggunaan layanan Autoloker.', 'legal.terms-and-conditions');
    }

    private function show(string $filename, string $title, string $description, string $routeName): Response
    {
        $path = resource_path('legal/'.$filename);
        $html = null;
        $status = 503;

        if (File::isFile($path) && File::isReadable($path)) {
            try {
                $markdown = File::get($path);
                if (is_string($markdown) && trim($markdown) !== '') {
                    $html = Str::markdown($markdown, [
                        'html_input' => 'strip',
                        'allow_unsafe_links' => false,
                        'table' => ['wrap' => ['enabled' => true, 'tag' => 'div', 'attributes' => ['class' => 'legal-table-scroll', 'tabindex' => '0', 'role' => 'region', 'aria-label' => 'Tabel dokumen hukum']]],
                    ]);
                    $status = 200;
                }
            } catch (FileNotFoundException|ErrorException) {
                $html = null;
            }
        }

        return response()->view('legal.show', [
            'title' => $title,
            'description' => $description,
            'canonical' => $this->canonicalUrl($routeName),
            'html' => $html,
        ], $status);
    }

    private function canonicalUrl(string $routeName): ?string
    {
        if (app()->environment() !== 'production') {
            return null;
        }

        $base = config('app.url');
        if (! is_string($base) || filter_var($base, FILTER_VALIDATE_URL) === false) {
            return null;
        }

        $parts = parse_url($base);
        $host = strtolower($parts['host'] ?? '');
        if (($parts['scheme'] ?? '') !== 'https' || $host === '' || isset($parts['user']) || isset($parts['pass']) || isset($parts['query']) || isset($parts['fragment']) || filter_var($host, FILTER_VALIDATE_IP) !== false) {
            return null;
        }

        if ($host === 'localhost' || str_ends_with($host, '.localhost') || str_ends_with($host, '.local') || str_ends_with($host, '.test') || str_ends_with($host, '.invalid') || preg_match('/^(?:dev|staging)(?:\.|$)/', $host)) {
            return null;
        }

        return rtrim($base, '/').route($routeName, [], false);
    }
}
