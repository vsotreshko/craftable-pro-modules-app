<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class CreateGeneralSettings extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.available_locales', [config('app.locale', 'en')]);
        $this->migrator->add('general.default_locale', config('app.locale', 'en'));
        $this->migrator->add('general.default_route', 'admin/craftable-pro-users');
    }
}
