@extends('user.layouts.layout')

@section('content')
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
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
                        <form class="form-valide" action="" mathod="POST" id="content_edit" enctype="multipart/form-data">
                            <input type="hidden" name="app_id" value="{{$id}}" />
                            <input type="hidden" name="UUID-main" value="{{$app_data[0]->UUID}}" />
                              @csrf
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
                                  @foreach($app_data as $app)
                                  <?php 
                                    $input_name = $app->id."field_name";
                                    $single_name = $app->id."one[]"; 
                                  ?>
                                    @if($app->fieldd->field_type == "text")
                                    <div class="col-md-6 mb-4">
                                      <label>{{$app->fieldd->field_name}}</label>
                                      <input type="{{$app->fieldd->field_type}}" value="{{$app->value}}" placeholder="Field Name" class="form-control input-flat specReq" name="{{$input_name}}" />
                                    </div>
                                    @elseif($app->fieldd->field_type == "file")
                                    <div class="col-md-6 mb-4">
                                      <label>{{$app->fieldd->field_name}}</label>
                                      <input type="{{$app->fieldd->field_type}}" value="{{$app->value}}" placeholder="Field Name" class="form-control input-flat specReq" name="{{$single_name}}" />
                                      <img class="img_side" src="{{asset('app_data_images/'.$app->value)}}" >
                                    </div>
                                    @endif
                                  @endforeach
                                  @foreach($app_data as $app)
                                    @if($app->fieldd->field_type == "multi-file")
                                      <?php $file_name = $app->app_id."_".$app->category_id."_".$app->fieldd->id."_files[]";  ?>
                                      <div class="col-md-6 mb-4">
                                        <label>{{$app->fieldd->field_name}}</label>
                                        <input type="file" value="" placeholder="Field Name" class="form-control input-flat specReq files" name="{{$file_name}}" multiple/>
                                      </div>
                                      @break
                                    @endif
                                  @endforeach
                                  @foreach($app_data as $app)
                                    @if($app->fieldd->field_type == "multi-file")
                                        <span class="pip">
                                          <img class="img_side" src="{{asset('app_data_images/'.$app->value)}}">
                                        </span>
                                    @endif
                                  @endforeach
                              </div>
                            <h4 class="card-title">Sub Form Content</h4>
                            <div class="sub_form">
                              <div class="row">
                                @foreach($sub_app_data->groupBy('UUID') as $app)
                                <div class="col-md-6 mb-4">
                                  <div class="cp_btn">
                                    <button class="btn btn-secondary text-white copy_btn" id="cp_btn" type="button">Copy</button>
                                    <button class="btn btn-secondary text-white remove_btn" id="cp_btn" type="button">X</button>
                                    <input type="hidden" class="UUID" data="already" name="UUID[]" value="{{$app[0]->UUID}}"/>
                                  </div>
                                  @foreach($app as $ap)
                                    <?php 
                                      $input_name = $app[0]->UUID."-".$ap->sub_form_structure_id."sub_fieldname[]";
                                      $single_name = $app[0]->UUID."-".$ap->sub_form_structure_id."sub_single[]"; 
                                    ?>
                                    <div class="form-group col-12">
                                        <label class="col-form-label" for="name">{{$ap->fieldd->field_name}}</label>
                                        @if($ap->fieldd->field_type == "file")
                                          <input type="{{$ap->fieldd->field_type}}" value="{{$ap->value}}" placeholder="Field Name" class="form-control input-flat specReq" name="{{$single_name}}" />
                                          <img class="img_side" src="{{asset('app_data_images/'.$ap->value)}}">
                                        @elseif($ap->fieldd->field_type == "text")
                                          <input type="{{$ap->fieldd->field_type}}" value="{{$ap->value}}" placeholder="Field Name" class="form-control input-flat specReq" name="{{$input_name}}" />
                                        @endif
                                    </div>	
                                    @endforeach
                                </div>
                                @endforeach
                              </div>
                            </div>
                            <div class="sub_form_edit">
                              <div class="row"></div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
<script type="text/javascript">
$(document).ready(function() {
  var ddd = 0;
  var app_id = "{{$id}}";
  console.log(app_id)
  if (window.File && window.FileList && window.FileReader) {
    $('body').on('change', '.files', function (e) {
    // $(".files").on("change", function(e) {
      var uniq = (new Date()).getTime()+"_s"+ddd;
      var main = $(this)
      console.log(main)
      // var image_array = [];
      // var image_string = "";
      var files = e.target.files, filesLength = files.length;
        // var dumm = JSON.stringify(files)
        // console.log(dumm)
        // ddd++;
        // var input_html = "";
        // var file_name = uniq+"multifile[]";
        // var ids = "files_hid"+ddd;
        // var sss = "#"+ids;
        // input_html = '<input type="hidden" value="" class="files_hid" id="'+ids+'" name="'+file_name+'" />';
        // input_html.val(input_html)
        // main.parent().append(input_html)
        // console.log()
      for (var i = 0; i < filesLength; i++) {
        var f = files[i]
        // image_array.push(f.name)
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
      // image_string = image_array.join(",")
      // $(sss).val(image_string)
    });
  } else {
    alert("Your browser doesn't support to File API")
  }
});
var app_id = "{{$id}}";
$('body').on('click', '#submit_app_data', function () {
    // var plus = 1;
    var all = $('.sub_form_edit .row .col-md-6').find('.cp_btn').find('.UUID');
    // console.log(all)
    // var alll = $('.sub_form .row .col-md-6').find('.cp_btn').find('.UUIDd');
    $(all).map(function(key, value){
      var uniq = (new Date()).getTime()+"_s"+key;
      return $(this).val(uniq);
    })
    var formData = new FormData($("#content_edit")[0]);
    $.ajax({
            type: 'POST',
            url: "{{ url('/contentt-update')}}/"+app_id,
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
                if(data.status == 200){
                    toastr.success("Content Added",'Success',{timeOut: 5000})
                    $("#content_edit")[0].reset()
                }else{
                    toastr.error("Please try again",'Error',{timeOut: 5000})
                }
            }
    });
})
// var uniqq = (new Date()).getTime()+"_"+1;
// $(".UUID").val(uniqq);
$('body').on('click', '.copy_btn', function () {
  console.log($(this).parent().parent())
  var parent_ = $(this).parent().parent().clone();
  $(".sub_form_edit .row").append(parent_);
})
$('body').on('click', '.remove_btn', function () {
  var parent_ = $(this).parent().parent().remove();
})

</script>
@endpush('scripts')