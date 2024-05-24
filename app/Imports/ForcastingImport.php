<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
// use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class ForcastingImport implements ToCollection,WithHeadingRow
{
    use Importable;
    /**
    * @param Collection $collection
    */

    public function model(array $rows)
    {   
        return [$rows];
        
    } 

   
    
    
    public function collection(Collection $rows)
    { 

        return $rows;
        
    }   
    public function headingRow(): int
    {
        return 1; // second row setup in excel sheet
    } 


}
