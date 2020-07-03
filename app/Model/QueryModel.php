<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Arr;
use \DB;

class QueryModel extends Model
{
    protected $tbl_user = 'users';
    protected $tbl_user_group = "user_group";
    protected $tbl_module = 'module';
    protected $tbl_employee = 'employee';

    public function __construct() { 

    }


    public function get_total_user_group($guid) {
        $query = DB::table($this->tbl_user);

        $query->where(['guid' => $guid])->select('id');

        return $query->count();
    }


    public function get_user_group($where = '')
    {
        $query = DB::table($this->tbl_user_group.' AS ug');

        is_array($where) ? $query->where($where) : NULL;

        return $query;
    }


    public function get_user($where = '')
    {
        $query = DB::table($this->tbl_user. ' AS u');

        $query->join($this->tbl_user_group.' AS ug', 'ug.guid', '=', 'u.guid');
        $query->selectRaw('u.id, u.name, u.email, u.status, u.created_at, u.updated_at, ug.guid, ug.gname');

        \is_array($where) ? $query->where($where) : null;

        return $query;
    }


    public function get_employee($where = '') {
        $query = DB::table($this->tbl_employee.' AS e');

        // $query->leftJoin($this->tbl_position.' AS p', 'p.id', '=', 'e.position_id');
        // $query->leftJoin($this->tbl_division.' AS d', 'd.id', '=', 'p.division_id');
        // $query->leftJoin($this->tbl_currency.' AS c', 'c.id', '=', 'e.currency_id');
        // $query->selectRaw('e.id,e.fullname,e.gender,e.join_date,e.position_id,e.currency_id,e.starting_salary,e.created_at,e.updated_at,p.name AS position,c.iso_code,c.symbol');

        \is_array($where) ? $query->where($where) : null;

        return $query;

    }


}
