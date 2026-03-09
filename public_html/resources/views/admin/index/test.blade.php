
    <script src="/admin/bower_components/jquery/dist/jquery.min.js"></script>
 
<script type="text/javascript">
  

  var createCORSRequest = function(method, url) {
  var xhr = new XMLHttpRequest();
  if ("withCredentials" in xhr) {
    // Most browsers.
    xhr.open(method, url, true);
  } else if (typeof XDomainRequest != "undefined") {
    // IE8 & IE9
    xhr = new XDomainRequest();
    xhr.open(method, url);
  } else {
    // CORS not supported.
    xhr = null;
  }
  return xhr;
};

var url = 'https://graph.microsoft.com/v1.0/me/drive';
var method = 'GET';
var xhr = createCORSRequest(method, url);

xhr.onload = function(res) {
  // Success code goes here.
  console.log(res);
};

xhr.onerror = function() {
  // Error code goes here.
};

xhr.setRequestHeader('Authorization', 'Bearer 68945E0CD921660982979DAAF2FD636097B92746');
xhr.send();

 $(document).ready(function(){
    $.get("https://login.live.com/oauth20_authorize.srf?client_id=7baee393-8159-4751-877f-b84d66462917&scope=onedrive.readonly&response_type=46A4859FF3950446F527C094E0730665ED4AE6C9&redirect_uri=http://127.0.0.1:8000/test",function(result){
        $("body").html(result);
    });
    
})

</script>