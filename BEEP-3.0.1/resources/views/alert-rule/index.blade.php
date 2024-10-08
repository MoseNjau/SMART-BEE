@extends('layouts.app')

@section('page-title') {{ __('crud.management', ['item'=>__('beep.AlertRule')]) }}
@endsection

@section('content')
    @component('components/box')
        @slot('title')
            {{ __('crud.overview', ['item'=>__('beep.AlertRule')]) }}
        @endslot

        @slot('action')
            @permission('role-create')
                <a href="{{ route('alert-rule.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus" aria-hidden="true"></i> {{ __('crud.add', ['item'=>__('beep.AlertRule')]) }}
                </a>
            @endpermission
        @endslot

        @slot('bodyClass')
        @endslot

        @slot('body')

        <script type="text/javascript">
            $(document).ready(function() {
                $("#table-alert-rule").DataTable(
                    {
                    "language": 
                        @php
                            echo File::get(public_path('js/datatables/i18n/'.LaravelLocalization::getCurrentLocaleName().'.lang'));
                        @endphp
                    ,
                    "order": 
                    [
                        [ 3, "desc" ],
                        [ 5, "desc" ]
                    ],
                });
            });
        </script>


        <table id="table-alert-rule" class="table table-responsive table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Name</th>
                    <th>Active</th>
                    <th>Minutes</th>
                    <th>Last evaluated</th>
                    <th>Last alert</th>
                    <th>Function</th>
                    <th>Measurement</th>
                    <th>Email</th>
                    <th>Default</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach($alertrule as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ isset($item->user_id) ? $item->user->name.' ('.$item->user_id.')' : '' }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->active }}</td>
                    <td>{{ $item->calculation_minutes }} x{{ $item->alert_on_occurences }}</td>
                    <td>{{ $item->last_evaluated_at }}</td>
                    <td>{{ $item->last_calculated_at }}</td>
                    <td>{{ $item->readableFunction() }}</td>
                    <td>{{ $item->measurement->pq_name_unit }}</td>
                    <td>{{ $item->alert_via_email }}</td>
                    <td>{{ $item->default_rule }}</td>
                    <td col-sm-1>
                        <a href="{{ route('alert-rule.show', $item->id) }}" title="{{ __('crud.show') }}"><button class="btn btn-default"><i class="fa fa-eye" aria-hidden="true"></i></button></a>

                        <a href="{{ route('alert-rule.edit', $item->id) }}" title="{{ __('crud.edit') }}"><button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button></a>

                        <form method="POST" action="{{ route('alert-rule.destroy', $item->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger pull-right" title="Delete" onclick="return confirm('{{ __('crud.sure',['item'=>'AlertRule','name'=>'']) }}')">
                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="pagination-wrapper"> {!! $alertrule->render() !!} </div>

        @endslot
    @endcomponent
@endsection
