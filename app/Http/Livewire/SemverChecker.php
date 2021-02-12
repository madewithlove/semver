<?php

namespace App\Http\Livewire;

use App\Packagist\Client;
use App\Version\Matcher;
use App\Version\Version;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Packagist\Api\Result\Package\Version as PackagistVersion;

class SemverChecker extends Component
{
    public string $packageName = 'madewithlove/htaccess-cli';
    public string $version = 'dev-main';
    public string $stability = 'stable';

    public function render(Client $client, Matcher $matcher): Factory|View
    {
        $package = $client->getPackage($this->packageName);
        $versions = [];

        if ($package) {
            $versions = $package->getVersions();

            usort($versions, function (PackagistVersion $a, PackagistVersion $b) {
                return -1 * version_compare($a->getVersionNormalized(), $b->getVersionNormalized());
            });

            $versions =  array_map(
                function (PackagistVersion $packagistVersion) use ($matcher) {
                    return new Version(
                        $packagistVersion->getVersion(),
                        $matcher->matches($packagistVersion->getVersion(), $this->version, $this->stability)
                    );
                },
                $versions
            );
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
