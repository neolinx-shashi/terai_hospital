{{--Marital Status from IPD Admit Form--}}
<div class="form-group row">
    <label for="marital_status" class="col-sm-1 form-control-label">Marital
        Status<label class="text-danger">*</label></label>
    <div class="col-sm-4">
        <select name="marital_status" id="marital_status" class="form-control">
            <option value="">Select Marital Status</option>
            <option value="Married" @if(old('marital_status')=='Married') <?php echo 'selected' ?> @endif>
                Married
            </option>
            <option value="Unmarried" @if(old('marital_status')=='Unmarried') <?php echo 'selected' ?> @endif>
                Unmarried
            </option>

        </select>
        @if ($errors->has('marital_status'))
            <span class="help-block" style="color: red">
                                        <strong> * {{ $errors->first('marital_status') }}</strong>
                                    </span>
        @endif
    </div>

    <label for="spouse_name" class="col-sm-1 form-control-label">Spouse
        Name</label>
    <div class="col-sm-4">
        <input type="text" class="form-control" id="spouse_name"
               name="spouse_name"
               placeholder="Spouse Name">

    </div>
</div>


{{--Dashboard Search--}}

<div class="search">
    <div class="row">
        <div class="col-md-6">
            <div class="input-group">
                <span class="input-group-addon" style="color: white; background-color: #00a7d0;">SEARCH</span>


                <input type="text" autocomplete="off" id="search" class="form-control input-lg"
                       placeholder="Enter search term here...">
            </div>
        </div>
        <div class="col-md-6">
            <!-- date -->
        <?php
        echo "<div id='myDate'>".$date = date("l jS \of F Y")."</div>";
        ?><!-- end of date -->
        </div>
    </div>
</div>