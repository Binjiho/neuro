<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailAddressDetail extends Model
{
    use HasFactory;


    protected $primaryKey = 'sid';

    protected $guarded = [
        'sid',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function setByData($data)
    {
        $ma_sid = $data->ma_sid;

        if (empty($this->sid)) {
            $this->ma_sid = $ma_sid;
        }

        $this->name = trim($data->name);
        $this->email = trim($data->email);
    }

    public function address()
    {
        return $this->belongsTo(MailAddress::class, 'ma_sid');
    }
}
