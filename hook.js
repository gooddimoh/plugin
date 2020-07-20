add_action('cuponsinit', 'my_cupons', 100);

function my_cupons()
{
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
        position: relative;
        top: 0vh;
        left: 0;
        border: 0px solid #000;
    }
</style>
<div class=\"wrapper\">
    <div id=\"result\">
    </div>
</div>
<script>
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
</script>
</body>
