<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Website Settings
        DB::table('settings')->insert(['setting' => 'title', 'group' => 'website', 'value' => 'Youdex']);
        DB::table('settings')->insert(['setting' => 'subtitle', 'group' => 'website', 'value' => 'Initial Coin Offering']);
        DB::table('settings')->insert(['setting' => 'support_email', 'group' => 'website', 'value' => 'support@futurx.space']);
        DB::table('settings')->insert(['setting' => 'base_url', 'group' => 'website', 'value' => 'http://ico.test']);
        DB::table('settings')->insert(['setting' => 'logo', 'group' => 'website', 'value' => '/files/logos/logo.png']);
        DB::table('settings')->insert(['setting' => 'favicon', 'group' => 'website', 'value' => '/files/logos/favicon.png']);
        DB::table('settings')->insert(['setting' => 'token_icon', 'group' => 'website', 'value' => '/files/logos/token_icon.png']);
        DB::table('settings')->insert(['setting' => 'GOOGLE_CAPTCHA_PUBLIC_KEY', 'group' => 'website', 'value' => '6LcE-BoaAAAAAC6VsbTHr9MsOm0NgkcKvv3aFjun']);
        DB::table('settings')->insert(['setting' => 'GOOGLE_CAPTCHA_PRIVATE_KEY', 'group' => 'website', 'value' => '6LcE-BoaAAAAALlYPE7LznuHIlpX9ZvCXTvcjLtK']);
        //SEO Settings
        DB::table('settings')->insert(['setting' => 'indexable', 'group' => 'seo', 'value' => '0']);
        DB::table('settings')->insert(['setting' => 'description', 'group' => 'seo', 'value' => 'Initial Coin Offering Description']);
        DB::table('settings')->insert(['setting' => 'keywords', 'group' => 'seo', 'value' => 'Initial,Coin,Offering']);
        //Contact Settings
        DB::table('settings')->insert(['setting' => 'contact_email', 'group' => 'contact', 'value' => 'info@test.mail']);
        DB::table('settings')->insert(['setting' => 'contact_phone', 'group' => 'contact', 'value' => '+14582410011']);
        DB::table('settings')->insert(['setting' => 'telegram_group', 'group' => 'contact', 'value' => 'https://t.me/telegram']);
        DB::table('settings')->insert(['setting' => 'telegram_channel', 'group' => 'contact', 'value' => 'https://t.me/telegram']);
        //Front Settings
        DB::table('settings')->insert(['setting' => 'banner_title', 'group' => 'front_banner', 'value' => 'ICO PROJECT']);
        DB::table('settings')->insert(['setting' => 'banner_subtitle', 'group' => 'front_banner', 'value' => 'is your future.']);
        DB::table('settings')->insert(['setting' => 'banner_details', 'group' => 'front_banner', 'value' => 'bla bla bla']);

        DB::table('settings')->insert(['setting' => 'video', 'group' => 'front_video', 'value' => 'https://www.youtube-nocookie.com/']);

        DB::table('settings')->insert(['setting' => 'about', 'group' => 'front_about', 'value' => '1']);
        DB::table('settings')->insert(['setting' => 'about_title', 'group' => 'front_about', 'value' => 'About us']);
        DB::table('settings')->insert(['setting' => 'about_subtitle', 'group' => 'front_about', 'value' => 'what about']);
        DB::table('settings')->insert(['setting' => 'about_content', 'group' => 'front_about', 'value' => 'Lorem ipsum']);

        DB::table('settings')->insert(['setting' => 'partners', 'group' => 'front_partners', 'value' => '1']);
        DB::table('settings')->insert(['setting' => 'partners_title', 'group' => 'front_partners', 'value' => 'Our Partners']);
        DB::table('settings')->insert(['setting' => 'partners_subtitle', 'group' => 'front_partners', 'value' => 'Lorem ipsum']);

        DB::table('settings')->insert(['setting' => 'press', 'group' => 'front_press', 'value' => '1']);
        DB::table('settings')->insert(['setting' => 'press_title', 'group' => 'front_press', 'value' => 'On Press']);
        DB::table('settings')->insert(['setting' => 'press_subtitle', 'group' => 'front_press', 'value' => 'Lorem ipsum']);

        DB::table('settings')->insert(['setting' => 'roadmap', 'group' => 'switch', 'value' => '1']);
        DB::table('settings')->insert(['setting' => 'contact_form', 'group' => 'switch', 'value' => '1']);
        DB::table('settings')->insert(['setting' => 'subscribe', 'group' => 'switch', 'value' => '1']);
        //ICO Settings
        DB::table('settings')->insert(['setting' => 'status', 'group' => 'ico', 'value' => '1']);
        DB::table('settings')->insert(['setting' => 'token_name', 'group' => 'ico', 'value' => 'U2']);
        DB::table('settings')->insert(['setting' => 'token_symbol', 'group' => 'ico', 'value' => 'U2']);
        DB::table('settings')->insert(['setting' => 'decimal', 'group' => 'ico', 'value' => '3']);
        //MLM Settings
        DB::table('settings')->insert(['setting' => 'mlm_status', 'group' => 'mlm', 'value' => '1']);
        //System Settings
        DB::table('settings')->insert(['setting' => 'welcome_message', 'group' => 'userpanel', 'value' => 'We are happy to see you among us.']);
        //Email Sending Settings
        DB::table('settings')->insert(['setting' => 'mail_service', 'group' => 'mailing', 'value' => 'smtp']);
        DB::table('settings')->insert(['setting' => 'mail_from_name', 'group' => 'mailing', 'value' => 'FuturX']);
        DB::table('settings')->insert(['setting' => 'mail_from_address', 'group' => 'mailing', 'value' => 'mail@ilkerkocatepe.com.tr']);
            //SMTP
            DB::table('settings')->insert(['setting' => 'smtp_host', 'group' => 'mailing', 'value' => 'ilkerkocatepe.com.tr']);
            DB::table('settings')->insert(['setting' => 'smtp_port', 'group' => 'mailing', 'value' => '465']);
            DB::table('settings')->insert(['setting' => 'smtp_encryption', 'group' => 'mailing', 'value' => 'ssl']);
            DB::table('settings')->insert(['setting' => 'smtp_username', 'group' => 'mailing', 'value' => 'mail@ilkerkocatepe.com.tr']);
            DB::table('settings')->insert(['setting' => 'smtp_password', 'group' => 'mailing', 'value' => 'Yalovax*2020']);
            //Mailgun
            DB::table('settings')->insert(['setting' => 'mailgun_domain', 'group' => 'mailing', 'value' => '']);
            DB::table('settings')->insert(['setting' => 'mailgun_secret', 'group' => 'mailing', 'value' => '']);
            DB::table('settings')->insert(['setting' => 'mailgun_endpoint', 'group' => 'mailing', 'value' => 'api.eu.mailgun.net']);
            //Postmark
            DB::table('settings')->insert(['setting' => 'postmark_token', 'group' => 'mailing', 'value' => '']);
            //SES
            DB::table('settings')->insert(['setting' => 'ses_key', 'group' => 'mailing', 'value' => '']);
            DB::table('settings')->insert(['setting' => 'ses_secret', 'group' => 'mailing', 'value' => '']);
            DB::table('settings')->insert(['setting' => 'ses_region', 'group' => 'mailing', 'value' => 'us-east-1']);
    }
}
