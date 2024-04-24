<!DOCTYPE html>
<html>
<head>
    <title>【ヤフカリ】価格再設定のお知らせ</title>
</head>
<body>
    <p>ヤフカリからのお知らせ</p>
    <br/>
    <p><a href="{{$details['link']}}" target="_blank">【{{$details['item_name']}}】</a>が目標価格より安くなりました。</p>
    <br/>
    <p>登録時価格 :「{{$details['y_register_price']}}円」 </p>
    <p>目標価格 : 「{{$details['y_target_price']}}円」</p>
    <p>現在価格 : 「{{$details['y_min_price']}}円」</p>
    <img src="{{ 'https://graph.keepa.com/pricehistory.png?asin=' . $details['asin'] . '&domain=co.jp&salesrank=1' }}" alt="価格履歴グラフ" style="width: 400px;" />
    <br/>
    -------------------------------------------------------------<br/>
    <br/>
    今後ともヤフカリをよろしくお願いいたします。<br/>
    ご利用いただくなかでお困りごとがございましたらお気軽にご連絡ください。<br/>
    https://gies0315.com/contact/<br/>
    <br/>
</body>
</html>