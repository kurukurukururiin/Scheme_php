<?php

require_once 'User.php';
require_once 'AdminUser.php';
require_once 'Validator.php';
class UserRepository {
    private string $filePath;
    private Validator $validator;

    public function __construct(string $filePath = 'users.json') {
        $this->filePath = $filePath;
        $this->validator = new Validator();
        
        if (!file_exists($this->filePath)) {
            $handle = fopen($this->filePath, 'w');
            fwrite($handle, json_encode([]));
            fclose($handle);
        }
    }

    private function readAll(): array {
        $handle = fopen($this->filePath, 'r');
        $size = filesize($this->filePath);
        $content = '';
        if ($size > 0) {
            $content = fread($handle, $size);
        }
        fclose($handle);
        return json_decode($content, true) ?? [];
    }

    private function writeAll(array $data): void {
        $handle = fopen($this->filePath, 'w');
        fwrite($handle, json_encode($data, JSON_PRETTY_PRINT));
        fclose($handle);
    }

    public function save(User $user): void {
        $this->validator->validate($user->email, 'email');
        $this->validator->validate($user->name, 'isim');

        $users = $this->readAll();

        $userData = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->password,
            'isAdmin' => ($user instanceof AdminUser),
            'requires2FA' => ($user instanceof AdminUser) ? $user->requires2FA() : false
        ];

        $exists = false;
        foreach ($users as &$existing) {
            if ($existing['id'] === $user->id) {
                $existing = $userData;
                $exists = true;
                break;
            }
        }

        if (!$exists) {
            $users[] = $userData;
        }

        $this->writeAll($users);
    }
}
?>