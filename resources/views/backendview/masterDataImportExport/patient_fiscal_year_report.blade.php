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
        <th colspan="2" class="text-center">Logo</th>
        <th colspan="10" class="text-center">Fiscal Year</th>
    </tr>
    <tr>

        <th>S.N
        </th>
        <th>
            Patient Full Name
        </th>
         <th>
            Patient Code
        </th>

        <th>
            Patient Type
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
            Consulted With
        </th>
        <th>
            Doctor Fee
        </th>
         <th>
            Doctor Fee With Tax
        </th>

         <th>
            Doctor  Tax Only
        </th>

        <th>
        Discount Percent(%)
        </th>
        <th>
            Appontment Date
        </th>

        <th>
            SubTotal 
        </th>
        <th>
            Tax 
        </th>
        <th>
            Discount
        </th>
        <th>
            GrandTotal
        </th>

         <th>
            Sub Total IPD
        </th>

        <th>
            HST @5%
        </th>

        <th>
            Total After Tax
        </th>
        

    </tr>

@foreach($excelReport as $key=> $report)

<tr>
<td>
{{$key+1}}.
</td>
<td>{{ucfirst($report->first_name).' '.ucfirst($report->middle_name). ' '. ucfirst($report->last_name)}}

</td>

<td>
{{$report->patient_code}}
</td>


<td>
{{$report->patient_type}}
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
{{ucfirst($report->isOfNationality->country_name)}}
</td>

<td>
{{ucfirst($report->isInDepartment->name)}}</td>

<td>
{{ucfirst($report->isConsultedToDoctor->first_name)}}
{{ucfirst($report->isConsultedToDoctor->middle_name)}}
{{ucfirst($report->isConsultedToDoctor->last_name)}}</td>

<td>
{{$report->doctor_fee}}
</td>



<td>
{{$report->doctor_fee_with_tax}}
</td>

<td>
{{$report->doctor_tax_only}}
</td>

<td>
{{$report->discounted_fee_value}}
</td>

<td>
{{$report->appointment}}
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
{{$report->subtotal_after_discount}}
</td>
<td>
{{$report->hst}}
</td>
<td>
{{$report->total_after_tax}}
</td>

</tr>

@endforeach



</table>