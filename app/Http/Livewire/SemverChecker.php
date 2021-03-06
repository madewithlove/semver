<?php

namespace App\Http\Livewire;

use App\Packagist\Client;
use App\Version\Matcher;
use App\Version\Version;
use Composer\Semver\VersionParser;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
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

        if ($package) {
            $versions = $package->getVersions();

            usort($versions, function (PackagistVersion $a, PackagistVersion $b) {
                return -1 * version_compare($a->getVersionNormalized(), $b->getVersionNormalized());
            });

            $versions =  array_map(
                function (PackagistVersion $packagistVersion) use ($matcher) {
                    return new Version(
                        $this->getNameWithBranchAliasReplaced($packagistVersion),
                        (string) $packagistVersion->getSource()?->getUrl(),
                        $matcher->matches($packagistVersion->getVersion(), $this->constraint, $this->stability)
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

        return '@' . $this->stability;
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
}
