@extends('layouts.partner_layout')

@section('title', 'Заявки на потребы')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-9">
                    <div class="card-body">
                        <h1 class="mb-3">Просмотр заявки на кредит</h1>
                        <div class="row">
                            <div class="col-md-9">
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-6 mb-3">
                                                <label for="exampleInputPassword1">ФИО клиента</label>
                                                <input type="text" class="form-control" id="name" value="{{$credit->name}}" disabled>
                                            </div>
                                            <div class="col-sm-6 mb-3">
                                                <label for="exampleInputPassword1">Мобильный телефон</label>
                                                <input type="text" class="form-control" id="phone" value="{{$credit->phone}}" disabled>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4 mb-3">
                                                <label for="exampleInputPassword1">Сумма кредита</label>
                                                <input type="text" class="form-control" id="price" value="{{$credit->price}}" disabled>
                                            </div>

                                            @if(isset($credit_program->title))
                                            <div class="col-sm-4 mb-3">
                                                <label for="exampleInputPassword1">Программа кредитования</label>
                                                <select class="custom-select" size="1" disabled>
                                                    <option selected>{{$credit_program->title}}</option>
                                                </select>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="form-group text-start">
                                            <label for="exampleFormControlTextarea1">Комментарий к заявке:</label>
                                            <textarea id="commentary" class="form-control" rows="3" disabled>
                                                {{$credit->commentary}}
                                            </textarea>
                                        </div>

                                        <div class="form-group mt-3">
                                            @if(isset($banks_list))
                                            <label for="exampleInputPassword1">Заявка отправлена в банки:</label>
                                            @endif
                                            <div class="row">
                                                @foreach($banks as $bank)
                                                    @if(isset($banks_list) && in_array($bank['id'], $banks_list))
                                                    <div class="col-sm-3">
                                                        <!-- checkbox -->
                                                        <div class="form-group clearfix">
                                                            <div class="icheck-primary d-inline">
                                                                <input type="checkbox" id="checkboxBank-{{ $bank['id'] }}" name="{{ $bank['id'] }}" disabled  checked>
                                                                <label for="checkboxBank-{{ $bank['id'] }}">
                                                                    {{ $bank['name'] }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleFormControlFile1">Отправленные файлы</label>
                                            <div class="form-group">
                                                <button type="button" id="downloadBtn" class="btn btn-success">Скачать все файлы архивом</button>
                                            </div>

                                            <div>
                                                @foreach(json_decode($credit['files']) as $key => $file)
                                                <div class="form-group clearfix mb-0">
                                                        <a href="/clients/credits/{{ $credit['uid'] . '/' . $file }}" target="_blank">
                                                            <div class="file-preview file-image-preview">
                                                                <div class="file-image">
                                                                    <img id="{{$file.$key}}" src="/clients/credits/{{ $credit['uid'] . '/' . $file }}" alt="" style="height: 100%; width: 100%; object-fit: cover;"
                                                                         onerror="this.src='/img/dropzone/default.png'">
                                                                </div>
                                                                <div class="file-details">
                                                                    <div class="file-filename">
                                                                        <div class="file-filename__name">{{$file}}</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <style>
        .slide-fade-enter-active {
            transition: all .3s ease;
        }

        .slide-fade-leave-active {
            transition: all .8s cubic-bezier(1.0, 0.5, 0.8, 1.0);
        }

        .slide-fade-enter, .slide-fade-leave-to
            /* .slide-fade-leave-active below version 2.1.8 */
        {
            transform: translateX(10px);
            opacity: 0;
        }

        .file-preview {
            position: relative;
            display: inline-block;
            vertical-align: top;
            margin: 16px 16px 16px 0;
            max-height: 75px;
        }
        .file-preview:hover {
            z-index: 1000;
        }
        .file-preview:hover .file-details {
            opacity: 1;
        }
        .file-preview.file-file-preview .file-image {
            border-radius: 20px;
            background: #999;
        }
        .file-preview.file-file-preview .file-details {
            opacity: 1;
        }
        .file-preview.file-image-preview .file-details {
            -webkit-transition: opacity 0.2s linear;
            -moz-transition: opacity 0.2s linear;
            -ms-transition: opacity 0.2s linear;
            -o-transition: opacity 0.2s linear;
            transition: opacity 0.2s linear;
        }
        .file-preview .file-remove {
            font-size: 14px;
            text-align: center;
            display: block;
            cursor: pointer;
            border: none;
        }

        .file-preview:hover .file-details {
            opacity: 1;
        }
        .file-preview .file-details {
            z-index: 20;
            position: absolute;
            top: 0;
            left: 0;
            opacity: 0;
            font-size: 18px;
            min-width: 100%;
            max-width: 100%;
            padding: 2em 1em;
            text-align: center;
            color: rgba(0, 0, 0, 0.9);
            line-height: 150%;
            max-height: 75px;
        }

        .file-preview:hover .file-image img {
            -webkit-transform: scale(1.05, 1.05);
            -moz-transform: scale(1.05, 1.05);
            -ms-transform: scale(1.05, 1.05);
            -o-transform: scale(1.05, 1.05);
            transform: scale(1.05, 1.05);
            /*-webkit-filter: blur(8px);*/
            /*filter: blur(8px);*/
        }
        .file-preview .file-image {
            border-radius: 20px;
            overflow: hidden;
            width: 75px;
            height: 75px;
            position: relative;
            display: block;
            font-size: 18px;
            z-index: 10;
        }
        .file-preview .file-image img {
            display: block;
        }
        .file-preview.file-success .file-success-mark {
            -webkit-animation: passing-through 3s cubic-bezier(0.77, 0, 0.175, 1);
            -moz-animation: passing-through 3s cubic-bezier(0.77, 0, 0.175, 1);
            -ms-animation: passing-through 3s cubic-bezier(0.77, 0, 0.175, 1);
            -o-animation: passing-through 3s cubic-bezier(0.77, 0, 0.175, 1);
            animation: passing-through 3s cubic-bezier(0.77, 0, 0.175, 1);
        }
        .file-preview.file-error .file-error-mark {
            opacity: 1;
            -webkit-animation: slide-in 3s cubic-bezier(0.77, 0, 0.175, 1);
            -moz-animation: slide-in 3s cubic-bezier(0.77, 0, 0.175, 1);
            -ms-animation: slide-in 3s cubic-bezier(0.77, 0, 0.175, 1);
            -o-animation: slide-in 3s cubic-bezier(0.77, 0, 0.175, 1);
            animation: slide-in 3s cubic-bezier(0.77, 0, 0.175, 1);
        }
        .file-preview .file-success-mark, .file-preview .file-error-mark {
            pointer-events: none;
            opacity: 0;
            z-index: 500;
            position: absolute;
            display: block;
            top: 50%;
            left: 50%;
            margin-left: -27px;
            margin-top: -27px;
        }
        .file-preview .file-success-mark svg, .file-preview .file-error-mark svg {
            display: block;
            width: 54px;
            height: 54px;
        }
        .file-preview.file-processing .file-progress {
            opacity: 1;
            -webkit-transition: all 0.2s linear;
            -moz-transition: all 0.2s linear;
            -ms-transition: all 0.2s linear;
            -o-transition: all 0.2s linear;
            transition: all 0.2s linear;
        }
        .file-preview.file-complete .file-progress {
            opacity: 0;
            -webkit-transition: opacity 0.4s ease-in;
            -moz-transition: opacity 0.4s ease-in;
            -ms-transition: opacity 0.4s ease-in;
            -o-transition: opacity 0.4s ease-in;
            transition: opacity 0.4s ease-in;
        }
        .file-preview:not(.file-processing) .file-progress {
            -webkit-animation: pulse 6s ease infinite;
            -moz-animation: pulse 6s ease infinite;
            -ms-animation: pulse 6s ease infinite;
            -o-animation: pulse 6s ease infinite;
            animation: pulse 6s ease infinite;
        }
        .file-preview .file-progress {
            opacity: 1;
            z-index: 1000;
            pointer-events: none;
            position: absolute;
            height: 16px;
            left: 50%;
            top: 50%;
            margin-top: -8px;
            width: 80px;
            margin-left: -40px;
            background: rgba(255, 255, 255, 0.9);
            -webkit-transform: scale(1);
            border-radius: 8px;
            overflow: hidden;
        }
        .file-preview .file-progress .file-upload {
            background: #333;
            background: linear-gradient(to bottom, #666, #444);
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            width: 0;
            -webkit-transition: width 300ms ease-in-out;
            -moz-transition: width 300ms ease-in-out;
            -ms-transition: width 300ms ease-in-out;
            -o-transition: width 300ms ease-in-out;
            transition: width 300ms ease-in-out;
        }
        .file-preview.file-error .file-error-message {
            display: block;
        }
        .file-preview.file-error:hover .file-error-message {
            opacity: 1;
            pointer-events: auto;
        }

        .file-preview .file-details {
            background-color: rgba(119, 127, 134, 0);
            opacity: 1;
            color: black;
        }


        .file-preview .file-image {
            border-radius: 20px;
        }

        .file-preview.file-file-preview .file-details {
            border-radius: 20px;

        }

        .file-preview.file-image-preview .file-details {
            border-radius: 20px;
            min-height: 75px;
        }

        .file-preview.file-image-preview {
            border-radius: 20px;
        }

        .file-preview {
            max-width: 75px;
            max-height: 75px;
        }


        .file-preview .file-image img:not([src]) {
            max-width: 120px;
            max-height: 120px;
        }


        .file-filename {
            position: relative;
            top: -37px;
            left: 70px;
            height: 75px;
            display: flex;
            align-items: center;
            min-width: 1000px;
            text-align: left;
        }


        @media(max-width: 1374px){
            .file-filename {
                min-width: 900px;
            }

        }

        @media(max-width: 1274px){
            .file-filename {
                min-width: 633px;
            }

        }

        @media(max-width: 1274px){
            .file-filename {
                min-width: 633px;
            }

        }

        @media(max-width: 1017px){
            .file-filename {
                min-width: 550px;
                font-size: 16px;
            }

        }

        @media(max-width: 682px){
            .file-filename {
                min-width: 450px;
                font-size: 16px;
            }

        }

        @media(max-width: 575px){
            .file-filename {
                min-width: 411px;
                font-size: 14px;
            }

        }

        @media(max-width: 531px){
            .file-filename {
                min-width: 332px;
                font-size: 14px;
            }

        }

        @media(max-width: 465px){
            .file-filename {
                margin-top: 5px;
                min-width: 292px;
                font-size: 12px;
            }

        }

        @media(max-width: 410px){
            .file-filename {
                margin-top: 5px;
                min-width: 265px;
                font-size: 11px;
            }

        }

        @media(max-width: 373px){
            .file-filename {
                margin-top: 5px;
                min-width: 233px;
                font-size: 11px;
            }

        }

        @media(max-width: 350px){
            .file-filename {
                margin-top: 11px;
                min-width: 196px;
                font-size: 9px;
            }

        }

        @media(max-width: 318px){
            .file-filename {
                margin-top: 11px;
                min-width: 184px;
                font-size: 9px;
            }

        }

        @media(max-width: 301px){
            .file-filename {
                margin-top: 11px;
                min-width: 150px;
                font-size: 9px;
            }

        }

    </style>

@endsection
@section('specialscripts')
    <script>
        $('#downloadBtn').click(function() {
            var serializeFormData = $('#form').serialize();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: '/download',
                data: { _token:"{{ csrf_token() }}", clientname: "{{ $credit['name'] }}", uid: "{{ $credit['uid'] }}" },
                success: function(response){
                    window.location = response;
                },
                error:  function(data){
                    console.log('Внимание! произошла ошибка:' + data);
                }
            });
        });

        let files = {!! $credit->files !!};
        for (let [index, name] of files.entries()){
            if(name.toLowerCase().includes('.pdf'.toLowerCase())){
                $(document).ready(function () {
                    document.getElementById(name+index).src="/img/dropzone/PDF.png";
                })
            } else if(name.toLowerCase().includes('.xlsx'.toLowerCase()) ||
                name.toLowerCase().includes('.xls'.toLowerCase())){
                $(document).ready(function () {
                    document.getElementById(name+index).src="/img/dropzone/EXCEL_2.png";
                })
            } else if(name.toLowerCase().includes('.zip'.toLowerCase()) || name.toLowerCase().includes('.rar'.toLowerCase())){
                $(document).ready(function () {
                    document.getElementById(name+index).src="/img/dropzone/ARCHIVE.png";
                })
            } else if(name.toLowerCase().includes('.doc'.toLowerCase()) ||
                name.toLowerCase().includes('.docx'.toLowerCase())){
                $(document).ready(function () {
                    document.getElementById(name+index).src="/img/dropzone/WORD.png";
                })
            } else {
                if(!name.toLowerCase().includes('.jpg'.toLowerCase()) &&
                    !name.toLowerCase().includes('.jpeg'.toLowerCase()) &&
                    !name.toLowerCase().includes('.png'.toLowerCase())){
                    $(document).ready(function () {
                        document.getElementById(name+index).src="/img/dropzone/default.png";
                    })
                }
            }
        }
    </script>

@endsection

