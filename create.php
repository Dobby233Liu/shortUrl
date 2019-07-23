<?php

/**
 * @Author: Ding Jianlong
 * @Date:   2019-03-20 22:39:04
 * @Last Modified by:   Ding Jianlong
 * @Last Modified time: 2019-03-20 23:42:37
 */


error_reporting(E_ALL ^ E_NOTICE);//显示除去 E_NOTICE 之外的所有错误信息
$config = array(
	'site' => "https://d2l.uk-linux.cnidc.co",  //短网址域名
	//不允许缩短的域名，单个匹配，*表示所有的二级域名
	'key' => "145170dif",                             //token 使用的密钥

	//根据需求修改
	'use_rewrite' => 1
);

//生成大小写字母和数字随机字符串
function createId($len){
    //大小写字母和数字混用
    $str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $key = '';
    for($i = 0;$i < $len;$i++){
        $key .= $str{mt_rand(0,strlen($str)-1)};
    }
    return $key;
}

//查看随机生成的id 是否已经被占用,占用重新生成，递归
function checkId($arr,$id){
    if(!isset($arr[$id])){
        return $id;
    }else{
        $id = createId(6);
        return checkId($arr,$id);
    }
}


$saveFile = 'urls.php';

$keyshit = trim($_POST["sig"]);
// 检查本地文件是否可读写
if (!is_writable($saveFile) || !is_readable($saveFile)) {
    die('chmod 777 urls.php');
}

//引入保存网址的php文件
$arr = require $saveFile;

// 判断是生成还是跳转
@$id = trim($_GET['id']);
if ($id) {
    $message = "";
    //跳转
    if ($arr[$id]) {
        header('Location:' . $arr[$id]);
    }
    $message = "not found " . $id;
    echo $message;
    exit();
} else {
    //生成
    $url = trim($_POST['url']);
    if ($url == '') {
        $message = 'nourl';
        echo $message;
        exit();
    }
    //判断是否正则为正确的网址
    $regex = "/^(https?:\/\/)([\w-]+\.)+[\w-]+(\/[\w-.\/?%&=#]*)?$/i";
    if (!preg_match($regex, $url)) {
        $message = 'bad url';
        echo $message;
        exit();
    }
    //判断是否是黑名单域名
    
    //检查是否已存在重复网址
    $find = array_search($url, $arr);
    if ($find !== false) {
        $id = $find;   //返回之前的短网址
    } else {
        //原来没有新插入
        $id = createId(6);    //随机生成5位小数字母+数字
        if(isset($keyshit) && $keyshit != '') $id=$keyshit;
        $id = checkId($arr, $id);
        //原来没有新插入
        $arr[$id] = $url;
        $a = '<?php' . PHP_EOL . 'return ' . var_export($arr, true) . ';';
        file_put_contents($saveFile, $a);
    }
    $message = "success<br>";
    $shortUrl = ($config['use_rewrite'] == 1) ? "{$config['site']}/{$id}" : "{$config['site']}/create.php?id={$id}";
    echo $message;
    echo "<img src='genqr.php?c=".$shortUrl."'><br>";
    echo "url: <a href='".$shortUrl."'>".$shorturl."</a>";
    exit();
}
