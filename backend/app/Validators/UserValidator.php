
<?php

class UserValidator
{
    public function validateUserData($userData)
    {
        // Validação básica para campos obrigatórios
        if (empty($userData['first_name']) || empty($userData['last_name']) || empty($userData['email'])) {
            return false;
        }
        return true;
    }
}