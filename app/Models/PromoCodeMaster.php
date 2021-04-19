<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;
use App\Models\PromoCodes;
use DB;
use PDO;

class PromoCodeMaster extends Model
{
    use SoftDeletes;

    public $table = 'promo_code_master';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = ['title','description','start_date','end_date','reward_type','reward_type_x_value','type','promo_code','qty','status','created_by','updated_by','created_at','updated_at'];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function promoCodes() {
        return $this->hasMany(PromoCodes::class, 'promo_code_master_id');
    }
}
