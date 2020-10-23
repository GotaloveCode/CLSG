<?php
namespace App\Exports;


use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromArray;
//Use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromView;

class InvoicesExport implements FromView
{

    public function view(): View
    {
        return view("exports.revenues",["users"=>User::all()]);
    }
}
