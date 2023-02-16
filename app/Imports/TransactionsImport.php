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
        if (empty($row['code_transactions'])) {
            throw new \Exception('Code transactions is required, Please check your excel have a field code_transactions');
        }
        return new TransactionsModel([
            'code_transactions' => $row['code_transactions'],
            'date'              => $row['date'],
            'variant'           => $row['variant'],
        ]);
    }
}
