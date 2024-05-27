

<table>
   


<tbody>
<tr>
    <th>
       Month
    </th>
    <th>
        Customer Name
    </th> 
    <th>
        Quantity
    </th>
    <th>
        Product Name
    </th> 
</tr>
@forelse($forecast as $key=> $report) 
    

    <tr>
        <th>
            {{$key}}
        </th>
        <th>
        </th> 
        <th>
        </th>
        <th>
        </th>  
    </tr>    
    @forelse($report as $data)
        <tr>
            <td></td>
            <td>{{$data['customer']}}</td>
            <td>{{$data['quantity']}}</td>
            <td>{{$data['product']}}</td>
        </tr>
    @empty   
    @endforelse 


@empty


@endforelse
</tbody>
<table>
