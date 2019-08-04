<?php if(isset($_COOKIE["d2ls.s_nolist"])) return; ?>
<style>
body{
    font-family: arial, sans-serif;
    margin:0;
}
table {
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
<meta http-equiv="refresh" content="5">

<h1>Shortened URLs list</h1>
<table>
  <tr>
    <th>id</th>
    <th>url</th>
  </tr>
<?php
    function truncate($text, $chars = 25) {
        if (strlen($text) <= $chars) {
            return $text;
        }
        $text2=$text;
        $text2 = $text2." ";
        $text2 = substr($text2,0,$chars);
        $text2 = substr($text2,0,strrpos($text2,' '));
        $text2 = $text2."...";
        return $text2;
    }
    function build_table($array){
        $i=0;
        while($i<count($array)){
        $html .= '  <tr>'."\n";
        $key=array_keys($array)[$i];
        if($key!==''){ 
        $value=$array[$key];
        $value2=truncate($array[$key]);
        $html .= '      <td>' . $key . '</td>'."\n";
        $html .= '      <td><a href=' . $value . '>'.$value2.'</a></td>'."\n";
        $html .= '  </tr>'."\n";
        }
        $i=$i+1;
        }
    return $html;
}

if(!isset($_COOKIE["_d2ls.ml_s_nolist"])) echo build_table(require 'urls.php');
?>
</table>