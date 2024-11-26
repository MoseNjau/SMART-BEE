@extends('layouts.app')

@section('page-title') {{ __('crud.management', ['item'=>__('beep.ChecklistSvg')]) }}
@endsection

@section('content')
    @component('components/box')
        @slot('title')
            {{ __('crud.overview', ['item'=>__('beep.ChecklistSvg')]) }}
        @endslot

        @slot('action')
            @permission('role-create')
                <a href="{{ route('checklist-svg.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus" aria-hidden="true"></i> {{ __('crud.add', ['item'=>__('beep.ChecklistSvg')]) }}
                </a>
            @endpermission
        @endslot

        @slot('bodyClass')
        @endslot

        @slot('body')

        <script type="text/javascript">
            $(document).ready(function() {
                $("#table-checklist-svg").DataTable(
                    {
                    "language": 
                        @php
                            echo File::get(public_path('js/datatables/i18n/'.LaravelLocalization::getCurrentLocaleName().'.lang'));
                        @endphp
                    ,
                    "order": 
                    [
                        [ 1, "asc" ]
                    ],
                });
            });
        </script>


        <table id="table-checklist-svg" class="table table-responsive table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>User Id</th>
                    <th>Checklist Id</th>
                    <th>Name</th>
                    <th>Svg</th>
                    <th>Pages</th>
                    <th>Last Print</th>
                    <th>App version</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach($checklistsvg as $item)
                <tr>
                    <td>{{ $loop->iteration or $item->id }}</td>
                    <td>{{ $item->user_id }}</td>
                    <td>{{ $item->checklist_id }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->svg }}</td>
                    <td>{{ $item->pages }}</td>
                    <td>{{ $item->last_print }}</td>
                    <td>{{ $item->app_version }}</td>
                    <td col-sm-1>
                        <a href="{{ route('checklist-svg.show', $item->id) }}" title="{{ __('crud.show') }}"><button class="btn btn-default"><i class="fa fa-eye" aria-hidden="true"></i></button></a>

                        <a href="{{ route('checklist-svg.edit', $item->id) }}" title="{{ __('crud.edit') }}"><button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button></a>

                        <form method="POST" action="{{ route('checklist-svg.destroy', $item->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger pull-right" title="Delete" onclick="return confirm('{{ __('crud.sure',['item'=>'ChecklistSvg','name'=>'']) }}')">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="pagination-wrapper"> {!! $checklistsvg->render() !!} </div>

        @endslot
    @endcomponent
@endsection
