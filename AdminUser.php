<?php

require_once 'User.php';
require_once 'Required2FA.php';

class AdminUser extends User
{
    use Required2FA;
}