function fetchData() {
  let yahooToken = "1571d294868bc45f11a3353708aad795c";
  let url = "http://webservice.valuecommerce.ne.jp/productdb/search?token=" + yahooToken;
  
  // for (let item of items) {
    // url += "&product_id=" + item.jan + 
    url += "&product_id=" + 4560491364655 + 
          "&ec_code=0hzmc,0m5af" + 
          "&price_min=100" + 
          "&format=json" + 
          "&sort_by=price" + 
          "&sort_order=asc";
    $.ajax({
      url: url,
      type: 'get',
      success: function(response) {
        let y_current_price = response.data.items[0].price;
        if (y_current_price < item.y_tracking_price) {
          alert('Brrrr!');
        }
      }
    });
  // }
}
fetchData();