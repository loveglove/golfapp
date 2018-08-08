<?php

namespace App;

use App\Team;
use Session;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'avatar', 'facebook_id'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];


    public function getId()
    {
      return $this->id;
    }

    public function team()
    {
        $tournament = Session::get('tournament');
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
