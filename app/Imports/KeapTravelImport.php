<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
// use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class KeapTravelImport implements ToCollection,WithHeadingRow
{
    use Importable;
    /**
    * @param Collection $collection
    */
    // public function collection(Collection $collection)
    // {
    //     return $collection[1];
    // }
    // public function model(array $rows)
    // {   
    //     return [$rows];
        
    // } 

    function applyTag($id){
        try {
            if(!empty($id)){
                $curl = curl_init();
                // dd(json_encode($data,JSON_UNESCAPED_SLASHES));
                curl_setopt_array($curl, array(
                  CURLOPT_URL => 'https://api.infusionsoft.com/crm/rest/v1/contacts/'.$id.'/tags',
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => '',
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 0,
                  CURLOPT_FOLLOWLOCATION => true,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => 'POST',
                  CURLOPT_POSTFIELDS =>json_encode(['tagIds'=>getTagIdTT()],JSON_UNESCAPED_SLASHES),
                //   CURLOPT_POSTFIELDS =>'{
                //    "email_addresses":[
                //       {
                //          "email":"test.k@tst.com",
                //          "field":"EMAIL1",
                //       }
                //    ]
                // }',
                  CURLOPT_HTTPHEADER => array(
                      "accept: application/json",
                    "content-type: application/json",
                    'X-Keap-API-Key:KeapAK-b9e500d39238982f54dd8b1a82d24a56b232d66247446a0177',
                    // 'Authorization:Bearer Gzy5wZSfwjys7NwcNnVAhTLq0IsK'
                    // 'Authorization:Basic '.base64_encode("e4BRs3OAnPiAtu5KY4GkYLkNhV84HwitI17OugI3fY1IeKEp:2MXRC06GsI8PnSYsIWzYG9UnNPUEX4so9zi56rpxxBAAz3ATXAmLefKfy4saQWgT")
                  ),
                ));
            
                $response = json_decode(curl_exec($curl));
            }
           
            
        }catch(Exception $e) {
     
          echo 'Message: ' .$e->getMessage();
        }	

    }
    function importData($data){
        try {
            $curl = curl_init();
            // dd(json_encode($data,JSON_UNESCAPED_SLASHES));
            curl_setopt_array($curl, array(
              CURLOPT_URL => 'https://api.infusionsoft.com/crm/rest/v1/contacts',
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'PUT',
              CURLOPT_POSTFIELDS =>json_encode($data,JSON_UNESCAPED_SLASHES),
            //   CURLOPT_POSTFIELDS =>'{
            //    "email_addresses":[
            //       {
            //          "email":"test.k@tst.com",
            //          "field":"EMAIL1",
            //       }
            //    ]
            // }',
              CURLOPT_HTTPHEADER => array(
                  "accept: application/json",
                "content-type: application/json",
                'X-Keap-API-Key:KeapAK-b9e500d39238982f54dd8b1a82d24a56b232d66247446a0177',
                // 'Authorization:Bearer Gzy5wZSfwjys7NwcNnVAhTLq0IsK'
                // 'Authorization:Basic '.base64_encode("e4BRs3OAnPiAtu5KY4GkYLkNhV84HwitI17OugI3fY1IeKEp:2MXRC06GsI8PnSYsIWzYG9UnNPUEX4so9zi56rpxxBAAz3ATXAmLefKfy4saQWgT")
              ),
            ));
            
            
            $response = json_decode(curl_exec($curl));
            if(isset($response->id)){
                $this->applyTag($response->id);
            }

         
        }catch(Exception $e) {
            
          echo 'Message: ' .$e->getMessage();
        }	



    }

    function changeDateFormat($date){
        $new_date=\DateTime::createFromFormat('d/m/Y',$date);
        return $new_date->format('Y-m-d');
    }

    function prepareImportData($row){
      
        $birth_date =\DateTime::createFromFormat('d/m/Y',$row['date_of_birth']); 
        $birth_date =$birth_date->format('Y-m-d\TH:i:s\Z');
        $variables=getVariablesTT();
  
        if(!empty($row['email'])){
            $data=[
                'addresses'=>[
                   [ 'field'=>"BILLING",
                    'postal_code'=>$row['postcode']
                   ]
                ],
                'email_addresses'=>[ 
                    [
                    'email'=>$row['email'],
                    'field'=>"EMAIL1"
                    ]
                ],
                'birthday'=>$birth_date,
                'family_name'=>$row['lastname'],
                'preferred_name'=>$row['firstname'],
               'given_name'=>$row['title'].' '.$row['firstname'],
                'custom_fields'=>[
                    [
                        'content'=>[ $row['agent'] ],
                        'id'=>$variables['agent']
                    ],
                    [
                        'content'=>[ $row['campaign'] ],
                        'id'=>$variables['campaign']
                    ],
                    [
                        'content'=>[ $row['clientid'] ],
                        'id'=>$variables['client_id']
                    ],
                    [
                        'content'=>[ $this->changeDateFormat($row['enddate'])],
                        'id'=>$variables['end_date']
                    ],
                    [
                        'content'=>[ [ $this->changeDateFormat($row['startdate'])], ],
                        'id'=>$variables['start_date']
                    ],
                    [
                        'content'=>[ [ $this->changeDateFormat($row['purchasedate'])], ],
                        'id'=>$variables['purchase_date']
                    ],
                    [
                        'content'=>[ $row['scheme']] ,
                        'id'=>$variables['scheme']
                    ],
                    [
                        'content'=>[ $row['schemetype'] ],
                        'id'=>$variables['scheme_type']
                    ],
                    [
                        'content'=>[ $this->changeDateFormat($row['lastupdated']) ],
                        'id'=>$variables['last_update']
                    ],
                    [
                        'content'=>[ $row['certificatestatus'] ],
                        'id'=>$variables['certificate_status']
                    ],
                    [
                        'content'=>[ $row['certificatereference'] ],
                        'id'=>$variables['policy_number']
                    ],
                    // [
                    //     'content'=>$row['purchasedate'],
                    //     'id'=>30
                    // ],
                ],
                
                "duplicate_option"=> "Email"

            ];
            return $data;
        }   

    }
    
    
    public function collection(Collection $rows)
    { 

        foreach($rows as $row){
    
            $data=$this->prepareImportData($row);
            $this->importData($data);
        
        }
        
      
    }   
    public function headingRow(): int
    {
        return 1; // second row setup in excel sheet
    } 


}
