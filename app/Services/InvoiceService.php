<?php


namespace App\Services;


use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;
use NumberFormatter;

class InvoiceService
{
    private $invoiceCount;

    public function __construct()
    {
        $this->user = Auth::user();
    }

    public function getInvoiceLastNumber($userId)
    {
        $this->invoiceCount = Invoice::where('user_id', $userId)->orderBy('id', 'desc')->value('number');
        if ($this->invoiceCount) {
            return ++$this->invoiceCount;
        }

        return $this->invoiceCount = 1;
    }

    public function generateInvoiceNumber($prefix)
    {
        return strtoupper($prefix) . str_pad($this->invoiceCount, 6, "0", STR_PAD_LEFT);
    }

    public function getPriceWithTax($price)
    {
        if ($this->user->info->vat_code) {
            return $price * 1.21;
        }

        return $price;
    }

    public function spellout($sum)
    {
        $sumExploded = explode('.', $sum,);
        $formatter = new NumberFormatter('en_GB', NumberFormatter::SPELLOUT);

        $first = $formatter->format($sumExploded[0]) . ' euro ';
        $second = $formatter->format($sumExploded[1] ?? 0) . ' ct';

        return $first . $second;
    }


}
