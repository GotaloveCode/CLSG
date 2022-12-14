<?php

namespace App\Imports;

use App\Mail\WspCreatedMailable;
use App\Models\PostalCode;
use App\Models\User;
use App\Models\Wsp;
use App\Traits\GenerateTokenTrait;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class WspsImport implements ToCollection,WithHeadingRow
{
    use GenerateTokenTrait;

    /*
    *
    * @param Collection $collection
    *
    */
    public function collection(Collection $collection)
    {
        Validator::make($collection->toArray(), [
            '*.name' => 'required|max:191|unique:wsps,name',
            '*.acronym' => 'required|max:191',
            '*.email' => 'required|max:191|unique:wsps,email',
            '*.postaladdress' => 'required|max:191',
            '*.physicaladdress' => 'required|max:191',
            '*.managingdirector' => 'required|max:191',
            '*.postalcode' => 'required|max:191|exists:postal_codes,code'
        ])->validate();

        $postalcodes = PostalCode::all();
        foreach ($collection as $row) {
            $postal_code = $postalcodes->where('code', $row['postalcode'])->first();

            $wsp = Wsp::create([
                'name' => $row['name'],
                'acronym' => $row['acronym'],
                'email' => $row['email'],
                'postal_address' => $row['postaladdress'],
                'physical_address' => $row['physicaladdress'],
                'postal_code_id' => $postal_code->id,
                'managing_director' => $row['managingdirector']
            ]);

            $password = $this->getToken();

            $user = User::create([
                'name' => $row['name'],
                'email' => $row['email'],
                'password' => Hash::make($password),
            ]);

            $user->assignRole('wsp');
            $user->givePermissionTo('create_users');
            $user->wsps()->attach($wsp->id);

            Mail::to($user)->queue(new WspCreatedMailable($wsp, $password));
        }
    }


}
