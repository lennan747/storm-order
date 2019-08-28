<?php
/**
 * Created by PhpStorm.
 * User: leo
 * Date: 2019/8/26
 * Time: 17:49
 */
namespace App\Admin\Extensions;

use Maatwebsite\Excel\Concerns\FromArray;

class InvoicesExport implements FromArray
{
    protected $invoices;

    public function __construct(array $invoices)
    {
        $this->invoices = $invoices;
    }

    public function array(): array
    {
        return $this->invoices;
    }
}
