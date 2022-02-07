<?php

function getkeys($length){
    $config = array(
        "digest_alg" => "sha512",
        "private_key_bits" => $length,
        "private_key_type" => OPENSSL_KEYTYPE_RSA,
    );

    $private_key = openssl_pkey_new();
    $pub_key = openssl_pkey_get_details($private_key)['key'];
    openssl_pkey_export($private_key, $priv_key);

    return(array($priv_key,$pub_key));
}

function gen_token($l=20){
   return substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789"), 10, $l);
}

$a = $_POST['a'];
$mail = $_POST['m'];
$pass = $_POST['p'];
$nick = $_POST['n'];
$pubkey = $_POST['pk'];

if (empty($a)){
    $a=$_GET['a'];
}
if (empty($mail)){
    $mail=$_GET['m'];
}
if (empty($pass)){
    $pass=$_GET['p'];
}
if (empty($nick)){
    $nick=$_GET['n'];
}
if (empty($pubkey)) {
    $pubkey = $_GET['pk'];
}

if ($a == 'auth') {
    $bdd = mysqli_connect("mysql-trickish.alwaysdata.net", "trickish", "C216200310", "trickish_palabre");

    $result = $bdd->query("SELECT nickname,confirmed FROM users WHERE email='".$mail."' AND password='".$pass."'");

    if ($result->num_rows < 1) {
        echo("false");
    } else {
        $bdd->query("UPDATE users SET pub_key='".$pubkey."' WHERE email='".$mail."'");
        $rs = $result->fetch_array(MYSQLI_NUM);
        echo($rs[0].$rs[1]);
    }
} else if ($a == 'reg') {
    $bdd = mysqli_connect("mysql-trickish.alwaysdata.net", "trickish", "C216200310", "trickish_palabre");

    $result = $bdd->query("SELECT nickname FROM users WHERE email='".$mail."'");

    if ($result->num_rows != 0) {
        echo("email_taken");
    } else {
        $bdd->query("INSERT INTO users (email,nickname,password,confirmed,pub_key) VALUES ('".$mail."','".$nick."','".$pass."',0,'".$pubkey."')");
        $result=$bdd->query("SELECT nickname FROM users WHERE email='".$mail."'");
        if ($result->num_rows != 0) {
            echo("success");
        } else {
            echo("failed");
        }
    }
} else if ($a == "token") {
    $bdd = mysqli_connect("mysql-trickish.alwaysdata.net", "trickish", "C216200310", "trickish_palabre");

    $result = $bdd->query("SELECT nickname FROM users WHERE email='".$mail."' AND password='".$pass."'");

    if ($result->num_rows < 1) {
        echo("false");
    } else {
        $t = gen_token(20);
        $bdd->query("UPDATE users SET token='".$t."' WHERE email='".$mail."'");
        echo($t);
    }
}

?>