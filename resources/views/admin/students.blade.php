@extends('layouts.admin') @section('content')

    <div class="container" xmlns="http://www.w3.org/1999/html">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-9">
                        @if ($subSubject)
                            <h3>Studenci zapisani na "{{$subSubject->name}}"</h3>
                        @elseif ($subject)
                            <h3>Studenci z możliwością zapisu na przedmiot "{{$subject->name}}"</h3>
                        @else
                            <h3>Studenci</h3>
                        @endif
                    </div>
                    <div class="text-right col-md-3">
                        <a href="{{route('admin.getstudent')}}" class="btn btn-primary">Dodaj studenta</a>
                    </div>
                </div>
                @if (!$subSubject && !$subject)
                    <div class="row">
                        <div class="text-right col-md-9 col-md-offset-3">
                            <form action="{{ route('admin.importStudents') }}" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <div class="col-md-8">
                                        <input type="file" id="csvFile" name="csvFile" multiple="">
                                        <input type="text" readonly="" class="form-control" placeholder="Wybierz plik CSV (Studenci) z komputera...">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Zaimportuj</button>
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="text-right col-md-12">
                            <a data-toggle="collapse" href="#csvHintStudents" class="btn btn-primary btn-sm">Przykładowy plik CSV (Studenci)</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2 col-xs-12">
                            <div class="collapse text-center scroll-text" id="csvHintStudents">
                                <p><strong>Przykład poprawnego formatu pliku CSV</strong></p>
                                <p><strong>Tak powinna wyglądać zawartość poprawnego pliku CSV z danymi studentów</strong></p>
                                <p><strong>Każdy wiersz powienien składać się z indeksu, imienia, nazwiska i emaila studenta.</strong></p>
                                <p><strong>Kolejność danych musi być zgodna z podaną w przykładzie.</strong></p>
                                <p><strong>========================================</strong></p>
                                <p><strong>89546;Jan;Kowalski;s89546@student.po.edu.pl</strong></p>
                                <p><strong>89545;Jan;Nowak;s89545@student.po.edu.pl</strong></p>
                                <p><strong>89543;Zenon;Nowak;s89543@student.po.edu.pl</strong></p>
                                <p><strong>89557;Paweł;Burak;s89557@student.po.edu.pl</strong></p>
                                <p><strong>========================================</strong></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="text-right col-md-9 col-md-offset-3">
                            <form action="{{ route('admin.importAverages') }}" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <div class="col-md-8">
                                        <input type="file" id="csvFile" name="csvFile" multiple="">
                                        <input type="text" readonly="" class="form-control" placeholder="Wybierz plik CSV (Średnie studentów) z komputera...">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Zaimportuj</button>
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="text-right col-md-12">
                            <a data-toggle="collapse" href="#csvHintAvg" class="btn btn-primary btn-sm">Przykładowy plik CSV (Średnie studentów)</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <div class="collapse text-center scroll-text" id="csvHintAvg">
                                <p><strong>Przykład poprawnego formatu pliku CSV</strong></p>
                                <p><strong>Tak powinna wyglądać zawartość poprawnego pliku CSV ze średnimi studentów</strong></p>
                                <p><strong>Każdy wiersz powienien się składać z indeksu i średniej studenta.</strong></p>
                                <p><strong>Kolejność danych musi być zgodna z podaną w przykładzie.</strong></p>
                                <p><strong>========================================</strong></p>
                                <p><strong>89546;4.5</strong></p>
                                <p><strong>89545;3.55</strong></p>
                                <p><strong>89543;5</strong></p>
                                <p><strong>89557;4,12</strong></p>
                                <p><strong>========================================</strong></p>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" href="#filter">Filtruj <i class="fa fa-filter"></i></a>
                        </h4>
                        <div class="panel-body collapse {{$filtered? 'in': ''}}" id="filter">
                            <form class="form" method="post" action="">
                                <div class="form-group col-md-4">
                                    <label for="faculties">Wydział</label>
                                    <select id="faculties" name="faculties" class="form-control select">
                                        <option value="">-- wybierz --</option>
                                        @foreach ($faculties as $faculty)
                                            <option value="{{$faculty->id}}" {{old('faculties') == $faculty->id? 'selected' : ''}}>{{$faculty->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="fields">Kierunek</label>
                                    <select id="fields" name="fields" class="form-control select">
                                        <option value="">-- wybierz --</option>
                                        @foreach ($fields as $field)
                                            <option value="{{$field->id}}" {{old('fields') == $field->id? 'selected' : ''}}>{{$field->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="semesters">Semestr</label>
                                    <select id="semesters" name="semesters" class="form-control select">
                                        <option value="">-- wybierz --</option>
                                        @foreach ($semesters as $semester)
                                            <option value="{{$semester->id}}" {{old('semesters') == $semester->id? 'selected' : ''}}>{{$semester->number .' - ' .$semester->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="degrees">Stopień</label>
                                    <select id="degrees" name="degrees" class="form-control select">
                                        <option value="">-- wybierz --</option>
                                        @foreach ($degrees as $degree)
                                            <option value="{{$degree->id}}" {{old('degrees') == $degree->id? 'selected' : ''}}>{{$degree->name .' - ' .$degree->type}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="study_forms">Forma studiów</label>
                                    <select id="study_forms" name="study_forms" class="form-control select">
                                        <option value="">-- wybierz --</option>
                                        @foreach ($study_forms as $study_form)
                                            <option value="{{$study_form->id}}" {{old('study_forms') == $study_form->id? 'selected' : ''}}>{{$study_form->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="active">Status studenta</label>
                                    <select id="active" name="active" class="form-control select">
                                        <option value="1" {{old('active') === '1'? 'selected' : ''}}>Aktywny</option>
                                        <option value="0" {{old('active') === '0'? 'selected' : ''}}>Usunięty</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="classes_status">Status zapisu</label>
                                    <select id="classes_status" name="classes_status" class="form-control select">
                                        <option value="">-- wybierz --</option>
                                        <option value="ready">Zapisany</option>
                                        <option value="pending">Niezapisany</option>
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
                                    @if ($subSubject)
                                        <a href="{{{URL::route('admin.studentsWithSubSubject', array('subsubject' => $subSubject->id, 'sortProperty' => 'index', 'sortOrder' => $sortProperty === 'index'? ($sortOrder === 'asc'? 'desc': 'asc'): $sortOrder ))}}}">Nr indeksu
                                            @if ($sortProperty === 'index')
                                                <span class="{{$sortOrder === 'asc'?' dropup' : ''}}">
                                            <span class="caret"></span>
                                        </span>
                                            @endif
                                        </a>
                                    @elseif ($subject)
                                        <a href="{{{URL::route('admin.studentsWithSubject', array('subject' => $subject->id, 'sortProperty' => 'index', 'sortOrder' => $sortProperty === 'index'? ($sortOrder === 'asc'? 'desc': 'asc'): $sortOrder ))}}}">Nr indeksu
                                            @if ($sortProperty === 'index')
                                                <span class="{{$sortOrder === 'asc'?' dropup' : ''}}">
                                            <span class="caret"></span>
                                        </span>
                                            @endif
                                        </a>
                                    @else
                                        <a href="{{{URL::route('admin.students', array('sortProperty' => 'index', 'sortOrder' => $sortProperty === 'index'? ($sortOrder === 'asc'? 'desc': 'asc'): $sortOrder ))}}}">Nr indeksu
                                            @if ($sortProperty === 'index')
                                                <span class="{{$sortOrder === 'asc'?' dropup' : ''}}">
                                            <span class="caret"></span>
                                        </span>
                                            @endif
                                        </a>
                                    @endif
                                </th>
                                <th class="text-center">
                                    @if ($subSubject)
                                        <a href="{{{URL::route('admin.studentsWithSubSubject', array('subsubject' => $subSubject->id, 'sortProperty' => 'surname', 'sortOrder' => $sortProperty === 'surname'? ($sortOrder === 'asc'? 'desc' : 'asc'): $sortOrder ))}}}">Nazwisko i imię
                                            @if ($sortProperty === 'surname')
                                                <span class="{{$sortOrder === 'asc'?' dropup' : ''}}">
                                            <span class="caret"></span>
                                        </span>
                                            @endif
                                        </a>
                                    @elseif ($subject)
                                        <a href="{{{URL::route('admin.studentsWithSubject', array('subject' => $subject->id, 'sortProperty' => 'surname', 'sortOrder' => $sortProperty === 'surname'? ($sortOrder === 'asc'? 'desc' : 'asc'): $sortOrder ))}}}">Nazwisko i imię
                                            @if ($sortProperty === 'surname')
                                                <span class="{{$sortOrder === 'asc'?' dropup' : ''}}">
                                            <span class="caret"></span>
                                        </span>
                                            @endif
                                        </a>
                                    @else
                                        <a href="{{{URL::route('admin.students', array('sortProperty' => 'surname', 'sortOrder' => $sortProperty === 'surname'? ($sortOrder === 'asc'? 'desc' : 'asc'): $sortOrder ))}}}">Nazwisko i imię
                                            @if ($sortProperty === 'surname')
                                                <span class="{{$sortOrder === 'asc'?' dropup' : ''}}">
                                            <span class="caret"></span>
                                        </span>
                                            @endif
                                        </a>
                                    @endif
                                </th>
                                <th class="text-center">
                                    @if ($subSubject)
                                        <a href="{{{URL::route('admin.studentsWithSubSubject', array('subsubject' => $subSubject->id, 'sortProperty' => 'email', 'sortOrder' => $sortProperty === 'email'? ($sortOrder === 'asc'? 'desc' : 'asc'): $sortOrder ))}}}">Email
                                            @if ($sortProperty === 'email')
                                                <span class="{{$sortOrder === 'asc'?' dropup' : ''}}">
                                            <span class="caret"></span>
                                        </span>
                                            @endif
                                        </a>
                                    @elseif ($subject)
                                        <a href="{{{URL::route('admin.studentsWithSubject', array('subject' => $subject->id, 'sortProperty' => 'email', 'sortOrder' => $sortProperty === 'email'? ($sortOrder === 'asc'? 'desc' : 'asc'): $sortOrder ))}}}">Email
                                            @if ($sortProperty === 'email')
                                                <span class="{{$sortOrder === 'asc'?' dropup' : ''}}">
                                            <span class="caret"></span>
                                        </span>
                                            @endif
                                        </a>
                                    @else
                                        <a href="{{{URL::route('admin.students', array('sortProperty' => 'email', 'sortOrder' => $sortProperty === 'email'? ($sortOrder === 'asc'? 'desc' : 'asc'): $sortOrder ))}}}">Email
                                            @if ($sortProperty === 'email')
                                                <span class="{{$sortOrder === 'asc'?' dropup' : ''}}">
                                            <span class="caret"></span>
                                        </span>
                                            @endif
                                        </a>
                                    @endif
                                </th>
                                @if ($subject)
                                    <th class="text-center">Wybrane zajęcia</th>
                                @else
                                    <th class="text-center">
                                        {{--<a href="{{{URL::route('admin.students', array('sortProperty' => 'average', 'sortOrder' => $sortProperty === 'average'? ($sortOrder === 'asc'? 'desc' : 'asc'): $sortOrder ))}}}">Średnia--}}
                                        {{--@if ($sortProperty === 'average')--}}
                                        {{--<span class="{{$sortOrder === 'asc'?' dropup' : ''}}">--}}
                                        {{--<span class="caret"></span>--}}
                                        {{--</span>--}}
                                        {{--@endif--}}
                                        {{--</a>--}}
                                        Średnia(e)
                                    </th>
                                    <th class="text-center">Kierunki</th>
                                @endif
                                <th class="text-center">Opcje</th>
                                <th class="text-right">Zaznacz</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($students as $index => $student)
                                <tr>
                                    <td>{{{$index+1}}}</td>
                                    <td>{{{$student->index}}}</td>
                                    <td>{{{$student->surname}}} {{{$student->name}}}</td>
                                    <td>{{{$student->email}}}</td>
                                    @if ($subject)
                                        <td>
                                            @foreach($student->subSubjects as $subSubject)
                                                <p>{{ $subSubject->name }}</p>
                                            @endforeach
                                        </td>
                                    @else
                                        <td>
                                            @foreach($student->getDBStudies() as $study)
                                                <p>{{ $study->average }}</p>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach ($student->getStudies() as $study)
                                                <p>{{{$study['field']->name}}}, {{$study['semester']->number .' - ' .$study['semester']->name }}</p>
                                            @endforeach
                                        </td>
                                    @endif
                                    <td>
                                        @if ($student->active)
                                            <a href="javascript:void(0)" onclick="deleteItems('Czy na pewno chcesz usunąć tego studenta?', '{{ route('admin.deletestudent', ['id' => $student->id]) }}')">Usuń</a>
                                        @else
                                            <a href="javascript:void(0)" onclick="deleteItems('Czy na pewno chcesz przywrócić tego studenta?', '{{route('admin.restoreStudent', ['id' => $student->id])}}')">Przywróć</a>
                                        @endif
                                        <a href="{{route('admin.savestudent', ['id' => $student->id])}}">Edytuj</a>
                                        <a href="/">Pokaż zapisy</a>
                                    </td>
                                    <td class="text-right">
                                        <label for="checkboxes[{{$index}}][checkbox]"></label>
                                        <input name="checkboxes[{{$index}}][checkbox]" type="checkbox" />
                                        <label for="checkboxes[{{$index}}][id]"></label>
                                        <input type="hidden" name="checkboxes[{{$index}}][id]" value="{{ $student->id }}"/>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-right">
                        <a href="javascript:void(0)" onclick="selectAll()">Zaznacz wszystko</a>
                        /
                        <a href="javascript:void(0)" onclick="deselectAll()">Usuń zaznaczenia</a>
                    </div>
                    <div class="text-right">
                        <a a href="javascript:void(0)" onclick="changeStudyAll()">Zmień informacje studiowania</a>
                        |
                        @if ($active)
                            <a href="javascript:void(0)" onclick="deleteItems('Czy na pewno chcesz zaznaczonych studentów?', '{{ route('admin.deletestudent', ['id' => 0]) }}')">Usuń</a>
                        @else
                            <a href="javascript:void(0)" onclick="deleteItems('Czy na pewno chcesz przywrócić zaznaczonych studentów?', '{{route('admin.restoreStudent', ['id' => 0])}}')">Przywróć</a>
                        @endif
                    </div>
                    <div id="div_study">

                    </div>

                    {{ csrf_field() }}
                </form>
            </div>
        </div>
    </div>
    <template id="template_study">
        <div class="panel-heading">
            <div class="form-group">
                <label for="fields[faculty_id]" class="col-md-2 control-label">Wydział</label>
                <div class="col-md-10">
                    <select id="0" name="fields[faculty_id]" class="form-control templateSelect" onchange="ajaxGetFields(this.value, this.id)">
                        <option value="0">-- bez zmian --</option>
                        @foreach ($faculties as $faculty)
                            <option value="{{$faculty->id}}">{{$faculty->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="fields[field_id]" class="col-md-2 control-label">Kierunek</label>
                <div class="col-md-10">
                    <select id="select-field0" name="fields[field_id]" class="form-control templateSelect">
                        <option value="0">-- bez zmian --</option>

                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="fields[semester_id]" class="col-md-2 control-label">Semestr</label>
                <div class="col-md-10">
                    <select name="fields[semester_id]" class="form-control templateSelect">
                        <option value="0">-- bez zmian --</option>
                        @foreach($semesters as $sem)
                            <option value="{{$sem->id}}">{{ $sem->number . ' - ' . $sem->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="fields[degree_id]" class="col-md-2 control-label">Stopień</label>
                <div class="col-md-10">
                    <select name="fields[degree_id]" class="form-control templateSelect">
                        <option value="0">-- bez zmian --</option>
                        @foreach ($degrees as $degree)
                            <option value="{{$degree->id}}">{{$degree->name .' - ' .$degree->type}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="fields[study_form_id]" class="col-md-2 control-label">Forma studiów</label>
                <div class="col-md-10">
                    <select name="fields[study_form_id]" class="form-control templateSelect">
                        <option value="0">-- bez zmian --</option>
                        @foreach ($study_forms as $study_form)
                            <option value="{{$study_form->id}}">{{$study_form->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary btn-raised pull-right">Wykonaj</button>
    </template>
    <script>
        function changeStudyAll() {
            var form = document.getElementById('del');
            form.action = "{{ route('admin.changeStudyAll') }}"
            var fieldView = document.getElementById('template_study').innerHTML;
            document.getElementById('div_study').innerHTML = fieldView;
            $(".templateSelect").dropdown({"optionClass": "withripple"});
        }
    </script>
@endsection