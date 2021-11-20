@extends('layouts.master')
@section('css')
    @toastr_css
@section('title')
    Teachers List
@stop
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="page-title">
        <div class="row">
            <div class="col-sm-6">
                <h4 class="mb-0">Teachers List</h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}" class="default-color">Home</a></li>
                    <li class="breadcrumb-item active">Teachers List</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-md-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    <div class="col-xl-12 mb-30">
                        <div class="card card-statistics h-100">
                            <div class="card-body">
                                <a href="{{route('teachers.create')}}" class="btn btn-success btn-sm" role="button"
                                   aria-pressed="true">Add Teacher</a><br><br>
                                <div class="table-responsive">
                                    <table id="datatable" class="table  table-hover table-sm table-bordered p-0"
                                           data-page-length="50"
                                           style="text-align: center">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Gender</th>
                                            <th>Join Date</th>
                                            <th>Specialization</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $i = 0; ?>
                                        @foreach($teachers as $Teacher)
                                            <tr>
                                                <?php $i++; ?>
                                                <td>{{ $i }}</td>
                                                <td>{{$Teacher->Name}}</td>
                                                <td>
                                                    @if($Teacher->gender == 1)
                                                        Male
                                                    @else
                                                        Female
                                                    @endif
                                                </td>
                                                <td>{{$Teacher->Joining_Date}}</td>
                                                <td>{{$Teacher->specializations->Name}}</td>
                                                <td>
                                                    <a href="{{route('teachers.edit',$Teacher->id)}}" class="btn btn-info btn-sm" role="button" aria-pressed="true"><i class="fa fa-edit"></i></a>
                                                    <button data-id="{{$Teacher->id}}" type="button" class="btn btn-danger btn-sm delete_teacher_btn" data-toggle="modal" data-target="#delete_teacher" title="delete"><i class="fa fa-trash"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->


    <div class="modal fade" id="delete_teacher" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="delete_teacher_form" method="post">
                {{method_field('delete')}}
                {{csrf_field()}}
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">Delete Teacher</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are You Sure ?</p>
                    </div>
                    <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">Close</button>
                            <button type="submit"
                                    class="btn btn-danger">Delete</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('js')
    @toastr_js
    @toastr_render


    <script>
        $(document).ready(function () {
            $(document).on('click','.delete_teacher_btn',function (){
               let id = $(this).attr('data-id');
                $('#delete_teacher_form').attr('action',"teachers/"+id)
            });
        });
    </script>
@endsection
