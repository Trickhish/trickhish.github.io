<?php

$config = array(
    "digest_alg" => "sha512",
    "private_key_bits" => 1024,
    "private_key_type" => OPENSSL_KEYTYPE_RSA,
);

$private_key = openssl_pkey_new();
$pub_key = openssl_pkey_get_details($private_key)['key'];
openssl_pkey_export($private_key, $priv_key);

//echo($priv_key."<br/><br/>");
//echo($pub_key);

$data = "coucou";

openssl_public_encrypt($data,$encrypted,$pub_key,OPENSSL_PKCS1_PADDING);

echo("encrypted : ".$encrypted);

openssl_private_decrypt($encrypted,$decrypted,$priv_key,OPENSSL_PKCS1_PADDING);

echo("decrypted : ".$decrypted);

?>