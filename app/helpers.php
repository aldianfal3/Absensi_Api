<?php

    use App\Models\User;
    use App\Models\Absensi;

    function getUser($param) {
        $user = User::where('id', $param)
                ->orWhere('email', $param)
                ->orWhere('username', $param)
                ->first();


        return $user;
    }

?>