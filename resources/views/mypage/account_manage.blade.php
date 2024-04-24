@extends("layouts.mypage")
@section('content')
<style>
	table th, table td {
		text-align: center !important;
		vertical-align: middle !important;
	}
</style>
<?php
$applicationId = "dj00aiZpPVJpRFdoRUdpY3pUaSZzPWNvbnN1bWVyc2VjcmV0Jng9MWE-";
$secret = "jOr0rr7kmvXR9r5T6ERkXfN7KpGTu4vmd8TC8Ahv";
// echo base64_encode($applicationId.":".$secret);
?>

<div class="content-wrapper">	
	<div class="content" style="padding-top: 0.5rem;">
		<div class="col-12">
			<div class="card card-info card-outline">
				<div class="card-body">
					<div class="row">
						<div id="table-wrapper" style="overflow: auto; width: 100%;">
							<table class="table table-bordered" style="width: 100%;" id="item-table">
							<!-- <table class="table table-bordered table-head-fixed" style="width: 100%;" id="item-table"> -->
								<thead>
									<tr>
										<th rowspan="1" colspan="1" style="width: 50px;">操作</th>
										<th rowspan="1" colspan="1" style="width: 100px;">ユーザー名</th>
										<th rowspan="1" colspan="1" style="width: 250px;">メール</th>
										<th rowspan="1" colspan="1" style="width: 150px;">役割</th>
										<th rowspan="1" colspan="1" style="width: 150px;">パーミッション</th>
									</tr>
								</thead>
								<tbody id="item-table-body">
									@if ($user['role'] == 'admin')
										@foreach($users as $user_item)
										
										<tr data-id={{$user_item->id}}>
											<td>
												<span style="cursor:pointer;" class="delete"><i class="fa fa-trash text-danger" aria-hidden="true"></i></span>
											</td>
											<td rowspan="1" colspan="1">{{$user_item['family_name']}}</td>
											<td rowspan="1" colspan="1">{{$user_item['email']}}</td>
											<td rowspan="1" colspan="1">{{$user_item['role']}}</td>
											<td rowspan="1" colspan="1">
												<div class="form-group">
													<div class="custom-control custom-switch">
														<input type="checkbox" class="custom-control-input permission" id={{"customSwitch".$user_item->id}} @if($user_item['is_permitted']) checked @endif>
														<label class="custom-control-label" for={{"customSwitch".$user_item->id}}></label>
													</div>
												</div>
											</td>
										</tr>
										@endforeach
									@endif
								</tbody>
							</table>
						</div>								
					</div>
				</div>
				<!-- /.card-body -->
				
				<!-- /.card-footer -->
			</div>
		</div>
	</div>
</div>
@endsection
	
@section("script")
	@include("js.js_my")

	<script>
		$(document).ready(function() {
			$('.delete').on('click', function(event) {
				
				let _tr = $(event.target).parents('tr');
				let userId = _tr.data('id');
				if (window.confirm('ユーザーを削除してもよろしいですか?')) {
					$.ajax({
						url: './delete_account',
						type: 'get',
						data: {
							id: userId
						},
						success: function(response) {
							location.href = './item_list';
							_tr.remove();
							toastr.info('ユーザーが削除されました。');
						},
						error: function(response) {
							let msg = response.responseText;
							toastr.warning(JSON.parse(msg)['message'])
						}
					});
				}
				
			});

			$('.permission').on('click', function(event) {
				let isPermitted = (event.target.checked == true) ? 1 : 0;
				$.ajax({
					url: './permit_account',
					type:'get',
					data: {
						id: event.target.id.replace("customSwitch", ""),
						isPermitted: isPermitted
					},
					success: function(response) {
						console.log(response);
					}
				});
			});
		});
	</script>
@endsection
