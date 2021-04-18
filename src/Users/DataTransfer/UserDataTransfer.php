<?php
declare(strict_types=1);

namespace App\Users\DataTransfer;


class UserDataTransfer
{
    public $lastName;
    public $firstName;
    public $middleName;
    public $age;
    public $phone;
    public $employ;
    public $privileges;

    public function __construct(array $array)
    {
        $this->initialize($array);
    }

    private function initialize(array $array): void
    {
        foreach ($array as $k => $v){
            if(property_exists($this, $k)){
                $this->{$k} = $v;
            }
        }
    }

}