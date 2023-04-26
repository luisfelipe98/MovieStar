<?php

interface UserDAOInterface {

    public function buildUser($data);
    public function create(User $user, $authUser = false);
    public function update(User $user);
    public function verifyToken($protected = false);
    public function setTokenToSession($token, $redirect = true);
    public function authenticateUser($email, $password);
    public function findByEmail($user);
    public function findById(User $user);
    public function findByToken(User $user);
    public function changePassword(User $user);
    
}

?>