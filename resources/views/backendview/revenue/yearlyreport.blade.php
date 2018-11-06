<style type="text/css">
    #fiscal_table th{
        background-color: #ecf0f5;
        border: 1px solid #000;
        padding: 20px;
        text-align: center;
    }
</style>
<table id="fiscal_table">
<thead>
    <tr>
        <th colspan="13" style="font-size: 16px;"><strong>Terai Hospital and Research Centre</strong><br><p>Padam Road, Birgunj, Reg No.80071/067-68 / PAN No: 601240803, Ph: 051-525252</p></th>
        
    </tr>
    <tr>
        <th colspan="13"><br><p>Padam Road, Birgunj, Reg No.80071/067-68 / PAN No: 601240803, Ph: 051-525252</p></th>
        
    </tr>

    <tr>

        <th>S.N
        </th>
        <th>Patient Code</th>
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
            Department
        </th>
        <th>
            Consulted With
        </th>
        <th>
            Appontment Date
        </th>
        <th>
            Doctor Fee
        </th>
        <th>
         Discount (%) 
        </th>
        <th>
        Discounted Value
        </th>
        <th>
        Tax @5 %
        </th>
         <th>
            Doctor Fee With Tax
        </th>

        <th>
        Created By
        </th>
        
    </tr>
    </thead>
    <tbody>
            <?php $feeOnly=0; ?>
        <?php $sum=0; ?>
        <?php $discountedOnly=0; ?>
        <?php $taxOnly=0; ?>
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
                 {{$report->isInDepartment->name}} 
            <td>
            {{ucfirst($report->isConsultedToDoctor->first_name)}}
            {{ucfirst($report->isConsultedToDoctor->middle_name)}}
            {{ucfirst($report->isConsultedToDoctor->last_name)}}</td>

            <td>
           
           
            </td>

            <td>
            {{$report->doctor_fee}}
            </td>

            <td>
            {{$report->discount_percent}}
            
            </td>
            <td>
           {{$report->discounted_fee_value}}
            </td>

            <td>
            {{$report->doctor_tax_only}}
            </td>

            <td>
            {{$report->doctor_fee_with_tax}}
            </td>

            <td>
            {{$report->belongsToUser->fullname}}/
             {{$report->belongsToUser->userTypes->type_label}}
            
            
            </td>

            

        
</tr>


<?php $sum += $report->doctor_fee_with_tax; ?>
<?php $discountedOnly += $report->discounted_fee_value; ?>
<?php $taxOnly += $report->doctor_tax_only; ?>
<?php $feeOnly += $report->doctor_fee; ?>
@endforeach
<tr>
<td colspan="10" style="text-align: right;"><strong></strong></td>
<td rowspan="2" style="text-align: right;">
<strong>Total :{{$feeOnly}}</strong>
</td>
<td></td>
<td rowspan="2" style="text-align: right;">
<strong> Total {{$discountedOnly}}</strong>
</td>

<td rowspan="2" style="text-align: right;">

<strong>Total: {{$taxOnly}}</strong>
</td>

<td rowspan="2" style="text-align: right;">

<strong>Total :{{$sum}}</strong>
</td>
</tbody>
</table>