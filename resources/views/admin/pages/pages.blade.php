@extends('admin.layout')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-lg-6 offset-xs-3 offset-sm-3 offset-lg-3">
                <div class="center button-block">
                    <a href="/admin/posts/create" class="btn btn-primary btn-sm visible-md-block">Add Page</a>
                    <a href="/admin/posts/deleted-posts" class="btn btn-primary visible-md-block">Deleted pages</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 offset-xs-3 offset-sm-3 offset-md-2 offset-lg-3">
                <div class="center">
                    <form class="backend-form" method="post" action="/admin/pages/action">
                        {{ csrf_field() }}
                        <table class="table table-sm table-striped">
                            <thead class="thead-default">
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th class="hidden-xs-down">Author</th>
                                <th class="hidden-md-down">Date / Time</th>
                                <th>Edit</th>
                                <th>Status</th>
                                <th>Del</th>
                                <th>
                                    <button type="button" id="check-all"><img class="glyph-small" alt="check-all-items"
                                                                              src="check.png"/></button>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($pages as $single)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td class="td-title"><p><a href="{{route($single->table.'.show',$single->id())}}">{{ $single->title }}</a></p></td>
                                    <td class="hidden-xs-down"><p>{{ $single->user['first_name']}}</p></td>
                                    <td class="hidden-md-down"><p>{{ $single->created_at }}</p></td>
                                    @include('admin.partials.single-action')
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @include('admin.partials.actions')
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

