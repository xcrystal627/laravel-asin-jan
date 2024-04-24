<?php

namespace App\Http\Controllers;


use App\Models\Item;
use App\Models\User;
use ZipArchive;

use Illuminate\Support\Facades\Mail;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MypageController extends Controller
{  
	public function index() {
		$user = Auth::user();
		$item_cnt = Item::where('user_id', $user->id)->where('status', 1)->count();
		$error_cnt = Item::where('user_id', $user->id)->where('status', 0)->count();
		return view('mypage.dashboard', ['user' => $user, 'item_cnt' => $item_cnt, 'error_cnt' => $error_cnt]);
	}

	public function itemAdd() {
		$user = Auth::user();
		return view('mypage.item_add', ['user' => $user]);
	}
	
	public function item_list(Request $request) {
		$user = Auth::user();
		$sort = $request->sort;
		$type = $request->type;
		
		if(empty($sort)){
			$items = Item::where('user_id', $user->id)->where('status', 1)->where('jan','<>', null)->where('y_register_price','<>', null)->orderBy('id', 'desc')->paginate(50);			
		}else {			
			$items = Item::where('user_id', $user->id)->where('status', 1)->where('jan','<>', null)->where('y_register_price','<>', null)->orderBy($type, $sort)->paginate(50);
		}
		return view('mypage.item_list', ['user' => $user, 'items' => $items,'sort' => $sort, 'type' => $type ]);
	}

	public function error_list() {
		$user = Auth::user();
		
		$all_items = Item::where('user_id', $user->id)->where('status', 0)->orderBy('created_at', 'desc')->get();
		foreach ($all_items as $key => $value) {
			if($key > 5000) {
				$del_id = $all_items[$key];
				Item::where('id', $del_id->id)->delete();
			}
		}
		$items = Item::where('user_id', $user->id)->where('status', 0)->orderBy('created_at', 'desc')->paginate(50);

		return view('mypage.error_list', ['user' => $user, 'items' => $items]);
	}

	public function itemEdit($id) {
		$item = Item::find($id);
		return $item;
	}

	public function saveItem(Request $request) {
		$res = $request->all();
		$res["user_id"] = Auth::user()->id;
		
		$common_id = Item::select('id')->where('id', $res["sel"])->where('user_id', Auth::user()->id)->get();

		if (count($common_id) > 0) {			
			$sel = $res["sel"];
			unset($res["sel"]);
			Item::where("id", $sel)->update($res);
			$sel = Item::where("id", $sel)->get();
			echo json_encode($sel);
		} else {
			unset($res["sel"]);
			$sel = Item::create($res);
			$sel = Item::where("id", $sel["id"])->get();
			echo json_encode($sel);
		}
	}

	public function delete_item(Request $request) {
		$ids = json_decode($request['ids']);
		// Item::whereIn('id', $ids)->delete();

		foreach(array_chunk($ids, 500) as $arr) {
			Item::whereIn('id', $arr)->delete();
			
		};

		// foreach($ids as $id) {
		// 	Item::where('id', $id)->delete();
		// }
		return;

	}

	public function scanDB() {
		$user = User::find(Auth::user()->id);
		return $user;
	}

	public function checkOtherRestigerStatus() {
		$isRegisteringUser =  User::where('is_registering', 1)->get();


		if(count($isRegisteringUser) > 0) {
			$data = [
				'isRegistering' => true
			];
		} else {
			$data = [
				'isRegistering' => false
			];
		}

		return response()->json($data, 200);
	}

	public function resetRegisterValues( ) {
		// $user = User::find(Auth::user()->id);
		$allCountForRegiseter = User::find(Auth::user()->id)->len;
		User::where('id', Auth::user()->id)->update([
			'register_number' 	=> 0, 
			'is_registering' 	=> 0,
			'len'				=> 0 
		]);

		$itemsAfterRegsiter = Item::where('user_id', Auth::user()->id)->where('status', 1)->get();

		$data = [
			'successCount'	=>  count($itemsAfterRegsiter),
			'allCount' 		=>  $allCountForRegiseter
		];

		return response()->json($data, 200);
	}

	public function manage_account() {
		$user = Auth::user();
		$users = User::all();
		return view('mypage.account_manage', ['user' => $user, 'users' => $users]);
	}

	public function delete_account(Request $request) {
		$id = $request->id;
		$user_id = Auth::user()->id;
		if($user_id == $id) {
			return response()->json(array('message'=> "このアカウントは削除できません!"), 400);
		}
		User::find($id)->delete();
		Item::where('user_id', $id)->delete();
	}

	public function permit_account(Request $request) {
		$id = $request['id'];
		$user = User::find($id);
		$user->is_permitted = $request['isPermitted'];
		$user->save();
	}

	public function register_tracking(Request $request) {
		$user = User::find(Auth::user()->id);
		$user['y_register_percent'] = $request['percent'];
		$user['y_lower_bound'] = $request['lower'];
		$user['y_upper_bound'] = $request['upper'];
		$user['fee_include'] = $request['fee'];
		$user['ex_key'] = $request['ex_key'];
		$user->save();
	}

	public function save_name_index(Request $request)
	{
		$user = User::find(Auth::user()->id);
		$user['len'] = $request['len'];
		$user['name'] = $request['name'];
		$user->save();
	}

	public function update_tracking(Request $request)
	{
		$user = User::find(Auth::user()->id);
		$user['y_register_percent'] = $request['percent'];
		$user->save();
		$items = Item::where('user_id', Auth::user()->id)->get();
		foreach ($items as $item) {
			$item['y_register_price'] = $item['y_min_price'];
			$item['y_target_price'] = $item['y_min_price'] * $request['percent'] / 100;
			$item->save();
			// sleep(2);
		}
	}

	// public function shop_list($id) {
	// 	$user = Auth::user();
	// 	$item = Item::find($id);
	// 	$lists = json_decode($item->y_shops);
	// 	$prs = array();
	// 	$pos = array();
	// 	$total = array();

	// 	if ($lists != null && count($lists) > 0) {
	// 		foreach($lists as $list) {
	// 			$curl = curl_init();
	
	// 			curl_setopt_array($curl, array(
	// 				CURLOPT_RETURNTRANSFER => 1,
	// 				CURLOPT_URL => $list
	// 			));
	
	// 			$response = curl_exec($curl);
				
	// 			$price_regex = '/span class="elPriceNumber">[0-9,]+/';
	// 			preg_match($price_regex, $response, $price);
	// 			if ($price == null) {
	// 				$pr = 0;
	// 			} else {
	// 				$pr = preg_replace('/\D/', '', html_entity_decode($price[0]));
	// 			}			
	// 			array_push($prs, $pr);
	
	// 			if ($user->fee_include == 0) {
	// 				$po = 0;
	// 			} else {
	// 				$postage_regex = '/送料[0-9,]+円/';
	// 				preg_match($postage_regex, $response, $postage);
	// 				if ($postage == null) {
	// 					$po = 0;
	// 				} else {
	// 					$po = preg_replace('/\D/', '', html_entity_decode($postage[0]));
	// 				}
	// 				array_push($pos, $po);
	// 			}
				
	// 			$list = 'https://ck.jp.ap.valuecommerce.com/servlet/referral?sid=3546031&pid=888145296&vc_url=' . urlencode($list);
	// 			$total[$list] = $pr + $po;
	// 			// array_push($total, $pr + $po);
	// 		}
			
	// 		asort($total);
	
	// 		$item->y_min_price = reset($total);
	// 		$item->y_register_price = reset($total);
	// 		$item->y_target_price = round(reset($total) * $user->y_register_percent / 100);
	// 		$item->save();
			
	// 		header('Location: ' . array_keys($total, reset($total))[0]);
	// 		die();
	// 	} else {
	// 		header('Location: ' . $item['y_shop_list']);
	// 		die();
	// 	}

	// 	// return view('mypage.shop_list', ['user' => $user, 'lists' => $lists, 'total' => $total]);
	// }

	public function shop_list($id) {
		$total = array();
		$item = Item::find($id);
		$lists = json_decode($item->y_shops);
		// return $lists;
		return redirect($lists[0]);
		$user = Auth::user();
		return view('mypage.shop_list', ['user' => $user, 'lists' => $lists, 'total' => $total]);
	}

	public function get_item($id) {
		$item = Item::find($id);
		return $item;
	}

	public function get_allitems() {
		$user = Auth::user();
		// $items = Item::where('user_id', $user->id)->get();
		$items = Item::select('id')->where('user_id', $user->id)->where('status', 1)->get();
		return $items;
	}

	public function edit_track(Request $request) {
		$item = Item::find($request['id']);
		$item->y_target_price = $request['price'];
		$item->is_mailed = 0;
		$item->save();
	}

	public function search(Request $request) {
		$user = Auth::user();
		$k = explode(' ', $request->key);
		
		for ($i = 0; $i < count($k); $i++) {
			$GLOBALS['pattern'] = '%'.$k[$i].'%';
			$items = Item::where('user_id', $user->id)
							->where('status', 1)
							->where(function($query) {
								$query->where('item_name', 'like', $GLOBALS['pattern'])
											->orWhere('jan', 'like', $GLOBALS['pattern'])
											->orWhere('asin', 'like', $GLOBALS['pattern']);
							})
							->paginate(50);
		}
		return view('mypage.item_list', ['user' => $user, 'items' => $items]);
	}

	public function regTrack(Request $request) {
		$user = User::where('email', $request['email'])->first();
		if ($user->is_permitted == 0) {
			return redirect()->route('login');
		}

		$item = Item::where('user_id', $user['id'])->where('jan', $request['itemCode'])->first();
		if ($item == null) {
			$item = new Item;
		}

		$item->user_id = $user['id'];
		$item->y_img_url = $request['img-url'];
		$item->item_name = $request['itemName'];
		$item->code_kind = 0;
		// $item->asin = null;
		$item->jan = $request['itemCode'];
		$item->y_register_price = $request['current-price'];
		$item->y_target_price = $request['target-price'];
		$item->y_min_price = $request['current-price'];
		$item->y_shop_list = "https://ck.jp.ap.valuecommerce.com/servlet/referral?sid=3546031&pid=888145296&vc_url='" . urlencode($request['shop-url']);
		$item->y_shops = json_encode(array($request['shop-url']));
		$item->updated_time = date("Y.m.d H.i.s");

		if ($request['itemCode'] == '') {
			$item->status = 0;
		} else {
			$item->status = 1;
		}

		$item->save();

		return redirect()->route('item_list');
	}

	public function updateAlert(Request $request) {
		$res = $request->all();
		$details = [];
		$bccAry = [];

		$user = User::find($res['user_id']);
		$item = Item::find($res['item_id']);
		$item->is_mailed = 1;

		$lists = json_decode($item->y_shops);
		// $total = array();

		// foreach($lists as $list) {
		// 	$curl = curl_init();

		// 	curl_setopt_array($curl, array(
		// 		CURLOPT_RETURNTRANSFER => 1,
		// 		CURLOPT_URL => $list
		// 	));

		// 	$response = curl_exec($curl);
			
		// 	$price_regex = '/span class="elPriceNumber">[0-9,]+/';
		// 	preg_match($price_regex, $response, $price);
		// 	if ($price == null) {
		// 		$pr = 0;
		// 	} else {
		// 		$pr = preg_replace('/\D/', '', html_entity_decode($price[0]));
		// 	}

		// 	if ($user->fee_include == 0) {
		// 		$po = 0;
		// 	} else {
		// 		$postage_regex = '/送料[0-9,]+円/';
		// 		preg_match($postage_regex, $response, $postage);
		// 		if ($postage == null) {
		// 			$po = 0;
		// 		} else {
		// 			$po = preg_replace('/\D/', '', html_entity_decode($postage[0]));
		// 		}
		// 	}

		// 	$list = 'https://ck.jp.ap.valuecommerce.com/servlet/referral?sid=3546031&pid=888145296&vc_url=' . urlencode($list);
		// 	$total[$list] = $pr + $po;
		// }
		
		// asort($total);
		// while(reset($total) == 0) {
		// 	$total = array_slice($total, 1);
		// }

		// if (reset($total) < 1000) {
		// 	return;
		// }

		// $item->y_min_price = reset($total);
		// $item->y_shop_list = array_keys($total, reset($total))[0];
		// $item->save();
		$item->y_shop_list = $lists[0];

		$item = Item::find($res['item_id']);

		$details['email'] = $user['email'];
		$details['name'] = $user['family_name'];
		$details['item_name'] = $item['item_name'];
		$details['y_register_price'] = $item['y_register_price'];
		$details['y_target_price'] = $item['y_target_price'];
		$details['y_min_price'] = $item['y_min_price'];
		$details['link'] = $item['y_shop_list'];
		$details['asin'] = $item['asin'];
		
		if ($details['y_target_price'] < $details['y_min_price']) {
			return;
		}
		
		Mail::to($details["email"])
				->bcc($bccAry)
				->send(new \App\Mail\UpdateMail($details));

		$item->y_register_price = $item['y_min_price'];
		$item->y_target_price = round($item['y_min_price'] * $user['y_register_percent'] / 100);
		$item->save();
		var_export($item);
	}

	public function extDownload() {
		$zip = new ZipArchive();
		//create the file and throw the error if unsuccessful
		$file = 'yahoo_ext/inject.js';
		// Открываем файл для получения существующего содержимого
		$current = file_get_contents($file);
		// Добавляем нового человека в файл
		$current = "let email = '".Auth::user()->email."';";

		$current .= 'async function init() {
    
			let janCode = document.getElementById("itm_cat").innerHTML.match(/\d{13}/)[0];
			let name = document.querySelector(\'p[class="elName"]\').innerHTML;
			let currentPrice = document.getElementsByClassName("elPriceNumber")[0].innerHTML.replace(/,/g, "");
			let y_img_url = document.getElementsByClassName("elPanelImage")[0].src;
			let y_shop_list = document.querySelector(\'meta[property="og:url"]\').content;
			
			let inject = 
			\'<form target="_blank" method="get" action="https://keepaautobuy.xsrv.jp/mypage/individual">\' + 
				\'<div class="form-group">\' +
					\'<label for="titles"><ヤフカリ>\' + email + \'</label>\' + 
					\'<div style="margin-top: 10px;"><label for="target-price">目標価格</label>\' + 
					\'<input type="number" class="form-control" id="target-price" name="target-price" placeholder="1000" value="" style="width: 150px !important;" />円になったら通知する</div>\' + 
					\'<input type="hidden" name="email" value="\' + email + \'" />\' + 
					\'<input type="hidden" name="itemName" value="\' + name + \'" />\' + 
					\'<input type="hidden" name="itemCode" value="\' + janCode + \'" />\' + 
					\'<input type="hidden" name="current-price" value="\' + currentPrice + \'" />\' + 
					\'<input type="hidden" name="img-url" value="\' + y_img_url + \'" />\' + 
					\'<input type="hidden" name="shop-url" value="\' + y_shop_list + \'" />\' + 
					\'<div style="margin-top: 10px;"><button type="submit" class="btn btn-block btn-primary" style="background-color: lightblue; width: 200px !important;">トラッキング登録</button></div>\' + 
				\'</div>\' +
			\'</form>\';
			let target = document.getElementById("prcdsp");
			target.innerHTML += inject;
		}
		init();';

		// Пишем содержимое обратно в файл
		file_put_contents($file, $current);

		$tmp_file = 'assets/myzip.zip';
		if ($zip->open($tmp_file,  ZipArchive::CREATE)) {
			$zip->addFile('yahoo_ext/inject.js', 'inject.js');
			$zip->addFile('yahoo_ext/manifest.json', 'manifest.json');
			$zip->addFile('yahoo_ext/yahoo.png', 'yahoo.png');
			$zip->close();
			header('Content-disposition: attachment; filename=yahoo_tracking_ext.zip');
			header('Content-type: application/zip');
			header('Encoding: UTF-8');
			readfile($tmp_file);
		} else {
			echo 'Failed!';
		}
	}

	public function register_token(Request $request) {
		$user = User::find(Auth::user()->id);
		$user['yahoo_token'] = $request['token'];
		$user['yahoo_token1'] = $request['token1'];
		$user['yahoo_token2'] = $request['token2'];
		$user->save();
	}

	public function toastWarning(Request $request) {
		$res = $request->all();
		$user = User::find($res['user_id']);
		$warningItem = Item::find($res['item_id']);
		$items = Item::where('user_id', $user->id)->where('status', 1)->paginate(50);
		return view('mypage.item_list', ['user' => $user, 'items' => $items, 'warningItem' => $warningItem]);
	}

	public function toastError(Request $request) {
		$res = $request->all();
		$user = User::find($res['user_id']);
		$errorItem = Item::find($res['item_id']);
		$items = Item::where('user_id', $user->id)->where('status', 1)->paginate(50);
		return view('mypage.item_list', ['user' => $user, 'items' => $items, 'errorItem' => $errorItem]);
	}

	public function change_percent(Request $request) {
		$res = $request->all();
		$user = User::find(Auth::user()->id);
		$user['y_register_percent'] = $res['pro'];
		$user->save();
		return $res['pro'];
	}

	public function set_state(Request $request)
	{
		$req = $request->all();
		$user = User::find(Auth::user()->id);
		$user['is_registering'] = $req['state'];
		$user->save();
	}

	public function get_state(Request $request)
	{
		$user = User::find(Auth::user()->id);
		return $user['is_registering'];
	}
}