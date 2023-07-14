@extends('layouts.app')

@section('content')

<div>
    <h3>Site List</h3>

    <div class="alert alert-info" role="alert">
        <b>1E.</b> The system needs to display a list of sites that are managed by any given user. 
        Each site should display the total amount ($) and total electricity usage (kWh) from 
        its latest available bill.
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th data-toggle="tooltip" data-placement="top" title="Site identifier that is alphanumeric and 10 characters long">Site ID <i class="fa fa-question-circle"></i></th>
                    <th>Name</th>
                    <th>Address</th>
                    <th data-toggle="tooltip" data-placement="top" title="The name of the site manager that comes from the Users table linked via site_manager_id in the sites table">Site Manager <i class="fa fa-question-circle"></i></th>
                    <th data-toggle="tooltip" data-placement="top" title="Electricity Usage (kWh) from latest bill record">Total Electricity Usage <i class="fa fa-question-circle"></i></th>
                    <th data-toggle="tooltip" data-placement="top" title="Amount ($) from latest bill record">Total Amount <i class="fa fa-question-circle"></i></th>
                    <th data-toggle="tooltip" data-placement="top" title="If clicked it redirects to the specific Site detail view which includes 1D and 1F">Actions <i class="fa fa-question-circle"></i></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sites as $site)
                    <tr>
                        <td>{{ $site->id }}</td>
                        <td>{{ $site->name }}</td>
                        <td>{{ $site->address }}</td>
                        <td>{{ $site->user->name }}</td>
                        <td>{{ number_format($site->bill->electricity_usage) }} kWh</td>
                        <td>${{ $site->bill->amount }}</td>
                        <td>
                            <a href="/sites/{{ $site->id }}" class="btn btn-primary btn-sm">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="text-center">
    {{ $sites->links('pagination::bootstrap-4') }}
</div>

@endsection
