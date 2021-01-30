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
        DB::table('settings')->insert(['setting' => 'title','value' => 'FuturX ICO']);
        DB::table('settings')->insert(['setting' => 'subtitle','value' => 'FuturX Initial Coin Offering']);
        DB::table('settings')->insert(['setting' => 'support_email','value' => 'support@futurx.space']);
        DB::table('settings')->insert(['setting' => 'base_url','value' => 'http://ico.test']);
        DB::table('settings')->insert(['setting' => 'logo','value' => '/files/logos/logo.png']);
        DB::table('settings')->insert(['setting' => 'favicon','value' => '/files/logos/favicon.png']);
        DB::table('settings')->insert(['setting' => 'token_icon','value' => '/files/logos/token_icon.png']);
        DB::table('settings')->insert(['setting' => 'GOOGLE_CAPTCHA_PUBLIC_KEY','value' => '6LcE-BoaAAAAAC6VsbTHr9MsOm0NgkcKvv3aFjun']);
        DB::table('settings')->insert(['setting' => 'GOOGLE_CAPTCHA_PRIVATE_KEY','value' => '6LcE-BoaAAAAALlYPE7LznuHIlpX9ZvCXTvcjLtK']);
        //SEO Settings
        DB::table('settings')->insert(['setting' => 'indexable','value' => '0']);
        DB::table('settings')->insert(['setting' => 'description','value' => 'Initial Coin Offering Description']);
        DB::table('settings')->insert(['setting' => 'keywords','value' => 'Initial,Coin,Offering']);
        //Contact Settings
        DB::table('settings')->insert(['setting' => 'contact_email','value' => 'info@futurx.space']);
        DB::table('settings')->insert(['setting' => 'contact_phone','value' => '+14582410011']);
        //Front Settings
        DB::table('settings')->insert(['setting' => 'banner_title','value' => 'FUTURX']);
        DB::table('settings')->insert(['setting' => 'banner_subtitle','value' => 'is your future.']);
        DB::table('settings')->insert(['setting' => 'banner_details','value' => 'bla bla bla']);
        DB::table('settings')->insert(['setting' => 'video','value' => 'https://www.youtube-nocookie.com/']);

        DB::table('settings')->insert(['setting' => 'about','value' => '1']);
        DB::table('settings')->insert(['setting' => 'about_title','value' => 'About us']);
        DB::table('settings')->insert(['setting' => 'about_subtitle','value' => 'what about']);
        DB::table('settings')->insert(['setting' => 'about_content','value' => 'Lorem ipsum']);

        DB::table('settings')->insert(['setting' => 'partners','value' => '1']);
        DB::table('settings')->insert(['setting' => 'partners_title','value' => 'Our Partners']);
        DB::table('settings')->insert(['setting' => 'partners_subtitle','value' => 'Lorem ipsum']);

        DB::table('settings')->insert(['setting' => 'press','value' => '1']);
        DB::table('settings')->insert(['setting' => 'press_title','value' => 'On Press']);
        DB::table('settings')->insert(['setting' => 'press_subtitle','value' => 'Lorem ipsum']);

        DB::table('settings')->insert(['setting' => 'roadmap','value' => '1']);
        DB::table('settings')->insert(['setting' => 'contact_form','value' => '1']);
        DB::table('settings')->insert(['setting' => 'subscribe','value' => '1']);
        //ICO Settings
        DB::table('settings')->insert(['setting' => 'status','value' => '1']);
        DB::table('settings')->insert(['setting' => 'token_name','value' => 'FUTURX']);
        DB::table('settings')->insert(['setting' => 'token_symbol','value' => 'FTX']);
        DB::table('settings')->insert(['setting' => 'decimal','value' => '3']);
        //MLM Settings
        /*DB::table('settings')->insert(['setting' => 'status','value' => '1']);
        DB::table('settings')->insert(['setting' => 'levels','value' => '5']);
        DB::table('settings')->insert(['setting' => 'parent_minimum','value' => '1000']);
        DB::table('settings')->insert(['setting' => 'child_minimum','value' => '1000']);
        DB::table('settings')->insert(['setting' => 'level_x_com','value' => '10']); */
        //System Settings
        DB::table('settings')->insert(['setting' => 'welcome_message','value' => 'We are happy to see you among us.']);
        //Email Sending Settings
        DB::table('settings')->insert(['setting' => 'mail_service','value' => 'smtp']);
        DB::table('settings')->insert(['setting' => 'mail_from_name','value' => 'FuturX']);
        DB::table('settings')->insert(['setting' => 'mail_from_address','value' => 'mail@ilkerkocatepe.com.tr']);
            //SMTP
            DB::table('settings')->insert(['setting' => 'smtp_host','value' => 'ilkerkocatepe.com.tr']);
            DB::table('settings')->insert(['setting' => 'smtp_port','value' => '465']);
            DB::table('settings')->insert(['setting' => 'smtp_encryption','value' => 'ssl']);
            DB::table('settings')->insert(['setting' => 'smtp_username','value' => 'mail@ilkerkocatepe.com.tr']);
            DB::table('settings')->insert(['setting' => 'smtp_password','value' => 'Yalovax*2020']);
            //Mailgun
            DB::table('settings')->insert(['setting' => 'mailgun_domain','value' => '']);
            DB::table('settings')->insert(['setting' => 'mailgun_secret','value' => '']);
            DB::table('settings')->insert(['setting' => 'mailgun_endpoint','value' => 'api.eu.mailgun.net']);
            //Postmark
            DB::table('settings')->insert(['setting' => 'postmark_token','value' => '']);
            //SES
            DB::table('settings')->insert(['setting' => 'ses_key','value' => '']);
            DB::table('settings')->insert(['setting' => 'ses_secret','value' => '']);
            DB::table('settings')->insert(['setting' => 'ses_region','value' => 'us-east-1']);
        //Profile Settings
        DB::table('settings')->insert(['setting' => 'address_information','value' => '1']);
        DB::table('settings')->insert(['setting' => 'mobile_information', 'value' => '1']);
    }
}
