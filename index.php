<?php
session_start();

require_once 'User.php';
require_once 'AdminUser.php';
require_once 'UserRepo.php';

$repo = new UserRepository('users.json');

$admin = new AdminUser(1, "Ege Kuru", "Egekuru2006@gmail.com", "12345qwerty");
$User = new User(2, "John Pork", "johnporj@proton.me", "porkpork1243");

$admin->enable2FA();
$repo->save($admin);
$repo->save($User);

$bulunan = $repo->findByEmail("Egekuru2006@gmail.com");

if ($bulunan) {
    $_SESSION['user_id'] = $bulunan->id;
    $_SESSION['user_name'] = $bulunan->getName();
    
    echo "Kullanıcı bulundu ve Session başlatıldı: " . $_SESSION['user_name'] . "<br>";
    
    if ($bulunan instanceof AdminUser && $bulunan->requires2FA()) {
        echo "DİKKAT: Bu bir yöneticidir ve 2FA doğrulaması zorunludur!";
    }
}
?>