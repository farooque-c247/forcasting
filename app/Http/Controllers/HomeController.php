<?php

namespace App\Http\Controllers;
use DateTime;
use Illuminate\Http\Request;
use App\Imports\ForcastingImport;
use Phpml\Regression\LeastSquares;
use Phpml\Dataset\ArrayDataset;
use Phpml\CrossValidation\RandomSplit;
use Phpml\Metric\Regression;
use App\Exports\ReportExport;
use Maatwebsite\Excel\Facades\Excel;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    function changeTimeToMonth($date) {
        // Create a DateTime object from the old date
        $dateTime = DateTime::createFromFormat('m/d/Y', $date);
        // If the DateTime object was created successfully
        if ($dateTime !== false) {
            // Format the DateTime object to the desired format
            return strtotime($dateTime->format('Y-m'));
        } 
    }

    function getMonth($date) {
        // Create a DateTime object from the old date
        $dateTime = DateTime::createFromFormat('m/d/Y', $date);
        // If the DateTime object was created successfully
        if ($dateTime !== false) {
            // Format the DateTime object to the desired format
            return $dateTime->format('M');
        } 
    }


    public function index()
    {
        $sample_data =(new ForcastingImport)->toArray('test.csv');
        $prepare_data = [];

// Iterate through the array and organize the data
        foreach ($sample_data[0] as $item) {
       
                $invoiceDate = $this->changeTimeToMonth($item['invoice_date']);
                $companyName = $item['company_name'];
                $quantity = $item['quantity_on_order'];
                $product = $item['product_name'];

                // Extract month from invoice date
                $month = date('M',$invoiceDate);

                // Initialize the structure if not already set
                if (!isset($prepare_data[$month][$companyName][$product][$invoiceDate])) {
                    $prepare_data[$month][$companyName][$product][$invoiceDate] = 0;
                }

                // Aggregate quantity for each combination of month, customer, product, and invoice date
                $prepare_data[$month][$companyName][$product][$invoiceDate] += $quantity;
            
        }


    
    
        $order_dates=[];
        $targets=[];
        $forecast = [];
 
        foreach($prepare_data as $month=> $customer){
            foreach($customer as $key =>$product){
               
                foreach($product as $product_key =>$orders){
                    $order_dates=[];
                    $targets=[];
                    foreach($orders as $order_key=>$order){
                        $order_dates[]= [$order_key];
                        $targets[]=$order;

                    }    
              
                
                    if(count($order_dates)>=2){
                        $regression = new LeastSquares();
                    
                        $regression->train($order_dates, $targets);
                    
                        $next_month = strtotime(date('Y-m-t',strtotime($month)));
               
                        $next_month_quantity = $regression->predict([$next_month]);
                        $forecast[date('Y-M', $next_month)][] = [
                            "quantity"=>round($next_month_quantity),
                            "customer"=>$key,
                            "product"=>$product_key
                        ]; 
                    }    
                }   
                
          
            }
        }
       // return Excel::download(new ReportExport($forecast), 'report' . date('YmdHis').'.xls', \Maatwebsite\Excel\Excel::XLS);
        
        return view('table-export',compact('forecast'));
    }
}
