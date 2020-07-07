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
    protected $tbl_users_biodata = 'users_biodata';

    protected $tbl_categories = 'categories';
    protected $tbl_products = 'products';
    protected $tbl_products_atrtribute = 'products_attributes';
    protected $tbl_products_images = 'products_images';



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


    public function get_data_users_front($where = '')
    {
        $query = DB::table($this->tbl_user.' AS u');

        $query->leftJoin($this->tbl_users_biodata.' AS ub', 'u.id', '=', 'ub.user_id');
        $query->selectRaw('u.id, u.avatar, u.name, u.email, u.admin, u.status, u.created_at, u.updated_at, ub.address, ub.city, ub.state, ub.country, ub.pincode, ub.mobile');

        \is_array($where) ? $query->where($where) : null;

        return $query;
    }


    public function get_employee($where = '') {
        $query = DB::table($this->tbl_employee.' AS e');

        // $query->leftJoin($this->tbl_position.' AS p', 'p.id', '=', 'e.position_id');
        // $query->leftJoin($this->tbl_division.' AS d', 'd.id', '=', 'p.division_id');
        // $query->leftJoin($this->tbl_currency.' AS c', 'c.id', '=', 'e.currency_id');
        // $query->selectRaw('c.*');

        \is_array($where) ? $query->where($where) : null;

        return $query;

    }


    public function get_categories($where = '')
    {
        $query = DB::table($this->tbl_categories.' AS c');

        \is_array($where) ? $query->where($where) : null;

        return $query;

    }


    public function get_product($where = '')
    {
        $query = DB::table($this->tbl_products.' AS p');
        
        $query->leftJoin($this->tbl_categories.' AS c', 'p.category_id', '=', 'c.id');
        $query->selectRaw('p.*, c.name');

        \is_array($where) ? $query->where($where) : null;

        return $query;
    }


    public function get_product_image($where = '')
    {
        $query = DB::table($this->tbl_products.' AS p');
        
        $query->leftJoin($this->tbl_products_images.' AS pi', 'p.id', '=', 'pi.product_id');
        $query->selectRaw('p.*, pi.*');

        \is_array($where) ? $query->where($where) : null;

        return $query;
    }


    public function get_product_with_attribute($where = '')
    {
        $query = DB::table($this->tbl_products.' AS p');
        
        $query->leftJoin($this->tbl_products_atrtribute.' AS pa', 'p.id', '=', 'pa.product_id');
        $query->selectRaw('p.*, pa.*');

        \is_array($where) ? $query->where($where) : null;

        return $query;
    }




}
