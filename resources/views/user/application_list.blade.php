@extends('user.layouts.layout')

@section('content')
<link href="{{asset('user/assets/plugins/tables/css/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{asset('user/assets/css/style.css')}}" rel="stylesheet">
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet"> -->
<div class="container-fluid mt-3">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Data Table</h4>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered zero-configuration">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>App Id</th>
                                    <th>Package Name</th>
                                    <th width="100px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>1</td>
                                <td>application 1</td>
                                <td>gfffd66665675f6g5543</td>
                                <td>first package</td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>application 2</td>
                                <td>gfffd6666567DGDsGDD</td>
                                <td>second package</td>
                                <td>-</td>
                            </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                <th>No</th>
                                    <th>Name</th>
                                    <th>App Id</th>
                                    <th>Package Name</th>
                                    <th width="100px">Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- <div class="table-responsive dt-responsive">
                        <table id="offer_details" class="table table-striped table-bordered nowrap">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>App Id</th>
                                <th>Package Name</th>
                                <th width="100px">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/min/dropzone.min.js"></script> -->
<script src="{{asset('user/assets/plugins/common/common.min.js')}}"></script>
<script src="{{asset('user/assets/js/custom.min.js')}}"></script>
<script src="{{asset('user/assets/js/settings.js')}}"></script>
<script src="{{asset('user/assets/js/gleek.js')}}"></script>
<script src="{{asset('user/assets/js/styleSwitcher.js')}}"></script>

<script src="{{asset('user/assets/plugins/tables/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('user/assets/plugins/tables/js/datatable/dataTables.bootstrap4.min.js')}}"></script>

<script src="{{asset('user/assets/plugins/tables/js/datatable-init/datatable-basic.min.js')}}"></script>
<!-- <script type="text/javascript" src="https://cdn.datatables.net/1.10.8/js/jquery.dataTables.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script> -->
<script type="text/javascript">
    $(function () {
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{url('application')}}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    });
</script>
@endpush('scripts')