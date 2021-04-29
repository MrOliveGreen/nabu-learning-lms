@extends('welcome')

@section('css_after')
<link rel="stylesheet" href="assets/js/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
<style>
    #LeftPanel {
        width: 30%;
        float: left;
    }

    #RightPanel {
        width: 70%;
        float: right;
    }

    #LeftPanel1 {
        width: 30%;
        float: left;
    }

    #RightPanel1 {
        width: 70%;
        float: right;
    }

    .list-group-item {
        background-color: #c8c7c7 !important;
    }

    .list-group-item.active {
        background-color: #362f81 !important;
    }

    .nav-item .nav-link {
        background-color: #c8c7c7 !important;
    }

    .nav-item[aria-selected='true'] .nav-link {
        background-color: #362f81 !important;
    }

    .card,
    .card-body,
    .form-group {
        background-color: #c8c7c7 !important;
    }

    li.ui-tabs-active.ui-state-active {
        /* back */
    }


    #color-picker-select .active-item span {
        background-color: #aaa;
    }

    #color-picker-select label {
        width: 200px;
    }

    .fas.fa-crosshairs {
        font-size: 26pt;
        color: green;
    }

    .dropdown-menu {
        min-width: 0px;
    }

    .dropdown-toggle::after {
        border: 0px;
    }

    .input-group>.input-group-prepend>.input-group-text {
        background-color: transparent;
        border-color: transparent;
    }

    .custom-control-label::before {
        background-color: green;
        border-color: green;
    }

    .custom-control-input:checked~.custom-control-label::before {
        background-color: red;
        border-color: red;
    }

    i.pl-2.fas.fa-crosshairs:hover {
        padding: 5px;
        font-size: 20pt;
        transition: all .1s;
    }

    #color-picker-select .active-item i.pl-2.fas.fa-crosshairs {
        color: red;
    }

    img#rainbow:hover {
        cursor: url("{{('assets/media/part.png')}}") 4 12,
        auto;
    }

    .card-body.p-3 span.input-group-text {
        min-width: 200px;
    }

    main select.form-control {
        background-color: #2d4272 !important;
        color: white !important;
    }

    main select.form-control option {
        background-color: #a7acd6;
        color: white;
        border: 4px transparent !important;
        margin-top: 10px;
    }

    .form-group button:hover {
        background-color: #d52f72 !important;
    }
</style>
@endsection

@section('js_after')
<script src="{{asset('assets/js/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js')}}"></script>

<script>
    jQuery(function() {
        Dashmix.helpers(['colorpicker']);
    });
    $(document).ready(function() {
        (function(factory) {
            "use strict";
            if (typeof define === "function" && define.amd) {

                // AMD
                define(["jquery"], factory);
            } else if (typeof exports === "object") {

                // CommonJs
                factory(require("jquery"));
            } else {

                // Browser globals
                factory(jQuery);
            }
        }(function($) {
            "use strict";
            $.fn.broiler = function(callBack) {
                var image = this[0],
                    canvas = $("<canvas/>")[0],
                    imageData;
                canvas.width = image.width;
                canvas.height = image.height;
                canvas.getContext("2d").drawImage(image, 0, 0, image.width, image.height);
                imageData = canvas.getContext("2d").getImageData(0, 0, image.width, image.height).data;
                console.log(imageData);
                this.click(function(event) {
                    var offset = $(this).offset(),
                        x, y, scrollLeft, scrollTop, start;
                    scrollLeft = $(window).scrollLeft();
                    scrollTop = $(window).scrollTop();
                    x = Math.round(event.clientX - offset.left + scrollLeft);
                    y = Math.round(event.clientY - offset.top + scrollTop);
                    start = (x + y * image.width) * 4;

                    callBack({
                        r: imageData[start],
                        g: imageData[start + 1],
                        b: imageData[start + 2],
                        a: imageData[start + 3]
                    });
                });
            };
        }));
        $('#color-picker-select').children('.active-item').removeClass('active-item');
        $('#color-picker-select i').click(function() {
            $('#color-picker-select').children('.active-item').removeClass('active-item');
        })
        $(".fas.fa-crosshairs").click(function(event) {
            $(this).parents('.form-group').addClass('active-item');
        });
    });
</script>
<script src="{{asset('assets/js/ga.js')}}"></script>
<script>
    $(function() {
        $("#rainbow").broiler(function(color) {
            var hex = "#" + ((1 << 24) + (color.r << 16) + (color.g << 8) + color.b).toString(16).slice(1);
            $("#color-picker-select").find('.active-item i:first').css("background-color", hex);
        });
    });
</script>
<script type="text/javascript">
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-36251023-1']);
    _gaq.push(['_setDomainName', 'jqueryscript.net']);
    _gaq.push(['_trackPageview']);
</script>
@endsection

@section('con')
<script>
    $(function() {
        $("#tabs").tabs();
    });
</script>
<div id="tabs">
    <ul class="nav nav-tabs border-0 mb-2 px-4">
        <li class="nav-item">
            <a class="nav-link active mr-2 bg-red-1 rounded-1 border-0" href="#clients">CLIENTS</a>
        </li>
        <li class="nav-item">
            <a class="nav-link mr-2 bg-red-0 rounded-1 border-0" href="#languages">LANGUAGES</a>
        </li>
        <li class="nav-item">
            <a class="nav-link mr-2 bg-red-0 rounded-1 border-0" href="#reports">REPORTS</a>
        </li>
    </ul>
    <div id="clients">
        <div id="content">
            <fieldset id="LeftPanel">
                <div class="px-4">
                    <div class="list-group m-0" id="list-tab" role="tablist">
                        <a class="list-group-item list-group-item-action active  p-1 border-0" id="list-home-list" data-toggle="list" href="#list-home" role="tab" aria-controls="home">
                            <div class="float-left">
                                <i class="fa fa-circle text-danger m-2"></i>
                                Client1
                            </div>
                            <div class="btn-group float-right">

                                <button class="btn text-white px-2" id="list-home-list" data-toggle="list" href="#list-home" role="tab" aria-controls="home">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn text-white px-2">
                                    <i class="fa fa-trash-alt"></i>
                                </button>
                            </div>
                        </a>
                        <a class="list-group-item list-group-item-action  p-1 border-0" id="list-profile-list" data-toggle="list" href="#list-profile" role="tab" aria-controls="profile">
                            <div class="float-left">
                                <i class="fa fa-circle text-danger m-2"></i>
                                Client2
                            </div>
                            <div class="btn-group float-right">

                                <button class="btn text-white px-2">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn text-white px-2">
                                    <i class="fa fa-trash-alt"></i>
                                </button>
                            </div>
                        </a>
                        <a class="list-group-item list-group-item-action  p-1 border-0" id="list-settings-list" data-toggle="list" href="#list-settings" role="tab" aria-controls="settings">
                            <div class="float-left">
                                <i class="fa fa-circle text-danger m-2"></i>
                                Client3
                            </div>
                            <div class="btn-group float-right">

                                <button class="btn text-white px-2">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn text-white px-2">
                                    <i class="fa fa-trash-alt"></i>
                                </button>
                            </div>
                        </a>
                        <div><a class="text-white font-size-h1" href="#">+</a></div>

                        <div class="mt-3 d-flex flex-column">
                            <div class="clearfix mb-3">
                                <label class="px-2 py-1 bg-blue-4 text-white" style="width:150px; font-size:18pt;">
                                    Status
                                </label>
                                <div class="custom-control custom-switch custom-control-lg custom-control-inline pl-2">
                                    <input type="checkbox" class="custom-control-input" id="example-sw-custom-lg1" name="example-sw-custom-lg1" checked="">
                                    <label class="custom-control-label" for="example-sw-custom-lg1"><i></i></label>
                                </div>
                            </div>
                            <div class="clearfix mb-3">
                                <label class="px-2 py-1 bg-blue-4 text-white" style="width:150px; font-size:18pt;">
                                    PPT import
                                </label>
                                <div class="custom-control custom-switch custom-control-lg custom-control-inline pl-2">
                                    <input type="checkbox" class="custom-control-input" id="example-sw-custom-lg2" name="example-sw-custom-lg2" checked="">
                                    <label class="custom-control-label" for="example-sw-custom-lg2"><i></i></label>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </fieldset>
            <div id="div_vertical" class="handler_vertical width-controller">
                <i class="fas fa-grip-lines-vertical text-white"></i>
            </div>
            <fieldset id="RightPanel">

                <form class="mx-4" method="post" action="{{route('clientssetting')}}">
                    @csrf
                    <div class="card text-black mx-2 pt-3">
                        <div class="d-flex  flex-wrap pl-3" style="overflow:hidden;">
                            <div style="width:350px !important; height:250px; position:relative">
                                <img id="rainbow" src="{{asset('assets/media/17.jpg')}}" width="350" height="250">
                                <i class="fa fa-cog float-right p-3 position-absolute ml-auto" style="right:0;"></i>
                            </div>
                            <div class="flex-grow-1 p-4">
                                <div id="color-picker-select">
                                    <div class="form-group">
                                        <div class="js-colorpicker input-group" data-format="hex">
                                            <label for="" class="pr-2">
                                                Menu Background
                                            </label>
                                            <div class="input-group-append float-right">
                                                <span class="input-group-text colorpicker-input-addon p-0" style="width:38px; height:38px;">
                                                    <i style="width:38px; height:38px; ">
                                                    </i>
                                                </span>
                                                <i style="width:38px; height:38px; " class="pl-2 fas fa-crosshairs">
                                                </i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group active-item">
                                        <div class="js-colorpicker input-group" data-format="hex">
                                            <label for="" class="pr-2">
                                                Page Background
                                            </label>
                                            <div class="input-group-append float-right">
                                                <span class="input-group-text colorpicker-input-addon p-0" style="width:38px; height:38px;">
                                                    <i style="width:38px; height:38px; ">
                                                    </i>
                                                </span>
                                                <i style="width:38px; height:38px; " class="pl-2 fas fa-crosshairs">
                                                </i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="js-colorpicker input-group" data-format="hex">
                                            <label for="" class="pr-2">
                                                Icon over color
                                            </label>
                                            <div class="input-group-append float-right">
                                                <span class="input-group-text colorpicker-input-addon p-0" style="width:38px; height:38px;">
                                                    <i style="width:38px; height:38px; ">
                                                    </i>
                                                </span>
                                                <i style="width:38px; height:38px; " class="pl-2 fas fa-crosshairs">
                                                </i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="js-colorpicker input-group" data-format="hex">
                                            <label for="" class="pr-2">
                                                Icon default color
                                            </label>
                                            <div class="input-group-append float-right">
                                                <span class="input-group-text colorpicker-input-addon p-0" style="width:38px; height:38px;">
                                                    <i style="width:38px; height:38px; ">
                                                    </i>
                                                </span>
                                                <i style="width:38px; height:38px; " class="pl-2 fas fa-crosshairs">
                                                </i>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <a class="float-right" href="#">
                                    Restore Default
                                </a>
                            </div>
                        </div>
                        <div class="card-body  p-3">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Login Administrator
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="administrator" name="">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Password
                                        </span>
                                    </div>
                                    <input type="password" class="form-control" id="password" name="">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Company
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="company" name="">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Name
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="name" name="">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Surname
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="surname" name="">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Complete Address
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="address" name="">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Email
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="email" name="">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Language of the Platform
                                        </span>
                                    </div>
                                    <select class="form-control" id="languagePlatform" name="example-select">
                                        <option value="0">Please select</option>
                                        <option value="1">Option #1</option>
                                        <option value="2">Option #2</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Pack
                                        </span>
                                    </div>
                                    <select class="form-control" id="pack" name="example-select">
                                        <option value="0">Please select</option>
                                        <option value="1">Option #1</option>
                                        <option value="2">Option #2</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <button type="submit" class="float-right bg-blue-0 text-white p-1 mx-2">SAVE</button>
                                <button type="reset" class="float-right bg-blue-0 text-white p-1">CANCEL</button>
                            </div>
                        </div>
                    </div>
                </form>
            </fieldset>
        </div>
    </div>

    <div id="languages">

        <div class="content1">
            <fieldset id="LeftPanel1">
                <div class="mx-4">
                    <div class="list-group m-0" id="list-tab" role="tablist">
                        <a class="list-group-item list-group-item-action active  p-1 border-0" id="list-home-list" data-toggle="list" href="#list-home" role="tab" aria-controls="home">
                            <div class="float-left">
                                <i class="fa fa-circle text-danger m-2"></i>
                                French
                            </div>
                            <div class="btn-group float-right">

                                <button class="btn text-white px-2" id="list-home-list" data-toggle="list" href="#list-home" role="tab" aria-controls="home">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn text-white px-2">
                                    <i class="fa fa-trash-alt"></i>
                                </button>
                            </div>
                        </a>
                        <a class="list-group-item list-group-item-action  p-1 border-0" id="list-profile-list" data-toggle="list" href="#list-profile" role="tab" aria-controls="profile">
                            <div class="float-left">
                                <i class="fa fa-circle text-danger m-2"></i>
                                English
                            </div>
                            <div class="btn-group float-right">

                                <button class="btn text-white px-2">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn text-white px-2">
                                    <i class="fa fa-trash-alt"></i>
                                </button>
                            </div>
                        </a>
                        <a class="list-group-item list-group-item-action  p-1 border-0" id="list-settings-list" data-toggle="list" href="#list-settings" role="tab" aria-controls="settings">
                            <div class="float-left">
                                <i class="fa fa-circle text-danger m-2"></i>
                                Polish
                            </div>
                            <div class="btn-group float-right">

                                <button class="btn text-white px-2">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn text-white px-2">
                                    <i class="fa fa-trash-alt"></i>
                                </button>
                            </div>
                        </a>

                    </div>
                </div>
            </fieldset>
            <div id="div_vertical1" class="handler_vertical width-controller">
                <i class="fas fa-grip-lines-vertical text-white"></i>
            </div>
            <fieldset id="RightPanel1">
                <div class="px-4">

                    <div class="card bg-secondary text-black  col-md-11">
                        <div class="card-body p-3">

                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Lesson Plan
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="lessonPlan" name="">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Appendix
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="appendix" name="">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Curren Language
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="currenLanguage" name="">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            Interface Language
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="interfaceLanguage" name="">
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="float-right bg-blue-0 text-white p-1 mx-2">SAVE</button>
                                <button type="reset" class="float-right bg-blue-0 text-white p-1">CANCEL</button>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
        </div>

    </div>
    <div id="reports">

        <div class="content2">
            <fieldset id="LeftPanel2">
                <div id="div_A" class="window top">

                </div>
                <div id="div_left" class="handler_horizontal text-center font-size-h3 text-white mb-4">
                    <i class="fas fa-grip-lines"></i>
                </div>
                <div id="div_B" class="window bottom">
                    <div id="div_A1" class="window top">

                    </div>
                    <div id="div_left1" class="handler_horizontal text-center font-size-h3 text-white mb-4">

                    </div>
                    <div id="div_B1" class="window bottom">

                    </div>
                </div>
            </fieldset>
            <div id="div_vertical2" class="handler_vertical width-controller"></div>
            <fieldset id="RightPanel2" class="m-4">

            </fieldset>
        </div>

    </div>
</div>


@endsection
