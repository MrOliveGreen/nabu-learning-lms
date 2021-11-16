@extends('layout')

@section('con')
    <link rel="stylesheet" href="{{ asset('assets/css/commondashPage.css') }}">
@section('js_after')
    <script src="{{ asset('assets/js/commondashPage.js') }}"></script>
@endsection
<div id="content">
    @foreach ($trainings as $training)
        <div class="row ml-3">
            <fieldset class='col-sm-12 col-md-3 col-lg-3 h-100'>
                <div id="div_A" class="window top">
                    <div class="training-item" data-session="{{ $training['session_id'] }}"
                        data-type="{{ $training['training']['type'] }}">
                        <div class="training-card">
                            <div class="card mb-4 pr-3 border-0" id="training_{{ $training['training']['id'] }}">
                                <div class="card-header d-flex">
                                    <div class="w-100 text-white">
                                        <h3 class='mb-0 text-white'>{{ $training['training']['name'] }}</h3>
                                    </div>
                                </div>
                                <div class="items-push card-img-top">
                                    <div class="animated fadeIn ">
                                        <div class="options-container fx-item-zoom-in fx-overlay-slide-right">
                                            <img class="img-fluid options-item w-100"
                                                src="{{ $training['training']['training_icon'] ? $training['training']['training_icon'] : asset('assets/media/18.jpg') }}"
                                                alt="">
                                            <div class="options-overlay bg-black-75">
                                                <div class="options-overlay-content">

                                                    {{-- <p class="h6 text-white-75 mb-3">
                                                        {{ $training['training']['description'] }}</p> --}}
                                                    <a class="btn btn-sm btn-primary training-show"
                                                        href="javascript:void(0)">
                                                        <i class="fa fa-eye mr-1"></i> show
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-0 text-center text-black">
                                        <div class="col-6">
                                            @if ($training['progress'] == 0)
                                                <i class="fa fa-chart-line">

                                                </i>
                                                <span class="text-mute">
                                                    {{ number_format($training['progress'], 1, '.', '') }}%
                                                </span>
                                            @elseif ($training['progress'] < 100) <i
                                                    class="fa fa-chart-line text-warning">

                                                    </i>
                                                    <span class="text-mute text-warning">
                                                        {{ number_format($training['progress'], 1, '.', '') }}%
                                                    </span>
                                                @elseif ($training['progress'] == 100)
                                                    <i class="fa fa-chart-line text-success">

                                                    </i>
                                                    <span class="text-mute text-success">
                                                        {{ number_format($training['progress'], 1, '.', '') }}%
                                                    </span>
                                            @endif
                                        </div>
                                        <div class="col-6">
                                            @if ($training['success'] == 'true')
                                                <i class="fa fa-check-circle text-success">
                                                </i>

                                                <span class="text-success">
                                                    {{ number_format($training['eval'], 1, '.', '') }}%
                                                </span>
                                            @elseif ($training['success'] == "false")
                                                <i class="fa fa-check-circle text-danger">
                                                </i>

                                                <span class="text-danger">
                                                    {{ number_format($training['eval'], 1, '.', '') }}%
                                                </span>
                                            @elseif ($training['success'] == "NULL")
                                                <i class="fa fa-check-circle text-warning">
                                                </i>
                                                <span class="text-warning">
                                                    {{ number_format($training['eval'], 1, '.', '') }}%
                                                </span>
                                            @elseif ($training['success'] == "")
                                                <i class="fa fa-check-circle text-muted">
                                                </i>
                                                <span class="text-muted">
                                                    -
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <p class="h4 mb-0 mt-2 text-center training-description">
                                        Ends on
                                        {{ date_format(date_create($training['training']['date_end']), 'd F Y') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="content-training push pr-3">
                        </div>
                    </div>
                </div>
            </fieldset>
            <fieldset class='col-sm-12 col-md-9 col-lg-9'>
                <div id="div_C" class="window top">
                    <div class="push" style="display: none"
                        data-type="{{ $training['training']['type'] }}">
                        <div class="block-content bg-white mt-2 pb-3 text-black">
                            <div>
                                @if ($training['training']['description'])
                                <p class="description-title"><b>Description: </b></p>
                                @endif
                                @if ($training['training']['duration'])
                                    <p><b>Duration:
                                        </b>{{ $training['training']['duration'] }}</p>
                                @endif
                            </div>
                            {{-- @if ($training['training']['publicAudio'])
                                <p><b>Public Target: </b>{{ $training['training']['publicAudio'] }}</p>
                            @endif --}}
                            @if ($training['training']['description'])
                                <p>{{ $training['training']['description'] }}</p>
                            @endif
                            @if ($training['user_info'])
                                <p><b>Responsible for training:</b></p>
                                <p>{{ $training['user_info']->email }}</p>
                                <p>{{ $training['user_info']->address }}</p>
                            @endif
                        </div>
                        <div class="lessons">
                            @foreach ($lessons[$training['session_id']] as $lesson)
                                <div class="accordion" role="tablist" aria-multiselectable="true"
                                    id="accordion{{ $lesson['lesson']['id'] }}"
                                    data-progress="{{ $lesson['progress'] }}" data-eval="{{ $lesson['eval'] }}"
                                    data-course="{{ $lesson['course_id'] }}"
                                    data-session="{{ $training['session_id'] }}">
                                    <div class="block block-rounded mb-1 bg-transparent shadow-none">
                                        <div class="block-header block-header-default border-transparent border-0 bg-transparent p-0"
                                            role="tab" id="accordion_h1">
                                            <div class=" col-md-3 text-white align-self-stretch d-flex text-center  flex-md-row"
                                                style="border-right:3px solid white;">
                                                <span class="col-md-6 align-middle py-2">
                                                    @if ($lesson['progress'] == 0)
                                                        <i class="fa fa-chart-line align-middle">
                                                        </i>
                                                        <span class=" align-middle pl-1 text-black">
                                                            {{ $lesson['progress'] }}%
                                                        </span>
                                                    @elseif ($lesson['progress'] < 100) <i
                                                            class="fa fa-chart-line align-middle text-warning">
                                                            </i>
                                                            <span class=" align-middle pl-1 text-warning">
                                                                {{ $lesson['progress'] }}%
                                                            </span>
                                                        @elseif ($lesson['progress'] = 100)
                                                            <i class="fa fa-chart-line align-middle text-success">
                                                            </i>
                                                            <span class=" align-middle pl-1 text-success">
                                                                {{ $lesson['progress'] }}%
                                                            </span>
                                                    @endif
                                                </span>
                                                <span class="col-md-6 py-2">
                                                    @if ($lesson['eval'] == '')
                                                        <i class="fa fa-check-circle"></i>
                                                        <span class="pl-1">-</span>
                                                    @elseif($lesson['lesson']['threshold_score'] > $lesson['eval'])
                                                        <i class="fa fa-check-circle text-danger"></i>
                                                        <span class="pl-1 text-danger">{{ $lesson['eval'] }}%</span>
                                                    @else
                                                        <i class="fa fa-check-circle text-success"></i>
                                                        <span class="pl-1 text-success">{{ $lesson['eval'] }}%</span>
                                                    @endif
                                                </span>
                                            </div>
                                            <div
                                                class="  col-md-9 border-transparent border-left-1 align-self-stretch d-flex flex-row justify-content-between">
                                                <div class="float-left py-2">
                                                    <span
                                                        class="item-name align-middle">{{ $lesson['lesson']['name'] }}</span>
                                                </div>
                                                <div class="btn-group float-right d-flex">
                                                    @if ($lesson['lesson']['description'] || $lesson['lesson']['duration'] || $lesson['lesson']['publicAudio'])
                                                        <button class="btn  item-show" data-content='teacher'>
                                                            <a class="font-w600 collapsed" data-toggle="collapse"
                                                                data-parent="#accordion{{ $lesson['lesson']['id'] }}"
                                                                href="#lesson_{{ $lesson['lesson']['id'] }}"
                                                                aria-expanded="false" aria-controls="accordion_q1"
                                                                onclick="showContent(this)">
                                                                <i class="fas fa-exclamation-circle m-0 p-2"></i>
                                                            </a>
                                                    @endif
                                                    </button>
                                                    <button class="btn  item-play" data-content='teacher'
                                                        data-fabrica="{{ $lesson['lesson']['idFabrica'] }}">
                                                        <i class="fa fa-play m-0 p-2 align-middle"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="lesson_{{ $lesson['lesson']['id'] }}" class="collapse"
                                            role="tabpanel" aria-labelledby="accordion_h1"
                                            data-parent="#accordion{{ $lesson['lesson']['id'] }}">
                                            <div class="block-content bg-white mt-2 pb-3 text-black">
                                                <div>
                                                    <p class="description-title"><b>Description: </b></p>
                                                    @if ($lesson['lesson']['duration'] != '')
                                                        <p><b style="margin-left: 40px">Duration:
                                                            </b>{{ $lesson['lesson']['duration'] }}</p>
                                                    @else
                                                        <p><b style="margin-left: 40px"></b></p>
                                                    @endif
                                                </div>
                                                @if ($lesson['lesson']['description'])
                                                    <p>{{ $lesson['lesson']['description'] }}</p>
                                                @endif
                                                @if ($lesson['lesson']['publicAudio'])
                                                    <p><b>Public Target: </b>{{ $lesson['lesson']['publicAudio'] }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                {{-- <div id="div_right" class="handler_horizontal  text-center text-white mb-4">
                <i class="fas fa-grip-lines"></i>
            </div>
            <div id="div_D" class="window bottom"> --}}

                {{-- <div class="dash-description mx-4">
                        <div class="dash-panel">
                            <span class="dash-panel-title">{{ $translation->l('Objectifs') }} :</span>
                            <div class="dash-panel-content">
                                {{ $translation->l('
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean eleifend
                        magna dignissim nunc maximus maximus. Nunc eget laoreet purus. Proin
                        interdum, felis non malesuada vehicula, est ante ornare tortor, blandit
                        sodales enim diam eu leo. Nam malesuada in tortor quis pharetra. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia
                        curae; Curabitur ultricies odio velit, vitae rutrum ipsum viverra in. Suspendisse mollis et dolor gravida ultrices. Aenean iaculis, orci ultrices posuere
                        sagittis, nisi felis fermentum quam, viverra euismod eros velit non ligula.
                        Etiam sit amet tempor massa.
                        ') }}
                            </div>
                            <div class="dash-panel-footer"><span
                                    class="dash-panel-bottom-title">{{ $translation->l('Durée') }} :</span>25 minutes
                            </div>
                        </div>
                        <div class="dash-item-list">
                            <div class="dash-item">
                                <div><img src="{{ asset('assets/media/13.jpg') }}" alt="" class="dash-avatar"></div>
                                <div class="dash-avatar-title text-mute">
                                    {{ $translation->l('Télécharger mon
                            attestation de
                            formation') }}
                                </div>
                            </div>
                            <div class="dash-item">
                                <img src="{{ asset('assets/media/14.jpg') }}" alt="" class="dash-avatar">
                                <div class="dash-avatar-title text-mute">
                                    {{ $translation->l('Télécharger mon
                            attestation de
                            formation') }}
                                </div>
                            </div>
                        </div>

                    </div> --}}

                {{-- </div> --}}
            </fieldset>
        </div>
    @endforeach
</div>
@endsection
