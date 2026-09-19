<?php
$mesaj = "";
$hataVar = false;

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["resim"])) {
    

    $hedefKlasor = "uploads/";

    if (!file_exists($hedefKlasor)) {
        mkdir($hedefKlasor, 0777, true);
    }

    $dosya = $_FILES["resim"];

    $dosyaAdi = basename($dosya["name"]); 
    $geciciYol = $dosya["tmp_name"];      
    $hataKodu = $dosya["error"];          

    $hedefDosyaYolu = $hedefKlasor . $dosyaAdi;

    if ($hataKodu === 0) {
        if (move_uploaded_file($geciciYol, $hedefDosyaYolu)) {
            $mesaj = "Tebrikler! <b>{$dosyaAdi}</b> adlı resim başarıyla sunucuya yüklendi.";
            $hataVar = false;
        } else {
            $mesaj = "Kayıt Başarısız: Dosya klasöre taşınamadı.";
            $hataVar = true;
        }
    } else {
        $mesaj = "Yükleme sırasında teknik bir hata oluştu. Hata Kodu: " . $hataKodu;
        $hataVar = true;
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Resim Yükleme Modülü</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, sans-serif; background-color: #f0f2f5; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .form-kutusu { background: #ffffff; padding: 40px; border-radius: 12px; box-shadow: 0 8px 24px rgba(0,0,0,0.1); width: 350px; text-align: center; }
        h2 { margin-top: 0; color: #1a1a1a; margin-bottom: 20px; }
        label { display: block; margin-bottom: 15px; font-weight: 500; color: #4a4a4a; text-align: left;}
        

        input[type="file"] { width: 100%; padding: 10px; border: 1px dashed #007bff; border-radius: 8px; background-color: #f8fbff; cursor: pointer; margin-bottom: 20px; box-sizing: border-box;}
        
        button { width: 100%; padding: 12px; background-color: #007bff; color: white; border: none; border-radius: 8px; font-size: 16px; font-weight: bold; cursor: pointer; transition: 0.3s; }
        button:hover { background-color: #0056b3; }
        
        .bildirim { padding: 12px 15px; margin-bottom: 20px; border-radius: 8px; font-size: 14px; line-height: 1.4; }
        .basari { background-color: #d1e7dd; color: #0f5132; border: 1px solid #badbcc; }
        .hata { background-color: #f8d7da; color: #842029; border: 1px solid #f5c2c7; }
    </style>
</head>
<body>

    <div class="form-kutusu">
        <h2>Profil Resmi Yükle</h2>

        <?php if ($mesaj !== ""): ?>
            <div class="bildirim <?php echo $hataVar ? 'hata' : 'basari'; ?>">
                <?php echo $mesaj; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="" enctype="multipart/form-data">
            
            <label for="resim">Bilgisayarından bir resim seç:</label>
            <input type="file" id="resim" name="resim" accept="image/*" required>

            <button type="submit">Resmi Yükle</button>
        </form>
    </div>

</body>
</html>