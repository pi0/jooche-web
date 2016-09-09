@extends('layouts.dashboard')

@section('title')
    Offers
@endsection

@section('body')
    <table class="table table-responsive">
        <tr>
            <th></th>
            <th>Name</th>
            <th>Topic</th>
            <th>Actions</th>
        </tr>
        <tr v-for="item in items">
            <td>
                <label>
                    <img class="img-responsive" v-bind:src="item.image" style="max-width: 100px;display: inline">
                    <input type="file" @change="save(item,this)" style="display: none" id="@{{'img_'+item._id}}">
                </label>
                <span class="label label-info">@{{ item._id }}</span>
            </td>
            <td>
                <input v-model="item.name" @change="save(item)" class="form-control">
            </td>
            <td>
                <select v-model="item.topic_id" @change="save(item)" class="form-control">
                @foreach(\App\Topic::all() as $topic)
                    <option value="{{$topic->id}}">{{$topic->name}}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <span class="btn btn-sm btn-danger" @click='remove(item._id)'>x</span>
            </td>
        </tr>
    </table>
    <a class="btn btn-success" @click='add'>New Offer</a>
@endsection


@push('scripts')

<script>

    var url = '/dashboard/offers';
    var app = new Vue({

        el: 'body',
        data: {
            items: [],
        },
        methods: {
            add: function () {
                this.$http.put(url).then(function (r) {
                    this.reload();
                });
            },
            remove: function (id) {
                this.$http.delete(url + '/' + id).then(function (r) {
                    this.reload();
                });
            },
            reload: function () {
                this.$http.get(url).then(function (r) {
                    this.items = r.json();
                });
            },
            save: function (item) {
                var _this = this;
                var post = function () {
                    _this.$http.post(url + '/' + item._id, item).then(function (r) {
                        _this.reload();
                    });
                };

                img = $('#img_' + item._id)[0].files[0];
                if (img != null) {
                    var reader = new FileReader();
                    reader.readAsDataURL(img);
                    reader.onload = function (e) {
                        item.image = e.target.result;
                        post();
                    };
                } else {
                    post();
                }

            }
        }


    });

    app.reload();

</script>

@endpush