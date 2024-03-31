<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\ImportData\ImportCSVJob;

class ImportTestController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {

        // $file = fopen(base_path() . '/public/files/test_data.csv', "r");
        // // fgetcsv($file);

        // while (($row = fgetcsv($file)) !== false) {
        //     // Виводимо дані з кожного рядка
        //     echo "Authors: " . $row[0] . "<br>";
        //     echo "Title: " . $row[1] . "<br>";
        //     echo "Genre: " . $row[2] . "<br>";
        //     echo "Description: " . $row[3] . "<br>";
        //     echo "Edition: " . $row[4] . "<br>";
        //     echo "Publisher: " . $row[5] . "<br>";
        //     echo "Year: " . $row[6] . "<br>";
        //     echo "Format: " . $row[7] . "<br>";
        //     echo "Pages: " . $row[8] . "<br>";
        //     echo "Country: " . $row[9] . "<br>";
        //     echo "ISBN: " . $row[10] . "<br>";
        //     echo "<br>";
        // }
        
        // fclose($file);
        ImportCSVJob::dispatch(base_path() . '/public/files/test_data.csv');
    }
}
