<style type="text/css">
    #fiscal_table th{
        background-color: #ecf0f5;
        border: 1px solid #000;
        padding: 20px;
        text-align: center;
    }
</style>
<table id="fiscal_table">
    <tr>
        <th colspan="13" style="font-size: 16px;"><strong>Terai Hospital and Research Centre</strong><br><p>Padam Road, Birgunj, Reg No.80071/067-68 / PAN No: 601240803, Ph: 051-525252</p></th>
        
    </tr>
    <tr>
        <th colspan="13"><br><p>Padam Road, Birgunj, Reg No.80071/067-68 / PAN No: 601240803, Ph: 051-525252</p></th>
        
    </tr>
    <tr>

        <th>S.N
        </th>
        <th>
        Patient Code
        </th>
        <th>
            Patient Full Name
        </th>
        <th>
            Age/Gender
        </th>
      
        <th>
            Address
        </th>
        <th>
            Contact Number
        </th>
       
        <th>
            Nationality
        </th>

        
        <th>
            Ward/Room/Bed
        </th>

         <th>
            Admitted Date
        </th>

         <th>
            Sub Total
        </th>

            <th>
            Tax @ 5 %
        </th>

        <th>
            Grand Total
        </th>

       
        
        

    </tr>
<?php $sum=0; ?>
<?php $gTotal=0; ?>
<?php $tax=0; ?>
@foreach($patients as $key=> $report)

<tr>
<td>
{{$key+1}}.
</td>
<td>
{{$report->patient_code}}
</td>
<td>{{ucfirst($report->first_name).' '.ucfirst($report->middle_name). ' '. ucfirst($report->last_name)}}<br>

</td>

<td>
{{$report->age}}/ {{$report->gender}}
</td>

<td>
{{$report->permanent_address}}
</td>

<td>
{{$report->phone}}
</td>

<td>
{{$report->isOfNationality->country_name}} 
</td>

<td>
{{ $report->isOfWard->ward_name.'/'.$report->isOfRoom->room_name }}

</td>

<td>
<?php
        $todayDate= date('Y-m-d',strtotime($report->created_at));
        $localDate = str_replace("-", ",", $todayDate);
        $classes=explode(",",$localDate);  
        $a=$classes[0];
        $b=$classes[1];
        $c=$classes[2]; 
        echo eng_to_nep($a,$b,$c); 
       //echo date('h:i A',strtotime($report->created_at));
    ?>
</td>

<td>
{{$report->subtotal_after_discount}}
</td>

<td>
{{$report->hst}}
</td>

<td>
{{$report->total_after_tax}}
</td>

<td>


</td>

</tr>
<?php $gTotal += $report->total_after_tax; ?>
<?php $tax  += $report->hst; ?>
<?php $sum  += $report->subtotal_after_discount; ?>

@endforeach

<tr>
<td colspan="9" style="text-align: right;"><strong></strong></td>
<td rowspan="2" style="text-align: right;">
<strong>Total :{{$sum}}</strong>
</td>

<td rowspan="2" style="text-align: right;">
<strong> Total {{$tax}}</strong>
</td>

<td rowspan="2" style="text-align: right;">

<strong>Total: {{$gTotal}}</strong>
</td>


</td>
</tr>

</table>