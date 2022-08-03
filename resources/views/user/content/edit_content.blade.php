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
span.error-display {
    color: #f00;
}
</style>
<div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="{{url('application')}}">Application List</a></li>
            <li class="breadcrumb-item active"><a href="{{url('content-list/'.$id)}}">content List</a></li>
        </ol>
    </div>
</div>
<div class="container-fluid pt-0 custom-form-design">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Edit Content</h4>
                        <form class="form-valide" action="" mathod="POST" id="content_edit" enctype="multipart/form-data">
                            <input type="hidden" id="app_id" name="app_id" value="{{$id}}" />
                            <input type="hidden" id="UUID-main" name="UUID-main" value="{{$app_data[0]->UUID}}" />
                              @csrf
                              <div class="row">
                                <div class="col-md-6">
                                  <label class="col-form-label" for="name">select category</label>
                                  <div class="position-relative">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="arrow_selectbox" xmlns:xlink="http://www.w3.org/1999/xlink" width="46" height="46" viewBox="0 0 46 46" fill="none">
                                      <rect width="46" height="46" fill="url(#pattern0)"></rect>
                                      <defs>
                                      <pattern id="pattern0" patternContentUnits="objectBoundingBox" width="1" height="1">
                                      <use xlink:href="#image0_303_257" transform="scale(0.00195312)"></use>
                                      </pattern>
                                      <image id="image0_303_257" width="512" height="512" xlink:href="data:image/png;base64,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"></image>
                                      </defs>
                                    </svg>
                                    <select class="form-control select-box" id="category" name="category">
                                        <option value="">Please select</option>
                                        @foreach($categories as $cat)
                                            <option data-id="{{$cat->id}}" value="{{$cat->id}}">{{$cat->title}}</option>
                                        @endforeach
                                    </select>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                  @foreach($app_data as $app)
                                  <?php 
                                    $input_name = $app->id."field_name";
                                    $single_name = $app->id."one[]"; 
                                    $input_name_id = $app->id."field_name";
                                    $single_name_id = $app->id."one"; 
                                  ?>
                                    @if($app->fieldd->field_type == "text")
                                    <div class="col-md-6 mb-2 mb-md-3">
                                      <label class="col-form-label">{{$app->fieldd->field_name}}</label>
                                      <input type="{{$app->fieldd->field_type}}" value="{{$app->value}}" placeholder="Field Name" class="form-control input-flat specReq" name="{{$input_name}}" />
                                    </div>
                                    @elseif($app->fieldd->field_type == "file")
                                    <div class="col-md-6 mb-3">
                                      <div class="row m-0">
                                        <div class="col-12 px-0"><label class="col-form-label">{{$app->fieldd->field_name}}</label></div>
                                          <div class="d-flex w-100 align-items-center">
                                              <input type="{{$app->fieldd->field_type}}" value="{{$app->value}}" placeholder="Field Name" class="form-control input-flat specReq mr-3" name="{{$single_name}}" />
                                              <img class="img_side" src="{{asset('app_data_images/'.$app->value)}}" >
                                          </div>
                                      </div>
                                      
                                    </div>
                                    @endif
                                  @endforeach
                                  @foreach($app_data as $app)
                                    
                                    @if($app->fieldd->field_type == "multi-file")
                                      <?php 
                                        $file_name = $app->app_id."_".$app->category_id."_".$app->fieldd->id."_files[]";  
                                        $file_name_id = $app->app_id."_".$app->category_id."_".$app->fieldd->id."_files";  
                                      ?>
                                      <div class="col-md-6 mb-3">
                                        <label class="col-form-label">{{$app->fieldd->field_name}}</label>
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
                                <?php $count = 0; ?>
                                @foreach($sub_app_data->groupBy('UUID') as $app)
                                  <div class="col-md-6 mb-4">
                                      <div class="form-validation-part p-3 p-sm-4 p-md-3 p-lg-4">
                                        <div class="cp_btn">
                                          @if($count == 0)
                                            <!-- <button class="btn btn-secondary text-white copy_btn" id="cp_btn" type="button">Copy</button> -->
                                            <button class="text-white copy_btn mr-2" id="cp_btn" type="button">
                                              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                                <path d="M11.332 8.93329V10.9333C11.332 13.6 10.2654 14.6666 7.5987 14.6666H5.06536C2.3987 14.6666 1.33203 13.6 1.33203 10.9333V8.39996C1.33203 5.73329 2.3987 4.66663 5.06536 4.66663H7.06537" stroke="#8B8B8B" stroke-width="0.75" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M11.3331 8.93329H9.19974C7.59974 8.93329 7.06641 8.39996 7.06641 6.79996V4.66663L11.3331 8.93329Z" stroke="#8B8B8B" stroke-width="0.75" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M7.73242 1.33337H10.3991" stroke="#8B8B8B" stroke-width="0.75" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M4.66797 3.33337C4.66797 2.22671 5.5613 1.33337 6.66797 1.33337H8.41464" stroke="#8B8B8B" stroke-width="0.75" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M14.6663 5.33337V9.46004C14.6663 10.4934 13.8263 11.3334 12.793 11.3334" stroke="#8B8B8B" stroke-width="0.75" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M14.668 5.33337H12.668C11.168 5.33337 10.668 4.83337 10.668 3.33337V1.33337L14.668 5.33337Z" stroke="#8B8B8B" stroke-width="0.75" stroke-linecap="round" stroke-linejoin="round"/>
                                              </svg>
                                            </button>
                                          @endif
                                          @if($count != 0)
                                          <button class="btn btn-secondary text-white remove_btn" id="cp_btn" type="button"><img src="{{asset('user/assets/icons/delete-red.png')}}"></button>
                                          @endif
                                          <input type="hidden" class="UUID" data="already" name="UUID[]" value="{{$app[0]->UUID}}"/>
                                        </div>
                                          @foreach($app as $ap)
                                              <?php 
                                                  $input_name = $app[0]->UUID."-".$ap->sub_form_structure_id."sub_fieldname[]";
                                                  $single_name = $app[0]->UUID."-".$ap->sub_form_structure_id."sub_single[]"; 
                                                  $input_name_id = $app[0]->UUID."-".$ap->sub_form_structure_id."sub_fieldname";
                                                  $single_name_id = $app[0]->UUID."-".$ap->sub_form_structure_id."sub_single"; 
                                              ?>
                                                <div class="form-group col-12">
                                                    <label class="col-form-label" for="name">{{$ap->fieldd->field_name}}</label>
                                                    @if($ap->fieldd->field_type == "file")
                                                      <input type="{{$ap->fieldd->field_type}}" value="{{$ap->value}}" placeholder="Field Name" class="form-control input-flat specReq" name="{{$single_name}}" />
                                                      <img class="img_side mt-3 choose-file-img" src="{{asset('app_data_images/'.$ap->value)}}">
                                                    @elseif($ap->fieldd->field_type == "text")
                                                      <input type="{{$ap->fieldd->field_type}}" value="{{$ap->value}}" placeholder="Field Name" class="form-control input-flat specReq" name="{{$input_name}}" />
                                                    @endif
                                                </div>	
                                          @endforeach
                                      </div>
                                  </div>
                                  <?php $count ++; ?>
                                @endforeach
                              </div>
                            </div>
                            <div class="sub_form_edit">
                              <div class="row sub_form_edit_row"></div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <div class="">
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
    });
  } else {
    alert("Your browser doesn't support to File API")
  }
});
var app_id = "{{$id}}";
$('body').on('click', '#submit_app_data', function () {
    // var plus = 1;
    var all = $('.sub_form_edit .row.sub_form_edit_row .col-md-6').find('.cp_btn').find('.UUID');
   
    $(all).map(function(key, value){
      var uniq = (new Date()).getTime()+"_s"+key;
      return $(this).val(uniq);
    })
    var formData = new FormData($("#content_edit")[0]);
    console.log(ValidateForm())
    var validation = ValidateForm()
    if(validation != false){
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
    }
})
// var uniqq = (new Date()).getTime()+"_"+1;
// $(".UUID").val(uniqq);
$('body').on('click', '.copy_btn', function () {
  console.log($(this).parent().parent())
  var parent_ = $(this).parent().parent().parent().clone();
  $(".sub_form_edit .row.sub_form_edit_row").append(parent_);
})
$('body').on('click', '.remove_btn', function () {
  var parent_ = $(this).parent().parent().remove();
})

function ValidateForm() {
  var isFormValid = true;  
  $("#content_edit input").each(function () { 
      var only_id = "#"+$(this).attr("id");
      if($(this).attr("id") != undefined && $(this).attr('data') != "multi"){
        var FieldId = "span_" + $(this).attr("id");
        var trim_val = $(only_id).attr('value');
        if ($.trim($(this).val()).length == 0 || $.trim($(this).val())==0) {
          if ($.trim(trim_val).length == 0) {
              $(this).addClass("highlight");
              if ($("#" + FieldId).length == 0) {  
                      $("<span class='error-display' id='" + FieldId + "'>This Field Is Required</span>").insertAfter(this);  
              }  
              if ($("#" + FieldId).css('display') == 'none'){  
                  $("#" + FieldId).fadeIn(500);  
              } 
              isFormValid = false;  
          }
        }else{  
            $(this).removeClass("highlight");  
            if ($("#" + FieldId).length > 0) {  
                $("#" + FieldId).fadeOut(1000);  
            }  
        }
      }
  })
  return isFormValid;  
}

</script>
@endpush('scripts')