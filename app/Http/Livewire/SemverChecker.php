<?php

namespace App\Http\Livewire;

use App\Packagist\Client;
use App\Version\Matcher;
use App\Version\Version;
use App\VirtualPackages\VirtualPackage;
use App\VirtualPackages\VirtualPackageVersion;
use Composer\Semver\VersionParser;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Livewire\Component;
use Packagist\Api\Result\Package\Version as PackagistVersion;
use UnexpectedValueException;

class SemverChecker extends Component
{
    public string $package = 'madewithlove/htaccess-cli';

    public string $constraint = 'dev-main';

    public string $stability = 'stable';

    /**
     * @var string[]
     */
    protected $queryString = ['package', 'constraint', 'stability'];

    public function render(Client $client, Matcher $matcher): Factory|View
    {
        $package = $client->getPackage($this->package);
        $versions = [];
        $results = [];

        if ($package) {
            $versions = $package->getVersions();

            usort($versions, function (PackagistVersion $a, PackagistVersion $b) {
                return -1 * version_compare($a->getVersionNormalized(), $b->getVersionNormalized());
            });

            $versions = collect($versions)
                ->map(function (PackagistVersion $version) use ($matcher) {
                    $alias = $this->getNameWithBranchAliasReplaced($version);
                    $matches = $matcher->matches($alias, $this->constraint, $this->stability) || $matcher->matches($version->getVersion(), $this->constraint, $this->stability);

                    if ($version instanceof VirtualPackageVersion) {
                        return new Version(
                            $alias,
                            $version->getUrl(),
                            $matches,
                        );
                    }

                    $name = $version->getVersion();
                    $url = substr((string) $version->getSource()?->getUrl(), 0, -4);

                    if (Str::startsWith($name, 'dev-')) {
                        $url .= '/tree/'.substr($name, 4);
                    } elseif (Str::endsWith($name, '-dev')) {
                        $url .= '/tree/'.substr($name, 0, -4);
                    } else {
                        $url .= '/releases/tag/'.$name;
                    }

                    return new Version(
                        $alias,
                        $url,
                        $matches
                    );
                });
        } else {
            $results = $client->search($this->package);
        }

        return view(
            'livewire.semver-checker',
            [
                'isVirtual' => $package instanceof VirtualPackage,
                'versions' => $versions,
                'results' => $results,
            ]
        );
    }

    private function getNameWithBranchAliasReplaced(PackagistVersion $version): string
    {
        $extras = $version->getExtra();

        if ($extras && isset($extras['branch-alias'])) {
            foreach ($extras['branch-alias'] as $branch => $alias) {
                if ($version->getVersion() === $branch) {
                    return $alias;
                }
            }
        }

        return $version->getVersion();
    }

    public function getStabilityFlagProperty(): string
    {
        if ($this->stability === 'stable') {
            return '';
        }

        return '@'.$this->stability;
    }

    public function getIsValidConstraintProperty(VersionParser $versionParser): bool
    {
        try {
            $versionParser->parseConstraints($this->constraint);
        } catch (UnexpectedValueException) {
            return false;
        }

        return true;
    }

    public function choosePackage(string $name): void
    {
        $this->package = $name;
    }
}
