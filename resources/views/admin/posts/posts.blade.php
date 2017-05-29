@extends('admin.layout')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-lg-6 offset-xs-3 offset-sm-3 offset-lg-3">
                <a href="/admin/posts/create" class="link-btn">Add Post</a>
                <a href="/admin/posts/deleted-posts" class="link-btn">Deleted posts</a>
                <a href="/admin/categories" class="link-btn">Categories</a>
                <a href="/admin/categories/create" class="link-btn">Add Category</a>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 offset-xs-3 offset-sm-2 offset-md-2 offset-lg-3">
                <form class="backend-form" method="post" action="/admin/posts/action">
                    {{ csrf_field() }}
                    <table class="table table-sm">
                        <thead class="thead-default">
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th  class="hidden-xs-down">Author</th>
                            <th>Category</th>
                            <th class="hidden-xs-down">Tags</th>
                            <th class="hidden-md-down">Date / Time</th>
                            <th>Edit</th>
                            <th>View</th>
                            <th>
                                <button type="button" id="check-all"><img class="glyph-small" alt="check-all-items"
                                                                          src="check.png"/></button>
                            </th>
                        </tr>
                        @each('admin.content.content-table',$posts,'single')
                    </table>
                    <table>
                        <?php if($trashed === 0){ ?>
                        <tr><th>Trash</th><th>Show</th><th>Hide</th></tr>
                        <tr>
                            <td><p><button type="submit" name="trash-selected" id="trash-selected"><img class="glyph-small" alt="trash-selected" src="<?= 'trash-post.png'?>"/></button></p></td>
                            <td><p><button type="submit" name="approve-selected" id="approve-selected"><img class="glyph-small" alt="approve-selected-for-front-end-view" src="<?= 'show.png'?>"/></button></p></td>
                            <td><p><button type="submit" name="hide-selected" id="hide-selected"><img class="glyph-small" alt="hide-selected-from-front-end-view" src="<?= 'hide.png'?>"/></button></p></td>
                        </tr>
                        <?php } else if($trashed === 1){ ?>
                        <th>Restore</th><th>Remove</th></tr>
                        <tr>
                            <td><p><button type="submit" name="restore-selected" id="restore-selected"><img class="glyph-small" alt="restore-selected-from-trash" src="<?= 'add-post.png'?>"/></button></p></td>
                            <td><p><button type="submit" name="delete-selected" id="delete-selected"><img class="glyph-small" alt="delete-selected-from-trash" src="<?= 'delete-post.png'?>"/></button></p></td>
                        </tr>
                        <?php } ?>
                    </table>
                </form>
            </div>
        </div>
    </div>
@stop