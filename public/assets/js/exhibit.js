var newCsvResult = [];

$('body').on('change', '#csv_load', function(e) {
	newCsvResult = [];
	var csv = $('#csv_load');
	var csvFile = e.target.files[0];

	var ext = csv.val().split(".").pop().toLowerCase();
	if ($.inArray(ext, ["csv"]) === -1) {
		toastr.error('CSVファイルを選択してください。');
		return false;
	}
	
	if (csvFile !== undefined) {

		reader = new FileReader();
		reader.onload = function (e) {
			$('#csv-name').html(csvFile.name)
			$('#count').css('visibility', 'visible');

			csvResult = e.target.result.split(/\n/);

			for (let i of csvResult) {
				let code = i.split('\r');
				code = i.split('"');

				if (code.length == 1) {
					code = i.split('\r');
					if (code[0] != '') {
						newCsvResult.push(code[0]);
					}
				} else {
					newCsvResult.push(code[1]);
				}
			}

			if (newCsvResult[0] == 'ASIN' || newCsvResult[0] == 'asin' || newCsvResult[0] == 'JAN' || newCsvResult[0] == 'jan') {
				newCsvResult.shift();
			}
			
			if (newCsvResult.length > 5000) {
				toastr.error('ファイルに5000以上のコードがあります。別のファイルを選択するか、個数を減らしてください。');
				return;
			}

			$('#total-num').html(newCsvResult.length);
			// console.log(newCsvResult);
		}
		reader.readAsText(csvFile);
		// $("#csv_load")[0].value = '';
	}
});

const scanDB = () => {
	$.ajax({
		url: "./scan",
		type: "get",
		success: function(response) {
			// console.log(response);
			$('#progress-num').html(response);
			let percent = Math.floor(response / newCsvResult.length * 100);
			$('#percent-num').html(percent + '%');
			$('#progress').attr('aria-valuenow', percent);
			$('#progress').css('width', percent + '%');
		}
	})
};

const addCsv = () => {
	if (!isPermitted) {
		toastr.error('管理者から許可を得てください。');
		return;
	}

	if (!newCsvResult.length) {return;}
	jQuery.ajax({
		url: "http://keepaautobuy.xsrv.jp/fmproxy/api/v1/yahoos/get_info",
		// url: "http://localhost:32768/api/v1/yahoos/get_info",
		type: "post",
		data: {
			index: index,
			code_kind: $('input[name="code_kind"]:checked').val(),
			code: JSON.stringify(newCsvResult),
		},
	});
	
	setInterval(scanDB, 5000);
};
