@extends('layouts.master')
@section('css')
    @toastr_css

    <style>
        body {
            font-family: 'Varela Round', sans-serif;
        }
        .modal-confirm {
            color: #636363;
            width: 400px;
        }
        .modal-confirm .modal-content {
            padding: 20px;
            border-radius: 5px;
            border: none;
            text-align: center;
            font-size: 14px;
        }
        .modal-confirm .modal-header {
            border-bottom: none;
            position: relative;
        }
        .modal-confirm h4 {
            text-align: center;
            font-size: 26px;
            margin: 30px 0 -10px;
        }
        .modal-confirm .close {
            position: absolute;
            top: -5px;
            right: -2px;
        }
        .modal-confirm .modal-body {
            color: #999;
        }
        .modal-confirm .modal-footer {
            border: none;
            text-align: center;
            border-radius: 5px;
            font-size: 13px;
            padding: 10px 15px 25px;
        }
        .modal-confirm .modal-footer a {
            color: #999;
        }
        .modal-confirm .icon-box {
            width: 80px;
            height: 80px;
            margin: 0 auto;
            border-radius: 50%;
            z-index: 9;
            text-align: center;
            border: 3px solid #f15e5e;
        }
        .modal-confirm .icon-box i {
            color: #f15e5e;
            font-size: 46px;
            display: inline-block;
            margin-top: 13px;
        }
        .modal-confirm .btn, .modal-confirm .btn:active {
            color: #fff;
            border-radius: 4px;
            background: #60c7c1;
            text-decoration: none;
            transition: all 0.4s;
            line-height: normal;
            min-width: 120px;
            border: none;
            min-height: 40px;
            border-radius: 3px;
            margin: 0 5px;
        }
        .modal-confirm .btn-secondary {
            background: #c1c1c1;
        }
        .modal-confirm .btn-secondary:hover, .modal-confirm .btn-secondary:focus {
            background: #a8a8a8;
        }
        .modal-confirm .btn-danger {
            background: #f15e5e;
        }
        .modal-confirm .btn-danger:hover, .modal-confirm .btn-danger:focus {
            background: #ee3535;
        }
        .trigger-btn {
            display: inline-block;
            margin: 100px auto;
        }
    </style>
@section('title')
    {{trans('main.grades_list')}}
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0">{{trans('main.grades_list')}}</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}" class="default-color">Home</a></li>
                <li class="breadcrumb-item active">{{trans('main.grades_list')}}</li>
            </ol>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row">
    <div class="col-xl-12 mb-30">
        <div class="card card-statistics h-100">
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <button type="button" class="button x-small" data-toggle="modal" data-target="#exampleModal">
                    Add Grade
                </button>
                <br><br>
                <div class="table-responsive">
                    <table id="datatable" class="table table-striped table-bordered p-0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Notes</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 0; ?>
                        @foreach($grades as $grade)
                            <?php $i++; ?>
                        <tr>
                            <td>{{$i}}</td>
                            <td>{{$grade->name}}</td>
                            <td>{{$grade->notes}}</td>
                            <td>
                                <button class="btn btn-primary edit_grade" data-id="{{$grade->id}}" ><i class="fa fa-edit"></i></button>
                                <form id="delete_grade_form" style="display: inline-block;" action="{{ route('grades.destroy',$grade->id)}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <a class="delete_grade"><i class="fa fa-trash-o"></i></a>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>



    <!-- add_modal_Grade -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                       Add Grade
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- add_form -->
                    <form action="{{ route('grades.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col">
                                <label for="Name" class="mr-sm-2">اسم المرحلة
                                    :</label>
                                <input id="Name" type="text" name="name" class="form-control">
                            </div>
                            <div class="col">
                                <label for="Name_en" class="mr-sm-2">Grade name
                                    :</label>
                                <input type="text" class="form-control" name="name_en">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Note
                                :</label>
                            <textarea class="form-control" name="notes" id="exampleFormControlTextarea1"
                                      rows="3"></textarea>
                        </div>
                        <br><br>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Add</button>
                </div>
                </form>
                </div>

            </div>
        </div>
    </div>


    <!-- edit_modal_Grade -->
    <div class="modal fade" id="edit_grade_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel1">
                        Edit Grade
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- add_form -->
                    <form id="edit_grade_form" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col">
                                <label for="name_edit" class="mr-sm-2">اسم المرحلة
                                    :</label>
                                <input id="name_edit" type="text" name="name_edit" class="form-control">
                            </div>
                            <div class="col">
                                <label for="name_en_edit" class="mr-sm-2">Grade name
                                    :</label>
                                <input type="text" class="form-control" name="name_en_edit" id="name_en_edit">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="notes_edit">Note
                                :</label>
                            <textarea class="form-control" name="notes_edit" id="notes_edit"
                                      rows="3"></textarea>
                        </div>
                        <br><br>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning">Edit</button>
                </div>
                </form>

            </div>
        </div>
    </div>


    <!-- Delete Modal grade -->
    <div id="myModal" class="modal fade">
        <div class="modal-dialog modal-confirm">
            <div class="modal-content">
                <div class="modal-header flex-column">
                    <div class="icon-box">
                        <i class="fa fa-times"></i>
                    </div>
                    <h4 class="modal-title w-100">Are you sure?</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Do you really want to delete these records? This process cannot be undone.</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button id="delete_form_submit" type="button" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- row closed -->
@endsection
@section('js')

    @toastr_js
    @toastr_render

    <script>
        $(document).ready(function (){
            // $(document).on('click','#delete_form_submit',function (){
            //     $('#delete_grade_form').submit();
            // });
            $(document).on('click','.edit_grade',function (){
                let grade_id = $(this).attr('data-id');
                $.ajax({
                    type:'GET',
                    url: "grades/"+grade_id+"/edit",
                    data:{grade_id:grade_id},
                    success:function(data){
                        if(data.status){
                            var id ="grades/"+data.data.id+"";
                            $('#notes_edit').val(data.data.notes);
                            $('#name_edit').val(data.data.name.ar);
                            $('#name_en_edit').val(data.data.name.en);
                            $('#edit_grade_modal').modal('show');
                            $('#edit_grade_form').attr('action',id)
                        }
                    }
                });
            });
        });
    </script>
@endsection
