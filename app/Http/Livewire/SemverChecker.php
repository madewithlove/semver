<?php

namespace App\Http\Livewire;

use App\Packagist\Client;
use Livewire\Component;

class SemverChecker extends Component
{
    public string $packageName = 'madewithlove/htaccess-cli';
    public string $version = 'dev-main';
    public string $stability = 'stable';

    public function render(Client $client)
    {
        return view(
            'livewire.semver-checker',
            [
                'package' => $client->getPackage($this->packageName),
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
