@extends('layout')

@section('con')

    <style>
        :root {
            --company-c:
                <?php
                echo '#'. $interfaceCfg->Companies->c;
            ?>
            ;
            --company-h:
                <?php
                echo '#'. $interfaceCfg->Companies->h;
            ?>
            ;
            --training-c:
                <?php
                echo '#'. $interfaceCfg->TrainingCourses->c;
            ?>
            ;
            --training-h:
                <?php
                echo '#'. $interfaceCfg->TrainingCourses->h;
            ?>
            ;
            --session-c:
                <?php
                echo '#'. $interfaceCfg->Sessions->c;
            ?>
            ;
            --session-h:
                <?php
                echo '#'. $interfaceCfg->Sessions->h;
            ?>
            ;
            --template-c: #ffc61a;
            --template-h: #c29100;
        }

    </style>
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/templatePage.css') }}">
@section('js_after')
    <script src="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/js/templatePage.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
    <script>
        $('#templates').addClass('active');
        $('#templates .nav-main-link-icon').css('color', '<?php echo session("iconOverColor") ?>');

        jQuery(function() {
            Dashmix.helpers(['notify']);
        });
    </script>
@endsection
<div id="content"
data-template-display="{{isset(session("permission")->template->template->display)}}"
data-template-edit="{{isset(session("permission")->template->template->edit)}}"
data-template-create="{{isset(session("permission")->template->template->create)}}"
data-template-delete="{{isset(session("permission")->template->template->delete)}}"
data-template-copy="{{isset(session("permission")->template->template->copy)}}"
data-training-display="{{isset(session("permission")->template->training->display)}}"
data-training-edit="{{isset(session("permission")->template->training->edit)}}"
data-training-create="{{isset(session("permission")->template->training->create)}}"
data-training-delete="{{isset(session("permission")->template->training->delete)}}"
data-training-show="{{isset(session("permission")->template->training->show)}}"
data-session-display="{{isset(session("permission")->template->session->display)}}"
data-session-edit="{{isset(session("permission")->template->session->edit)}}"
data-session-create="{{isset(session("permission")->template->session->create)}}"
data-session-delete="{{isset(session("permission")->template->session->delete)}}"
data-session-show="{{isset(session("permission")->template->session->show)}}"
data-search-template="{{isset(session("permission")->template->search->template)}}"
data-search-training="{{isset(session("permission")->template->search->training)}}"
>
    <fieldset id="LeftPanel">
        <div class="clear-fix text-white mb-3 toolkit  d-flex justify-content-lg-start flex-column mx-4"
            id="template-toolkit">
            <div class="w-100 p-2">
                <span style="font-size:16pt">TEMPLATES</span>
                <div class="input-container float-right">
                    @if (isset(session("permission")->template->template->create))
                    <a href="#" class="toolkit-add-item">
                        <i class="fa fa-plus icon p-2 text-white"></i>
                    </a>
                    @endif
                    <span class="bg-white text-black p-2 rounded">
                        <input class="input-field border-0 mw-100 search-filter" type="text" name="search-filter">
                        <i class="fa fa-search icon p-2"></i>
                    </span>
                    <a href="#" class="toolkit-show-filter float-right">
                        <i class="fas fa-sliders-h icon p-2  text-white"></i>
                    </a>
                </div>
            </div>
            <div class="filter p-2 toolkit-filter">
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
                    <button value='' class="rounded text-white filter-name-btn px-1 border-0">Name
                        <i class="fas fa-sort-numeric-down"></i>
                    </button>
                    <button value='' class="rounded text-white filter-date-btn px-1 border-0">Date
                        <i class="fas fa-sort-numeric-down"></i>
                    </button>
                </div>
            </div>
        </div>
        <div id="div_A" class="window top">
            <div class="clear-fix mx-4">

                <div class="list-group" id="template-list-tab" role="tablist">
                    @if (isset(session("permission")->template->template->display))
                    @foreach ($templates as $template)
                        @if(!isset($template->default_user) && auth()->user()->type>1)
                        @else
                        <a class="list-group-item list-group-item-action p-0 border-transparent border-5x template_{{ $template->id }} <?php if(isset(session("permission")->limited) && auth()->user()->id != $template->id_creator) echo "drag-disable"?>"
                            id="template_{{ $template->id }}" data-date="{{ $template->creation_date }}">
                            <div class="float-left">
                                @if ($template->status != 0)
                                <i class="fa fa-circle  m-2" style="color:green;"></i>
                                <input type="hidden" name="item-status" class='status-notification' value="1">
                                @else
                                <i class="fa fa-circle m-2" style="color:red;"></i>
                                <input type="hidden" name="item-status" class='status-notification' value="0">
                                @endif
                                <span class="item-name">{{ $template->name }}</span>
                                <input type="hidden" name="item-name" value="{{ $template->name }}">
                            </div>
                            <div class="btn-group float-right">
                                @if(!isset(session("permission")->limited))
                                    @if( auth()->user()->type < 2)
                                        @if (isset(session("permission")->template->template->edit))
                                        <button class="btn item-edit" data-content='template'
                                            data-item-id="{{ $template->id }}">
                                            <i class="px-2 fa fa-edit"></i>
                                        </button>
                                        @endif
                                        @if (isset(session("permission")->template->template->delete))
                                            @if(!isset($template->default_user))
                                                <button class="btn item-delete" data-content='template'
                                                    data-item-id="{{ $template->id }}">
                                                    <i class="px-2 fa fa-trash-alt"></i>
                                                </button>
                                            @endif
                                        @endif
                                        @if (isset(session("permission")->template->template->play))
                                        <button class="btn item-template" data-content='template'
                                            data-template="#/template-generator/{{ $template->alpha_id }}">
                                            <i class="px-2 fa fa-cube"></i>
                                        </button>
                                        @endif
                                        @if (isset(session("permission")->template->template->copy))
                                        <button class="btn item-duplicate" data-content='template'
                                            data-item-id="{{ $template->id }}">
                                            <i class="px-2 far fa-copy"></i>
                                        </button>
                                        @endif
                                    @elseif (auth()->user()->id == $template->id_creator)
                                        @if (isset(session("permission")->template->template->edit))
                                        <button class="btn item-edit" data-content='template'
                                            data-item-id="{{ $template->id }}">
                                            <i class="px-2 fa fa-edit"></i>
                                        </button>
                                        @endif
                                        @if (isset(session("permission")->template->template->delete))
                                            @if(!isset($template->default_user))
                                                <button class="btn item-delete" data-content='template'
                                                    data-item-id="{{ $template->id }}">
                                                    <i class="px-2 fa fa-trash-alt"></i>
                                                </button>
                                            @endif
                                        @endif
                                        @if (isset(session("permission")->template->template->play))
                                        <button class="btn item-template" data-content='template'
                                            data-template="#/template-generator/{{ $template->alpha_id }}">
                                            <i class="px-2 fa fa-cube"></i>
                                        </button>
                                        @endif
                                        @if (isset(session("permission")->template->template->copy))
                                        <button class="btn item-duplicate" data-content='template'
                                            data-item-id="{{ $template->id }}">
                                            <i class="px-2 far fa-copy"></i>
                                        </button>
                                        @endif
                                    @endif
                                @else
                                    @if (isset(session("permission")->template->template->edit))
                                    <button class="btn item-edit" data-content='template'
                                        data-item-id="{{ $template->id }}">
                                        <i class="px-2 fa fa-edit"></i>
                                    </button>
                                    @endif
                                    @if (isset(session("permission")->template->template->delete))
                                        @if(!isset($template->default_user))
                                        <button class="btn item-delete" data-content='template'
                                            data-item-id="{{ $template->id }}">
                                            <i class="px-2 fa fa-trash-alt"></i>
                                        </button>
                                        @endif
                                    @endif
                                    @if (isset(session("permission")->template->template->play))
                                    <button class="btn item-template" data-content='template'
                                        data-template="#/template-generator/{{ $template->alpha_id }}">
                                        <i class="px-2 fa fa-cube"></i>
                                    </button>
                                    @endif
                                    @if (isset(session("permission")->template->template->copy))
                                    <button class="btn item-duplicate" data-content='template'
                                        data-item-id="{{ $template->id }}">
                                        <i class="px-2 far fa-copy"></i>
                                    </button>
                                    @endif
                                @endif
                            </div>
                        </a>
                        @endif
                    @endforeach
                    @endif
                </div>

            </div>
        </div>

        <div id="div_left" class="handler_horizontal text-center font-size-h3 text-white  mb-4">
            <i class="fas fa-grip-lines"></i>
        </div>
        <div id="div_B" class="window bottom">

            {{-- <div class="mx-4">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active container m-0 p-2" id="list-home" role="tabpanel"
                        aria-labelledby="list-home-list">
                        <div class="card bg-white text-black p-3 mx-2 text-left">
                            <p>
                                <strong class="pt-1">{{ $translation->l('Template Name') }} :</strong>
            <button class="float-right p-2 border-0" id="template_edit_btn"><i class="fa fa-cog"></i></button>
            </p>

            <label id="template_name_label"></label>
            <input type="label" id="template_name_input">
            <button class="float-right mt-3 p-2 border-0 float-right bg-yellow-1"
                id="template_save_btn">{{ $translation->l('SAVE') }}</button>


        </div>
</div>
<div class="tab-pane fade" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">
    Messages</div>
<div class="tab-pane fade" id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">
    Settings</div>
</div>

</div> --}}
            <form method="post" id="template_form" enctype="multipart/form-data" class="form mx-4" action="">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input name='_method' type='hidden' value='PUT' class='method-select' />
                <div class="card bg-white text-black mx-2">
                    <div class="card-body  p-3">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        Name<span class="text-danger">*</span>
                                    </span>
                                </div>
                                <input type="text" class="form-control" id="template_name" name="template_name" value=""
                                    required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        Description<span class="text-danger">*</span>
                                    </span>
                                </div>
                                <input type="text" class="form-control" id="template_description"
                                    name="template_description" value="" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch custom-control-lg mb-2 ml-0 ">
                                <input type="checkbox" class="custom-control-input" id="template-status-icon"
                                    name="template-status-icon" checked="">
                                <label class="custom-control-label" for="template-status-icon">Status</label>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            {{-- <button type="submit" class="btn btn-hero-primary float-right mx-1 publish-btn"
                                id="template_publish_button" data-form="template_form">Publish</button> --}}
                            <button type="submit" class="btn btn-hero-primary float-right mx-1 submit-btn"
                                id="template_save_button" data-form="template_form">SAVE</button>
                            <button type="button" class="btn btn-hero-primary float-right mx-1 cancel-btn"
                                id="template_cancel_button">CANCEL</button>
                            <input type="hidden" name="template-status">
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </fieldset>
    <div id="div_vertical" class="handler_vertical width-controller">
        <i class="fas fa-grip-lines-vertical text-white"></i>
    </div>
    <fieldset id="RightPanel">
        <ul class="nav nav-tabs border-0 mb-2 mx-4">
            @if (isset(session("permission")->template->training->display))
            <li class="nav-item">
                <a class="nav-link active m-1 rounded-1 border-0" id="training-tab"
                    href="#training">{{ $translation->l('TRAININGS') }}</a>
            </li>
            @endif
            @if (isset(session("permission")->template->company->display))
            <li class="nav-item">
                <a class="nav-link m-1 rounded-1 border-0" id="company-tab"
                    href="#company">{{ $translation->l('COMPANIES') }}</a>
            </li>
            @endif
            @if (isset(session("permission")->template->session->display))
            <li class="nav-item">
                <a class="nav-link m-1 rounded-1 border-0" id="session-tab"
                    href="#session">{{ $translation->l('SESSIONS') }}</a>
            </li>
            @endif
        </ul>
        <div class="clear-fix text-white mb-3 toolkit  d-flex justify-content-lg-start flex-column mx-4"
            id="cate-toolkit">
            <div class="w-100 p-2">
                <span style="font-size:16pt" id="toolkit-tab-name">TRAINS</span>
                <div class="input-container float-right">
                    <a href="#" class="toolkit-add-item">
                        <i class="fa fa-plus icon p-2 text-white"></i>
                    </a>
                    <span class="bg-white text-black p-2 rounded">
                        <input class="input-field border-0 mw-100 search-filter" type="text" name="search-filter">
                        <i class="fa fa-search icon p-2"></i>
                    </span>
                    <a href="#" class="toolkit-show-filter float-right">
                        <i class="fas fa-sliders-h icon p-2  text-white"></i>
                    </a>
                </div>
            </div>
            <div class="filter p-2 toolkit-filter">
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
                    <button value='' class="rounded text-white filter-name-btn px-1 border-0">Name
                        <i class="fas fa-sort-numeric-down"></i>
                    </button>
                    <button value='' class="rounded text-white filter-date-btn px-1 border-0">Date
                        <i class="fas fa-sort-numeric-down"></i>
                    </button>
                </div>
            </div>
        </div>
        <div id="div_C" class="window top">

            <div id="training">
                <div class="list-group mx-4" id="list-tab" role="tablist" data-src=''>
                    @if (isset(session("permission")->template->training->display))
                    @foreach ($trainings as $training)
                        <a class="list-group-item list-group-item-action p-0 border-transparent border-5x training_{{ $training->id }} <?php if(isset(session("permission")->limited) && auth()->user()->id != $training->id_creator) echo "drag-disable"?>"
                            id="training_{{ $training->id }}" data-date="{{ $training->creation_date }}">
                            <div class="float-left">
                                @if ($training->status != 0)
                                    <i class="fa fa-circle  m-2" style="color:green;"></i>
                                    <input type="hidden" name="item-status" class='status-notification' value="1">
                                @else
                                    <i class="fa fa-circle m-2" style="color:red;"></i>
                                    <input type="hidden" name="item-status" class='status-notification' value="0">
                                @endif
                                <span class="item-name">{{ $training->name }}</span>
                                <input type="hidden" name="item-name" value="{{ $training->name }}">
                            </div>
                            <div class="btn-group float-right">
                                @if(isset(session("permission")->limited))
                                    @if(auth()->user()->id == $training->id_creator)
                                        @if (isset(session("permission")->template->training->show))
                                        <button class="btn  toggle1-btn  item-show" data-content='training'
                                            data-item-id="{{ $training->id }}">
                                            <i class="px-2 fa fa-eye"></i>
                                        </button>
                                        @endif
                                        @if (isset(session("permission")->template->training->edit))
                                        <button class="btn item-edit toggle1-btn" data-content='training'
                                            data-item-id="{{ $training->id }}">
                                            <i class="px-2 fa fa-edit"></i>
                                        </button>
                                        @endif
                                        @if (isset(session("permission")->template->training->delete))
                                        <button class="btn item-delete toggle1-btn" data-content='training'
                                            data-item-id="{{ $training->id }}">
                                            <i class="px-2 fa fa-trash-alt"></i>
                                        </button>
                                        @endif
                                    @endif
                                @else
                                    @if (isset(session("permission")->template->training->show))
                                    <button class="btn  toggle1-btn  item-show" data-content='training'
                                        data-item-id="{{ $training->id }}">
                                        <i class="px-2 fa fa-eye"></i>
                                    </button>
                                    @endif
                                    @if (isset(session("permission")->template->training->edit))
                                    <button class="btn item-edit toggle1-btn" data-content='training'
                                        data-item-id="{{ $training->id }}">
                                        <i class="px-2 fa fa-edit"></i>
                                    </button>
                                    @endif
                                    @if (isset(session("permission")->template->training->delete))
                                    <button class="btn item-delete toggle1-btn" data-content='training'
                                        data-item-id="{{ $training->id }}">
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
            <div id="company">
                <div class="list-group mx-4" id="list-tab" role="tablist" data-src=''>
                    @if (isset(session("permission")->template->company->display))
                    @foreach ($companies as $company)
                        <a class="list-group-item list-group-item-action p-0 border-transparent border-5x company_{{ $company->id }} <?php if(isset(session("permission")->limited) && auth()->user()->id != $company->id_creator) echo "drag-disable"?>"
                            id="company_{{ $company->id }}" data-date="{{ $company->creation_date }}">
                            <div class="float-left">
                                <span class="item-name">{{ $company->name }}</span>
                                <input type="hidden" name="item-name" value="{{ $company->name }}">
                            </div>
                            <div class="btn-group float-right">
                                @if(isset(session("permission")->limited))
                                    @if(auth()->user()->id == $company->id_creator)
                                        @if (isset(session("permission")->template->company->show))
                                        <button class="btn  toggle1-btn  item-show" data-content='company'
                                        data-item-id="{{ $company->id }}">
                                        <i class="px-2 fa fa-eye"></i>
                                        </button>
                                        @endif
                                        @if (isset(session("permission")->template->company->edit))
                                        <button class="btn item-edit toggle1-btn" data-content='company'
                                        data-item-id="{{ $company->id }}">
                                        <i class="px-2 fa fa-edit"></i>
                                        </button>
                                        @endif
                                        @if (isset(session("permission")->template->company->delete))
                                        <button class="btn item-delete toggle1-btn" data-content='company'
                                        data-item-id="{{ $company->id }}">
                                        <i class="px-2 fa fa-trash-alt"></i>
                                        </button>
                                        @endif
                                    @endif
                                @else
                                    @if (isset(session("permission")->template->company->show))
                                    <button class="btn  toggle1-btn  item-show" data-content='company'
                                    data-item-id="{{ $company->id }}">
                                    <i class="px-2 fa fa-eye"></i>
                                    </button>
                                    @endif
                                    @if (isset(session("permission")->template->company->edit))
                                    <button class="btn item-edit toggle1-btn" data-content='company'
                                    data-item-id="{{ $company->id }}">
                                    <i class="px-2 fa fa-edit"></i>
                                    </button>
                                    @endif
                                    @if (isset(session("permission")->template->company->delete))
                                    <button class="btn item-delete toggle1-btn" data-content='company'
                                    data-item-id="{{ $company->id }}">
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
            <div id="session">
                <div class="list-group mx-4" id="list-tab" role="tablist" data-src=''>
                    @if (isset(session("permission")->template->session->display))
                    @foreach ($sessions as $session)
                        <a class="list-group-item list-group-item-action p-0 border-transparent border-5x session_{{ $session->id }} <?php if(isset(session("permission")->limited) && auth()->user()->id != $session->id_creator) echo "drag-disable"?>"
                            id="session_{{ $session->id }}" data-date="{{ $session->creation_date }}">
                            <div class="float-left">
                                <span class="item-name">{{ $session->name }}</span>
                                <input type="hidden" name="item-name" value="{{ $session->name }}">
                            </div>
                            <div class="btn-group float-right">
                                @if(isset(session("permission")->limited))
                                    @if(auth()->user()->id == $session->id_creator)
                                        @if (isset(session("permission")->template->session->show))
                                        <button class="btn  toggle1-btn item-show" data-content='session'
                                            data-item-id="{{ $session->id }}">
                                            <i class="px-2 fa fa-eye"></i>
                                        </button>
                                        @endif
                                        @if (isset(session("permission")->template->session->edit))
                                        <button class="btn item-edit toggle1-btn" data-content='session'
                                            data-item-id="{{ $session->id }}">
                                            <i class="px-2 fa fa-edit"></i>
                                        </button>
                                        @endif
                                        @if (isset(session("permission")->template->session->delete))
                                        <button class="btn item-delete toggle1-btn" data-content='session'
                                            data-item-id="{{ $session->id }}">
                                            <i class="px-2 fa fa-trash-alt"></i>
                                        </button>
                                        @endif
                                    @endif
                                @else 
                                    @if (isset(session("permission")->template->session->show))
                                    <button class="btn  toggle1-btn item-show" data-content='session'
                                        data-item-id="{{ $session->id }}">
                                        <i class="px-2 fa fa-eye"></i>
                                    </button>
                                    @endif
                                    @if (isset(session("permission")->template->session->edit))
                                    <button class="btn item-edit toggle1-btn" data-content='session'
                                        data-item-id="{{ $session->id }}">
                                        <i class="px-2 fa fa-edit"></i>
                                    </button>
                                    @endif
                                    @if (isset(session("permission")->template->session->delete))
                                    <button class="btn item-delete toggle1-btn" data-content='session'
                                        data-item-id="{{ $session->id }}">
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
        <div id="div_right" class="handler_horizontal  text-center  font-size-h3 text-white mb-4">
            <i class="fas fa-grip-lines"></i>
        </div>
        <div id="div_D" class="window top">
            <div class="second-table mx-4">
                <div class="list-group">

                </div>
            </div>
            <div class="tab-content mx-4" id="nav-tabContent">
                <form method="post" id="category_form" enctype="multipart/form-data" class="form" action="">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input name='_method' type='hidden' value='PUT' class='method-select' />
                    <div class="card bg-white text-black mx-2">
                        <div class="card-body  p-3">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Name<span class="text-danger">*</span>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="name" name="name" value="" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Description<span class="text-danger">*</span>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="description" name="description" value=""
                                        required>
                                </div>
                            </div>
                            <div class="form-group" id='status-form-group'>
                                <div class="custom-control custom-switch custom-control-lg mb-2 ml-0 "
                                    id="status_checkbox">
                                    <input type="checkbox" class="custom-control-input" id="cate-status-icon"
                                        name="cate-status-icon" checked="">
                                    <label class="custom-control-label" for="cate-status-icon">Status</label>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <button type="submit" class="btn btn-hero-primary float-right mx-1 submit-btn"
                                    id="category_save_button" data-form="category_form">SAVE</button>
                                <button type="button" class="btn btn-hero-primary float-right mx-1 cancel-btn"
                                    id="category_cancel_button">CANCEL</button>
                                <input type="hidden" name="cate-status">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </fieldset>
</div>

@endsection
