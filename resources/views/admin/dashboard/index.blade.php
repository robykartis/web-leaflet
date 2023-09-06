@extends('admin.layouts.app')
@section('title')
{{ $title }}
@endsection
@section('breadcrumbs')
{{ Breadcrumbs::render() }}
@endsection
@section('content')
<section>
    <div class="flex flex-wrap">
        <div class="w-full md:w-1/2 xl:w-full p-3">
            <div class="stats shadow">
                <div class="stat">
                    <div class="stat-title">Total Page Views</div>
                    <div class="stat-value">89,400</div>
                    <div class="stat-desc">21% more than last month</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!--Divider-->
<hr class="border-b-2 border-gray-400 my-8 mx-4">

<div class="flex flex-row flex-wrap flex-grow mt-2">
    <div class="w-full p-3">
        <!--Table Card-->
        <div class="card w-full bg-base-100 shadow-xl  mb-11">
            <div class="card-body">
                <h2 class="card-title">Data Maps</h2>
                <div class="overflow-x-auto">
                    <table class="table">
                        <!-- head -->
                        <thead>
                            <tr>
                                <th></th>
                                <th>Name</th>
                                <th>Job</th>
                                <th>Favorite Color</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- row 1 -->
                            <tr class="bg-base-200">
                                <th>1</th>
                                <td>Cy Ganderton</td>
                                <td>Quality Control Specialist</td>
                                <td>Blue</td>
                            </tr>
                            <!-- row 2 -->
                            <tr>
                                <th>2</th>
                                <td>Hart Hagerty</td>
                                <td>Desktop Support Technician</td>
                                <td>Purple</td>
                            </tr>
                            <!-- row 3 -->
                            <tr>
                                <th>3</th>
                                <td>Brice Swyre</td>
                                <td>Tax Accountant</td>
                                <td>Red</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--/table Card-->
    </div>
</div>

@endsection