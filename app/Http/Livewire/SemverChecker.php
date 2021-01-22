<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Packagist\Api\Client;

class SemverChecker extends Component
{
    public string $packageName = 'madewithlove/htaccess-cli';
    public string $version = 'dev-main';
    public string $stability = 'stable';

    public function render(Client $client)
    {
        $package = $client->get($this->packageName);

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
