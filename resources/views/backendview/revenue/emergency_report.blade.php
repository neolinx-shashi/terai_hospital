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
            Patient Full Name/Code
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
            Department
        </th>


         <th>
            Bed
        </th>
       

        <th>
            Emergency Charge
        </th>

        <th>
            Emergency Charge @5 %
        </th>


        <th>
            Emergency Total With Tax
                    </th>

        <th>
            Discharge Total
        </th>

        <th>
            Tax @5 %
        </th>

         <th>
            Discount

        </th>

        <th>
            Discharge Total With Tax

        </th>

         <th>
             Total Charge With Tax

        </th>

         <th>
            Created By
        </th>

        <th>
            Admitted On
        </th>

       


        
       
        

    </tr>
<?php $sum=0; ?>
<?php $dischargeSum=0; ?>
<?php $emerTaxOnly=0; ?>
<?php $totalEmergencyFee=0; ?>
<?php $dischargeSubTotal=0; ?>
<?php $dischargeTaxOnly=0; ?>
<?php $dischargeDiscount =0; ?>
<?php $dischargeGrandTotal =0; ?>
@foreach($patients as $key=> $report)

<tr>
<td>
{{$key+1}}.
</td>
<td>
{{$report->patient_code}}
</td>

<td>{{ucfirst($report->first_name).' '.ucfirst($report->middle_name). ' '. ucfirst($report->last_name)}}<br>/
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
{{$report->isInDepartment->name}}

</td>

<td>
{{$report->isOfBed->bed_name}}

</td>

<td>
{{$report->doctor_fee}}
</td>

<td>
{{$report->doctor_tax_only}}
</td>
<td>
{{$report->doctor_fee_with_tax}}
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



<td>
{{($report->grand_total)+($report->doctor_fee_with_tax)}}
</td>

<td>
 {{$report->belongsToUser->fullname}}/
{{$report->belongsToUser->userTypes->type_label}}

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
     
       echo date('h:i A',strtotime($report->created_at));
    ?>
</td>

</tr>
<?php  $sum+=$report->doctor_fee; ?>
<?php  $dischargeSum+=$report->grand_total; ?>
<?php $emerTaxOnly+=$report->doctor_tax_only; ?>
<?php $dischargeSubTotal+=$report->sub_total; ?>
<?php $dischargeDiscount+=$report->discount; ?>
<?php $dischargeTaxOnly+=$report->tax; ?>
<?php $dischargeGrandTotal+=$report->grand_total; ?>
<?php $totalEmergencyFee+=$report->doctor_fee_with_tax; ?>
@endforeach

<tr>
<td colspan="9" style="text-align: right;"><strong></strong></td>
<td rowspan="2" style="text-align: right;">
<strong>Total :{{$sum}}</strong>
</td>

<td rowspan="2" style="text-align: right;">
<strong> Total {{$emerTaxOnly}}</strong>
</td>

<td rowspan="2" style="text-align: right;">
<strong> Total {{$totalEmergencyFee}}</strong>
</td>

<td rowspan="2" style="text-align: right;">
<strong> Total {{$dischargeSubTotal}}</strong>
</td>

<td rowspan="2" style="text-align: right;">
<strong> Total {{$dischargeTaxOnly}}</strong>
</td>


<td rowspan="2" style="text-align: right;">
<strong> Total {{$dischargeDiscount}}</strong>
</td>

<td rowspan="2" style="text-align: right;">
<strong> Total {{$dischargeGrandTotal}}</strong>
</td>

<td rowspan="2" style="text-align: right;">
<strong> Total {{$dischargeGrandTotal+$totalEmergencyFee}}</strong>
</td>




</table>