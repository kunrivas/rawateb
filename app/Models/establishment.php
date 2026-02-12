<?php

namespace App\Models;

use App\Models\RwEmployee;
use App\Models\RwRendement;
use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Model;

class establishment extends Model
{
    private $list_fonctions = [4000, 6000, 7065, 7055];

    // protected $connection = 'mysql_user';
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        /* If we are in production web mode use establishem in mysql user
        else if we in local  use mysql */
        $this->connection = App::environment('production')
            ? 'mysql_user'
            : 'mysql';
    }

    function sevedCount($rw_re_migrations_id)
    {
        return RwRendement::where("AFFECT", $this->estab_rawateb_user)->where("rw_re_migrations_id", $rw_re_migrations_id)->count();
    }
    function allCount()
    {
        return RwEmployee::where("AFFECT", $this->estab_rawateb_user)->whereNotIn("CODFONC", $this->list_fonctions)->count();
    }
}
