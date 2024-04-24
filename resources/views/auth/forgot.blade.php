@extends("layouts.auth")

@section("content")
	<div class="login-box">
		<div class="login-logo">
			<a href="#" style="color: white; text-shadow: 1px 1px 2px black, 0 0 25px blue, 0 0 5px darkblue;">ヤフカリ</a>
		</div>

		<div class="card">
			<div class="card-body login-card-body">
				<div id="contact-page" class="container">
					<div class="bg">
						<div class="row">
							<div class="col-sm-12">
								<h3 class="title text-center">パスワードを変更する</h3>
							</div>
						</div>
						<div class="row center">
							<div class="login-form col-sm-12">          
								<form method="GET" action="{{ route('reset') }}" id="forget" onsubmit="validate(event)">
									<div class="input-group mb-3">
										<input type="email" class="form-control" placeholder="Email" name="email" id="email">
										<div class="input-group-append">
											<div class="input-group-text">
												<span class="fas fa-envelope"></span>
											</div>
										</div>
									</div>

									<div>
										ご登録したメールアドレスにパスワード再設定のご案内が送信されます。
									</div>
									<input type="submit" value="送信する" class="btn btn-primary btn-user btn-block">
								</form>
							</div>
						</div>
					</div>	
				</div><!--/#contact-page-->
			</div>
			<!-- /.login-card-body -->
		</div>
	</div>

	<div id="toast-container" class="toast-top-right"></div>
@endsection

<script>
	let emails = <?php echo $emails; ?>;
	const validate = function (e) {
		let addr = document.getElementById('email').value;
		let addrs = [];
		for (const addr of emails) {
			addrs.push(addr.email);
		}

		console.log(addrs);
		
		if (addrs.indexOf(addr) == -1) {
			e.preventDefault();
			toastr.error('登録されたメールではありません。');
			setTimeout(() => {
				location.href = "/";
			}, 5000);
			return false;
		} else {
			toastr.success('情報が正常に送信されました。');
			setTimeout(() => {
				location.href = "/";
			}, 5000);
			return true;
		}
	};
</script>