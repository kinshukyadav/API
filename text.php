<?php
  require_once 'header.php';
  function isvalidRequest($apikey, $enc, $url){
       $result = queryMySQL("SELECT * FROM members WHERE apikey='$apikey'");
    if ($result->num_rows == 0){
        echo "Unauthorised Request";
      }
      else{
          $result->data_seek(0);
          $privatekey = $result->fetch_assoc()['privatekey'];
          $enchere = hash('ripemd128', "$privatekey$url");
          if($enchere==$enc)
              return true;
  }
  }

if(isset($_GET['apikey']) && isset($_GET['enc']) && isset($_GET['url'])){
    $apikey = $_GET['apikey'];
    $enc = $_GET['enc'];
    $url = $_GET['url'];
    $sp = $_GET['sp'];
    
    if(isvalidRequest($apikey, $enc, $url)){
          $json = file_get_contents("https://api.havenondemand.com/1/api/sync/ocrdocument/v1?url=http://ankitmishra2215.hostoi.com/Ankit.jpg&apikey=80c9b8ee-24be-46b6-9ebf-6b90bc09fef9");
$array = json_decode($json,true);
$s = $array['text_block'][0]['text'];
         echo $s."<br>";
/*$needle  = 'apos;';
$replace = "'";
$s = str_replace($needle, $replace, $s);
for($i = 0;$i<strlen($s);$i++){
    if($s[$i]=="\n" || $s[$i]=="&" || $s[$i]=";"){
        $s[$i]=" ";
    }
}
        echo $s."<br>";*/
$url = "https://translate.yandex.net/api/v1.5/tr.json/translate?key=trnsl.1.1.20160219T121442Z.c5fc9df1cad7d7a6.e9b1b23f95b8ba39171cc50867fa24931feb8d38&text=".$s."&lang=en&options=1";
if($sp=='n')        
echo file_get_contents($url);
        else {
            $json_translated = file_get_contents($url);
            $array_translated = json_decode($json_translated,true);
            echo "<audio src='http://api.voicerss.org/?key=16f97f3ea525467cad4c431c9d18a64b&src=".$array_translated['text'][0]."&hl=en-us&r=-3' autoplay>
  Your browser does not support the <code>audio</code> element.
</audio>";
            
        }
echo "<br><a href='http://translate.yandex.com/'>Powered by Yandex.Translate</a>";
      }
    
    else{
        echo "Unauthorised request";
    }
}

else{
   echo "Lacking required parameters to access this url";
}
?>
