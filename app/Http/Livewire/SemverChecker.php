<?php

namespace App\Http\Livewire;

use Livewire\Component;

class SemverChecker extends Component
{
    public string $package = 'madewithlove/htaccess-cli';

    public function render()
    {
        return view('livewire.semver-checker');
    }
}
