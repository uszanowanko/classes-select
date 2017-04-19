@extends('layouts.admin') @section('content')

    <div class="container">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-3">
                        <h3>Wydziały</h3>
                    </div>
                    <div class="text-right col-md-9">
                        <a href="{{route('admin.getDegree')}}" class="btn btn-primary">Dodaj stopień</a>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" href="#filter">Filtruj <i class="fa fa-filter"></i></a>
                        </h4>
                        <div class="panel-body collapse {{$filtered? 'in': ''}}" id="filter">
                            <form class="form" method="post" action="{{route('admin.degrees')}}">
                                <div class="form-group col-md-4">
                                    <label for="active">Status</label>
                                    <select id="active" name="active" class="form-control select">
                                        <option value="1" {{old( 'active')==='1' ? 'selected' : ''}}>Aktywny</option>
                                        <option value="0" {{old( 'active')==='0' ? 'selected' : ''}}>Usunięty</option>
                                    </select>
                                </div>
                                {{ csrf_field() }}
                                <div class="col-md-12">
                                    <button type="submit" class="pull-right btn btn-primary">Filtruj</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <form id="del" method="post">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover text-center">
                            <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">
                                    <a href="{{{URL::route('admin.degrees', array('sortProperty' => 'name', 'sortOrder' => $sortProperty === 'name'? ($sortOrder === 'asc'? 'desc': 'asc'): $sortOrder ))}}}">Stopień
                                        @if ($sortProperty === 'name')
                                            <span class="{{$sortOrder === 'asc'?' dropup' : ''}}">
                                        <span class="caret"></span>
                                    </span>
                                        @endif
                                    </a>
                                </th>
                                <th class="text-center">Opcje</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($degrees as $index => $degree)
                                <tr>
                                    <td class="text-center">{{$index+1}}</td>
                                    <td class="text-center">{{$degree->name .' - ' .$degree->type}}</td>
                                    <td>
                                        @if ($degree->active)
                                            <a href="javascript:void(0)" onclick="deleteItems('Czy na pewno chcesz usunąć ten stopień?', '{{ route('admin.deleteDegree', ['id' => $degree->id]) }}')">Usuń</a>
                                        @else
                                            <a href="javascript:void(0)" onclick="deleteItems('Czy na pewno chcesz przywrócić ten stopień?', '{{ route('admin.restoredegree', ['id' => $degree->id]) }}')">Przywróć</a>
                                        @endif
                                        <a href="{{route('admin.getDegree', ['id' => $degree->id])}}">Edytuj</a>
                                    </td>
                                    <td class="text-right">
                                        <label for="checkboxes[{{$index}}][checkbox]"></label>
                                        <input name="checkboxes[{{$index}}][checkbox]" type="checkbox" />
                                        <label for="checkboxes[{{$index}}][id]"></label>
                                        <input type="hidden" name="checkboxes[{{$index}}][id]" value="{{ $degree->id }}" />
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-right">
                        <a href="javascript:void(0)" onclick="selectAll()">Zaznacz wszystko</a> /
                        <a href="javascript:void(0)" onclick="deselectAll()">Usuń zaznaczenia</a>
                    </div>
                    <div class="text-right">
                        <a a href="javascript:void(0)" onclick="deleteItems('Czy na pewno chcesz usunąć zaznaczone stopnie?', '{{ route('admin.deleteDegree', ['id' => 0]) }}')">Usuń</a>
                    </div>
                    {{ csrf_field() }}
                </form>
            </div>
        </div>
    </div>
@endsection
