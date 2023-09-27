<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use CrudTrait;
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'transactions';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['transaction_date', 'amount', 'status', 'consumer_id', 'collector_id', 'supplier_id', 'user_id'];
    // protected $hidden = [];



    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    protected static function boot()
    {
        parent::boot();

        static::created(function ($transaction) {
            $transaction->collector->updateBillsColumn();
        });

        static::updated(function ($transaction) {
            $transaction->collector->updateBillsColumn();
        });
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function consumer()
    {
        return $this->belongsTo(Consumer::class);
    }

    public function collector()
    {
        return $this->belongsTo(Collector::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }


    /* user logs */

    public function user() {
        return $this->belongsTo(User::class);
    }

    /*    
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
