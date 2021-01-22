<?php

namespace App\Http\Livewire;

use Livewire\Component;

class SemverChecker extends Component
{
    public string $package = 'madewithlove/htaccess-cli';
    public string $version = 'dev-main';
    public string $stability = 'stable';

    public function render()
    {
        return view('livewire.semver-checker');
    }

    public function getStabilityFlagProperty(): string
    {
        if ($this->stability === 'stable') {
            return '';
        }

        return '@' . $this->stability;
    }
}
