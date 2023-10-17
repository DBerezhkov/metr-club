@extends('layouts.partner_layout')

@section('title', 'Нарисовать картинку')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Новая заявка на картинку</h1>
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
                        <form action="{{ route('picasso.store') }} " method="POST" id='formSnd' enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-8">
                                        <label for="exampleInputPassword1">ФИО клиента</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            </div>
                                            <input type="text" value="{{ old('clientname') }}" class="form-control" id="clientname" name="clientname" required>
                                        </div>
                                        @error('clientname')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-4">
                                        <label>Дата рождения</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="text" value="{{ old('date_of_birth') }}" name="date_of_birth" class="form-control" required data-inputmask='"mask": "99.99.9999"' data-mask>
                                        </div>
                                        @error('date_of_birth')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-3">
                                        <label for="exampleInputPassword1">Серия и номер паспорта</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-passport"></i></span>
                                            </div>
                                            <input type="text" value="{{ old('passport_sn') }}" class="form-control" id="email-copy-bank" name="passport_sn" required data-inputmask='"mask": "9999 999999"' data-mask>
                                        </div>
                                        @error('passport_sn')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group col-2">
                                        <label for="exampleInputPassword1">Дата выдачи</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="text" value="{{ old('passport_when') }}" class="form-control" id="email-copy-bank" name="passport_when" required data-inputmask='"mask": "99.99.9999"' data-mask>
                                        </div>
                                        @error('passport_when')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-7">
                                        <label for="exampleInputPassword1">Код подразделения</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                                            </div>
                                            <input type="text" value="{{ old('passport_code') }}" class="form-control" id="passport_code" name="passport_code" required data-inputmask='"mask": "999 999"' data-mask placeholder="Введите, и мы постараемся сами заполнить поле 'КЕМ ВЫДАН'">
                                        </div>
                                        @error('passport_code')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <p class="font-weight-bold">Кем выдан</p>
                                    <textarea name="passport_who" id="passport_who" class="form-control" rows="2">{{ old('passport_who') }}</textarea>
                                    @error('passport_who')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="form-group col-4">
                                        <label for="exampleInputPassword1">Названия банков</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-piggy-bank"></i></span>
                                            </div>
                                            <input type="text" value="{{ old('banks') }}" class="form-control" id="email-copy-bank" placeholder="Укажите до трёх банков" name="banks" required>
                                        </div>
                                        @error('banks')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-4">
                                        <label for="exampleInputPassword1">ИНН</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-address-card"></i></span>
                                            </div>
                                            <input type="text" value="{{ old('inn') }}" class="form-control" id="email-copy-bank" name="inn" required data-inputmask-regex='[0-9]*' data-mask>
                                        </div>
                                        @error('inn')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-4">
                                        <label for="exampleInputPassword1">Зарплата</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-ruble-sign"></i></span>
                                            </div>
                                            <input type="text" value="{{ old('salary') }}" class="form-control" id="email-copy-bank" name="salary" required data-inputmask-regex='[0-9]*' data-mask>
                                        </div>
                                        @error('salary')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <h3>Для заполнения трудовой книжки</h3>
                                <div class="row">
                                    <div class="form-group col-2">
                                        <label for="exampleInputPassword1">Желаемая должность</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="far fa-laugh-squint"></i></span>
                                            </div>
                                            <input type="text" value="{{ old('position') }}" class="form-control" id="email-copy-bank" name="position" required>
                                        </div>
                                        @error('position')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-5">
                                        <label for="exampleInputPassword1">Дата открытия трудовой книжки</label>
                                        <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="text" value="{{ old('record_of_service_date') }}" class="form-control" id="email-copy-bank" name="record_of_service_date" placeholder="Делаем запись от первой компании с последующим увольнением" required data-inputmask='"mask": "99.99.9999"' data-mask>
                                        </div>
                                        @error('record_of_service_date')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-5">
                                        <label for="exampleInputPassword1">Дата трудоустройства на текущем месте работы</label>
                                        <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="text" value="{{ old('employment_date') }}" class="form-control" id="email-copy-bank" name="employment_date" required data-inputmask='"mask": "99.99.9999"' data-mask>
                                        </div>
                                        @error('employment_date')
                                        <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlFile1" class="text-danger">Прикрепите <u>образец подписи</u> и <u>документ-основание о смене фамилии (если имеет место быть)</u></label>
                                    <input type="file" class="form-control-file mb-2" name="scanfiles[]" id="scanfiles" multiple>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" id="btnSubmit" class="btn btn-primary">Отправить заявку</button>
                            </div>
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

        $( "#passport_code" ).keypress(async function() {
            var $this = $(this),
            val = $this.val().replace(/[^0-9]/g, '');

            if(val.length == 6){

                var url = "https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/fms_unit";
                var token = "50e09e9a559d764a0dd75936e507e2469d53b34d";
                query = val;

                var options = {
                    method: "POST",
                    mode: "cors",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "Authorization": "Token " + token
                    },
                    body: JSON.stringify({query: query})
                }

                let response = await fetch(url, options);
                let codes = await response.json(); // читаем ответ в формате JSON
                $("#passport_who").val(codes.suggestions[1].value)
                console.log(codes)

            }
        });


    </script>

@endsection
