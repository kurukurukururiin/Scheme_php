<?php

require_once 'User.php';
require_once 'AdminUser.php';
require_once 'UserRepo.php';

$repo = new UserRepository('users.json');

try {
    $hataliKullanici = new User(2, "E", "yanlis_email_formati", "123456");
    
    $repo->save($hataliKullanici);
    
    echo "Kullanıcı başarıyla kaydedildi!";
} catch (Exception $e) {
    echo "<b>Sistem Hatası Yakalandı:</b> " . $e->getMessage();
}

?>