<?php

namespace App\Http\Controllers;
use DateTime;
use Illuminate\Http\Request;
use App\Imports\ForcastingImport;
use Phpml\Regression\LeastSquares;
use Phpml\Dataset\ArrayDataset;
use Phpml\CrossValidation\RandomSplit;
use Phpml\Metric\Regression;


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
            return strtotime($dateTime->format('Y-m-d'));
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
       
                $invoiceDate = strtotime($item['invoice_date']);
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



        

        foreach($prepare_data as $customer){
            foreach($customer as $key =>$product){
              
            }
        }

        foreach ($monthly_totals as $month => $quantity) {
            $time_series[] = [$month];
            $target[] = $quantity;
        }



        // Train the model
        $regression = new LeastSquares();
        $regression->train($time_series, $target);

   

        // Forecast for the next 12 months
        $last_month = end($time_series);

        $forecast = [];
        for ($i = 1; $i <= 12; $i++) {
            $next_month = strtotime("+$i month", date('Y-m',$last_month[0]));
            $next_month_quantity = $regression->predict([$next_month]);
            $forecast[date('Y-m', $next_month)] = $next_month_quantity[0];
        }

        // Output the forecast
        echo "12-Month Forecast:\n";
        foreach ($forecast as $month => $quantity) {
            echo "Month: $month - Quantity: $quantity\n";
        }

     

    

        
        
        return view('index');
    }
}
