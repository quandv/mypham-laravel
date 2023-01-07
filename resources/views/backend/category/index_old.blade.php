@extends('backend.layouts.master')
@section ('title','Category'))
@section('content')
   <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">111111</h3>

            <div class="box-tools pull-right">
                {{--@include('backend.includes.partials.header-buttons') --}}
            </div><!--box-tools pull-right-->
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="table-responsive">
                <table id="category-table" class="table table-condensed table-hover">
                    <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
            </div><!--table-responsive-->
        </div><!-- /.box-body -->
    </div><!--box-->
	@section('after-scripts-end')
	    {{ asset("js/backend/plugin/datatables/jquery.dataTables.min.js") }}
	    {{ asset("js/backend/plugin/datatables/dataTables.bootstrap.min.js") }}

	    <script>
	        $(function() {
	            $('#category-table').DataTable({
	                processing: true,
	                serverSide: true,
	                ajax: {
	                    //url: '{{ route("admin.category.get") }}',
	                    type: 'get',
	                    data: {status: 1, trashed: false}
	                },
	                columns: [
	                    {data: 'id', name: 'id'},
	                    {data: 'name', name: 'name'},
	                    {data: 'email', name: 'email'},
	                    {data: 'confirmed', name: 'confirmed'},
	                    {data: 'roles', name: 'roles'},
	                    {data: 'created_at', name: 'created_at'},
	                    {data: 'updated_at', name: 'updated_at'},
	                    {data: 'actions', name: 'actions'}
	                ],
	                order: [[0, "asc"]],
	                searchDelay: 500
	            });
	        });
	    </script>
	@stop
@endsection