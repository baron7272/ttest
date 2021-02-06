<?php

namespace App\Exports;
use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //

        return User::where('id',44)->get(['id','name']);
    }
}
