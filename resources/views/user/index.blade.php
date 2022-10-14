@extends('user.layouts.layout')

@section('content')

<div>
    <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('dashboard')}}">Dashboard</a></li>
                <li class="breadcrumb-item active">User List</li>
            </ol>
        </div>
    </div>
    <div class="container-fluid pt-0">
        <div class="row">
            <div class="col-12">
                <div class="card application_part">
                    <div class="card-body">
                        <h4 class="card-title mb-4">User List - User Management</h4>
                        <div class="text-left mb-4 add_application_btn_part">

                        <a class="btn btn-success" href="javascript:void(0)" id="createNewProduct"> Create New Product</a>
                        <table class="table table-bordered data-table">
                        <thead>
                         <tr>
                        <th>No</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>User Name</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th width="280px">Action</th>
                         </tr>
                        </thead>
                        <tbody>
                        </tbody>
</table>
</div>  
<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="productForm" name="productForm" class="form-horizontal">
                   <input type="hidden" name="product_id" id="product_id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">FirstName</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="fname" placeholder="Enter Name" value="" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">LastName</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="lname" placeholder="Enter Name" value="" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">UserName</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="uname" placeholder="Enter Name" value="" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="email" placeholder="Enter Name" value="" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Password</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="password" placeholder="Enter Name" value="" maxlength="50" required="">
                        </div>
                    </div>
                  
      
                    <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
                     </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
    
</body>
    
<script type="text/javascript">
  $(function () {
     
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });
    
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('ajaxusers.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'firstname', name: 'fname'},
            {data: 'lastname', name: 'lname'},
            {data: 'username', name: 'uname'},
            {data: 'email', name: 'email'},
            {data: 'password', name: 'password'},
 
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
     
    $('#createNewProduct').click(function () {
        $('#saveBtn').val("create-product");
        $('#product_id').val('');
        $('#productForm').trigger("reset");
        $('#modelHeading').html("Create New Product");
        $('#ajaxModel').modal('show');
    });
    
    $('body').on('click', '.editProduct', function () {
      var product_id = $(this).data('id');
      $.get("{{ route('ajaxusers.index') }}" +'/' + product_id +'/edit', function (data) {
          $('#modelHeading').html("Edit Product");
          $('#saveBtn').val("edit-user");
          $('#ajaxModel').modal('show');
          $('#product_id').val(data.id);
          $('#firstname').val(data.fname);
          $('#lastname').val(data.lname);
          $('#username').val(data.uname);
          $('#email').val(data.email);
          $('#password').val(data.password);
       
      })
   });
    
    $('#saveBtn').click(function (e) {
        e.preventDefault();
        $(this).html('Sending..');
    
        $.ajax({
          data: $('#productForm').serialize(),
          url: "{{ route('ajaxusers.store') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
     
              $('#productForm').trigger("reset");
              $('#ajaxModel').modal('hide');
              table.draw();
         
          },
          error: function (data) {
              console.log('Error:', data);
              $('#saveBtn').html('Save Changes');
          }
      });
    });
    
    $('body').on('click', '.deleteProduct', function () {
     
        var product_id = $(this).data("id");
        confirm("Are You sure want to delete !");
      
        $.ajax({
            type: "DELETE",
            url: "{{ route('ajaxusers.store') }}"+'/'+product_id,
            success: function (data) {
                table.draw();
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
     
  });
</script>   
  @endsection