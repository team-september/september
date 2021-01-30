<?php


namespace App\Repositories\User;


interface IUserRepository
{
    public function getUserBySub($sub);

    public function getUserById($id);

    public function getMentors();

}
