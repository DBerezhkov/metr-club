@extends('layouts.admin_layout')

@section('title', 'Редактировать страницу')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Редактировать Лендинг</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
            @if (session('success'))
                <div class="alert alert-success" role="'alert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="">x</button>
                    <h4><i class="icon fa fa-check"></i>{{ session('success') }}</h4>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger" role="'danger">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="">x</button>
                    <h4><i class="icon fa fa-times"></i>{{ session('error') }}</h4>
                </div>
            @endif
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('landings.update', $landing->id) }} " method="POST" id='formSnd' enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-4">
                                        <label for="exampleInputPassword1">Название</label>
                                        <input type="text" value="{{ $landing->title }}" class="form-control" id="title" name="title" required>
                                        @error('title')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-4">
                                        <label for="exampleInputPassword1">URL</label>
                                        <input type="text" value="{{ $landing->slug }}" class="form-control" id="slug" name="slug" required data-inputmask-regex='[a-zA-Z0-9\-]*' data-mask>
                                        @error('slug')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-12">
                                        <p class="font-weight-bold">Выберите тип лендинга:</p>
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input" @if ($landing->landing_type == 1) checked @endif id="landingType1" name="landing_type" value="1">
                                            <label for="landingType1" class="form-check-label">Метр + Партнёр</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="radio" class="form-check-input" @if ($landing->landing_type == 2) checked @endif id="landingType2" name="landing_type" value="2">
                                            <label for="landingType2" class="form-check-label">Только Партнёр</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="radio" class="form-check-input" @if ($landing->landing_type == 3) checked @endif id="landingType3" name="landing_type" value="3">
                                            <label for="landingType3" class="form-check-label">Только Метр</label>
                                        </div>
                                    </div>
                                    @error('landing_type')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="row" id="fileDiv" @if ($landing->landing_type >2) style="display: none;" @endif>
                                    <div class="form-group col-12">
                                        <p class="font-weight-bold">Текущий логотип партнёра:</p>
                                        <img src="/img/landings/{{ $landing->image }}" alt="image" class="w-25">
                                        <p class="font-weight-bold">Изменить логотип партнёра</p>
                                        <input type="file" name="image">
                                        @error('image')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <button type="submit" id="btnSubmit" class="btn btn-success">Обновить контент</button>
                            </div>
                            <!-- /.card-body -->

                        </form>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

@endsection

@section('specialscripts')
    <!-- Page specific script -->
    <script>
        $('[data-mask]').inputmask()

        function urlLit(w,v) {
            var tr='a b v g d e ["zh","j"] z i y k l m n o p r s t u f h c ch sh ["shh","shch"] ~ y ~ e yu ya ~ ["jo","e"]'.split(' ');
            var ww=''; w=w.toLowerCase();
            w=w.replaceAll('|','');
            for(i=0; i<w.length; ++i) {
                cc=w.charCodeAt(i); ch=(cc>=1072?tr[cc-1072]:w[i]);
                if(ch.length<3) ww+=ch; else ww+=eval(ch)[v];}
            return(ww.replace(/[^a-zA-Z0-9\-]/g,'-').replace(/[-]{2,}/gim, '-').replace( /^\-+/g, '').replace( /\-+$/g, ''));
        }

        $(document).ready(function() {
            $('#title').bind('change keyup input click', function(){
                $('#slug').val(urlLit($('#title').val(),0))
            });
            $("input[name$='landing_type']").click(function () {
                let param = $(this).val()

                if (param < 3) {
                    $("#fileDiv").show("slow")
                    console.log(param)
                }
                else {
                    $("#fileDiv").hide("slow")
                    console.log(param)
                }
            })
        });

    </script>
@endsection
