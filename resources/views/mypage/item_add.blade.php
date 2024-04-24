@extends("layouts.mypage")
@section('content')
<style>
	.custom-file-label::after {
		content: "ファイルを選択" !important;
		background-color: #17a2b8 !important;
		color: white !important;
	}
</style>

<div id="toast-container" class="toast-top-right"></div>
<div class="content-wrapper">
	<div class="content" style="padding-top: 0.5rem;">
		<div class="col-12">
			<div class="card card-info card-outline card-outline-tabs">
				<div class="card-header p-0 border-bottom-0">
					<ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" id="custom-tabs-csv-tab" data-toggle="pill" href="#custom-tabs-csv" role="tab" aria-controls="custom-tabs-add" aria-selected="true">csv出品</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="custom-tabs-setting-tab" data-toggle="pill" href="#custom-tabs-setting" role="tab" aria-controls="custom-tabs-setting" aria-selected="true">設定</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="custom-tabs-token-tab" data-toggle="pill" href="#custom-tabs-token" role="tab" aria-controls="custom-tabs-token" aria-selected="true">ID情報</a>
						</li>
					</ul>		  
				</div>

				<div class="card-body">
					<div class="tab-content" id="custom-tabs-four-tabContent">
						<div class="tab-pane fade show active" id="custom-tabs-csv" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
							<form class="form-horizontal">
								<div class="card-body" style="padding:0px">
									<div class="form-group row">
										<div class="col-sm-1">
											<div class="icheck-primary d-inline float-left mr-4">
												<input type="radio" id="radioASIN" name="code_kind" value="1" checked />
												<label for="radioASIN">ASIN</label>
											</div>
										</div>
										<div class="col-sm-1">
											<div class="icheck-primary d-inline float-left">
												<input type="radio" id="radioJAN" name="code_kind" value="0" />
												<label for="radioJAN">JAN</label>
											</div>
										</div>
									</div>

									<div class="form-group row">
										<div class="col-sm-6">
											<div class="custom-file">
												<input type="file" class="custom-file-input" id="csv_load" name="csv_load" accept=".csv">
												<label class="custom-file-label" for="csv_load" id="csv-name">csvファイルを選択してください。</label>
											</div>
										</div>
									</div>

									<div class="form-group row" id="count">
										<div class="progress col-sm-6">
											<div class="progress-bar progress-bar-animated bg-info progress-bar-striped" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%" id="progress">
												<span id="percent-num">0%</span>
											</div>
										</div>

										<div class="col-sm-2">
											<p class="float-right">
												<span id="progress-num">0</span> 件/ <span id="total-num">0</span> 件
											</p>
										</div>
									</div>

									<div class="form-group row">
										<label for="registerPrice" class="col-sm-2 col-form-label">現在価格の</label>
										<div class="col-sm-2">
											<select class="custom-select rounded-0" id="registerPrice" name="register" onchange="changePercent(event);">
												<option @if ($user->y_register_percent == 5) selected @endif><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">5</font></font></option>
												<option @if ($user->y_register_percent == 10) selected @endif><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">10</font></font></option>
												<option @if ($user->y_register_percent == 15) selected @endif><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">15</font></font></option>
												<option @if ($user->y_register_percent == 20) selected @endif><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">20</font></font></option>
												<option @if ($user->y_register_percent == 25) selected @endif><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">25</font></font></option>
												<option @if ($user->y_register_percent == 30) selected @endif><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">30</font></font></option>
												<option @if ($user->y_register_percent == 35) selected @endif><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">35</font></font></option>
												<option @if ($user->y_register_percent == 40) selected @endif><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">40</font></font></option>
												<option @if ($user->y_register_percent == 45) selected @endif><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">45</font></font></option>
												<option @if ($user->y_register_percent == 50) selected @endif><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">50</font></font></option>
												<option @if ($user->y_register_percent == 55) selected @endif><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">55</font></font></option>
												<option @if ($user->y_register_percent == 60) selected @endif><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">60</font></font></option>
												<option @if ($user->y_register_percent == 65) selected @endif><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">65</font></font></option>
												<option @if ($user->y_register_percent == 70) selected @endif><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">70</font></font></option>
												<option @if ($user->y_register_percent == 75) selected @endif><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">75</font></font></option>
												<option @if ($user->y_register_percent == 80) selected @endif><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">80</font></font></option>
												<option @if ($user->y_register_percent == 85) selected @endif><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">85</font></font></option>
												<option @if ($user->y_register_percent == 90) selected @endif><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">90</font></font></option>
												<option @if ($user->y_register_percent == 95) selected @endif><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">95</font></font></option>
												<option @if ($user->y_register_percent == 100) selected @endif><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">100</font></font></option>
											</select>
										</div>
										<label for="registerPrice" class="col-sm-2 col-form-label">％で登録する</label>
									</div>
								</div><!-- /.card-body -->

								<div class="card-footer">
									<button type="button" class="btn btn-info float-left" id="add_csv" onclick="addCsv();">トラッキング登録</button>
									<button type="button" class="btn btn-info ml-2" id="stop_add_csv" onclick="stopAddCsv();">一時停止</button>
									<button type="button" class="btn btn-info ml-2" id="end_add_csv" onclick="endAddCsv();">処理終了</button>
								</div><!-- /.card-footer -->
							</form>
						</div>

						<div class="tab-pane fade" id="custom-tabs-setting" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
							<form class="form-horizontal">
								<div class="card-body" style="padding:0px">
									<div class="form-group row">
										<label for="exclusion_key" class="col-sm-2 col-form-label">除外ワード</label>
										<div class="col-sm-6">
											<input type="text" class="form-control" id="exclusion_key" name="exclusion_key" placeholder="除外ワード1 除外ワード2..." value="{{ $user['ex_key'] }}">
											<label for="exclusion_key" class="col-sm-12 col-form-label text-danger">（半角スペース区切りでAND条件として複数登録可）</label>
										</div>
									</div>
									
									<div class="form-group row">
										<label for="code" class="col-sm-2 col-form-label">送料
											<i class="far fa-question-circle tooltip-wide"></i>
										</label>
										
										<div class="col-sm-4 pt-2">
											<div class="icheck-primary d-inline col-sm-6">
												<input type="radio" id="radiofee1" name="fee_include" value="1" @if ($user['fee_include'] == 1) checked @endif />
												<label for="radiofee1">含む</label>
											</div>
											<div class="icheck-primary d-inline col-sm-6">
												<input type="radio" id="radiofee2" name="fee_include" value="0" @if ($user['fee_include'] == 0) checked @endif />
												<label for="radiofee2">含まない</label>
											</div>
										</div>
									</div>

									<div class="form-group row">
										<label for="priceRange" class="col-sm-2 col-form-label">登録対象価格範囲<br/>（現在価格）</label>
										<div class="col-sm-2">
											<input type="number" class="form-control" id="y_lower_bound" name="y_lower_bound" placeholder="" value="{{ $user['y_lower_bound'] }}">
										</div>
										<label for="priceRange" class="col-sm-1 col-form-label">円〜</label>
										<div class="col-sm-2">
											<input type="number" class="form-control" id="y_upper_bound" name="y_upper_bound" placeholder="" value="{{ $user['y_upper_bound'] }}">
										</div>
										<label for="priceRange" class="col-sm-1 col-form-label">円</label>
									</div>
								</div><!-- /.card-body -->

								<div class="card-footer">
									<button class="btn btn-info float-left" onclick="saveInfo(event);">保存</button>
								</div><!-- /.card-footer -->
							</form>
						</div>

						<div class="tab-pane fade" id="custom-tabs-token" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
							<form class="form-horizontal">
								<div class="card-body" style="padding:0px">
									<div class="form-group row">
										<label for="inputToken" class="col-sm-12 col-form-label text-danger">Yahoo!!アプリケーション情報を入力してください。</label>

										<label for="inputToken" class="col-sm-3 col-form-label">Yahoo!!アプリケーションID1</label>
										<div class="col-sm-6">
											<input type="text" class="form-control" id="token" name="token" value="{{ $user->yahoo_token }}"/>
										</div>
									</div>
									<div class="form-group row">
										<label for="inputToken" class="col-sm-3 col-form-label">Yahoo!!アプリケーションID2</label>
										<div class="col-sm-6">
											<input type="text" class="form-control" id="token1" name="token1" value="{{ $user->yahoo_token1 }}" />
										</div>
									</div>
									<div class="form-group row">
										<label for="inputToken" class="col-sm-3 col-form-label">Yahoo!!アプリケーションID3</label>
										<div class="col-sm-6">
											<input type="text" class="form-control" id="token2" name="token2" value="{{ $user->yahoo_token2 }}" />
										</div>
									</div>
								</div><!-- /.card-body -->

								<div class="card-footer">
									<button type="button" class="btn btn-info float-left" onclick="saveToken(event);">保存</button>
								</div><!-- /.card-footer -->
							</form>
						</div>
					</div>
				</div><!-- /.card-body -->
			</div>
		</div>
	</div>	
</div>
@endsection

@section("script")
@include("js.js_my")
<script>
	var index = <?php echo $user->id; ?>;
	var isPermitted = <?php echo $user['is_permitted']; ?>;
	var isReg = 0;
	var user = <?php echo $user; ?>;
	var existingNumber = 0;

	$(document).ready(function() {
		isReg = <?php echo $user->is_registering; ?>;
		user = <?php echo $user; ?>;
		$('#stop_add_csv').attr('disabled', true);
		$('#end_add_csv').attr('disabled', true);
		if (isReg == 1) {
			scanDB();
			setInterval(scanDB, 5000);
			$('#csv-name').html(user.name);
			$('#total-num').html(user.len);
			$('#csv_load').attr('disabled', true);
			$('#add_csv').attr('disabled', true);
			$('#stop_add_csv').attr('disabled', false);
			$('#end_add_csv').attr('disabled', false);
		}
	});

	const saveInfo = (e) => {
		e.preventDefault();
		let percent = $('select[name="register"]').val();
		$.ajax({
			url: './register_tracking',
			type: 'get',
			data: {
				percent: $('select[name="register"]').val(),
				lower: $('input[name="y_lower_bound"]').val(),
				upper: $('input[name="y_upper_bound"]').val(),
				ex_key: $('input[name="exclusion_key"]').val(),
				fee: $('input[name="fee_include"]:checked').val()
			},
			success: function(result) {
				toastr.success('設定が正常に保存されました。');
			}
		});
	};

	const saveToken = () => {
		$.ajax({
			url: './register_token',
			type: 'post',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				token: $('input[name="token"]').val(),
				token1: $('input[name="token1"]').val(),
				token2: $('input[name="token2"]').val(),
			},
			success: function() {
				toastr.success('トークン情報が正常に保存されました。');
			}
		});
	};
	
	const setRegState = (state) => {
		$.ajax({
			url: 'set_registering_state',
			type: 'get',
			data: {
				state: state
			}
		});
	};

	var newCsvResult = [];
	var scanInterval;
	var csvFile = '';
	$('body').on('change', '#csv_load', async function(e) {
		await $.ajax({
			url: 'get_registering_state',
			type: 'get',
			success: function(response) {
				isReg = response;
			}
		});
		
		if (isReg == 1) {
			toastr.error('別のファイルのアップロードが進行中です。<br/>少々お待ちください。');
			return;
		} else if (isReg == 0 || isReg == 2) {
			newCsvResult = [];
			var csv = $('#csv_load');
			csvFile = e.target.files[0];

			$('#progress-num').html('0');
			$('#percent-num').html('0%');
			$('#progress').attr('aria-valuenow', 0);
			$('#progress').css('width', '0%');

			var ext = csv.val().split(".").pop().toLowerCase();
			var codeKind = $('input[name="code_kind"]:checked').val();
			if ($.inArray(ext, ["csv"]) === -1) {
				toastr.error('CSVファイルを選択してください。');
				return false;
			}
			var asinCheck = /^(B[\dA-Z]{9}|\d{9}(X|\d))$/;
			var janCheck = /^(\d{13})?$/;
			if (csvFile !== undefined) {
				reader = new FileReader();
				reader.onload = function (e) {
					$('#count').css('visibility', 'visible');
					csvResult = e.target.result.split(/\n/);

				
					if(codeKind == 1) {							
						for (const i of csvResult) {

							let code = i.split('"');

							if (asinCheck.test(code[1])) {
								newCsvResult.push(code[1]);
							} else {
								toastr.error("無効な入力値が含まれています。")
							}
						}
					} else {
						for (const i of csvResult) {

							text_jan = parseFloat(i)

							if (janCheck.test(text_jan)) {
									newCsvResult.push(text_jan);
							} else {
								toastr.error("無効な入力値が含まれています。")
							}
						}
					}

								
					if (newCsvResult[0] == 'ASIN') { newCsvResult.shift(); }

					$('#csv-name').html(csvFile.name);
					$('#total-num').html(newCsvResult.length);
				}
				reader.readAsText(csvFile);
			}
		}
	});

	const scanDB = () => {
		$.ajax({
			url: "./scan",
			type: "get",
			success: function(response) {
				$('#progress-num').html(response.register_number);
				
				let percent = Math.floor(response.register_number / response.len * 100);
				$('#percent-num').html(percent + '%');
				$('#progress').attr('aria-valuenow', percent);
				$('#progress').css('width', percent + '%');

				if (percent == 100) {
					clearInterval(scanInterval);
					$.ajax({
						url: "./reset_register",
						type: "get",
						success: function(_response) {
							console.log(_response.successCount, _response.allCount);
							toastr.success( `${_response.successCount - existingNumber}/${_response.allCount} 正常に登録されました。`);
							$('#csv_load').attr('disabled', false);
							$('#add_csv').attr('disabled', false);
							$('#stop_add_csv').attr('disabled', true);
							$('#end_add_csv').attr('disabled', true);
							setTimeout(function() { location.href = './item_list'; }, 2000);
						}
					});

				}
			}
		});
	};

	const addCsv = async () => {
		if (!isPermitted) {
			toastr.error('管理者の承認をお待ちください。');
			return;
		}
		let isRegisteringCheckResponse
		try {
			isRegisteringCheckResponse = await $.ajax({  
				url: './check_other_registering_status',
				type: 'GET',
			});
		} catch (error) {
			return;
		}

		console.log(isRegisteringCheckResponse);

		if(isRegisteringCheckResponse.isRegistering) {
			toastr.error('現在商品登録中です。後にもう一度やり直してください。');
			return;
		}


		if (!newCsvResult.length) return;

		await $.ajax({
			url: './get_allitems',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			type: 'post',
			success: function(response) {
				existingNumber = response.length;
			}
		});
		
		if (Number(existingNumber) > 4999) {
			toastr.error('5000件（登録上限数）登録しております。登録済みの商品を削除して再度お試しください。');
			return;
		}

		if (Number(existingNumber) + Number(newCsvResult.length) > 5000) {
			var diff = 5000 - Number(existingNumber);
			toastr.info(existingNumber + '件登録していますので' + diff + '件登録を開始します。');
			var newCsvResults = newCsvResult.slice(0, diff);
		} else {
			toastr.info(existingNumber + '件登録していますので' + newCsvResult.length + '件登録を開始します。');
			var newCsvResults = newCsvResult;
		}
 
		$('#total-num').html(newCsvResults.length);

		let postData = {
			len: newCsvResults.length,
			name: csvFile.name
		};

		await $.ajax({
			url: './save_name_index',
			type: 'get',
			data: {
				len: newCsvResults.length,
				name: csvFile.name
			}
		});

		await setRegState(1);
		$.ajax({
			url: "https://yahookari.com/fmproxy/api/v1/yahoos/get_info",
			type: "post",
			data: {
				index: index,
				code_kind: $('input[name="code_kind"]:checked').val(),
				code: JSON.stringify(newCsvResults),
			},
		});


		scanInterval = setInterval(scanDB, 500);
		$("#csv_load").attr('disabled', true);
		$("#add_csv").attr('disabled', true);
		$('#stop_add_csv').attr('disabled', false);
		$('#end_add_csv').attr('disabled', false);
	};

	let toggle =true;
	const stopAddCsv = async () => {
		if(toggle){
			$.ajax({
				url: "https://yahookari.com/fmproxy/api/v1/yahoos/change_status",
				type: "post",
				data: {
					add_csv_status: JSON.stringify("stop"),
				},
			});
			toggle =false;
			document.getElementById("stop_add_csv").innerHTML ="再開";
		}else{
			$.ajax({
				url: "https://yahookari.com/fmproxy/api/v1/yahoos/change_status",
				type: "post",
				data: {
					add_csv_status: JSON.stringify("start"),
				},
			});
			toggle =true;
			document.getElementById("stop_add_csv").innerHTML ="一時停止";
		}
	
		$("#csv_load").attr('disabled', true);
		$("#add_csv").attr('disabled', true);
	};

	const endAddCsv = async () => {
		if (window.confirm('本当にデータを削除しますか?')) {
			await setRegState(0);
			$.ajax({
				url: "https://yahookari.com/fmproxy/api/v1/yahoos/exit_register",
				type: "post"
			});
			$.ajax({
				url: "./reset_register",
				type: "get",
				success: function(_response) {
					$('#csv_load').attr('disabled', false);
					$('#add_csv').attr('disabled', false);
					$('#stop_add_csv').attr('disabled', true);
					$('#end_add_csv').attr('disabled', true);
					document.location.reload();
				}
			});
		}
		
	};

	const changePercent = (e) => {
		$.ajax({
			url: './change_percent',
			type: 'get',
			data: {
				pro: $(e.target).val()
			}
		});
	};
</script>
@endsection