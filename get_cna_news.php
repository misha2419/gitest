<?php
function getElementsByClassName($dom, $ClassName, $tagName=null) {
    if($tagName){
        $Elements = $dom->getElementsByTagName($tagName);
    }else {
        $Elements = $dom->getElementsByTagName("*");
    }
    $Matched = array();
    for($i=0;$i<$Elements->length;$i++) {
        if($Elements->item($i)->attributes->getNamedItem('class')){
            if($Elements->item($i)->attributes->getNamedItem('class')->nodeValue == $ClassName) {
                $Matched[]=$Elements->item($i);
            }
        }
    }
    return $Matched;
}
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>中央社即時新聞</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <h1>Hello Line bot</h1>
        <p>今天是 <?php echo date("Y m d"); ?></p>
        <?php

            $url = "https://www.cna.com.tw/list/aall.aspx";
            $page = file_get_contents($url);
            // echo $page;

            if ($page) {

                libxml_use_internal_errors(true);

                $dom = new DOMDocument();
                //$dom -> loadHTML($page);
                $dom -> loadHTML(mb_convert_encoding($page, 'HTML-ENTITIES', 'UTF-8'));

                echo "<h1>中央社即時新聞</h1>";
                // 用 tag 名稱擷取
                $main = $dom->getElementById('jsMainList');
                $lists = $main->getElementsByTagName('li');

                $i=1;
                foreach ($lists as $node) {
                    
                    // 取得標題文字
                    $ntxts = $node -> getElementsByTagName('span');
                    $ntxt  = $ntxts[0]->textContent;

                    // 取得超連結
                    $links = $node->getElementsByTagName('a');
                    $href  = $links[0]->getAttribute('href');
                    
                    // 取得日期時間
                    $ndate = getElementsByClassName($node, 'date');
                    $sdate = $ndate[0]->textContent;

                    // 顯示結果
                    echo "<p>".strval($i).".".$sdate." ".$ntxt."(".$href.")</p>";
                    $i++;
                }

                libxml_clear_errors();
            } else {
                echo "無法取得網頁";
            }

            /*
            $doc = new DOMDocument();
            $doc -> loadHTML(mb_convert_encoding($page, 'HTML-ENTITIES', 'UTF-8'));
            echo $doc->saveHTML();
            */

        ?>
    </body>
</html>