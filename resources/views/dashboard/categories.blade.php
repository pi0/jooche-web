@extends('layouts.dashboard')

@section('title')
    Categories
@endsection

@section('body')
    <table class="table table-responsive">
        <tr>
            <th></th>
            <th>Name</th>
            <th>Topic</th>
            <th>Tags</th>
            <th>Actions</th>
        </tr>
        <tr v-for="item in categories">
            <td>
                <label>
                    <img class="img-responsive" v-bind:src="item.image" style="max-width: 100px;display: inline">
                    <input type="file" @change="save(item,this)" style="display: none" id="@{{'img_'+item._id}}">
                </label>
            </td>
            <td>
                <input v-model="item.name" @change="save(item)" class="form-control">
            </td>
            <td>
                <select v-model="item.topic" @change="save(item)" class="form-control">
                <option>موبایل و تبلت</option>
                <option>لپ‌تاپ، کامپیوتر، اداری</option>
                <option>صوتی و تصویری</option>
                <option>لوازم خانگی</option>
                <option>زیبایی و بهداشت</option>
                <option>سلامت و پزشکی</option>
                <option>فرهنگی هنری</option>
                <option>پوشاک، کیف و کفش</option>
                <option>کودک و نوزاد</option>
                <option>ابزار و ساختمان</option>
                <option>خودرو و سفر</option>
                <option>سوپر مارکت</option>
                </select>
            </td>
            <td>
                <input data-role="tagsinput2" v-model="item.tags" @change="save(item)" class="form-control" >
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

    var url = '/dashboard/categories';
    var app = new Vue({

        el: 'body',
        data: {
            categories: [],
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
                    this.categories = r.json();
                });
            },
            save: function (item) {
                var _this=this;
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