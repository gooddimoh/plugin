<?php

/*
* API key: 1513890
* API Secret: BTdPBZktbsH
* Associate ID: 10108950
* lkid: 20138277
* */

ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
error_reporting(0); // Disable all errors.

class GearBestPHP
{
    private $api_key, $api_secret, $currency;

    public function __construct($api_key, $api_secret, $currency = 'EUR')
    {
        $this->api_key = $api_key;
        $this->api_secret = $api_secret;
        $this->currency = $currency;
    }

    private function httprequest($method, $args)
    {
        $args['api_key'] = $this->api_key;
        $args['time'] = time();
        ksort($args);
        $str = '';
        foreach ($args as $key => $val) {
            $str .= $key . $val;
        }
        $args['sign'] = strtoupper(md5($this->api_secret . $str . $this->api_secret));
        $c = curl_init();
        curl_setopt($c, CURLOPT_HEADER, 0);
        curl_setopt($c, CURLOPT_URL, 'https://affiliate.gearbest.com/api/' . $method . '?' . http_build_query($args));
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        $r = curl_exec($c);
        curl_close($c);
        return json_decode($r, true);
    }

    public function getCompletedOrders($start_date, $end_date, $status = NULL, $page = NULL)
    {
        $args = [
            'start_date' => $start_date,
            'end_date' => $end_date
        ];
        if (isset($status)) $args['status'] = $status;
        if (isset($page)) $args['page'] = $page;
        return $this->httprequest('orders/completed-orders/', $args);
    }

    public function listPromotionProduct($lkid = NULL, $page = NULL, $keywords = NULL, $category = NULL)
    {
        $args = [
            'currency' => $this->currency
        ];
        if (isset($lkid)) $args['lkid'] = $lkid;
        if (isset($page)) $args['page'] = $page;
        if (isset($keywords)) $args['keywords'] = $keywords;
        if (isset($category)) $args['category'] = $category;
        return $this->httprequest('products/list-promotion-products/', $args);
    }

    public function listEventCreative($type, $lkid = NULL, $page = NULL, $language = NULL, $size = NULL, $category = NULL)
    {
        $args = [
            'type' => $type
        ];
        if (isset($lkid)) $args['lkid'] = $lkid;
        if (isset($page)) $args['page'] = $page;
        if (isset($language)) $args['language'] = $language;
        if (isset($size)) $args['size'] = $size;
        if (isset($category)) $args['category'] = $category;
        return $this->httprequest('banner/list-event-creative/', $args);
    }

    public function listProductCreative($type, $lkid = NULL, $category = NULL, $page = NULL)
    {
        $args = [
            'type' => $type
        ];
        if (isset($lkid)) $args['lkid'] = $lkid;
        if (isset($category)) $args['category'] = $category;
        if (isset($page)) $args['page'] = $page;
        return $this->httprequest('promotions/list-product-creative/', $args);
    }

    public
    function listCoupons($lkid = NULL, $language = NULL, $category = NULL, $page = NULL)
    {
        $args = [];
        if (isset($lkid)) $args['lkid'] = $lkid;
        if (isset($language)) $args['language'] = $language;
        if (isset($category)) $args['category'] = $category;
        if (isset($page)) $args['page'] = $page;
        return $this->httprequest('coupon/list-coupons/', $args);
    }

    //$urls and $link_names must be arrays
    public function getPromotionLinks($associate_id, $urls, $link_names = NULL)
    {
        $str_urls = '';
        foreach ($urls as $val2) {
            if ($str_urls == '')
                $str_urls = $str_urls . $val2;
            else
                $str_urls = $str_urls . ',' . $val2;
        }
        $args = [
            'associate_id' => $associate_id,
            'urls' => $str_urls
        ];
        if (isset($link_names)) {
            $str_link_names = '';
            foreach ($link_names as $val3) {
                if ($str_link_names == '')
                    $str_link_names = $str_link_names . $val3;
                else
                    $str_link_names = $str_link_names . ',' . $val3;
            }
            $args['link_names'] = $str_link_names;
        }
        return curlRequest('promotions/get-promotion-links/', $args);
    }
}

$apikey = $_POST["api_key"];
$api_secret = $_POST["api_secret"];
$currency = $_POST["currency"];
$lkid = $_POST["lkid"];
$language = $_POST["language"];
$category = $_POST["category"];
$page = $_POST["page"];

$request = new GearBestPHP($apikey, $api_secret, $currency);
?>

<style>
    .wrapper {
        width: 100%;
        margin: 10px auto;
    }
</style>

<table id="table" style="margin:0;" role="grid"
       aria-describedby="example_info">
    <thead>
    <tr>
        <!--        <th>image</th>-->
        <!--        <th>coupon_name</th>-->
        <!--        <th>coupon_code</th>-->
    </tr>
    </thead>
    <tbody>
    <?php

    for ($i = 1; $i < $page; $i++) {
        $res = $request->listCoupons($lkid, $language, $category, $i);
        $file = fopen("file.csv", 'r+w');
        foreach ($res["data"] as $fields) {
            foreach ($fields as $fitem) {
                fputcsv($file, $fitem);
            }
        }
    }

    $file = fopen("file.csv", 'r+w');
    $i = 0;

    while (($row = fgetcsv($file, 0, ",")) !== FALSE) {
        $i++;
        echo '<tr>';
        if (empty($row[11])) {
      // echo '<td><img style="width: 100px; height:100px" src="noimg.jpg" alt=""></td>'; //
            continue;
        } else {
            echo '<td> <img src="' . $row[11] . '" style="width: 100px; height: 100px"></td>';
        }

        $subject = $row[0];
        $res = preg_split('/\$(\d+\.\d+)/', $subject);
        echo '<td><a rel="nofollow noopener" href="' . $row[8] . '">' . $res[0] . '</a></td>';
        echo '<td>' . $row[3] . '</td>';
        echo '</tr>';
        if ($i >= 10) {
            break;
        }
    }

    ?>
    </tbody>
</table>
