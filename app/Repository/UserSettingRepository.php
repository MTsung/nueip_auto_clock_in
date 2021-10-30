<?php

namespace App\Repository;

use App\Models\UserSetting;
use Illuminate\Database\Eloquent\Model;

class UserSettingRepository
{
    public function module(): Model
    {
        return app(UserSetting::class);
    }

    public function find($user_id)
    {
        return $this->module()->query()->firstOrCreate(['user_id' => $user_id]);
    }

    public function save($user_id, $params)
    {
        $this->find($user_id)->update($params);
    }
}
