<?php

namespace App\Repositories\Contracts;

interface UserInterface extends RepositoryInterface
{
    public function active($token);

    public function register($inputs, $roleId);

    public function ownedCampaign($id, $orderBy = 'created_at', $direction = 'desc');

    public function joinedCampaign($id, $orderBy = 'created_at', $direction = 'desc');

    public function listFollower($id, $orderBy = 'created_at', $direction = 'desc');

    public function listFollowing($id, $orderBy = 'created_at', $direction = 'desc');
}