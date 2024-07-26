<?php
include "captcha.php";

if(isset($_REQUEST['captcha'])){
    if (Captcha::check($_REQUEST['captcha'])) {
        echo "Captcha is correct";
    } else {
        echo "Captcha is incorrect";
    }
} else {
    Captcha::show();
}
