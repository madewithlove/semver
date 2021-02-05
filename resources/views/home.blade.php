<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="canonical" href="http://semver.mwl.be">
        <title>Package Semver Checker - madewithlove</title>
        <meta name="description" content="Semver version constraint checker for packagist.">
        <link href="//fonts.googleapis.com/css?family=Lato:300,400,500,700" rel="stylesheet" type="text/css">
        <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
        <link href="{{asset('css/app.css')}}" rel="stylesheet">
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <header class="w-full z-30 top-0 py-2 border-b border-grey-200 mb-12">
            <div  class="w-full container mx-auto flex flex-wrap items-center mt-0 py-3 px-5">
                <a href="https://madewithlove.com?ref=semver" title="go to the madewitlove website" class="w-40 bg-transparent pb-0">
                    <img src="img/logo-new.svg" alt="the madewithlove logo">
                </a>

                <h1 class="ml-3 pl-3 text-xl border-l border-red-500">Packagist Semver Checker</h1>
            </div>
        </header>
        <main class="w-full mx-auto container px-5">
            <livewire:semver-checker />
        </main>
        <footer class="w-full border-t border-grey-200 mt-3">
            <div class="w-full mx-auto container flex flex-wrap items-center justify-between pt-5 mb-7 text-xs px-5">
                <div>
                    <span>&copy; {{ now()->year }} <strong>made</strong>with<strong>love</strong></span>
                    <a href="https://madewithlove.be/disclaimer/?ref=semver" class="ml-5">terms of service</a>
                    <a target="_blank" href="https://github.com/madewithlove/semver" class="ml-5">source</a>
                    <a target="_blank" href="https://app.changehub.io/share/p-oXqP9gaQg1" class="ml-5">changelog</a>
                    <a target="_blank" href="https://github.com/madewithlove/semver/graphs/contributors" class="ml-5">creators</a>
                </div>
                <div class="flex-end">
                    <a target="_blank" href="https://madewithlove.com/company/playground/?ref=semver">This is a madewithlove project</a>
                </div>
            </div>
        </footer>

        @livewireScripts
    </body>
</html>