<?php
$motdepasse = 'password';
$hash = password_hash($motdepasse, PASSWORD_DEFAULT);
echo $hash;
