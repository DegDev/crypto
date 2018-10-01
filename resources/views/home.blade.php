@extends('layouts.app')

@section('content')

<div class="container">


    <h1> Crypto Curriencies </h1>

    <hr>

    <input id="searchInput" value="Type To Filter" type="search" class="mt-2">

    <table id="crypto" class="table table-striped mt-4">
        <thead class="thead-dark">
            <tr >
                <th scope="col" data-sort="string" class="w-25 j-clickable">name</th>
                <th scope="col" data-sort="float" class="w-25 j-clickable">Avg. Price (USD)</th>
                <th scope="col" id="24h" class="w-25 j-clickable" data-sort="float" data-sort-default="desc" data-sort-onload=yes> % Change(24h)</th>
            </tr>
        </thead>
        <tbody id="fbody">


            @foreach($currencies as $currencie)
            <tr class="table_row" id="{{$currencie->coin_id}}">
                <td class="name">{{$currencie->coin->name}}</td>
                <td class="avg-price">{{$currencie->avg_price}}</td>
                <td  class="change24h">{{$currencie->change24h}}%</td>
            </tr>
            @endforeach

        </tbody>
    </table>

</div>

@endsection