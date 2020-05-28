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
        <title>Hello LINE BOT</title>
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
            // $word= "intercourse";
            $word = "secretary";
            // $word = "hydropower";
            // $word = "beckon";
            // $word = "benign";
            // $word = "dubious";

            $url = "https://dictionary.cambridge.org/zht/詞典/英語-漢語-繁體/".$word;
            $page = file_get_contents($url);
            // echo $page;
            if ($page) {
                libxml_use_internal_errors(true);

                $dom = new DOMDocument();
                $dom->loadHTML($page);
                $xpath = new DOMXPath($dom);
                $nodes = $xpath->query("//div[contains(@class,'def-block')]");

                $count = $nodes->length;

                echo "<p>Nodes def-block:$count</p>";
                if ($count>0) {
                    foreach ($nodes as $node) {

                        // echo "node:".gettype($node);
                        // var_dump($node);
                        // 中文解釋

                        // $cts = getElementsByClassName($node, 'def', 'div');
                        $divs = $node->getElementsByTagName('div');

                        foreach ($divs as $div) {
                            $divclstr = $div->attributes->getNamedItem('class')->nodeValue;
                            if ($divclstr=="def ddef_d db") {
                                echo "[ENG]".$div->textContent;
                            } elseif ($divclstr == "def-body ddef_b") {
                                $ts = $div -> getElementsByTagName('span');
                                echo "<br>[CHT]".$ts[0]->textContent;
                                $exs = $div -> getElementsByTagName('div');
                                foreach ($exs as $ex) {
                                    echo "<br> - ".$ex->textContent;
                                }
                            }
                        }

                        echo "<hr>";

                    }
                    echo '<p>資料來源(劍橋詞典):<a href="'.$url.'" target="_blank">'.$url.'</a></p>';
                } else {
                    echo "查無此字:".$word;
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