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
        <title>台灣彩卷-威力彩</title>
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

            $url = "https://www.taiwanlottery.com.tw";
            $page = file_get_contents($url);
            // echo $page;

            if ($page) {

                libxml_use_internal_errors(true);

                $dom = new DOMDocument();
                // $dom -> loadHTML(mb_convert_encoding($page, 'HTML-ENTITIES', 'UTF-8'));
                $dom->loadHTML($page);
                $xpath = new DOMXPath($dom);
                $tables = $xpath->query("//table[contains(@class,'tableWin')]");

                // $count = $tables->length;
                // echo "count: $count";

                echo "<h1>台灣彩卷</h1>";

                echo "<hr>";
                $items = $tables[0]->getElementsByTagName('td');
                echo "<p>名稱".$items[1]->textContent."</p>";
                echo "<p>期別".$items[3]->textContent."</p>";
                echo "<p>開獎日期".$items[5]->textContent."</p>";
                echo "<p>兌獎期限".$items[7]->textContent."</p>";
                // echo "<p>中獎號碼".$items[9]->textContent."</p>";
                $nums = $items[9]->getElementsByTagName('span');
                echo "<p>中獎號碼(1) ".$nums[0]->textContent.", ";
                echo $nums[1]->textContent.",";
                echo $nums[2]->textContent.",";
                echo $nums[3]->textContent.",";
                echo $nums[4]->textContent.",";
                echo $nums[5]->textContent;
                echo " (2) ".$nums[6]->textContent."</p>";

                echo "<hr>";
                $items = $tables[1]->getElementsByTagName('td');
                echo "<p>名稱".$items[1]->textContent."</p>";
                echo "<p>期別".$items[3]->textContent."</p>";
                echo "<p>開獎日期".$items[5]->textContent."</p>";
                echo "<p>兌獎期限".$items[7]->textContent."</p>";
                // echo "<p>中獎號碼".$items[9]->textContent."</p>";
                $nums = $items[9]->getElementsByTagName('span');
                echo "<p>中獎號碼 ".$nums[0]->textContent.", ";
                echo $nums[1]->textContent.",";
                echo $nums[2]->textContent.",";
                echo $nums[3]->textContent.",";
                echo $nums[4]->textContent.",";
                echo $nums[5]->textContent;
                echo " 特別號 ".$nums[6]->textContent."</p>";

                echo "<hr>";
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