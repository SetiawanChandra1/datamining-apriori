<?php

namespace App\Imports;

use App\Models\TransactionsModel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TransactionsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if (empty($row['code'])) {
            throw new \Exception('Code is required, Please check your excel have a field code');
        }
        return new TransactionsModel([
            'code_transactions' => $row['code'],
            'date'              => $row['date'],
            'variant'           => $row['variant'],
        ]);
    }
}
