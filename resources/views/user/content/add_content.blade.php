@extends('user.layouts.layout')

@section('content')
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<style>
   input[type="file"] {
  display: block;
}
.imageThumb {
  max-height: 75px;
  border: 2px solid;
  padding: 1px;
  cursor: pointer;
}
.pip {
  display: inline-block;
  margin: 10px 10px 0 0;
}
.remove {
  display: block;
  background: #444;
  border: 1px solid black;
  color: white;
  text-align: center;
  cursor: pointer;
}
.remove:hover {
  background: white;
  color: black;
}
.sub_form {
    width: 100%;
}
</style>
<div class="container-fluid mt-3">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Add Content</h4>
                        <form class="form-valide" action="" mathod="POST" id="content_add" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" value="{{ $application_id }}" name="application_id">
                            <div class="row">
                              <div class="col-md-6">
                                <label class="col-form-label" for="name">select category</label>
                                <select class="form-control" id="category" name="category">
                                    <option value="">Please select</option>
                                    @foreach($categories as $cat)
                                        <option data-id="{{$cat->id}}" value="{{$cat->id}}">{{$cat->title}}</option>
                                    @endforeach
                                </select>
                              </div>
                            </div>
                            <div class="row">
                                @foreach($main_form as $data)
                                <?php 
                                  $input_name = $data->id."field_name";
                                  $file_name = $data->id."files[]"; 
                                  $single_name = $data->id."single[]"; 
                                ?>
                                    @if($data->field_type == "text")
                                    <div class="form-group col-md-6">
                                        <label class="col-form-label" for="name">{{$data->field_name}}</label>
                                        <input type="{{$data->field_type}}" placeholder="Field Name" class="form-control input-flat specReq" name="{{$input_name}}" />
                                    </div>
                                    @elseif($data->field_type == "file")
                                    <div class="form-group col-md-6">
                                        <label class="col-form-label" for="name">{{$data->field_name}}</label>
                                        <input type="{{$data->field_type}}" placeholder="Field Name" class="form-control input-flat specReq" name="{{$single_name}}" />
                                    </div>
                                    @elseif($data->field_type == "multi-file")
                                    <div class="form-group col-md-6">
                                        <div class="field" align="left">
                                            <h3>Upload your images</h3>
                                            <input type="file" class="files" id="files" name="{{$file_name}}" multiple />
                                        </div>
                                    </div>
                                    @endif
                                @endforeach
                            </div>
                            <h4 class="card-title">Sub Form Content</h4>
                            <div class="sub_form">
                              <div class="row">
                                <div class="col-md-6 mb-4">
                                  <div class="cp_btn">
                                    <button class="btn btn-secondary text-white copy_btn" id="cp_btn" type="button">Copy</button>
                                    <button class="btn btn-secondary text-white remove_btn" id="cp_btn" type="button">X</button>
                                    <input type="hidden" class="UUID" name="UUID[]" value=""/>
                                  </div>
                                  @foreach($sub_form as $dat)
                                    <?php 
                                      $input_name = $dat->id."subname[]"; 
                                      $file_name = $dat->id."subfile[]"; 
                                      $uuid = $dat->id."uuid"; 
                                    ?>
                                    <!-- <input type="hidden" class="UUIDd" name="{{$uuid}}" value=""/> -->
                                      @if($dat->field_type == "file")
                                      <div class="form-group col-12">
                                          <label class="col-form-label" for="name">{{$dat->field_name}}</label>
                                          <input type="{{$dat->field_type}}" placeholder="Field Name" class="form-control input-flat specReq" name="{{$file_name}}" />
                                      </div>
                                      @elseif($dat->field_type == "multi-file")
                                      
                                      @else
                                      <div class="form-group col-12">
                                          <label class="col-form-label" for="name">{{$dat->field_name}}</label>
                                          <input type="{{$dat->field_type}}" placeholder="Field Name" class="form-control input-flat specReq" name="{{$input_name}}" />
                                      </div>
                                      @endif
                                  @endforeach
                                </div>
                              </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <div class="col-lg-8 ml-auto">
                                       <button type="button" id="submit_app_data" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
  var ddd = 0;
  if (window.File && window.FileList && window.FileReader) {
    $('body').on('change', '.files', function (e) {
    // $(".files").on("change", function(e) {
      var uniq = (new Date()).getTime()+"_s"+ddd;
      var main = $(this)
      var image_array = [];
      var image_string = "";
      var files = e.target.files, filesLength = files.length;
        // var dumm = JSON.stringify(files)
        // console.log(dumm)
        ddd++;
        var input_html = "";
        var file_name = uniq+"multifile[]";
        var ids = "files_hid"+ddd;
        var sss = "#"+ids;
        input_html = '<input type="hidden" value="" class="files_hid" id="'+ids+'" name="'+file_name+'" />';
        // input_html.val(input_html)
        // main.parent().append(input_html)
        // console.log()
      for (var i = 0; i < filesLength; i++) {
        var f = files[i]
        image_array.push(f.name)
        var fileReader = new FileReader();
        fileReader.onload = (function(e) {
          var file = e.target;
          $("<span class=\"pip\">" +
            "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
            "<br/><span class=\"remove\">Remove image</span>" +
            "</span>").insertAfter(main);
          $(".remove").click(function(){
            $(this).parent(".pip").remove();
          });
          
          // Old code here
          /*$("<img></img>", {
            class: "imageThumb",
            src: e.target.result,
            title: file.name + " | Click to remove"
          }).insertAfter("#files").click(function(){$(this).remove();});*/
          
        });
        fileReader.readAsDataURL(f);
      }
      image_string = image_array.join(",")
      $(sss).val(image_string)
    });
  } else {
    alert("Your browser doesn't support to File API")
  }
});

$('body').on('click', '#submit_app_data', function () {
    var plus = 1;
    var all = $('.sub_form .row .col-md-6').find('.cp_btn').find('.UUID');
    // var alll = $('.sub_form .row .col-md-6').find('.cp_btn').find('.UUIDd');
    $(all).map(function(key, value){
      var uniq = (new Date()).getTime()+"_s"+key;
      return $(this).val(uniq);
    })

    var formData = new FormData($("#content_add")[0]);
    $.ajax({
            type: 'POST',
            url: "{{ route('app-data.store') }}",
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
                if(data.status == 200){
                    toastr.success("Content Added",'Success',{timeOut: 5000})
                    $("#content_add")[0].reset()
                }else{
                    toastr.error("Please try again",'Error',{timeOut: 5000})
                }
            }
    });
})
// var uniqq = (new Date()).getTime()+"_"+1;
// $(".UUID").val(uniqq);
$('body').on('click', '.copy_btn', function () {
  var parent_ = $(this).parent().parent().clone();
  $(".sub_form .row").append(parent_);
})
$('body').on('click', '.remove_btn', function () {
  var parent_ = $(this).parent().parent().remove();
})

</script>
@endpush('scripts')