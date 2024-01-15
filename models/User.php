<?php

namespace app\models;

use app\core\Model;
use app\core\DbModel;
use app\core\UserModel;

class User extends UserModel
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 2;
    public string $firstname = '';
    public string $lastname = '';
    public string $email = '';
    public string $password = '';
    public int $status = self::STATUS_INACTIVE;
    public string $confirmPassword = '';
    public static function tableName(): string{
        return 'users';
    }
    public function save(): bool
    {
        $this->status = self::STATUS_INACTIVE;
        $this->password = password_hash($this->password,PASSWORD_DEFAULT);
        return parent::save();
    }
    public function rules(): array{
        return [
            'firstname' => [self::RULE_REQUIRED],
            'lastname' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL,[self::RULE_UNIQUE,'class'=>self::class]],
            'password' => [self::RULE_REQUIRED,[self::RULE_MIN,'min' => 8], [self::RULE_MAX,'max' => 9]],
            'confirmPassword' => [self::RULE_REQUIRED, [self::RULE_MATCH,'match' => 'password']]
        ];
    }
    public function attributes() : array{
        return [
            'firstname',
            'lastname',
            'email',
            'password',
            'status'
        ];
    }
    public function labels(): array
    {
        $labels = parent::labels();
        return [
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
            'email' => 'Email',
            'password' => 'Password',
            'confirmPassword' => 'Confirm password'
        ];
    }

    public static function primaryKey(): string
    {
        return 'id';
    }

    public function getDisplayName(): string
    {
        return $this->firstname;
    }
}