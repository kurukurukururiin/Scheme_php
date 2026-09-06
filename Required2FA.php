<?php

trait Required2FA
{
    public bool $requires2FA = false;

    public function requires2FA(): bool
    {
        return $this->requires2FA;
    }

    public function enable2FA(): void
    {
        $this->requires2FA = true;
    }

    public function disable2FA(): void
    {
        $this->requires2FA = false;
    }

}