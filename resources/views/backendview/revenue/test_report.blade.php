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
            Created On
        </th>

         <th>
            Sub Total
        </th>

         <th>
            Tax @ 5 %
        </th>

         <th>
            Discount
        </th>

         <th>
            Grand Total
        </th>

       

       
     
        

    </tr>
<?php $sum=0; ?>
<?php $taxOnly=0; ?>
<?php $discountTotal =0; ?>
<?php $gTotal=0; ?>
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
{{$report->sub_total}}
</td>

<td>
{{$report->tax}}
</td>

<td>
{{$report->discount}}
</td>

<td>
{{$report->grand_total}}
</td>




</tr>
<?php $discountTotal += $report->discount; ?>
<?php $taxOnly += $report->tax; ?>
<?php $sum += $report->sub_total; ?>
<?php $gTotal +=$report->grand_total; ?>
@endforeach

<tr>
<td colspan="7" style="text-align: right;"><strong></strong></td>
<td rowspan="2" style="text-align: right;">
<strong>Total :{{$sum}}</strong>
</td>
<td rowspan="2" style="text-align: right;">

<strong>Total: {{$taxOnly}}</strong>
</td>
<td rowspan="2" style="text-align: right;">
<strong> Total {{$discountTotal}}</strong>
</td>



<td rowspan="2" style="text-align: right;">

<strong>Total :{{$gTotal}}</strong>
</td>
</table>