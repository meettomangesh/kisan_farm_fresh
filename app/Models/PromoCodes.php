<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;
use App\User;
use App\Models\PromoCodeMaster;
use DB;
use PDO;

class PromoCodes extends Model
{
    use SoftDeletes;

    public $table = 'promo_codes';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = ['promo_code_master_id','user_id','promo_code','start_date','end_date','is_code_used','status','created_by','updated_by','created_at','updated_at'];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function userCustomer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function promoCodeMaster()
    {
        return $this->belongsTo(PromoCodeMaster::class, 'promo_code_master_id');
    }

    public function getPromoCodes($params) {
        $queryResult = DB::select('call getPromoCodes(?)', [$params]);
        return $queryResult;
    }

    public function validatePromoCode($params) {
        $pdo = DB::connection()->getPdo();
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
        $stmt = $pdo->prepare("CALL validatePromoCode(?)");
        $stmt->execute([$params]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $stmt->closeCursor();
        $reponse = json_decode($result['response']);
        if($reponse->status == "FAILURE" && $reponse->statusCode != 200) {
            return false;
        }
        return true;
    }
}
