@extends('layouts.dashboard')

@section('title')
    Interests
@endsection

@section('body')
    <table class="table table-responsive">
        <tr>
            <th>ID</th>
            <th>Name</th>
        </tr>
        @foreach($interests as $interest)
            <tr>
                <td>{{$interest->id}}</td>
                <td>{{$interest->name}}</td>
            </tr>
        @endforeach
    </table>
@endsection

@push('scripts')

<script>
    const app = new Vue({
        el: 'body'
    });

</script>

@endpush