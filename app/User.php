<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\File;
class User extends Authenticatable
{
    use Notifiable, hasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


  public function Avatar() {
    if($this->avatar_file_id) {
        $file = File::find($this->avatar_file_id);
    } 
    if(isset($file)) return "/files/uploads/".$file->saved_name;
      else return "https://static.slickdealscdn.com/images/avatar-150.png";
  }

}
