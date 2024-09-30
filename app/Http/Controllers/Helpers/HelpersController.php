<?php

namespace App\Http\Controllers\Helpers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HelpersController extends Controller
{
    public function ChangeFormatArray($data)
    {

        $data = [
            'data' =>  $data->items(),
            'total' => $data->total(),
            'per_page' =>  $data->perPage(),
            'current_page' => $data->currentPage(),
            'last_page' => $data->lastPage(),
        ];
        return $data;
    }

    function generateUniqueId($flag)
    {
        // Menghasilkan dua huruf acak dari a-z
        $randomLetters = substr(str_shuffle('abcdefghijklmnopqrstuvwxyz'), 0, 2);

        // Mengambil tahun saat ini
        $year = date('y'); // Mengambil dua digit terakhir dari tahun


        // Menghasilkan ID unik dengan format yang diinginkan
        return "{$flag}{$randomLetters}/{$year}";
    }
}