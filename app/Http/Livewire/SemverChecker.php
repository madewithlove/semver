<?php

namespace App\Http\Livewire;

use App\Packagist\Client;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Packagist\Api\Result\Package\Version;

class SemverChecker extends Component
{
    public string $packageName = 'madewithlove/htaccess-cli';
    public string $version = 'dev-main';
    public string $stability = 'stable';

    public function render(Client $client): Factory|View
    {
        $package = $client->getPackage($this->packageName);
        $versions = [];

        if ($package) {
            $versions = $package->getVersions();

            usort($versions, function (Version $a, Version $b) {
                return -1 * version_compare($a->getVersionNormalized(), $b->getVersionNormalized());
            });
        }

        return view(
            'livewire.semver-checker',
            [
                'package' => $package,
                'versions' => $versions,
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
