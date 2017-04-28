<div style="margin:0px 50px 0px 50px;">

    @if($services)

        <table class="table table-hover table-striped">
            <thead>
            <tr>
                <th>№</th>
                <th>Имя</th>
                <th>Текст</th>
                <th>Иконки</th>
                <th>Дата создания</th>
                <th>Удалить</th>
            </tr>
            </thead>
            <tbody>

            @foreach($services as $k => $service)

                <tr>
                    <td>{{ $service->id }}</td>
                    <td>{!! Html::link(route('serviceEdit', ['service'=>$service->id]), $service->name, ['alt'=>$service->name]) !!}</td>
                    <td>{{ $service->text }}</td>
                    <td>{{ $service->icon  }}</td>
                    <td>{{ $service->created_at }}</td>
                    <td>
                        {{--Формирование формы  с помощью библиотек--}}
                        {!! Form::open(['url'=>route('serviceEdit', ['service'=>$service->id]), 'class'=>'form-horizontal', 'method'=>'post']) !!}

                        {{ method_field('DELETE') }}
                        {!! Form::button('Удалить', ['class'=>'btn btn-danger', 'type'=>'submit']) !!}

                        {!! Form::close() !!}
                    </td>
                </tr>

            @endforeach

            </tbody>
        </table>
    @endif

    {!! Html::link(route('serviceAdd'), 'Добавить новый сервис') !!}

</div>