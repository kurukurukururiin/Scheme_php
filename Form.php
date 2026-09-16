<?php
require_once 'User.php';
require_once 'UserRepo.php';

$mesaj = "";
$hataVar = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $isim = htmlspecialchars($_POST['isim'] ?? "");
    $email = htmlspecialchars($_POST['email'] ?? "");
    $sifre = htmlspecialchars($_POST['sifre'] ?? "");

    if (empty($isim) || empty($email) || empty($sifre)) {
        $mesaj = "Kayıt Başarısız: Lütfen tüm alanları doldurun.";
        $hataVar = true;
    } else {
        try {
            $repo = new UserRepository('users.json');
            $rastgeleId = rand(1000, 9999);
            
            $yeniKullanici = new User($rastgeleId, $isim, $email, $sifre);
            
            $repo->save($yeniKullanici);
            
            $mesaj = "Harika! Kaydınız başarıyla oluşturuldu. Hoş geldin, {$isim}!";
            $hataVar = false;

        } catch (Exception $e) {
            $mesaj = "Kayıt Başarısız: " . $e->getMessage();
            $hataVar = true;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Sisteme Kayıt Ol</title>
    <style>
        body { font-family: sans-serif; background-color: #f4f4f9; display: flex; justify-content: center; padding-top: 50px; }
        .form-kutusu { background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); width: 350px; }
        .form-kutusu h2 { margin-top: 0; color: #333; text-align: center; }
        .form-grup { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; color: #555; }
        input { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background-color: #28a745; color: white; border: none; border-radius: 4px; font-size: 16px; cursor: pointer; }
        button:hover { background-color: #218838; }
        
        /* Hata ve Başarı mesajları için dinamik stiller */
        .bildirim { padding: 15px; margin-bottom: 20px; border-radius: 4px; text-align: center; }
        .basari { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .hata { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    </style>
</head>
<body>

    <div class="form-kutusu">
        <h2>Yeni Kayıt</h2>

        <?php if ($mesaj !== ""): ?>
            <div class="bildirim <?php echo $hataVar ? 'hata' : 'basari'; ?>">
                <?php echo $mesaj; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-grup">
                <label for="isim">Adınız Soyadınız</label>
                <input type="text" id="isim" name="isim" required placeholder="Örn: Ege Kuru">
            </div>

            <div class="form-grup">
                <label for="email">E-Posta Adresiniz</label>
                <input type="text" id="email" name="email" required placeholder="ornek@mail.com">
            </div>

            <div class="form-grup">
                <label for="sifre">Şifreniz</label>
                <input type="password" id="sifre" name="sifre" required placeholder="Gizli şifreniz">
            </div>

            <button type="submit">Kayıt Ol</button>
        </form>
    </div>

</body>
</html>