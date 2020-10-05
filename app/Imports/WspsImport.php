<?php

namespace App\Imports;

use App\Models\PostalCode;
use App\Models\Wsp;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class WspsImport implements ToCollection,WithHeadingRow
{
    /**
    * @param Collection $collection
    *
    */
    public function collection(Collection $collection)
    {
        Validator::make($collection->toArray(), [
            '*.name' => 'required|max:191|unique:wsps,name',
            '*.acronym' => 'required|max:191',
            '*.postaladdress' => 'required|max:191',
            '*.physicaladdress' => 'required|max:191',
            '*.postalcode' => 'required|max:191|exists:company.postal_codes,code'
        ])->validate();

        $postalcodes = PostalCode::all();
        foreach ($collection as $row) {
            $postal_code = $postalcodes->where('code', $row['postalcode'])->first();
            Wsp::create([
                'name' => $row['name'],
                'acronym' => row['acronym'],
                'postal_address' => row['postaladdress'],
                'physical_address' => row['physicaladdress'],
                'postal_code_id' => $postal_code->id
            ]);
        }
    }


}
