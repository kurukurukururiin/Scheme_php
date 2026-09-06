<?php

require_once 'User.php';
require_once 'AdminUser.php';
require_once 'UserRepo.php';

$admin = new AdminUser(1, "Ege Kuru", "ege@example.com", "sifre123");

if ($admin->requires2FA()) {
    echo "2FA gerekiyor.<br>";
} else {
    echo "2FA gerekmiyor (Varsayılan).<br>";
}

echo "Admin kullanıcısı başarıyla oluşturuldu: " . $admin->getName() . "";
?>