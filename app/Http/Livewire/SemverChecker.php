<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Packagist\Api\Client;
use Throwable;

class SemverChecker extends Component
{
    public string $packageName = 'madewithlove/htaccess-cli';
    public string $version = 'dev-main';
    public string $stability = 'stable';

    public function render(Client $client)
    {
        try {
            $package = $client->get($this->packageName);
        } catch (Throwable $e) {
            $package = null;
        }

        return view(
            'livewire.semver-checker',
            [
                'package' => $package,
            ]
        );
    }

    public function getStabilityFlagProperty(): string
    {
        if ($this->stability === 'stable') {
            return '';
        }

        return '@' . $this->stability;
    }
}
