@extends('layouts.partner_layout')

@section('title', 'Данные об агенте')

@section('content')
    <!-- Content Header (Page header) -->

    <div class="content-header">
        <div class="container-fluid">
        </div><!-- /.container-fluid -->
    </div>

    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">

        <div class="container-fluid">
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert">x</button>
                    <h4><i class="icon fa fa-check"></i>{{ session('success') }}</h4>
                </div>
            @endif
            <div class="row">
                <div class="col-md-3">
                    <div class="card card-primary">
                        <div class="card-body box-profile">
                            <div class="text-center mb-3">
                                <img  src="@if(isset($user->profile_photo_src)) {{$user->profile_photo_src}} @else/img/bear.jpeg @endif" class="img-fluid rounded-start img-circle" style="width: unset; border-radius: 3%; border: 2px solid #adb5bd; box-shadow: 1px 0px 5px 0px rgb(0 0 0 / 27%);">
                            </div>

                            <h3 class="profile-username text-center mb-3">{{$user->name}}</h3>
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Порядковый номер агента:</b> <div class="float-right">{{$user->id}}</div>
                                </li>
                                <li class="list-group-item">
                                    <b>Логин:</b> <div class="float-right">{{$user->email}}</div>
                                </li>
                                @if(isset($user->phone)  && $user->phone != '')
                                    <li class="list-group-item">
                                        <b>Телефон:</b><a class="btn btn-success btn-sm float-right" href="https://wa.me/{{$user->whatsapp_phone}}?text=@php echo urlencode('Привет, ' . $user->name) @endphp" target="_blank">
                                            <i class="fab fa-whatsapp">
                                            </i>
                                        </a>
                                        <div class="float-right mr-2">{{$user->phone}}</div>
                                    </li>
                                @endif
                                @if(isset($user->tglogin) && $user->tglogin != '')
                                    <li class="list-group-item">
                                        <b>Telegram:</b> <a class="btn btn-info btn-sm float-right" href="https://t.me/{{$user->tglogin}}" target="_blank">
                                            <i class="fab fa-telegram-plane">
                                            </i>
                                        </a>
                                        <div class="float-right mr-2">{{$user->tglogin}}</div>
                                    </li>
                                @endif
                            </ul>

                            <a href="{{route('supervisor_demands.index') . '?search_field=' . $user->email}}" class="btn btn-primary btn-block">Заявки на ипотеку</a>
                            <a href="{{route('supervisor_credits.index') . '?search_field=' . $user->email}}" class="btn btn-secondary btn-block">Заявки на потребы</a>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <div class="col-md-6">

                    <div class="card card-primary">
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('employees.update', $user->id) }} " method="POST" id='form-snd'
                              name='formSnd' enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                                <div class="card-body contract_type_card">
                                    <h4>Данные сотрудника {{$user->name}}</h4>
                                    <table class="table table-bordered">
                                        <tr class="font-weight-bold">
                                            <td class="w-50">
                                                Номер телефона
                                            </td>
                                            <td>
                                                <input type="text"
                                                       value="{{$user->phone ?? ''}}"
                                                       name="agent_contract_props[{{$user->agent_contract_type_id}}][{{'phone'}}]"
                                                       class="form-control"
                                                       required >
                                            </td>
                                        </tr>
                                        <tr class="font-weight-bold">
                                            <td class="w-50">
                                                E-mail сотрудника
                                            </td>
                                            <td>
                                                <input type="text"
                                                       value="{{$user->contract_email ??''}}"
                                                       name="agent_contract_props[{{$user->agent_contract_type_id}}][{{'email'}}]"
                                                       class="form-control"
                                                       required >
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                            <div class="d-flex justify-content-between">
                                <div class="form-group d-flex justify-content-center" style="flex-basis: 50%">
                                    <input type="submit" class="btn btn-success" value="Обновить данные"
                                           id="btn_update_data">
                                </div>
                                <div class="form-group d-flex justify-content-center" style="flex-basis: 50%">
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">
                                        Удалить агента
                                    </button>
                                </div>
                            </div>
                            <div>
                            </div>
                        </form>
                    </div>
                </div>
                </div>
            </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Подтвердите действие</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Вы действительно хотите удалить агента?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Оставить</button>
                        <form action="{{route('employees.destroy', $user->id)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger ml-3">Удалить агента</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection

@section('specialscripts')
    <script>
    </script>
@endsection
