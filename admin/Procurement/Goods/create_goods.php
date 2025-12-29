<style>
	select {
      background: #f0dcf7;
	  width: 100%;
}
.table th, .table td {
	padding: 5px;
}

tr
{
  line-height: 20px;
}
.select2-results {  background: #f0dcf7; }
.select2-search input { background: #f0dcf7; }
.select2-selection__rendered { background: #f0dcf7; }
.select2-search { background: #f0dcf7; }
.select2-results__option--highlighted { background: #f0dcf7; }
.select2-results__option[aria-selected=true] { background: #f0dcf7; }


.select2-container .select2-selection--single{
	padding: 0px;
	margin-top: 4px;
	height:34px !important;
	width: 100% !important;
}

.select2-container--default .select2-selection--single{
	padding: 0px;
	border: 1px solid blue !important; 
	border-radius: 0px !important;
}
</style>
<div class="container-fluid">
    <form action="" id="journal-form">
        <div class="row">
            <div class="col-md-4 form-group">
                Package No<input style="background-color: #f0dcf7;" type="text" id="package_no" name="package_no" class="form-control form-control-sm form-control-border rounded-0" value="" required>
			
            </div>

			<div class="col-md-4 form-group">
                Package Description <textarea style="background-color: #f0dcf7;" type="text" id="package_descrip" name="package_descrip" class="form-control form-control-sm form-control-border rounded-0"></textarea>
            </div>
			<div class="col-md-2 form-group">
                Unit<input style="background-color: #f0dcf7;" type="text" id="unit" name="unit" class="form-control form-control-sm rounded-0" value="<?= isset($description) ? $description : "" ?>" required>
				
            </div>
			<div class="col-md-2 form-group">
				Quantity<input style="background-color: #f0dcf7;" type="text" id="quantity" name="quantity" class="form-control form-control-sm rounded-0" value="" required>
            </div>
			
			
			<div class="col-md-3 form-group">
                Method Type<input style="background-color: #f0dcf7;" type="text" id="procuement_type" name="procuement_type" class="form-control form-control-sm rounded-0" value="" required>
                </select>
            </div>
			<div class="col-md-3 form-group">
                Tender Approval<input style="background-color: #f0dcf7;" type="text" id="tender_approval" name="tender_approval" class="form-control form-control-sm rounded-0" value="" required>
                </select>
            </div>
			<div class="col-md-3 form-group">
                Source Funds<input style="background-color: #f0dcf7;" type="text" id="source_funds" name="source_funds" class="form-control form-control-sm rounded-0" value="" required>
                </select>
            </div>
			<div class="col-md-3 form-group">
                Est. Cost (Lac Taka)<input style="background-color: #f0dcf7;" type="text" id="cost_lac" name="cost_lac" class="form-control form-control-sm rounded-0" value="" required>
                </select>
            </div>
			<div class="col-md-2 form-group">
                Invitation Tender<input style="background-color: #f0dcf7;" type="date" id="invitation_tender" name="invitation_tender" class="form-control form-control-sm rounded-0" value="" required>
                </select>
            </div>
			<div class="col-md-2 form-group">
                Signing Contract<input style="background-color: #f0dcf7;" type="date" id="signing_contract" name="signing_contract" class="form-control form-control-sm rounded-0" value="" required>
                </select>
            </div>
			<div class="col-md-2 form-group">
                Completion Contract<input style="background-color: #f0dcf7;" type="date" id="conpletion_contract" name="conpletion_contract" class="form-control form-control-sm rounded-0" value="" required>
                </select>
            </div>
			<div class="col-md-4 form-group">
                Procurement Status<input style="background-color: #f0dcf7;" type="text" id="procurement_status" name="procurement_status" class="form-control form-control-sm rounded-0" value="" required>
                </select>
            </div>
			
<script>

</script>