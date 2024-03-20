<?php

namespace Marwanosama8\SpatieActivitylogResources;

use Filament\Support\Assets\AlpineComponent;
use Filament\Support\Assets\Asset;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentIcon;
use Illuminate\Filesystem\Filesystem;
use Livewire\Features\SupportTesting\Testable;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Marwanosama8\SpatieActivitylogResources\Commands\SpatieActivitylogResourcesCommand;
use Marwanosama8\SpatieActivitylogResources\Testing\TestsSpatieActivitylogResources;

class SpatieActivitylogResourcesServiceProvider extends PackageServiceProvider
{
    public static string $name = 'spatie-activitylog-resources';

    public static string $viewNamespace = 'spatie-activitylog-resources';

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package->name(static::$name)
            ->hasConfigFile()
            ->hasTranslations()
            ->hasCommands($this->getCommands())
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->askToStarRepoOnGitHub('marwanosama8/spatie-activitylog-resources');
            });

        $configFileName = $package->shortName();

        if (file_exists($package->basePath("/../config/{$configFileName}.php"))) {
            $package->hasConfigFile();
        }


        if (file_exists($package->basePath('/../resources/lang'))) {
            $package->hasTranslations();
        }

   
    }

    public function registeringPackage(): void
    {
        $this->app->register(SpatieActivityLogEventServiceProvider::class);
    }

    public function packageBooted(): void
    {
        // // Icon Registration
        // FilamentIcon::register($this->getIcons());

        // Handle Stubs
        if (app()->runningInConsole()) {
            foreach (app(Filesystem::class)->files(__DIR__ . '/../stubs/') as $file) {
                $this->publishes([
                    $file->getRealPath() => base_path("stubs/spatie-activitylog-resources/{$file->getFilename()}"),
                ], 'spatie-activitylog-resources-stubs');
            }
        }

        // Testing
        Testable::mixin(new TestsSpatieActivitylogResources());
    }

    protected function getAssetPackageName(): ?string
    {
        return 'marwanosama8/spatie-activitylog-resources';
    }

    // /**
    //  * @return array<Asset>
    //  */
    // protected function getAssets(): array
    // {
    //     return [
    //         // AlpineComponent::make('spatie-activitylog-resources', __DIR__ . '/../resources/dist/components/spatie-activitylog-resources.js'),
    //         Css::make('spatie-activitylog-resources-styles', __DIR__ . '/../resources/dist/spatie-activitylog-resources.css'),
    //         Js::make('spatie-activitylog-resources-scripts', __DIR__ . '/../resources/dist/spatie-activitylog-resources.js'),
    //     ];
    // }

    /**
     * @return array<class-string>
     */
    protected function getCommands(): array
    {
        return [
            SpatieActivitylogResourcesCommand::class,
        ];
    }

    /**
     * @return array<string>
     */
    protected function getIcons(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function getRoutes(): array
    {
        return [];
    }

    /**
     * @return array<string, mixed>
     */
    protected function getScriptData(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function getMigrations(): array
    {
        return [
            'create_spatie-activitylog-resources_table',
        ];
    }
}
