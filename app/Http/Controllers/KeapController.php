<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\KeapImport;
use App\Imports\KeapTravelImport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;
use App\Http\Requests\ImportRequest;
class KeapController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }


    public function import(ImportRequest $request)
    {   
        try {
            if($request->insurance==1){
               
                $heading=(new HeadingRowImport)->toArray($request->file('file'));
                $missing_header= getMissingHeader($heading);
                if(!empty($missing_header)){
                    toastr()->error('Missing column name in sheet '.implode(',',$missing_header), 'error');
                    return redirect('/home');
                }

                $collection= Excel::import(new KeapImport,$request->file('file'),\Maatwebsite\Excel\Excel::XLSX);
                $heading=(new HeadingRowImport)->toArray($request->file('file'));
            }else{
                
                $heading=(new HeadingRowImport)->toArray($request->file('file'));
                $missing_header= getMissingHeader($heading);
                if(!empty($missing_header)){
                    toastr()->error('Missing column name in sheet '.implode(',',$missing_header), 'error');
                    return redirect('/home');
                }
                $collection= Excel::import(new KeapTravelImport,$request->file('file'),\Maatwebsite\Excel\Excel::XLSX);
            }

            toastr()->success('Data has been uploaded Successfully.', 'Success');
            return redirect('/home');
        }catch(Exception $e) {
            toastr()->error('Something went Successfully.', 'error'); 
             return redirect('/home');

        }        
       
    }
}
