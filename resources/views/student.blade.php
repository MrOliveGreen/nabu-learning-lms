@extends('layout')
@section('js_after')
    <script src="{{ asset('assets/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/flatpickr/flatpickr.min.js') }}"></script>

    <script src="{{ asset('assets/js/cropper.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/ion-rangeslider/js/ion.rangeSlider.js') }}"></script>
    <script src="{{ asset('assets/js/cropperModal.js') }}"></script>

    <script src="{{ asset('assets/js/plugins/select2/js/select2.full.min.js') }}"></script>

    <script src="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.js') }}"></script>
    <script
        src="{{ asset('assets/js/plugins/jquery-password-validation-while-typing/js/jquery.passwordRequirements.min.js') }}">
    </script>
    <script src="{{ asset('assets/js/userPage.js') }}"></script>

    <script src="{{ asset('assets/js/plugins/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

    <script>
        $(function() {
            $(" #LeftPanel, #RightPanel").tabs();
            $(".second-table").tabs();
        });

    </script>
    <script>
        $('#utilisateurs').addClass('active');
        jQuery(function() {
            Dashmix.helpers(['select2', 'rangeslider', 'notify', 'summernote', 'flatpickr', 'datepicker']);
        });

    </script>
@endsection
@section('con')

    <link rel="stylesheet" href="{{ asset('assets/js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/cropper.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/cropperModal.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/ion-rangeslider/css/ion.rangeSlider.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.min.css') }}" />

    <link rel="stylesheet"
        href="{{ asset('assets/js/plugins/jquery-password-validation-while-typing/css/jquery.passwordRequirements.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/jquery-password-validation-while-typing/demo.css') }}" />


    <style>
        :root {
            --student-c:
                <?php
                echo '#'. $interfaceCfg->Students->h;
            ?>
            ;
            --student-h:
                <?php
                echo '#'. $interfaceCfg->Students->c;
            ?>
            ;
            --teacher-c:
                <?php
                echo '#'. $interfaceCfg->Teachers->h;
            ?>
            ;
            --teacher-h:
                <?php
                echo '#'. $interfaceCfg->Teachers->c;
            ?>
            ;
            --author-c:
                <?php
                echo '#'. $interfaceCfg->Authors->h;
            ?>
            ;
            --author-h:
                <?php
                echo '#'. $interfaceCfg->Authors->c;
            ?>
            ;
            --group-c:
                <?php
                echo '#'. $interfaceCfg->Groups->h;
            ?>
            ;
            --group-h:
                <?php
                echo '#'. $interfaceCfg->Groups->c;
            ?>
            ;
            --company-c:
                <?php
                echo '#'. $interfaceCfg->Companies->h;
            ?>
            ;
            --company-h:
                <?php
                echo '#'. $interfaceCfg->Companies->c;
            ?>
            ;
            --position-c:
                <?php
                echo '#'. $interfaceCfg->Positions->h;
            ?>
            ;
            --position-h:
                <?php
                echo '#'. $interfaceCfg->Positions->c;
            ?>
            ;
            --session-c:
                <?php
                echo '#'. $interfaceCfg->Sessions->h;
            ?>
            ;
            --session-h:
                <?php
                echo '#'. $interfaceCfg->Sessions->c;
            ?>
            ;
        }

    </style>
    <link rel="stylesheet" href="{{ asset('assets/css/userPage.css') }}">




<div id="content"
data-log-user-id="{{auth()->user()->id}}"
data-log-user-type="{{auth()->user()->type}}"
data-student-limited="{{isset(session('permission')->limited)}}"
data-student-display="{{isset(session('permission')->student->student->display)}}"
data-student-edit="{{isset(session('permission')->student->student->edit)}}"
data-student-delete="{{isset(session('permission')->student->student->delete)}}"
data-student-show="{{isset(session('permission')->student->student->show)}}"
data-student-link="{{isset(session('permission')->student->student->link)}}"
data-student-create="{{isset(session('permission')->student->student->create)}}"

data-teacher-display="{{isset(session('permission')->student->teacher->display)}}"
data-teacher-edit="{{isset(session('permission')->student->teacher->edit)}}"
data-teacher-delete="{{isset(session('permission')->student->teacher->delete)}}"
data-teacher-show="{{isset(session('permission')->student->teacher->show)}}"
data-teacher-link="{{isset(session('permission')->student->teacher->link)}}"
data-teacher-create="{{isset(session('permission')->student->teacher->create)}}"

data-author-display="{{isset(session('permission')->student->author->display)}}"
data-author-edit="{{isset(session('permission')->student->author->edit)}}"
data-author-delete="{{isset(session('permission')->student->author->delete)}}"
data-author-show="{{isset(session('permission')->student->author->show)}}"
data-author-link="{{isset(session('permission')->student->author->link)}}"
data-author-create="{{isset(session('permission')->student->author->create)}}"

data-group-display="{{isset(session('permission')->student->group->display)}}"
data-group-edit="{{isset(session('permission')->student->group->edit)}}"
data-group-delete="{{isset(session('permission')->student->group->delete)}}"
data-group-show="{{isset(session('permission')->student->group->show)}}"
data-group-create="{{isset(session('permission')->student->group->create)}}"

data-company-display="{{isset(session('permission')->student->company->display)}}"
data-company-edit="{{isset(session('permission')->student->company->edit)}}"
data-company-delete="{{isset(session('permission')->student->company->delete)}}"
data-company-show="{{isset(session('permission')->student->company->show)}}"
data-company-create="{{isset(session('permission')->student->company->create)}}"

data-position-display="{{isset(session('permission')->student->position->display)}}"
data-position-edit="{{isset(session('permission')->student->position->edit)}}"
data-position-delete="{{isset(session('permission')->student->position->delete)}}"
data-position-show="{{isset(session('permission')->student->position->show)}}"
data-position-create="{{isset(session('permission')->student->position->create)}}"

data-search-member="{{isset(session('permission')->student->search->member)}}"
data-search-category="{{isset(session('permission')->student->search->category)}}"
data-search-showtable="{{isset(session('permission')->student->search->showtable)}}"
>
    <fieldset id="LeftPanel">
        <ul class="mx-4 mb-2 border-0 nav nav-tabs">
            @if(isset(session("permission")->student->student->display))
            <li class="nav-item">
                <a class="m-1 border-0 nav-link active rounded-1" id="students-tab"
                    href="#students">{{ $translation->l('STUDENTS') }}</a>
            </li>
            @endif
            @if(isset(session("permission")->student->teacher->display))
            <li class="nav-item">
                <a class="m-1 border-0 nav-link rounded-1" id="teachers-tab" href="#teachers">
                    {{ $translation->l('TEACHERS') }}</a>
            </li>
            @endif
            @if(isset(session("permission")->student->author->display))
            <li class="nav-item">
                <a class="m-1 border-0 nav-link rounded-1" id="authors-tab"
                    href="#authors">{{ $translation->l('AUTHORS') }}</a>
            </li>
            @endif
        </ul>
        <div class="mx-4 mb-3 text-white clear-fix toolkit d-flex justify-content-lg-start flex-column"
            id="user-toolkit">
            <div class="p-2 w-100">
                <div class="input-container">
                    <a href="#" class="toolkit-add-item">
                        <i class="p-2 text-white fa fa-plus icon"></i>
                    </a>
                    <span class="p-2 text-black bg-white rounded">
                        <input class="border-0 input-field mw-100 search-filter" type="text" name="search-filter">
                        <i class="p-2 fa fa-search icon"></i>
                    </span>
                    <a href="#" class="float-right toolkit-show-filter">
                        <i class="p-2 text-white fas fa-sliders-h icon"></i>
                    </a>
                </div>
            </div>
            <div class="p-2 filter toolkit-filter">
                <div class="float-left">
                    <div class="status-switch">
                        <input type="radio" id="filter-state-on" name="status" value="on">
                        <span>on&nbsp;</span>
                        <input type="radio" id="filter-state-off" name="status" value="off">
                        <span>off&nbsp;</span>
                        <input type="radio" id="filter-state-all" name="status" value="all">
                        <span>all&nbsp;</span>
                    </div>

                </div>
                <div class="float-right">
                    <span>
                        <button value='' class="px-1 text-white border-0 rounded filter-name-btn">Name
                            <i class="fas"></i>
                        </button>
                        <button value='' class="px-1 text-white border-0 rounded filter-date-btn">Date
                            <i class="fas"></i>
                        </button>
                    </span>
                    <button type="button" value="" class="px-1 text-white border-0 rounded filter-company-btn">company
                        +<i></i></button>&nbsp;
                    <button type="button" value="" class="px-1 text-white border-0 rounded filter-function-btn">function
                        +<i></i></button>
                </div>
            </div>
        </div>
        <div id="div_A" class="window top">
            <div class="mx-4 clear-fix">
                <div id="students">

                    <div class="list-group" id="list-tab" role="tablist" data-src=''>
                        @if(isset(session('permission')->student->student->display))
                        @foreach ($students as $student)
                            <a class="list-group-item list-group-item-action p-0 border-transparent border-5x student_{{ $student->id }}"
                                id="student_{{ $student->id }}" data-date="{{ $student->creation_date }}">
                                <div class="float-left">
                                    @if ($student->status == 1)
                                        <i class="m-2 fa fa-circle" style="color:green;"></i>
                                        <input type="hidden" name="item-status" class='status-notification' value="1">
                                    @else
                                        <i class="m-2 fa fa-circle" style="color:red;"></i>
                                        <input type="hidden" name="item-status" class='status-notification' value="0">
                                    @endif
                                    <span
                                        class="item-name">{{ $student->first_name }}&nbsp;{{ $student->last_name }}</span>
                                    <input type="hidden" name="item-name"
                                        value="{{ $student->first_name }}{{ $student->last_name }}">
                                    <input type="hidden" name="item-group" value="{{ $student->linked_groups }}">
                                    <input type="hidden" name="item-company" value="{{ $student->company }}">
                                    <input type="hidden" name="item-function" value="{{ $student->function }}">
                                </div>
                                <div class="float-right btn-group">
                                    <span
                                        class="p-2  font-weight-bolder item-lang">{{ strtoupper($student->language_iso) }}</span>
                                        <button class="btn item-mail" onclick="redirectPage('{{route('sendmail')}}?studentId={{$student->id}}')">
                                            <i class="px-2 fa fa-envelope"></i>
                                        </button>
                                    @if(!isset(session("permission")->limited) || (auth()->user()->type == 3 && auth()->user()->id == $student->id_creator))
                                        @if(isset(session('permission')->student->student->show))
                                        <button class="btn item-show" data-content='student'>
                                            <i class="px-2 fa fa-eye"></i>
                                        </button>
                                        @endif
                                        @if(isset(session("permission")->student->student->edit))
                                        <button class="btn item-edit" data-content='student'>
                                            <i class="px-2 fa fa-edit"></i>
                                        </button>
                                        @endif
                                        @if(isset(session("permission")->student->student->delete))
                                        <button class="btn item-delete" data-content='student'>
                                            <i class="px-2 fa fa-trash-alt"></i>
                                        </button>
                                        @endif
                                    @endif
                                </div>
                            </a>
                        @endforeach
                        @endif
                    </div>
                </div>
                <div id="teachers">

                    <div class="list-group" id="list-tab" role="tablist" data-src=''>
                        @if(isset(session("permission")->student->teacher->display))
                        @foreach ($teachers as $teacher)
                            <a class="list-group-item list-group-item-action p-0 border-transparent border-5x teacher_{{ $teacher->id }}"
                                id="teacher_{{ $teacher->id }}" data-date="{{ $teacher->creation_date }}">
                                <div class="float-left">
                                    @if ($teacher->status == 1)
                                        <i class="m-2 fa fa-circle" style="color:green;"></i>
                                        <input type="hidden" name="item-status" class='status-notification' value="1">
                                    @else
                                        <i class="m-2 fa fa-circle" style="color:red;"></i>
                                        <input type="hidden" name="item-status" class='status-notification' value="0">
                                    @endif
                                    <span
                                        class="item-name">{{ $teacher->first_name }}&nbsp;{{ $teacher->last_name }}</span>
                                    <input type="hidden" name="item-name"
                                        value="{{ $teacher->first_name }}{{ $teacher->last_name }}">
                                    <input type="hidden" name="item-group" value="{{ $teacher->linked_groups }}">
                                    <input type="hidden" name="item-company" value="{{ $teacher->company }}">
                                    <input type="hidden" name="item-function" value="{{ $teacher->function }}">
                                </div>
                                <div class="float-right btn-group">
                                    <span
                                        class="p-2  font-weight-bolder item-lang">{{ strtoupper($teacher->language_iso) }}</span>
                                        <button class="btn item-mail" onclick="redirectPage('{{route('sendmail')}}?teacherId={{$teacher->id}}')">
                                            <i class="px-2 fa fa-envelope"></i>
                                        </button>
                                @if(!isset(session("permission")->limited) || (auth()->user()->type == 3 && auth()->user()->id == $teacher->id_creator))
                                    @if(isset(session('permission')->student->teacher->show))

                                        <button class="btn item-show" data-content='teacher'>
                                            <i class="px-2 fa fa-eye"></i>
                                        </button>
                                    @endif

                                    @if(isset(session("permission")->student->teacher->edit))
                                        <button class="btn item-edit" data-content='teacher'>
                                            <i class="px-2 fa fa-edit"></i>
                                        </button>
                                    @endif

                                    @if(isset(session("permission")->student->teacher->delete))
                                        <button class="btn item-delete" data-content='teacher'>
                                            <i class="px-2 fa fa-trash-alt"></i>
                                        </button>
                                    @endif
                                @endif
                                </div>
                            </a>
                        @endforeach
                        @endif
                    </div>
                </div>
                <div id="authors">

                    <div class="list-group" id="list-tab" role="tablist" data-src=''>
                        @if(isset(session("permission")->student->author->display))
                        @foreach ($authors as $author)
                            <a class="list-group-item list-group-item-action p-0 border-transparent border-5x author_{{ $author->id }}"
                                id="author_{{ $author->id }}" data-date="{{ $author->creation_date }}">
                                <div class="float-left">
                                    @if ($author->status == 1)
                                        <i class="m-2 fa fa-circle" style="color:green;"></i>
                                        <input type="hidden" name="item-status" class='status-notification' value="1">
                                    @else
                                        <i class="m-2 fa fa-circle" style="color:red;"></i>
                                        <input type="hidden" name="item-status" class='status-notification' value="0">
                                    @endif
                                    <span
                                        class="item-name">{{ $author->first_name }}&nbsp;{{ $author->last_name }}</span>
                                    <input type="hidden" name="item-name"
                                        value="{{ $author->first_name }}{{ $author->last_name }}">
                                    <input type="hidden" name="item-group" value="{{ $author->linked_groups }}">
                                    <input type="hidden" name="item-company" value="{{ $author->company }}">
                                    <input type="hidden" name="item-function" value="{{ $author->function }}">
                                </div>
                                <div class="float-right btn-group">
                                    <span
                                        class="p-2  font-weight-bolder item-lang">{{ strtoupper($author->language_iso) }}</span>
                                        <button class="btn item-mail" onclick="redirectPage('{{route('sendmail')}}?authorId={{$author->id}}')">
                                            <i class="px-2 fa fa-envelope"></i>
                                        </button>
                                    @if(!isset(session("permission")->limited) || (auth()->user()->type == 3 && auth()->user()->id == $author->id_creator))
                                        @if(isset(session('permission')->student->author->show))
                                        <button class="btn item-show" data-content='author'>
                                            <i class="px-2 fa fa-eye"></i>
                                        </button>
                                        @endif

                                        @if(isset(session("permission")->student->author->edit))
                                        <button class="btn item-edit" data-content='author'>
                                                <i class="px-2 fa fa-edit"></i>
                                            </button>
                                        @endif

                                        @if(isset(session("permission")->student->author->delete))
                                        <button class="btn item-delete" data-content='author'>
                                                <i class="px-2 fa fa-trash-alt"></i>
                                            </button>
                                        @endif
                                    @endif
                                </div>
                            </a>
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div id="div_left" class="mb-4 text-center text-white handler_horizontal font-size-h3">
            <i class="fas fa-grip-lines"></i>
        </div>
        <div id="div_B" class="window bottom">

            <div class="mx-4">
                <form method="post" id="user_form" enctype="multipart/form-data" class="form" action=""
                    autocomplete="off" data-cate="" data-item="">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="type" id='user_type'>
                    <input name='_method' type='hidden' value='PUT' class='method-select' />
                    <div class="pt-3 mx-2 text-black card">
                        <div class="flex-wrap pb-3 pl-3 d-flex justify-content-center" style="overflow:hidden;">
                            <div style="width:300px !important; position:relative">
                                <i class="float-right p-3 ml-auto fa fa-cog position-absolute" style="right:0;"
                                    id="upload_button">
                                    <input type="file" name="image" class="image" accept="image/*" hidden>
                                </i>
                                <img src="" alt="" id="preview" width=300 height=300 name="preview" />
                                <input type="hidden" name="base64_img_data" id="base64_img_data">
                            </div>
                            <div class="m-5 my-auto form-group" id='status-form'>
                                <div class="mb-2 ml-0 custom-control custom-switch custom-control-lg ">
                                    <input type="checkbox" class="custom-control-input" id="user-status-icon"
                                        name="user-status-icon" checked="">
                                    <label class="custom-control-label" for="user-status-icon">Status</label>
                                </div>
                            </div>
                        </div>
                        <div class="p-3 card-body">
                            <div class="float-right form-check">
                                <input class="form-check-input" type="checkbox" value="" id="generatepassword"
                                    name="generatepassword">
                                <label class="form-check-label" for="generatepassword">Auto generate Login and
                                    Password</label>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <span id="login-label">Login</span><span class="text-danger">*</span>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="login" name="login" value="" required>
                                </div>
                            </div>
                            <div class="float-right pl-3 form-group">
                                6 characters minimum, at least 1 number, 1 lowercase, 1 uppercase, 1 special character (@ # $% ^ + = ._)
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Password<span class="text-danger">*</span>
                                        </span>
                                    </div>
                                    <input type="password" class="form-control pr-password" id="password"
                                        name="password" data-password="">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            First Name<span class="text-danger">*</span>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="firstname" name="first_name" value=""
                                        required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Last Name<span class="text-danger">*</span>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="lastname" name="last_name" value=""
                                        required>
                                </div>
                            </div>
                            <div class="form-group" id="form_group_position">
                                <div class="input-group" id="input_group_position">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Position
                                        </span>
                                    </div>
                                    <select class="form-control" id="position" name="function">
                                        <option value="" selected>No Position</option>
                                        @foreach ($positions as $position)
                                            <option value="{{ $position->id }}">{{ $position->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Company
                                        </span>
                                    </div>
                                    <select class="form-control" id="company" name="company">
                                        <option value="" selected>No Company</option>
                                        @foreach ($companies as $company)
                                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Language
                                        </span>
                                    </div>
                                    <select class="form-control" id="language" name="language">
                                        <option value="" selected>No Langauge</option>
                                        @foreach ($languages as $language)
                                            <option value="{{ $language->language_id }}">{{ $language->language_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Address<span class="text-danger">*</span>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="contact_info" name="contact_info"
                                        value="" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            E-mail<span class="text-danger">*</span>
                                        </span>
                                    </div>
                                    <input type="email" class="form-control" id="user-email" name="user-email" value=""
                                        required>
                                </div>
                            </div>
                            @if(auth()->user()->type<3)
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            User permission
                                        </span>
                                    </div>
                                    <select class="form-control" id="permission" name="permission">
                                        <option value="" selected>No selection</option>
                                        @foreach ($permissions as $permission)
                                            <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @endif
                            <div class="form-group" id="expired_date_input">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            User's subscription end date<span class="text-danger">*</span>
                                        </span>
                                    </div>
                                    <input type="text" class="bg-white js-flatpickr form-control" id="expired_date"
                                        name="expired_date" placeholder="Y-m-d" data-date-format="Y-m-d" required
                                        title="You need a correct date">
                                </div>
                            </div>

                            <div class="clearfix form-group">
                                <button type="submit" class="float-right mx-1 btn btn-hero-primary submit-btn"
                                    id="user_save_button" data-form="user_form">SAVE</button>
                                <button type="button" class="float-right mx-1 btn btn-hero-primary cancel-btn"
                                    id="user_cancel_button">CANCEL</button>
                            </div>
                        </div>
                    </div>
                </form>

                <div id="user-form-tags" class="second-table">
                    <ul class="mb-2 border-0 nav nav-tabs">
                        @if (isset(session("permission")->student->group->display))
                        <li class="nav-item">
                            <a class="m-1 border-0 nav-link active rounded-1" id="table-groups-tab"
                                href="#table-groups">{{ $translation->l('GROUPS') }}</a>
                        </li>
                        @endif
                        <li class="nav-item">
                            <a class="m-1 border-0 nav-link rounded-1" id="table-session-tab" href="#table-session">
                                {{ $translation->l('SESSIONS') }}</a>
                        </li>
                    </ul>

                    <div id="table-groups">
                        <div class="list-group" id="list-tab" role="tablist" data-src=''>

                        </div>
                    </div>
                    <div id="table-session">
                        <div class="list-group" id="list-tab" role="tablist" data-src=''>

                        </div>
                    </div>
                </div>

                <div class="modal myModal fade mt-lg-5" id="image-crop-modal" tabindex="-1" role="dialog"
                    aria-labelledby="modalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-md" role="document">
                        <div class="modal-content">
                            <div class="modal-body" id="drop">
                                <!-- <div id="drop">Drop files here.</div> -->

                                <div class="img-container" id="img-range-slider">

                                    <!-- <img id="image" src="https://avatars0.githubusercontent.com/u/3456749" style="max-width:500px;"> -->
                                    <div class="form-group" id="zoom-rangeslider-group">
                                        <input type="text" class="js-rangeslider" id="zoom-rangeslider" value="50">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">

                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-primary" id="crop">Crop</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </fieldset>
    <div id="div_vertical" class="handler_vertical width-controller">
        <i class="text-white fas fa-grip-lines-vertical"></i>
    </div>
    <fieldset id="RightPanel">


        <ul class="mx-4 mb-2 border-0 nav nav-tabs">
            @if (isset(session("permission")->student->group->display))
            <li class="nav-item">
                <a class="m-1 border-0 nav-link active rounded-1" id="groups-tab"
                    href="#groups">{{ $translation->l('GROUPS') }}</a>
            </li>
            @endif
            @if (isset(session("permission")->student->company->display))
            <li class="nav-item">
                <a class="m-1 border-0 nav-link rounded-1" id="companies-tab"
                    href="#companies">{{ $translation->l('COMPANIES') }}</a>
            </li>
            @endif
            @if (isset(session("permission")->student->position->display))
            <li class="nav-item">
                <a class="m-1 border-0 nav-link rounded-1" id="positions-tab"
                    href="#positions">{{ $translation->l('positions') }}</a>
            </li>
            @endif
        </ul>
        <div class="mx-4 mb-3 text-white clear-fix toolkit d-flex justify-content-lg-start flex-column"
            id="cate-toolkit">
            <div class="p-2 w-100">
                <div class="input-container">
                    <a href="#" class="toolkit-add-item">
                        <i class="p-2 text-white fa fa-plus icon"></i>
                    </a>
                    <span class="p-2 text-black bg-white rounded">
                        <input class="border-0 input-field mw-100 search-filter" type="text" name="search-filter">
                        <i class="p-2 fa fa-search icon"></i>
                    </span>
                    <a href="#" class="float-right toolkit-show-filter">
                        <i class="p-2 text-white fas fa-sliders-h icon"></i>
                    </a>
                </div>
            </div>
            <div class="p-2 filter toolkit-filter">
                <div class="float-left">
                    <div class="status-switch">
                        <input type="radio" id="filter-state-on" name="status" value="on">
                        <span>on&nbsp;</span>
                        <input type="radio" id="filter-state-off" name="status" value="off">
                        <span>off&nbsp;</span>
                        <input type="radio" id="filter-state-all" name="status" value="all">
                        <span>all&nbsp;</span>
                    </div>

                </div>
                <div class="float-right d-none">

                    <button type="button" value="" class="px-1 text-white border-0 rounded filter-company-btn">company
                        +<i></i></button>&nbsp;
                    <button type="button" value="" class="px-1 text-white border-0 rounded filter-function-btn">function
                        +<i></i></button>
                    </span>
                </div>
                <span class='float-right'>
                    <button value='' class="px-1 text-white border-0 rounded filter-name-btn">Name
                        <i class="fas"></i></button>
                    <button value='' class="px-1 text-white border-0 rounded filter-date-btn">Date
                        <i class="fas"></i></button>
                </span>
            </div>
        </div>
        <div id="div_C" class="window top">
            <div id="groups">


                <div class="mx-4 list-group " id="list-tab" role="tablist" data-src=''>
                    @if (isset(session("permission")->student->group->display))
                    @foreach ($groups as $group)
                        <a class="list-group-item list-group-item-action p-0 border-transparent border-5x group_{{ $group->id }}"
                            id="group_{{ $group->id }}" data-date="{{ $group->creation_date }}">
                            <div class="float-left">
                                @if ($group->status == 1)
                                    <i class="m-2 fa fa-circle" style="color:green;"></i>
                                    <input type="hidden" name="item-status" class="status-notification" value="1">
                                @else
                                    <i class="m-2 fa fa-circle" style="color:red;"></i>
                                    <input type="hidden" name="item-status" class="status-notification" value="0">
                                @endif
                                <span class="item-name">{{ $group->name }}</span>
                                <input type="hidden" name="item-name" value="{{ $group->name }}">
                            </div>
                            <div class="float-right btn-group">
                                <button class="btn item-mail" onclick="redirectPage('{{route('sendmail')}}?groupId={{$group->id}}')">
                                    <i class="px-2 fa fa-envelope"></i>
                                </button>
                                @if(!isset(session("permission")->limited) || (auth()->user()->type == 3 && auth()->user()->id == $group->id_creator))
                                    @if (isset(session("permission")->student->group->show))
                                    <button class="btn toggle1-btn item-show" data-content="group">
                                        <i class="px-2 fa fa-eye"></i>
                                    </button>
                                    @endif
                                    @if (isset(session("permission")->student->group->edit))
                                    <button class="btn item-edit toggle1-btn" data-content="group">
                                        <i class="px-2 fa fa-edit"></i>
                                    </button>
                                    @endif
                                    @if (isset(session("permission")->student->group->delete))
                                    <button class="btn item-delete toggle1-btn" data-content="group">
                                        <i class="px-2 fa fa-trash-alt"></i>
                                    </button>
                                    @endif
                                @endif
                                <button class="btn toggle2-btn" data-content="group">
                                    <i class="px-2 fas fa-check-circle"></i>
                                </button>
                            </div>
                        </a>
                    @endforeach
                    @endif
                </div>
            </div>
            <div id="companies">

                <div class="mx-4 list-group" id="list-tab" role="tablist" data-src=''>
                    @if (isset(session("permission")->student->company->display))
                    @foreach ($companies as $company)
                        <a class="list-group-item list-group-item-action p-0 border-transparent border-5x company_{{ $company->id }}"
                            id="company_{{ $company->id }}" data-date="{{ $company->creation_date }}">
                            <div class="float-left">
                                <span class="item-name">{{ $company->name }}</span>
                                <input type="hidden" name="item-name" value="{{ $company->name }}">
                            </div>
                            <div class="float-right btn-group">
                                <button class="btn item-mail" onclick="redirectPage('{{route('sendmail')}}?companyId={{$company->id}}')">
                                    <i class="px-2 fa fa-envelope"></i>
                                </button>
                                @if(!isset(session("permission")->limited) || (auth()->user()->type == 3 && auth()->user()->id == $company->id_creator))
                                    @if(isset(session("permission")->student->company->show))
                                    <button class="btn toggle1-btn item-show" data-content='company'>
                                        <i class="px-2 fa fa-eye"></i>
                                    </button>
                                    @endif
                                    @if(isset(session("permission")->student->company->edit))
                                    <button class="btn item-edit toggle1-btn" data-content='company'>
                                        <i class="px-2 fa fa-edit"></i>
                                    </button>
                                    @endif
                                    @if(isset(session("permission")->student->company->display))
                                    <button class="btn item-delete toggle1-btn" data-content='company'>
                                        <i class="px-2 fa fa-trash-alt"></i>
                                    </button>
                                    @endif
                                @endif
                                <button class="btn toggle2-btn" data-content='company'>
                                    <i class="px-2 fas fa-check-circle"></i>
                                </button>
                            </div>
                        </a>
                    @endforeach
                    @endif
                </div>
            </div>
            <div id="positions">

                <div class="mx-4 list-group" id="list-tab" role="tablist" data-src=''>
                    @if (isset(session("permission")->student->position->display))
                    @foreach ($positions as $position)
                        <a class="list-group-item list-group-item-action p-0 border-transparent border-5x function_{{ $position->id }}"
                            id="function_{{ $position->id }}">
                            <div class="float-left">
                                <!-- <i class="m-2 fa fa-circle text-danger"></i> -->
                                <span class="item-name">{{ $position->name }}</span>
                                <input type="hidden" name="item-name" value="{{ $position->name }}">
                            </div>
                            <div class="float-right btn-group">
                                @if(!isset(session("permission")->limited) || (auth()->user()->type == 3 && auth()->user()->id == $position->id_creator))
                                    @if(isset(session("permission")->student->position->show))
                                    <button class="btn toggle1-btn item-show" data-content='position'>
                                        <i class="px-2 fa fa-eye"></i>
                                    </button>
                                    @endif
                                    @if(isset(session("permission")->student->position->edit))
                                    <button class="btn item-edit toggle1-btn" data-content='position'>
                                        <i class="px-2 fa fa-edit"></i>
                                    </button>
                                    @endif
                                    @if(isset(session("permission")->student->position->display))
                                    <button class="btn item-delete toggle1-btn" data-content='position'>
                                        <i class="px-2 fa fa-trash-alt"></i>
                                    </button>
                                    @endif
                                @endif
                                <button class="btn toggle2-btn" data-content='position'>
                                    <i class="px-2 fas fa-check-circle"></i>
                                </button>
                            </div>
                        </a>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
        <div id="div_right" class="mb-4 text-center text-white handler_horizontal font-size-h3">
            <i class="fas fa-grip-lines"></i>
        </div>
        <div class="mx-4 second-table">
            <div class="mb-3 text-white clear-fix toolkit d-flex justify-content-lg-start flex-column"
                id="show-toolkit">
                <div class="p-2 w-100">
                    <div class="input-container">
                        <span id='member-count' class="pl-2 pr-4"></span>
                        <span class="p-2 text-black bg-white rounded">
                            <input class="border-0 input-field mw-100 search-filter" type="text" name="search-filter">
                            <i class="p-2 fa fa-search icon"></i>
                        </span>
                        <a href="#" class="float-right toolkit-show-filter">
                            <i class="p-2 text-white fas fa-sliders-h icon"></i>
                        </a>
                    </div>
                </div>
                <div class="p-2 filter toolkit-filter">
                    <div class="float-left">
                        <div class="status-switch">
                            <input type="radio" id="filter-state-on" name="status" value="on">
                            <span>on&nbsp;</span>
                            <input type="radio" id="filter-state-off" name="status" value="off">
                            <span>off&nbsp;</span>
                            <input type="radio" id="filter-state-all" name="status" value="all">
                            <span>all&nbsp;</span>
                        </div>

                    </div>
                    <div class="float-right">
                        <span>
                            <button value='' class="px-1 text-white border-0 rounded filter-name-btn">Name
                                <i class="fas"></i></button>
                            <button value='' class="px-1 text-white border-0 rounded filter-date-btn">Date
                                <i class="fas"></i></button>
                        </span>
                        <button type="button" value=""
                            class="px-1 text-white border-0 rounded filter-company-btn">company
                            +<i></i></button>&nbsp;
                        <button type="button" value=""
                            class="px-1 text-white border-0 rounded filter-function-btn">function
                            +<i></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div id="div_D" class="window bottom">

            <div class="mx-4 tab-content" id="nav-tabContent">
                <form method="post" id="category_form" enctype="multipart/form-data" class="form" action="">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input name='_method' type='hidden' value='PUT' class='method-select' />
                    <div class="mx-2 text-black bg-white card">
                        <div class="p-3 card-body">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Name<span class="text-danger">*</span>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="category_name" name="category_name"
                                        value="" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Description<span class="text-danger">*</span>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="category_description"
                                        name="category_description" value="" required>
                                </div>
                            </div>
                            <div class="form-group" id='status-form-group'>
                                <div class="mb-2 ml-0 custom-control custom-switch custom-control-lg ">
                                    <input type="checkbox" class="custom-control-input" id="cate-status-icon"
                                        name="cate-status-icon" checked="">
                                    <label class="custom-control-label" for="cate-status-icon">Status</label>
                                </div>
                            </div>
                            <div class="clearfix form-group">
                                <button type="submit" class="float-right mx-1 btn btn-hero-primary submit-btn"
                                    id="category_save_button" data-form="category_form">SAVE</button>
                                <button type="button" class="float-right mx-1 btn btn-hero-primary cancel-btn"
                                    id="category_cancel_button">CANCEL</button>
                                <input type="hidden" name="cate-status">
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div id="category-form-tags" class="mx-4 second-table">
                <div class="list-group" id="table-user" role="tablist" data-src=''>

                </div>

            </div>
            @if(Session::has('routeOfUser'))
            <input type="hidden" name="routeOfUser" value="{{ Session::get('routeOfUser')}}">
            @endif
    </fieldset>
</div>
<button type="button" id="notificator" class="js-notify btn btn-secondary push" data-message="Your message!<br>"
    style="display:none">
    Top Right
</button>

<script>
    funct                                                                                         