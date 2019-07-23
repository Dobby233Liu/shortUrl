<?php

/**
 * @Author: Ding Jianlong
 * @Date:   2019-03-20 22:39:26
 * @Last Modified by:   Ding Jianlong
 * @Last Modified time: 2019-03-20 23:52:39
 */

error_reporting(E_ALL ^ E_NOTICE);//显示除去 E_NOTICE 之外的所有错误信息
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>
        link shortener
    </title>
</head>
<body>
<h1>url shortener</h1>
	    <form id="main" action="create.php" method="post">
	            <div>
	                <label for="url">addr：</label>
	                <input type="text" name="url" id="url" placeholder="http:// or https://">
	                <input type="text" name="sig" id="uuu" placeholder="key">
	                <br>
	               
	            </div>
	            
	            <button id="submit" type="button">create</button>
	    </form>
</body>
</html>
