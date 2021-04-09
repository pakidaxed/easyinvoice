<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;

class Invoice extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function client()
    {
        return $this->hasOne(Client::class, 'id', 'client_id');
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class, 'invoice_id', 'id');
    }

    public function isLate(): bool
    {
        return Date::today() > $this->created_at->addDays($this->payment_term);
    }

    public function daysToOverdue()
    {
        return $this->created_at->addDays($this->payment_term)->diff(Date::now())->days;
    }
}
