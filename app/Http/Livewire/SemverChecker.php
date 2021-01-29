<?php

namespace App\Http\Livewire;

use App\Packagist\Client;
use Livewire\Component;
use Throwable;

class SemverChecker extends Component
{
    public string $packageName = 'madewithlove/htaccess-cli';
    public string $version = 'dev-main';
    public string $stability = 'stable';

    public function render(Client $client)
    {
        try {
            $package = $client->getPackage($this->packageName);
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
