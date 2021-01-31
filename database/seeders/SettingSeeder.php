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
        DB::table('settings')->insert(['setting' => 'title', 'group' => 'group','value' => 'FuturX ICO']);
        DB::table('settings')->insert(['setting' => 'subtitle', 'group' => 'group','value' => 'FuturX Initial Coin Offering']);
        DB::table('settings')->insert(['setting' => 'support_email', 'group' => 'group','value' => 'support@futurx.space']);
        DB::table('settings')->insert(['setting' => 'base_url', 'group' => 'group','value' => 'http://ico.test']);
        DB::table('settings')->insert(['setting' => 'logo', 'group' => 'group','value' => '/files/logos/logo.png']);
        DB::table('settings')->insert(['setting' => 'favicon', 'group' => 'group','value' => '/files/logos/favicon.png']);
        DB::table('settings')->insert(['setting' => 'token_icon', 'group' => 'group','value' => '/files/logos/token_icon.png']);
        DB::table('settings')->insert(['setting' => 'GOOGLE_CAPTCHA_PUBLIC_KEY', 'group' => 'group','value' => '6LcE-BoaAAAAAC6VsbTHr9MsOm0NgkcKvv3aFjun']);
        DB::table('settings')->insert(['setting' => 'GOOGLE_CAPTCHA_PRIVATE_KEY', 'group' => 'group','value' => '6LcE-BoaAAAAALlYPE7LznuHIlpX9ZvCXTvcjLtK']);
        //SEO Settings
        DB::table('settings')->insert(['setting' => 'indexable', 'group' => 'group','value' => '0']);
        DB::table('settings')->insert(['setting' => 'description', 'group' => 'group','value' => 'Initial Coin Offering Description']);
        DB::table('settings')->insert(['setting' => 'keywords', 'group' => 'group','value' => 'Initial,Coin,Offering']);
        //Contact Settings
        DB::table('settings')->insert(['setting' => 'contact_email', 'group' => 'group','value' => 'info@futurx.space']);
        DB::table('settings')->insert(['setting' => 'contact_phone', 'group' => 'group','value' => '+14582410011']);
        //Front Settings
        DB::table('settings')->insert(['setting' => 'banner_title', 'group' => 'group','value' => 'FUTURX']);
        DB::table('settings')->insert(['setting' => 'banner_subtitle', 'group' => 'group','value' => 'is your future.']);
        DB::table('settings')->insert(['setting' => 'banner_details', 'group' => 'group','value' => 'bla bla bla']);
        DB::table('settings')->insert(['setting' => 'video', 'group' => 'group','value' => 'https://www.youtube-nocookie.com/']);

        DB::table('settings')->insert(['setting' => 'about', 'group' => 'group','value' => '1']);
        DB::table('settings')->insert(['setting' => 'about_title', 'group' => 'group','value' => 'About us']);
        DB::table('settings')->insert(['setting' => 'about_subtitle', 'group' => 'group','value' => 'what about']);
        DB::table('settings')->insert(['setting' => 'about_content', 'group' => 'group','value' => 'Lorem ipsum']);

        DB::table('settings')->insert(['setting' => 'partners', 'group' => 'group','value' => '1']);
        DB::table('settings')->insert(['setting' => 'partners_title', 'group' => 'group','value' => 'Our Partners']);
        DB::table('settings')->insert(['setting' => 'partners_subtitle', 'group' => 'group','value' => 'Lorem ipsum']);

        DB::table('settings')->insert(['setting' => 'press', 'group' => 'group','value' => '1']);
        DB::table('settings')->insert(['setting' => 'press_title', 'group' => 'group','value' => 'On Press']);
        DB::table('settings')->insert(['setting' => 'press_subtitle', 'group' => 'group','value' => 'Lorem ipsum']);

        DB::table('settings')->insert(['setting' => 'roadmap', 'group' => 'group','value' => '1']);
        DB::table('settings')->insert(['setting' => 'contact_form', 'group' => 'group','value' => '1']);
        DB::table('settings')->insert(['setting' => 'subscribe', 'group' => 'group','value' => '1']);
        //ICO Settings
        DB::table('settings')->insert(['setting' => 'status', 'group' => 'group','value' => '1']);
        DB::table('settings')->insert(['setting' => 'token_name', 'group' => 'group','value' => 'FUTURX']);
        DB::table('settings')->insert(['setting' => 'token_symbol', 'group' => 'group','value' => 'FTX']);
        DB::table('settings')->insert(['setting' => 'decimal', 'group' => 'group','value' => '3']);
        //MLM Settings
        DB::table('settings')->insert(['setting' => 'mlm_status', 'group' => 'mlm','value' => '1']);
        DB::table('settings')->insert(['setting' => 'mlm_levels', 'group' => 'mlm','value' => '5']);
        //System Settings
        DB::table('settings')->insert(['setting' => 'welcome_message', 'group' => 'group','value' => 'We are happy to see you among us.']);
        //Email Sending Settings
        DB::table('settings')->insert(['setting' => 'mail_service', 'group' => 'group','value' => 'smtp']);
        DB::table('settings')->insert(['setting' => 'mail_from_name', 'group' => 'group','value' => 'FuturX']);
        DB::table('settings')->insert(['setting' => 'mail_from_address', 'group' => 'group','value' => 'mail@ilkerkocatepe.com.tr']);
            //SMTP
            DB::table('settings')->insert(['setting' => 'smtp_host', 'group' => 'group','value' => 'ilkerkocatepe.com.tr']);
            DB::table('settings')->insert(['setting' => 'smtp_port', 'group' => 'group','value' => '465']);
            DB::table('settings')->insert(['setting' => 'smtp_encryption', 'group' => 'group','value' => 'ssl']);
            DB::table('settings')->insert(['setting' => 'smtp_username', 'group' => 'group','value' => 'mail@ilkerkocatepe.com.tr']);
            DB::table('settings')->insert(['setting' => 'smtp_password', 'group' => 'group','value' => 'Yalovax*2020']);
            //Mailgun
            DB::table('settings')->insert(['setting' => 'mailgun_domain', 'group' => 'group','value' => '']);
            DB::table('settings')->insert(['setting' => 'mailgun_secret', 'group' => 'group','value' => '']);
            DB::table('settings')->insert(['setting' => 'mailgun_endpoint', 'group' => 'group','value' => 'api.eu.mailgun.net']);
            //Postmark
            DB::table('settings')->insert(['setting' => 'postmark_token', 'group' => 'group','value' => '']);
            //SES
            DB::table('settings')->insert(['setting' => 'ses_key', 'group' => 'group','value' => '']);
            DB::table('settings')->insert(['setting' => 'ses_secret', 'group' => 'group','value' => '']);
            DB::table('settings')->insert(['setting' => 'ses_region', 'group' => 'group','value' => 'us-east-1']);
        //Profile Settings
        DB::table('settings')->insert(['setting' => 'address_information', 'group' => 'group','value' => '1']);
        DB::table('settings')->insert(['setting' => 'mobile_information', 'group' => 'group', 'value' => '1']);
    }
}
