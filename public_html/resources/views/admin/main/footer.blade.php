


{{--    <script src="/admin/bower_components/jquery/dist/jquery.min.js"></script>--}}

{{--    <script src="/admin/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>--}}


{{--    <script src="/admin/admin/js/app.js"></script>--}}
    <script src="/js/app.js"></script>

    <script src="/admin/ckeditor/ckeditor.js"></script>
    <script src="/admin/ckeditor/function.js"></script>
    <script type="text/javascript">
      $(document).ready(function(){
          $(".click_remove").click(function(){
              if(confirm("Bạn muốn xoá dữ liệu ")){
                  $.post($(this).attr("href"));
                  $(this).parent().parent().remove();
              }
              return false;
          });
          $(".click_remove_cate").click(function(){
              if(confirm("Bạn muốn xoá dữ liệu ")){
                  $.post($(this).attr("href"));
                  $(this).parent().parent().next().remove();
                  $(this).parent().parent().remove();
              }
              return false;
          });
      });
    </script>
    <script type="text/javascript">
    	function handleFileSelectBanner(evt) {
                var files = evt.target.files;


                for (var i = 0, f; f = files[i]; i++) {

                  // Only process image files.
                  if (!f.type.match('image.*')) {
                    continue;
                  }

                  var reader = new FileReader();


                  reader.onload = (function(theFile) {
                    return function(e) {

                      var span = document.createElement('span');
                      span.innerHTML = ['<img class="thumb"  src="', e.target.result,
                                        '" title="', escape(theFile.name), '"/>'].join('');


                      $('.detail_banner').html(span);
                    };
                  })(f);


                  reader.readAsDataURL(f);
                }
              }
    	 function handleFileSelect(evt) {
                var files = evt.target.files;


                for (var i = 0, f; f = files[i]; i++) {

                  // Only process image files.
                  if (!f.type.match('image.*')) {
                    continue;
                  }

                  var reader = new FileReader();


                  reader.onload = (function(theFile) {
                    return function(e) {

                      var span = document.createElement('span');
                      span.innerHTML = ['<img class="thumb" style="" src="', e.target.result,
                                        '" title="', escape(theFile.name), '"/>'].join('');


                      $('.detail_picture').html(span);
                    };
                  })(f);


                  reader.readAsDataURL(f);
                }
              }
              function handleFileSelectMulti(evt) {
                var files = evt.target.files;
                 $('.multi_view').html('');

                for (var i = 0, f; f = files[i]; i++) {


                  if (!f.type.match('image.*')) {
                    continue;
                  }

                  var reader = new FileReader();


                  reader.onload = (function(theFile) {
                    return function(e) {

                      var span = document.createElement('span');
                      span.innerHTML = ['<img class="thumb" style="width:200px;border:1px solid #ddd;margin:10px;display:inline-block" src="', e.target.result,
                                        '" title="', escape(theFile.name), '"/>'].join('');


                      $('.multi_view').append(span);
                    };
                  })(f);


                  reader.readAsDataURL(f);
                }
              }


    </script>
     @yield('script_js');
