<?php
/**
 * @package gearbestplugin-plugin
 */

/*
 Plugin Name: gearbestplugin-plugin
 Plugin URI:  http://example.com
 */
defined('ABSPATH') or die('Hey, what are you doing here? you silly human!');

class gearbestplugin
{
    public function __construct()
    {
        add_action("admin_menu", "addMenu");
    }

    function activate()
    {
        flush_rewrite_rules();
    }

    function deactivate()
    {
        flush_rewrite_rules();

    }

    function uninstall()
    {
    }

///last update
}

if (class_exists('gearbestplugin')) {
    $sms_check_plugin = new gearbestplugin('Check Plugin initialized!');
}

// activation
register_activation_hook(__FILE__, array($sms_check_plugin, 'activate'));

// deactivation
register_deactivation_hook(__FILE__, array($sms_check_plugin, 'deactivate'));

// uninstall 
register_activation_hook(__FILE__, array($sms_check_plugin, 'activate'));

add_action("admin_menu", "addMenu");

function addMenu(){
    add_menu_page("cupons", "cupons", 4, "cupons", "cupons");
}

function foobar_func($atts){
    return "foo and bar";
}

add_shortcode( 'foobar', 'foobar_func' );


function Menu(){}


function foobar_shortcode(){
    return "date";
}


function cupons(){
    echo "<body> 
        <style>
            ul {
                list-style: none;
                padding: 0;
                margin: 10px;
            }

            button {
                margin: 10px;
            }


            table#table tr {
                border: 0px solid #000;
                text-align: center;
            }

            table#table tr td {
                border: 0px solid #000;
            }

            table#table th {
                text-transform: uppercase;
                text-align: center;
                border: 0px solid #000;
            }

            table#table img:hover {
                transform: none;
                top: 0vh;
                left: 0;
                border: 0px solid #000;
            }</style>
        <ul>
            <li><input type=\"text\" id=\"api_key\" name=\"api_key\" value=\"1513890\"><span>  api_key</span></li>
            <li><input type=\"text\" id=\"api_secret\" name=\"api_secret\" value=\"BTdPBZktbsH\"><span>  api_secret</span></li>
            <li><input type=\"text\" id=\"currency\" name=\"currency\" value=\"usd\"><span>  currency</span></li>
            <li><input type=\"text\" id=\"lkid\" name=\"lkid\" value=\"20138277\"><span>  lkid</span></li>
            <li><input type=\"text\" id=\"language\" name=\"language\" value=\"en\"><span>  language</span></li>
            <li><input type=\"text\" id=\"category\" name=\"category\" id=\"category\" value=\"11270\"><span> categoryID</span></li>
            <li>1<input type=\"range\" id=\"page\" name=\"page\" min=\"1\" max=\"100\" id=\"page\" name=\"page\" value=\"1\"
                        oninput=\"pageOutputId.value = page.value\">
                <output name=\"pageOutputName\" id=\"pageOutputId\">100</output>
                <span>page</span></li></ul> 
        <button type=\"submit\" id=\"gearbestreqeust\">Get a Result</button>
        <a href='/wp-content/plugins/gearbestplugin/file.csv'\>Get a CSV</a>
        <div class=\"wrapper\">
            <div id=\"result\">

            </div></div>
        <script src=\"https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js\"></script>
        <script>
            $(\"#gearbestreqeust\").click(function () {
                var apikey = $(\"#api_key\").val();  
                var apisecret = $(\"#api_secret\").val();
                var currency = $(\"#currency\").val();
                var lkid = $(\"#lkid\").val();
                var language = $(\"#language\").val();
                var category = $(\"#category\").val();
                var page = $(\"#page\").val();

                var request = $.ajax({
                    url: \"/wp-content/plugins/gearbestplugin/gearbest.php\",
                    method: \"POST\",
                    data: {
                        api_key: apikey,
                        api_secret: apisecret,
                        currency: currency,
                        lkid: lkid,
                        language: language,
                        category: category,
                        page: page
                    },
                    dataType: \"html\"
                });

                request.done(function (msg) {
                    $(\"#result\").html(msg);
                });

                request.fail(function (jqXHR, textStatus) {
                    alert(\"Request failed: \" + textStatus);
                });
            });
        </script>
        </body>";
}





