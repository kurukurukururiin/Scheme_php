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
            
            header("Location: Upload.php");
            exit(); 

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
    body { 
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
        background-color: #f0f2f5; 
        margin: 0;
        height: 100vh;
        display: flex; 
        justify-content: center;
        align-items: center;
    }
    
    .form-kutusu { 
        background: #ffffff; 
        padding: 40px; 
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.1); 
        width: 350px; 
    }
    
    .form-kutusu h2 { 
        margin-top: 0; 
        margin-bottom: 25px;
        color: #1a1a1a; 
        text-align: center; 
        font-weight: 600;
    }
    
    .form-grup { 
        margin-bottom: 20px; 
    }
    
    label { 
        display: block; 
        margin-bottom: 8px; 
        font-weight: 500; 
        color: #4a4a4a; 
        font-size: 14px;
    }
    
    input { 
        width: 100%; 
        padding: 12px 15px; 
        border: 1px solid #dcdcdc; 
        border-radius: 8px;
        box-sizing: border-box; 
        font-size: 15px;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }
    
    input:focus {
        outline: none;
        border-color: #007bff;
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.15);
    }
    
    button { 
        width: 100%; 
        padding: 12px; 
        background-color: #007bff; 
        color: white; 
        border: none; 
        border-radius: 8px;
        font-size: 16px; 
        font-weight: bold;
        cursor: pointer; 
        transition: background-color 0.3s ease;
        margin-top: 10px;
    }
    
    button:hover { 
        background-color: #0056b3; 
    }
    
    /* Hata ve Başarı bildirimleri */
    .bildirim { 
        padding: 12px 15px; 
        margin-bottom: 20px; 
        border-radius: 8px; 
        text-align: center; 
        font-size: 14px;
        line-height: 1.4;
    }
    .basari { 
        background-color: #d1e7dd; 
        color: #0f5132; 
        border: 1px solid #badbcc; 
    }
    .hata { 
        background-color: #f8d7da; 
        color: #842029; 
        border: 1px solid #f5c2c7;  
    }
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