@extends('admin.layouts.app')
@section('content')
<div class="flex flex-wrap">


    <div class="w-full md:w-1/2 xl:w-full p-3">
        <!--Metric Card-->
        <div class="bg-white border rounded shadow p-2">
            <div class="flex flex-row items-center">
                <div class="flex-shrink pr-4">
                    <div class="rounded p-3 bg-indigo-600"><i class="fas fa-tasks fa-2x fa-fw fa-inverse"></i></div>
                </div>
                <div class="flex-1 text-right md:text-center">
                    <h5 class="font-bold uppercase text-gray-500">To Do List</h5>
                    <h3 class="font-bold text-3xl">7 tasks</h3>
                </div>
            </div>
        </div>
        <!--/Metric Card-->
    </div>

</div>

<!--Divider-->
<hr class="border-b-2 border-gray-400 my-8 mx-4">

<div class="flex flex-row flex-wrap flex-grow mt-2">



    <div class="w-full p-3">
        <!--Table Card-->
        <div class="bg-white border rounded shadow">
            <div class="border-b p-3">
                <h5 class="font-bold uppercase text-gray-600">Table</h5>
            </div>
            <div class="p-5">
                <table class="w-full p-5 text-gray-700 table-auto">
                    <thead>
                        <tr>
                            <th class="text-left text-blue-900">Name</th>
                            <th class="text-left text-blue-900">Side</th>
                            <th class="text-left text-blue-900">Role</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>Obi Wan Kenobi</td>
                            <td>Light</td>
                            <td>Jedi</td>
                        </tr>
                        <tr>
                            <td>Greedo</td>
                            <td>South</td>
                            <td>Scumbag</td>
                        </tr>
                        <tr>
                            <td>Darth Vader</td>
                            <td>Dark</td>
                            <td>Sith</td>
                        </tr>
                    </tbody>
                </table>

                <p class="py-2"><a href="#">See More issues...</a></p>

            </div>
        </div>
        <!--/table Card-->
    </div>


</div>

@endsection