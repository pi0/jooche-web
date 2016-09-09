@extends('layouts.dashboard')

@section('title')
    Topics
@endsection

@section('body')
    <table class="table table-responsive">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Actions</th>
        </tr>
        <tr v-for="item in topics">
            <td>
                <label class="">
                    <img class="img-responsive" v-bind:src="item.image" style="max-width: 100px;display: inline">
                    <input type="file" @change="save(item,this)" style="display: none" id="@{{'img_'+item._id}}">
                </label>
                <span class="label label-info">@{{ item._id }}</span>
            </td>
            <td>
                <input v-model="item.name" @change="save(item)" class="form-control">
            </td>
            <td>
                <span class="btn btn-sm btn-danger" @click='remove(item._id)'>x</span>
            </td>
        </tr>
    </table>
    <a class="btn btn-success" @click='add'>New Item</a>
@endsection

@push('scripts')

<script>

    var url = '/dashboard/topics';
    var app = new Vue({

        el: 'body',
        data: {
            topics: [],
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
                    this.topics = r.json();
                });
            },
            save: function (item) {
                var _this=this;
                var post = function () {
                    _this.$http.post(url + '/' + item._id, item).then(function (r) {
                        _this.reload();
                        console.log(r);
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