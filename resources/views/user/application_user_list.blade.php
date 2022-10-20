@extends('user.layouts.layout')
@section('content')
<div>
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('dashboard')}}">Dashboard</a></li>
                <li class="breadcrumb-item active">Application Users List</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid pt-0">
        <div class="row">
            <div class="col-12">
                <div class="card application_part">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Application Users List - Application Management</h4>
                        <div class="text-left mb-4 add_application_btn_part">
                            <a href="javascript:void(0)" data-toggle="modal" data-target="#AddStudentModal" class="btn gradient-4 btn-lg border-0 btn-rounded add_application_btn">
                                <span class="mr-2 d-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M12 22C17.5 22 22 17.5 22 12C22 6.5 17.5 2 12 2C6.5 2 2 6.5 2 12C2 17.5 6.5 22 12 22Z" stroke="#151415" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M8 12H16" stroke="#151415" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M12 16V8" stroke="#151415" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                                Add User
                            </a>
                        </div>
                       
                        <div class="tab-content" id="myTabContent">

                            <div class="tab-pane fade show active" id="active" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="tab-pane fade show active table-responsive table_detail_part" id="all_application_tab">
                                    <div class="table-responsive application_table_part">
                                        <table id="application_list" class="table zero-configuration customNewtable application_table shadow-none" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <!-- <th></th> -->
                                                    <th>No</th>
                                                    <th>fullname</th>
                                                    <th>username</th>
                                                    <th>email</th>
                                                    <th>password</th>
                                                    <th>Action</th>
                                              
                                                </tr>
                                            </thead>
                                            <tbody>


                                            </tbody>
                                            
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="AddStudentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="registration" method="post" action="">
                                @csrf
                                <div class="formgroup mb-3">
                                    <label for="">FirstName</label>
                                    <input type="text" name="firstname" id="firstname" class="firstname form-control">
                                </div>
                                <div class="formgroup mb-3">
                                    <label for="">LastName</label>
                                    <input type="text" name="lastname" id="lastname" class="lastname form-control">
                                </div>
                                <div class="formgroup mb-3">
                                    <label for="">Username</label>
                                    <input type="text" name="username" id="username" class="username form-control">
                                </div>
                                <div class="formgroup mb-3">
                                    <label for="">Email</label>
                                    <input type="email" name="email" id="email" class="email form-control">
                                </div>
                                <div class="formgroup mb-3">
                                    <label for="">password</label>
                                    <input type="password" name="password" id="password" class="password form-control">
                                </div>
                                <div class="formgroup mb-3">
                                <label for="">role</label>
                                <select class="form-control select-box role" id="role" placeholder="Select" name="role" >
                                        <option value="3">Manager</option> 
                                        <option value="4">Developer</option>       
                                                      

                                </select>
                                 </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-info add_student" id="registerbutton">Save changes</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

            <!--edit modal -->
            <div class="modal fade" id="editstudentmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">edit User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <ul id="updateform_errlist"></ul>

        <input type="hidden" id="edit_stud_id">
        <div class="formgroup mb-3">
          <label for="">FirstName</label>
          <input type="text" id="edit_fname" class="firstname form-control">
        </div>
        <div class="formgroup mb-3">
          <label for="">LastName</label>
          <input type="text" id="edit_lname" class="lastname form-control">
        </div>
        <div class="formgroup mb-3">
          <label for="">Username</label>
          <input type="text" id="edit_uname" class="username form-control">
        </div>
        <div class="formgroup mb-3">
          <label for="">Email</label>
          <input type="email" id="edit_email" class="email form-control">
        </div>
        <div class="formgroup mb-3">
          <label for="">password</label>
          <input type="password" id="edit_password" class="password form-control">
        </div>
        <div class="formgroup mb-3">
              <label for="">role</label>
              <select class="form-control select-box " id="edit_role" placeholder="Select" name="role" >
              <option value="3">Manager</option> 
             <option value="4">Developer</option>       
              </select>
         </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-info update_student">Update</button>
      </div>
    </div>
  </div>
</div>

            <!-- <div class="modal fade" id="exampleModalCenter">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Are you sure you want to delete this record ?</h5>
                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-gray" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary delete" id="RemoveUserSubmit">Delete</button>
                        </div>
                    </div>
                </div>
            </div> -->

        <!--delete model -->
<div class="modal fade" id="deletestudentmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">delete User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">



        <input type="hidden" id="delete_stud_id">
        <h4>Are you sure you want to delete this record?</h4>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary delete_student_btn">Yes delete</button>
      </div>
    </div>
  </div>
</div>
        
        </div>
    </div>

</div>

@endsection
@push('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

<script>
    $(document).ready(function() {

        application_page_tabs('', true);

    });

    function application_page_tabs(tab_type = '', is_clearState = false) {

        if (is_clearState) {
            $('#application_list').DataTable().state.clear();
        }
        var table = $('#application_list').DataTable({
            "destroy": true,
            "processing": true,
            "serverSide": true,
            'stateSave': function() {
                if (is_clearState) {
                    return false;
                } else {
                    return true;
                }
            },
            "ajax": {

                "url": "{{ url('/userslist') }}",
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: '{{ csrf_token() }}',
                    tab_type: tab_type
                },
            },
            'columnDefs': [{
                    "width": "5%",
                    "targets": 0
                },
                {
                    "width": "5%",
                    "targets": 1
                },
                {
                    "width": "13%",
                    "targets": 2
                },
                {
                    "width": "10%",
                    "targets": 3
                },
                {
                    "width": "10%",
                    "targets": 4
                },
                {
                    "width": "10%",
                    "targets": 5
                },
                
           
            ],
            "columns": [{
                    data: 'id',
                    name: 'id',
                    class: "text-center",
                    orderable: false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'firstname',
                    name: 'firstname',
                    class: "text-center",
                    orderable: false,
                    render: function(data, type, row, meta) {
                      if(row.role == 3){
                        var role = 'Manager';
                      }else{
                        var role = 'Developer';
                      }
                        return row.firstname + ' ' + row.lastname + ' <br>' + role;
                    }
                },
                
                {
                    data: 'username',
                    name: 'username',
                    class: "text-center",
                    orderable: false,
                    render: function(data, type, row, meta) {
                        return row.username;
                    }
                },
                {
                    data: 'email',
                    name: 'email',
                    class: "text-center",
                    orderable: false,
                    render: function(data, type, row, meta) {
                        return row.email;
                    }
                },
                {
                    data: 'decrypted_password',
                    name: 'password',
                    class: "text-center",
                    orderable: false,
                    render: function(data, type, row, meta) {
                        return row.decrypted_password;
                    }
                    
                },
     
                {
                        "mData": "action",
                        "mRender": function(data, type, row) {
                          
                          var img_url1 = "{{asset('user/assets/icons/edit.png')}}";
                               var img_url2 = "{{asset('user/assets/icons/delete.png')}}";
                           
                          return "<button type='button' value=" + row.id + " class='edit_student border-0'><img src='" + img_url1 + "' alt='' style='margin-right:30px'></button>" +
                                    "<button type='button'  value=" + row.id + " class='delete_student border-0'><img src='" + img_url2 + "' alt=''></button>";
                            

                        }
                    },
             
                // {
                  
                //     class: "edit_student btn btn-primary btn-sm",
                //     orderable: false,
                //     render: function(data, type, row, meta) {
                //         return row.button;
                //     }
                // },
            ]
        })
    }
    $(document).on('click', '.delete_student', function(e) {
        e.preventDefault();

        var stud_id = $(this).val();
        $('#delete_stud_id').val(stud_id);
        $('#deletestudentmodal').modal('show');


      });
      $(document).on('click', '.delete_student_btn', function(e) {
        e.preventDefault();

        var stud_id = $('#delete_stud_id').val();

        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        $.ajax({
          type: "DELETE",
          url: "{{ url('/delete-student/') }}" + stud_id,
          success: function(response) {
             console.log(response);                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               
           // $('#success_message').addclass('alert alert-success');
            $('#success_message').text(response.message);
            $('#deletestudentmodal').modal('hide');
            application_page_tabs('', true);

          }
        });
      });

     $(document).on('click', '.add_student', function(e) {
        e.preventDefault();
        //console.log("hello");
        
        var data = {
            'firstname': $('.firstname').val(),
            'lastname': $('.lastname').val(),
            'username': $('.username').val(),
            'email': $('.email').val(),
            'password': $('.password').val(),
            'role': $('.role').val(),
        }
        //console.log(data);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            url:  "{{ url('/userdd') }}",
            data: data,
            dataType: "json",
            success: function(response) {

             
                if (response.status == 400) {

                    $('#saveform_errlist').html("");
                    $('#saveform_errlist').addClass('alert alert-danger');
                    $.each(response.errors, function(key, err_values) {
                    $('#saveform_errlist').append('<li>' + err_values + '</li>')
                    });
                } else {
                    $('#saveform_errlist').html("");
                    $('#success_message').addClass('alert alert-success')
                    $('#success_message').text(response.message)
                    $('#AddStudentModal').modal('hide');
                    toastr.success("User Created", 'Success', {
                      timeOut: 5000})
                    $('#AddStudentModal').find('input').val("");
                    application_page_tabs('', true);
                
                }


            }


        });
     });

     $(document).on('click', '.edit_student', function(e) {
        e.preventDefault();

        var stud_id = $(this).val();
        //alert(stud_id);
        //console.log(stud_id); 
        $('#editstudentmodal').modal('show');
        $.ajax({
          type: "GET",
          url: "{{ url('edit-student/') }}" + stud_id,
          success: function(response) {
            console.log(response);

            if (response.status == 404) {
              $('#success_message').html();
              $('#success_message').addclass('alert alert-danger')
              $('#success_message').text(response.message);
            } else {
              $('#edit_fname').val(response.user.firstname)
              $('#edit_lname').val(response.user.lastname)
              $('#edit_uname').val(response.user.username)
              $('#edit_email').val(response.user.email)
              $('#edit_password').val(response.user.decrypted_password)   
              $('#edit_role').val(response.user.role)   
              $('#edit_stud_id').val(stud_id)
            }
          }
        });
      });

      $(document).on('click', '.update_student', function(e) {
        e.preventDefault();
        var stud_id = $('#edit_stud_id').val();

        var data = {
          'firstname': $('#edit_fname').val(),
          'lastname': $('#edit_lname').val(),
          'username': $('#edit_uname').val(),
          'email': $('#edit_email').val(),
          'decrypted_password': $('#edit_password').val(),
          'role': $('#edit_role').val(),

        }
                console.log(data);
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        $.ajax({
          type: "POST",
          url: "{{ url('update-student/') }}" + stud_id,
          data: data,
          dataType: "json",
          success: function(response) {

            console.log(response); 
            if (response.status == 400) {
              $('#updateform_errlist').html("");
              $('#updateform_errlist').addClass('alert alert-danger');
              $.each(response.errors, function(key, err_values) {
                $('#updateform_errlist').append('<li>' + err_values + '</li>')
              });
              $('.update_student').text("update");
            } else if (response.status == 404) {
              $('#updateform_errlist').html("");
              $('#success_message').addClass('alert alert-success')
              $('#success_message').text(response.message)
              $('.update_student').text("update");
            } else {
              $('#updateform_errlist').html("");
              $('#success_message').html("")
             $('#success_message').addClass('alert alert-success')
              $('#success_message').text(response.message)
              toastr.success("User Updated", 'Success', {
                      timeOut: 5000})
              $('#editstudentmodal').modal('hide');
              $('.update_student').text("update");
              application_page_tabs('', true);
            }
          }
        });
      });

    $( "#registration" ).on( "click", "#registerbutton", function() {
        ValidateForm()
    })
    function ValidateForm() {
    var isFormValid = true;
    
    $("#registration input, select").each(function() {
      if ($(this).attr("id") != undefined) {
        var FieldId = "span_" + $(this).attr("id");
        if ($.trim($(this).val()).length == 0 || $.trim($(this).val()) == 0) {
          $(this).addClass("highlight");
          if ($("#" + FieldId).length == 0) {
            $("<span class='error-display' id='" + FieldId + "'>This Field Is Required</span>").insertAfter(this);
          }
          if ($("#" + FieldId).css('display') == 'none') {
            $("#" + FieldId).fadeIn(500);
          }
          isFormValid = false;
        } else {
          $(this).removeClass("highlight");
          if ($("#" + FieldId).length > 0) {
            $("#" + FieldId).fadeOut(1000);
          }
        }
      }
    })
    // return false;
    return isFormValid;
  }
</script>
@endpush('scripts')