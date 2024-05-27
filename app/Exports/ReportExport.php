<?php

namespace App\Exports;

use Exception;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Style\Color;








class ReportExport implements FromView ,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $forecast;

    function __construct($forecast) {
        $this->forecast = $forecast;
    }


    public function view(): View
    {
        try {
         
            return view('table-export', [
                'forecast' => $this->forecast,
            ]);
        } catch (Exception $ex) {
            \Log::error($ex);
            abort(404);
        }
    }

    
}
