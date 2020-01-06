<?php

namespace App;

use App\Team;
use App\Tournament;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function team()
    {
        $tournament = Tournament::where('active', 1)->first();
        $userid = $this->id;
        return Team::where('id_tour', '=', $tournament->id)->where(function($query) use($userid) {
            $query->where('id_user1', '=', $userid)
            ->orWhere('id_user2', '=', $userid)
            ->orWhere('id_user3', '=', $userid)
            ->orWhere('id_user4', '=', $userid);
        })->first();
    }

    public function isAdmin()
    {
        return $this->admin;
    }


}
