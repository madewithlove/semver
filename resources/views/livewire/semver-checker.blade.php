@inject('matcher', 'App\Version\Matcher')

<div>
    <p class="mb-3 text-sm">
        <a target="_blank" href="https://getcomposer.org/doc/articles/versions.md#versions-and-constraints">Learn more about version constraints</a>
    </p>

    <section>
        <form class="flex">
            <input wire:model="packageName" placeholder="Package" id="package" type="text" autofocus="" class="flex-grow text-center bg-gray-200 p-3 text-gray-600 outline-none focus:bg-gray-100">
            <button type="submit" class="p-3 bg-red-500 text-white font-bold text-sm mx-3">Search</button>
            <input wire:model="version" placeholder="Version (eg. ^1.5)" id="version" type="text"  class="flex-grow text-center bg-gray-200 p-3 text-gray-600 outline-none focus:bg-gray-100">
            <select name="stability" id="stability" wire:model="stability" class="bg-gray-200 p-3 pr-5 ml-3 text-gray-600 outline-none focus:bg-gray-100">
                <option label="dev" value="dev">dev</option>
                <option label="alpha" value="alpha">alpha</option>
                <option label="beta" value="beta">beta</option>
                <option label="RC" value="RC">RC</option>
                <option label="stable" value="stable">stable</option>
            </select>
        </form>

        <section class="text-center mt-5 pt-5 border-t border-gray-100">
            <h1 class="text-lg text-gray-600 font-medium">Results for <a target="_blank" href="https://packagist.org/packages/">:</a></h1>

            @if ($package === null)
                <p>The package does not exist</p>
            @endif

            <p class="hidden" ng-show="versions.length &amp;&amp; errors.matching">Invalid version constraint</p>

            <ul>
                @if ($package)
                    @foreach ($package->getVersions() as $packageVersion)
                        <li
                            @if ($matcher->matches($packageVersion->getVersion(), $version, $stability))
                                class="matches"
                            @endif
                        >
                            <a target="_blank" href="https://github.com/{{ $packageName }}/releases/tag/{{ $packageVersion->getVersion() }}">{{ $packageVersion->getVersion() }}</a>
                        </li>
                    @endforeach
                @endif
            </ul>
        </section>

        <h2 class="text-center text-lg text-gray-600 my-5 font-medium">Satisfied?</h2>
        <pre class="bg-gray-200 p-3 text-sm text-gray-600">composer require {{ $packageName }}:"{{ $version }}{{ $this->stabilityFlag }}"</pre>
    </section>
</div>
