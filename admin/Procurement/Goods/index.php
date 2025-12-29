<?php
function format_num($number){
	$decimals = 0;
	$num_ex = explode('.',$number);
	$decimals = isset($num_ex[1]) ? strlen($num_ex[1]) : 2 ;
	return number_format($number,$decimals);
}
?>
<style>
	th.p-0, td.p-0{
		padding: 0 !important;
	}

.form-container {
	width: 100%;
	display: flex;
	flex-wrap: wrap; /* Allow items to wrap to the next line if needed */
	gap: 10px; /* Adjust spacing between items as needed */
}

/* Style for the side-by-side input boxes */
.side-by-side {
	flex: 1; /* Grow to take available space */
}

/* Style for the full-width input box */
.full-width {
	flex: 2; /* Grow to take more available space */
	width: 100%; /* Take 100% of available width */
}	

	select {
      background: #f0dcf7;
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
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">Procurement Goods Entries</h3>
		<div class="card-tools">
			<button class="btn btn-primary btn-flat btn-sm" id="create_new" type="button"><i class="fa fa-pen-square"></i> Procurement Goods Entries</button>
		</div>
	</div>
	<div class="card-body">
        <div class="container-fluid">
			
		</div>
	</div>
</div>
<hr class="border-border bg-primary">

<script>
	$(document).ready(function(){
		$('#create_new').click(function(){
			uni_modal("New Debit Voucher Entry","Procurement/Goods/create_goods.php",'large')
		})
		$('.edit_data').click(function(){
			uni_modal("Edit Debit Voucher Entry","journalsDebitVoucher/manage_journal.php?id="+$(this).attr('data-id'),"large")
		})
		$('.duplicate_data').click(function(){
			uni_modal("Duplicate Debit Voucher Entry","journalsDebitVoucher/manage_journal_dup.php?id="+$(this).attr('data-id'),"large")
		})
		$('.delete_data').click(function(){
			_conf("Are you sure to delete this Journal Entry permanently?","delete_book",[$(this).attr('data-id')])
		})
		
		$('.table td,.table th').addClass('py-1 px-2 align-middle')
		
		$('.table').dataTable({
            columnDefs: [
                { orderable: true,  ordering: true, sorting: true, targets: 2 }
            ],
        });
	})
	
	function delete_book($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_journal",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("An error occured.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.reload();
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
</script>