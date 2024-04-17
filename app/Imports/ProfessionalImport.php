<?php

namespace App\Imports;

use App\Models\ProfessionalPolicyDetails;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;

class ProfessionalImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ProfessionalPolicyDetails([

        ]);
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            ProfessionalPolicyDetails::create([
                'name' => $row[0],
            ]);
        }
    }
}
