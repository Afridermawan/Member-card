<!DOCTYPE html>
<html>
  <body>
    U will buy {{$data->name}} with price IDR {{$data->total_harga | number_format}}
    <button id="pay-button">Pay!</button>
<!-- TODO: Remove ".sandbox" from script src URL for production environment. Also input your client key in "data-client-key" -->
  </body>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="VT-client-5EGdWYPKH8-XpVzb"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script type="text/javascript">
      document.getElementById('pay-button').onclick = function(){
        // SnapToken acquired from previous step
        snap.pay('{{$data->data->token}}');
      };
    </script>
</html>  
