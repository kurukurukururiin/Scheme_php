<?php

class Validator {
    
    public function validate(string $inputValue, string $type): void {
        switch ($type) {
            case 'email':
                $this->validateEmail($inputValue);
                break;
            case 'isim':
                $this->validateName($inputValue);
                break;
            case 'telefon':
                $this->validatePhone($inputValue);
                break;
            default:
                throw new Exception("Bilinmeyen doğrulama türü: {$type}");
        }
    }

    private function validateEmail(string $email): void {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Geçersiz e-posta formatı: {$email}");
        }
    }

    private function validateName(string $name): void {
        if (trim($name) === '' || strlen(trim($name)) < 4) {
            throw new Exception("İsim alanı boş bırakılamaz ve en az 4 karakter olmalıdır.");
        }
    }

    private function validatePhone(string $phone): void {
        if (!preg_match("/^[0-9]{10,11}$/", $phone)) {
            throw new Exception("Geçersiz telefon numarası. Sadece rakam içermeli ve 10-11 hane olmalıdır: {$phone}");
        }
    }
}
?>