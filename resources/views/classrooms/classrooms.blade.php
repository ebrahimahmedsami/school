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
        #current_grade{
            text-transform: uppercase;
            font-weight: bold;
            color: #a11313;
        }
    </style>
@section('title')
    Class Room List
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="page-title">
    <div class="row">
        <div class="col-sm-6">
            <h4 class="mb-0">Class Room List</h4>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb pt-0 pr-0 float-left float-sm-right ">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}" class="default-color">Home</a></li>
                <li class="breadcrumb-item active">Class Room List</li>
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
                    <button type="button" class="button x-small" data-toggle="modal" data-target="#add_class_modal">
                        Add Class Room
                    </button>
                    <button type="button" class="button x-small" id="btn_delete_all">
                        Delete all
                    </button>
                    <form action="{{route('filter-by-grade')}}" method="POST">
                        {{ csrf_field() }}
                        <select class="selectpicker" data-style="btn-info" name="filter_grade_id" required
                                onchange="this.form.submit()">
                            <option value="" selected disabled>Search By Grade</option>
                            @if (is_array($grades) || is_object($grades))
                                @foreach ($grades as $grade)
                                    <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </form>
                <br><br>
                <div class="table-responsive">
                    <table id="datatable" class="table table-striped table-bordered p-0">
                        <thead>
                        <tr>
                            <th>
                                <input type="checkbox" name="select_all" id="select_all" onclick="CheckAll('box1', this)" />
                            </th>
                            <th>Name</th>
                            <th>Grade</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($filtered_classrooms))
                            <?php $classrooms = $filtered_classrooms ?>
                        @else
                            <?php $classrooms = $classrooms ?>
                        @endif
                        @foreach($classrooms as $class)
                        <tr>
                            <td>
                                <input type="checkbox" class="box1" value="{{$class->id}}">
                            </td>
                            <td>{{$class->name}}</td>
                            <td>{{$class->grade->name}}</td>
                            <td>
                                <button class="btn btn-primary edit_class" data-id="{{$class->id}}" ><i class="fa fa-edit"></i></button>
                                <form id="delete_grade_form" style="display: inline-block;" action="{{ route('classrooms.destroy',$class->id)}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <a class="delete_class"><i class="fa fa-trash-o"></i></a>
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



    <!-- add_modal_class -->
    <div class="modal fade" id="add_class_modal" tabindex="-1" role="dialog" aria-labelledby="add_class_modalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="add_class_modalLabel">
                        Add Class
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form class=" row mb-30" action="{{ route('classrooms.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="repeater">
                                <div data-repeater-list="List_Classes">
                                    <div data-repeater-item>
                                        <div class="row">

                                            <div class="col">
                                                <label for="Name"
                                                       class="mr-sm-2">اسم الصف
                                                    :</label>
                                                <input class="form-control" type="text" name="name" />
                                            </div>


                                            <div class="col">
                                                <label for="Name"
                                                       class="mr-sm-2">Class Name
                                                    :</label>
                                                <input class="form-control" type="text" name="name_en" />
                                            </div>


                                            <div class="col">
                                                <label for="Name_en"
                                                       class="mr-sm-2">Grade Name
                                                    :</label>

                                                <div class="box">
                                                    <select class="fancyselect" name="grade_id">
                                                        @foreach ($grades as $Grade)
                                                            <option value="{{ $Grade->id }}">{{ $Grade->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                            </div>

                                            <div class="col">
                                                <label for="Name_en"
                                                       class="mr-sm-2">Process
                                                    :</label>
                                                <input class="btn btn-danger btn-block" data-repeater-delete
                                                       type="button" value="delete row" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-20">
                                    <div class="col-12">
                                        <input class="button mb-2" data-repeater-create type="button" value="add row"/>
                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                    <button type="submit"
                                            class="btn btn-success">Save</button>
                                </div>


                            </div>
                        </div>
                    </form>
                </div>


            </div>

        </div>

    </div>


    <!-- edit_modal_class -->
    <div class="modal fade" id="edit_class_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel1">
                        Edit Class
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- add_form -->
                    <form id="edit_class_form" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col">
                                <label for="name_edit" class="mr-sm-2">اسم الصف
                                    :</label>
                                <input id="name_edit" type="text" name="name_edit" class="form-control">
                            </div>
                            <div class="col">
                                <label for="name_en_edit" class="mr-sm-2">Class name
                                    :</label>
                                <input type="text" class="form-control" name="name_en_edit" id="name_en_edit">
                            </div>
                            <div class="col">
                                <label for="grade_ids">Grade
                                    :</label>
                                <select class="fancyselect" name="grade_id" id="grade_id">
                                    @foreach ($grades as $Grade)
                                        <option value="{{ $Grade->id }}">{{ $Grade->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="current_grade">Current Grade
                                    :</label>
                                <input type="text" id="current_grade" class="form-control" disabled>
                            </div>
                        </div>
                        <br><br>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning">Edit</button>
                </div>
                </form>
                </div>

            </div>
        </div>
    </div>


    <!-- Delete Modal class -->
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

    <div class="modal fade" id="delete_all" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                        Delete Classes
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{ route('delete_all') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        Are You Sure ?
                        <input class="text" type="hidden" id="delete_all_id" name="delete_all_id" value=''>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
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

        /////// fuction bulk select all ///////////

        function CheckAll(className, elem) {
            var elements = document.getElementsByClassName(className);
            var l = elements.length;
            if (elem.checked) {
                for (var i = 0; i < l; i++) {
                    elements[i].checked = true;
                }
            } else {
                for (var i = 0; i < l; i++) {
                    elements[i].checked = false;
                }
            }
        }

        $(function() {

            //////////// edit data /////////////////
            $(document).on('click','.edit_class',function (){
                let class_id = $(this).attr('data-id');
                console.log(class_id)
                let url = "classrooms/"+class_id+"/edit";
                $.ajax({
                    type:'GET',
                    url: url,
                    success:function(data){
                        if(data.status){
                            var id ="classrooms/"+data.data.id+"";
                            $('#grade_id option').each(function(index, item){
                                if(data.data.grade_id == item.value){
                                    $('#current_grade').val(item.text);
                                }
                            });
                            $('#name_edit').val(data.data.name.ar);
                            $('#name_en_edit').val(data.data.name.en);
                            $('#edit_class_modal').modal('show');
                            $('#edit_class_form').attr('action',id)
                        }
                    }
                });
            });

            //////////// delete all /////////////
            $("#btn_delete_all").click(function () {
                var selected = new Array();
                $("#datatable input[type=checkbox]:checked").each(function () {
                    selected.push(this.value);
                });
                if (selected.length > 0) {
                    $('#delete_all').modal('show')
                    $('input[id="delete_all_id"]').val(selected);
                }
                $('#delete_all_id').val(selected);
            });
        });

    </script>
@endsection
