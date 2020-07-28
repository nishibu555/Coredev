<?php


namespace App\Services\Social;


use Laravel\Socialite\AbstractUser;

class FakeUser extends AbstractUser
{
    public function __construct()
    {
        $this->id = '12345';
        $this->name = 'Fake Social Account';
        $this->nickname = 'Fake';
        $this->email = 'fake@social.com';
        $this->avatar = 'https://www.fake-social.com/avatar/fake.jpg';
    }
}
