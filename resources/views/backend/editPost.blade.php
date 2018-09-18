@extends('../layouts.backend')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">Create / View / Edit Post</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form id="form-edit-post">
                            <input type="hidden" name="postId" value="">
                            <div class="form-group">
                                <div class="alert-container text-center m-2"></div>
                                <label for="title">Title</label>
                                <input type="text" class="form-control" name="title" value="{{$post ? $post->title:""}}" placeholder="Enter Title">
                            </div>
                            <div class="form-group">
                                <label for="content">Content</label>
                                <textarea name="content" class="form-control content">{{$post ? $post->content : ""}}</textarea>
                            </div>
                            @if ($post)
                            <a class="btn btn-danger float-left" href="#" onclick="deletePost()">Delete</a>
                            @endif
                            <a class="btn btn-primary float-right" href="#" onclick="submitForm()">Submit</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    <script>
      var postId = "{{$post ? $post->ID : ""}}";
      function showAlert (msg, type) {
        var alertElmt = document.createElement('div');
        alertElmt.className = "alert-required "+type+" fade show";
        alertElmt.role = "alert";
        alertElmt.innerHTML = msg;
        alertElmt.style.display = "none";
        $('.alert-container')[0].appendChild(alertElmt);
        $(alertElmt).fadeIn();
        setTimeout(function () {
          $(alertElmt).fadeOut(100);
          setTimeout(function () {
            $('.alert-container')[0].removeChild(alertElmt);
          }, 10000);
        }, 10000);
      }
      function submitForm() {
        var data = {
          title: $("form#form-edit-post input[name='title']")[0].value,
          content: tinyMCE.activeEditor.getContent()
        };
        var url = "/admin/posts";
        var method = "POST";
        if (postId.length) {
          method = "PUT";
          url += "/"+postId;
        }
        if (data.content.length === 0 || data.title.length === 0) {
          showAlert("A title and some content are required.", "alert-warning");
          return;
        }
        $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: method,
          url: url,
          data: JSON.stringify(data),
          dataType: "json",
          contentType : "application/json"
        }).done(function (data) {
          console.log('post', data);
          showAlert("Success.", "alert-success");
          window.location = "/admin";
        });
      }
      function deletePost() {
        $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'DELETE',
          url: "/admin/posts/"+postId,
          dataType: "json",
          contentType : "application/json",
          success: function (data) {
            console.log('delete success', data );
            window.location = "/admin";
          }
        })
      }
      document.addEventListener('DOMContentLoaded', function () {
        $(document).ready(function () {
          $('.alert-required').alert();
          var editor_config = {
            path_absolute : "/",
            selector: "textarea.content",
            plugins: [
              "advlist autolink lists link image charmap print preview hr anchor pagebreak",
              "searchreplace wordcount visualblocks visualchars code fullscreen",
              "insertdatetime media nonbreaking save table contextmenu directionality",
              "emoticons template paste textcolor colorpicker textpattern"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
            relative_urls: false,
            file_browser_callback : function(field_name, url, type, win) {
              var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
              var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

              var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
              if (type == 'image') {
                cmsURL = cmsURL + "&type=Images";
              } else {
                cmsURL = cmsURL + "&type=Files";
              }

              tinyMCE.activeEditor.windowManager.open({
                file : cmsURL,
                title : 'Filemanager',
                width : x * 0.8,
                height : y * 0.8,
                resizable : "yes",
                close_previous : "no"
              });
            }
          };
          tinymce.init(editor_config);
          var form = $("form#form-edit-post");
          if (form.length === 1) {
            form = form[0];
            if (form.addEventListener) {
              form.addEventListener("submit", function(evt) {
                evt.preventDefault();
                submitForm();
              }, true);
            }
            else {
              form.attachEvent('onsubmit', function(evt){
                evt.preventDefault();
                submitForm();
              });
            }
          }
        });
      });
    </script>
@endsection
