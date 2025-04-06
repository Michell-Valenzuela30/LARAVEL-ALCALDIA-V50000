<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Configuration;
use Illuminate\Database\Seeder;

class ConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $configs = [
            // General
            ['key' => 'app_name', 'value' => config('app.name'), 'group' => 'general', 'type' => 'text'],
            ['key' => 'logo_light', 'value' => 'Img/Logo/logo_for_light-06-04-2025172953.webp', 'group' => 'general', 'type' => 'file'],
            ['key' => 'logo_dark', 'value' => 'Img/Logo/logo_for_dark-06-04-2025172946.webp', 'group' => 'general', 'type' => 'file'],

            // Contact
            ['key' => 'address', 'value' => '', 'group' => 'contact', 'type' => 'text'],
            ['key' => 'phone', 'value' => '', 'group' => 'contact', 'type' => 'text'],
            ['key' => 'email', 'value' => '', 'group' => 'contact', 'type' => 'email'],
            ['key' => 'facebook', 'value' => '', 'group' => 'contact', 'type' => 'text'],
            ['key' => 'twitter', 'value' => '', 'group' => 'contact', 'type' => 'text'],
            ['key' => 'instagram', 'value' => '', 'group' => 'contact', 'type' => 'text'],

            // SMTP
            ['key' => 'mail_mailer', 'value' => env('MAIL_MAILER', 'smtp'), 'group' => 'smtp', 'type' => 'text'],
            ['key' => 'mail_host', 'value' => env('MAIL_HOST', 'mailpit'), 'group' => 'smtp', 'type' => 'text'],
            ['key' => 'mail_port', 'value' => env('MAIL_PORT', '1025'), 'group' => 'smtp', 'type' => 'number'],
            ['key' => 'mail_username', 'value' => env('MAIL_USERNAME', ''), 'group' => 'smtp', 'type' => 'text'],
            ['key' => 'mail_password', 'value' => env('MAIL_PASSWORD', ''), 'group' => 'smtp', 'type' => 'password'],
            ['key' => 'mail_encryption', 'value' => env('MAIL_ENCRYPTION', 'null'), 'group' => 'smtp', 'type' => 'text'],
            ['key' => 'mail_from_address', 'value' => env('MAIL_FROM_ADDRESS', 'hello@example.com'), 'group' => 'smtp', 'type' => 'email'],
            ['key' => 'mail_from_name', 'value' => env('MAIL_FROM_NAME', config('app.name')), 'group' => 'smtp', 'type' => 'text'],
        ];

        foreach ($configs as $config) {
            Configuration::updateOrCreate(
                ['key' => $config['key']],
                $config
            );
        }
    }
}
