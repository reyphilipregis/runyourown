<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use HasFactory;

    // Need to override this since the primary key is 10 chars long which is a string.
    protected $keyType = 'string';

    /**
     * Since a Site can have many Bill then we create a relationship
     * to easily get the Bill's information.
     */
    public function bills()
    {
        return $this->hasMany(Bill::class, 'site_id');
    }

    /**
     * Relationship declaration that a Site belongs to a User.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'site_manager_id');
    }

    /**
     * This is method just outputs the latest bill via bill_start_date and display it's fields.
     */
    public function latestBill()
    {
        return $this->hasOne(Bill::class)
            ->latest('bill_start_date')
            ->select(
                'id', 
                'site_id', 
                'bill_start_date',
                'bill_end_date', 
                'electricity_usage', 
                'amount'
            );
    }

}
