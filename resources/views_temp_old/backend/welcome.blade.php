@extends('backend.layouts.master',['page_title' => 'Quản trị'])
@section ('title','Quản trị')
@section('content')
    <div class='row'>
    @if (session('flash_message_err') != '')
      <div class="alert alert-danger" role="alert">{!! session('flash_message_err')!!}</div>
    @endif
        <div class='col-md-6'>
            <!-- Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3>Wellcome back {!! Auth::user()->name !!}</h3>
                </div>
                <div class="box-body">
                    
                  
                </div><!-- /.box-body -->
                <div class="box-footer">
                    
                </div><!-- /.box-footer-->
            </div><!-- /.box -->
        </div><!-- /.col -->
       
    </div><!-- /.row -->
@endsection
