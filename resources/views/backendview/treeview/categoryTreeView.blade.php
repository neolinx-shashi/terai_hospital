@extends('backendlayout.master')
@extends('backendlayout.header')
@extends('backendlayout.leftmenu')
@extends('backendlayout.footer')
@section('userscontent')
    @extends('backendlayout.flashmessagecollection')
    <div class="search-breadcrumb-only">
        <div class="row">
            <div class="col-lg-12">
                <ol class="breadcrumb">
                    <li><a href="{{url('dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                    <li><a href="{{URL('category-tree-view')}}">Manage Test Setup</a></li>

                </ol>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="panel panel-primary categories-add-section">
            <div class="panel-heading">Manage Category TreeView</div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-8">
                        <h3>Category List</h3>
                        <ul class="nav nav-tabs" role="tablist">
                            @foreach($categories as $key => $category)
                                <li role="presentation" class="@if ($key == 0) {{ 'active' }}  @endif"><a
                                            href="#{{ $category->title }}" aria-controls="home" role="tab"
                                            data-toggle="tab"
                                            onclick="getSubCategory({{ $category->id }})">{{ $category->title }}</a>
                                </li>
                            @endforeach
                            <li class="pull-right">
                                <buton class="btn btn-info" title="Edit Categories" data-toggle="modal"
                                       data-target="#editCategoryModal"><span class="glyphicon glyphicon-pencil"></span>
                                </buton>
                                <button class="btn btn-info" data-toggle="modal" data-target="#categoryModal"
                                        title="Add New Category"><span class="glyphicon glyphicon-plus"></span></button>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <br>
                            <button class="btn btn-primary" id="newsubcat" title="Add New Sub Category"
                                    data-toggle="modal" data-target="#subcategoryModal"><span
                                        class="glyphicon glyphicon-plus-sign"></span> Add New Sub-category
                            </button>
                            @foreach($categories as $key => $category)
                                <div role="tabpanel" class="tab-pane fade in @if ($key == 0) {{ 'active' }}  @endif"
                                     id="{{ $category->title }}">
                                    <br>
                                    loading...
                                </div>
                            @endforeach
                        </div>

                        <br><br>

                    <!--
                        
                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="false">
                            @foreach($categories as $key => $category)
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="heading{{ $key }}">
                                    <h4 class="panel-title">
                                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $key }}" aria-expanded="true" aria-controls="collapse{{ $key }}">
                                            {{ $category->title }}
                                </a>
                                <span class="glyphicon glyphicon-pencil pull-right"></span>
                            </h4>

                        </div>
                        <div id="collapse{{ $key }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{ $key }}">
                                    <div class="panel-body">
                                        sda
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            </div>

-->

                    <!--
                        <ul id="tree1">
                            @foreach($categories as $category)
                        <li>
{{ $category->title }}
                        @if(count($category->childs))
                            @include('backendview.treeview.manageChild',['childs' => $category->childs])
                        @endif
                                </li>
@endforeach
                            </ul>
-->

                    </div>


                    <!-- Category Modal -->
                    <div class="modal fade" id="categoryModal" tabindex="-1" role="dialog"
                         aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                                aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Add New Category</h4>
                                </div>
                                <form role="form" method="POST" action="{{ route('add.category') }}">
                                    <div class="modal-body">


                                        {{ csrf_field() }}

                                        <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                                            <label for="title">Title</label>

                                            <input type="text" class="form-control" id="title" name="title"
                                                   value="{{ old('title') }}" placeholder="Enter Title">
                                            <span class="text-danger">{{ $errors->first('title') }}</span>
                                        </div>

                                    <!--
                            <div class="form-group {{ $errors->has('parent_id') ? 'has-error' : '' }}">
                                <label for="parent_id">Category</label>

                                <select name="parent_id" id="category" class="form-control">
                                    <option value="">Select a Category</option>
                                    @foreach($allCategories as $allCategory)
                                        <option value={{ $allCategory->id }}>{{ $allCategory->title }}</option>
                                    @endforeach
                                            </select>
                                            <span class="text-danger">{{ $errors->first('parent_id') }}</span>
                            </div>
                            -->

                                        <div id="price" style="display: none"
                                             class="form-group {{ $errors->has('price') ? 'has-error' : '' }}">
                                            <label for="price">Price</label>

                                            <input type="text" class="form-control" id="price" name="price"
                                                   placeholder="Enter Price">
                                            <span class="text-danger">{{ $errors->first('price') }}</span>
                                        </div>


                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close
                                        </button>
                                        <button class="btn btn-primary btn-flat test-add"><i
                                                    class="fa fa-plus-circle"></i> Add
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Subcategory Modal -->
                    <div class="modal fade" id="subcategoryModal" tabindex="-1" role="dialog"
                         aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                                aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Add New Sub-category</h4>
                                </div>
                                <form id="subcat-form" action="{{ route('add.subcategory') }}" method="post">
                                    <div class="modal-body">

                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <label for="category">Category</label>
                                            <select class="form-control" id="subcat_category" name="category">
                                                <option value="0">Select a Category</option>
                                                @foreach($categories as $allCategory)
                                                    <option value={{ $allCategory->id }}>{{ $allCategory->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="subcategory-title">Title</label>
                                            <input type="text" name="subcat_title" id="subcat_title" placeholder="Title"
                                                   class="form-control"/>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close
                                        </button>
                                        <button class="btn btn-primary btn-flat test-add"><i
                                                    class="fa fa-plus-circle"></i> Add
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>


                    <!-- edit categories -->
                    <div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog"
                         aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                                aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Edit Categories</h4>
                                </div>
                                <form id="cat-edit-form" action="{{ url('/edit-category') }}" method="post">
                                    {{ csrf_field() }}
                                    <div class="modal-body">
                                        @foreach($categories as $key => $category)
                                            <div class="col-md-12">
                                                <div class="form-group col-md-8">
                                                    <input name="{{ $category->id }}" type="text"
                                                           value="{{ $category->title }}" class="form-control"/>
                                                </div>
                                                <div class="com-md-1">
                                                    <button class="btn btn-danger" title="Delete Department"
                                                            onclick="deleteCat({{ $category->id }})"><span
                                                                class="glyphicon glyphicon-trash"></span></button>
                                                </div>
                                            </div>
                                        @endforeach
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close
                                        </button>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>


                    <!---------------------------------------------------->
                    <?php /*
                    <div class="col-md-4">
                        
                        <h3>Add New Category</h3>


                        <form role="form" method="POST"
                              action="{{ route('add.category') }}">

                            {{ csrf_field() }}

                            <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                                <label for="title">Title</label>

                                <input type="text" class="form-control" id="title" name="title"
                                       value="{{ old('title') }}" placeholder="Enter Title">
                                <span class="text-danger">{{ $errors->first('title') }}</span>
                            </div>

                            <!--
                            <div class="form-group {{ $errors->has('parent_id') ? 'has-error' : '' }}">
                                <label for="parent_id">Category</label>

                                <select name="parent_id" id="category" class="form-control">
                                    <option value="">Select a Category</option>
                                    @foreach($allCategories as $allCategory)
                                        <option value={{ $allCategory->id }}>{{ $allCategory->title }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger">{{ $errors->first('parent_id') }}</span>
                            </div>
                            -->

                            <div id="price" style="display: none"
                                 class="form-group {{ $errors->has('price') ? 'has-error' : '' }}">
                                <label for="price">Price</label>

                                <input type="text" class="form-control" id="price" name="price"
                                       placeholder="Enter Price">
                                <span class="text-danger">{{ $errors->first('price') }}</span>
                            </div>


                            <div class="form-group">
                                <button class="btn btn-primary btn-flat test-add"><i class="fa fa-plus-circle"></i> Add</button>
                            </div>

                        </form>
                        
                        <h3>Add Sub Category</h3>
                        <form id="subcat-form" action="{{ route('add.subcategory') }}" method="post">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="category">Category</label>
                                <select class="form-control" id="subcat_category" name="category">
                                    <option value="0">Select a Category</option>
                                    @foreach($categories as $allCategory)
                                    <option value={{ $allCategory->id }}>{{ $allCategory->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="subcategory-title">Title</label>
                                <input type="text" name="subcat_title" id="subcat_title" placeholder="Title" class="form-control" />
                            </div>

                            <div class="form-group">
                                <button class="btn btn-primary btn-flat test-add"><i class="fa fa-plus-circle"></i> Add</button>
                            </div>
                        </form>
                    </div>
                        */ ?>
                    <div class="col-md-4">
                        <h3>Add Tests</h3>
                        <form action="{{ route('add.test') }}" method="post" id="test-form">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="category">Category</label>
                                <select name="category" class="form-control cat-test" onchange="catChange()">
                                    <option value="0">Select a Category</option>
                                    @foreach($categories as $allCategory)
                                        <option value={{ $allCategory->id }}>{{ $allCategory->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group subcat-test">
                                <label for="sub category">Sub Category</label>
                                <select name="subcategory" id="test_subcat" class="form-control" disabled>
                                    <option value="">Select Category to enable</option>
                                </select>
                            </div>

                            <div id="test-title" class="form-group">
                                <label for="test-title">Title</label>
                                <input type="text" name="test_title" id="test_title" placeholder="Title"
                                       class="form-control"/>
                            </div>

                            <div id="test-title" class="form-group">
                                <label for="test-price">Price</label>
                                <input type="text" name="price" id="test_price" placeholder="Price"
                                       class="form-control"/>
                            </div>

                            <div class="form-group">
                                <button class="btn btn-primary btn-flat test-add"><i class="fa fa-plus-circle"></i> Add
                                </button>
                            </div>
                        </form>
                    </div>
                </div>


            </div>
        </div>

    </section>

    {{--<script type="text/javascript">
            $('#parent_id').on('change', function () {
                var category = $(this).val();
                document.write(category);
                if ($(this).val() === "Neurology") {
                    $("#price").show()
                }
                else {
                    $("#price").hide()
                }
            });
        </script>--}}

    <script src="{{URL::asset('backendtheme/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#category').change(function () {
                var categoryId = $(this).val();
                $("#price").load(
                        {!! json_encode(url('/category-check/')) !!} +'/' + categoryId + '/0'
                );
                /*document.write(asmit);*/

                $("#price").show()

            });

            /*$('.cat-test').change(function () {
                var cat_id = $(this).val();
                var url = '{{ url("/manageSubcategory") }}/' + cat_id;
                                    $.get(url, function (res) {
                                        var content = '<label for="sub category">Sub Category</label><select name="subcategory" class="form-control"><option value="">Select a Sub Category</option>';
                                        $.each(res, function (ind, val) {
                                            content += '<option value="' + val.id + '">' + val.title + '</option>';
                                        });
                                        content += '</select>';
                                        $('.subcat-test').html(content);
                                    });
                                    });*/
        });

        function catChange(sid = 0) {
            var cat_id = $('.cat-test').val();
            var url = '{{ url("/manageSubcategory") }}/' + cat_id;
            $.get(url, function (res) {
                var content = '<label for="sub category">Sub Category</label><select name="subcategory" class="form-control" id="test_subcat"><option value="">Select a Sub Category</option>';
                $.each(res, function (ind, val) {
                    if (sid != 0 && sid == val.id) {
                        var select = 'selected';
                    } else {
                        select = '';
                    }
                    content += '<option value="' + val.id + '" ' + select + '>' + val.title + '</option>';
                });
                content += '</select>';
                $('.subcat-test').html(content);
            });
        }

        /*result = $("#price").val();
        document.write(result);*/

        //document.write(asmit);

        //$("#price").show()

        if ($("#price").val() == "child") {
            $("#price").show()
        }
        else {
            $("#price").show()
        }


        function getSubCategory(cid) {
            var url = '{{ url("/manageSubcategoryWithTests") }}/' + cid;
            $('.tab-pane').html('<br>loading...');
            $.get(url, function (res) {
                var content = '<br><div class="panel-group" id="accordion" role="tablist" aria-multiselectable="false">';
                $.each(res, function (ind, val) {
                    content += '<div class="panel panel-default clicked-panel"><div class="panel-heading" role="tab" id="heading' + val.id + '"><h4 class="panel-title"><a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse' + val.id + '" aria-expanded="true" aria-controls="collapse' + val.id + '" onclick="toggleSub(this)">' + val.title + '</a><span class="glyphicon glyphicon-pencil pull-right" onclick="getSubDetail(' + val.id + ')" data-toggle="modal" data-target="#subcategoryModal"></span></h4></div><div id="collapse' + val.id + '" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading' + val.id + '"><div class="panel-body"><ul class="list-group">';
                    $.each(val.test_list, function (i, v) {
                        content += '<li class="list-group-item">' + v.title + '<span class="glyphicon glyphicon-pencil pull-right" onclick="getTestDetail(' + v.id + ')"></span></li>';
                    });
                    content += '</ul></div></div></div>';
                });
                content += '</div>';
                $('.tab-pane').html(content);
            });

            /* select category in add new sub-category */
            $('select#subcat_category').val(cid);
        }

        function toggleSub(ptr) {
            $(ptr).parent().parent().parent().find('.panel-collapse').collapse('toggle');
        }

        function getTests(cls, sid) {
            var url = '{{ url("/manageTests") }}/' + sid;
            $.get(url, function (res) {
                var content = '<ul>';
                $.each(res, function (ind, val) {
                    content += '<li>' + val.title + '</li>';
                });
                content += '</ul>';
                $('.' + cls).html(content);
            });
        }

        function getTestDetail(tid) {
            var url = '{{ url("/getTestDetail") }}/' + tid;
            $.get(url, function (val) {
                var parent_id = val.parent_id;
                var title = val.title;
                var price = val.price;
                var category = val.pId;

                var action_url = '{{ url("/update-tests") }}';
                $('#test-form').attr('action', action_url);
                $('#test-form').prepend('<input name="id" type="hidden" value="' + tid + '">');
                $('.test-add').text('Update');

                $('.cat-test').val(category);
                $('#test_title').val(title);
                $('#test_price').val(price);
                catChange(parent_id);
            });
        }

        function getSubDetail(sid) {
            var url = '{{ url("/getSubDetail") }}/' + sid;
            $.get(url, function (res) {
                var parent_id = res.parent_id;
                var title = res.title;

                $('#subcat_title').val(title);
                $('#subcat_category').val(parent_id);

                var action_url = '{{ url("/update-subcategory") }}';
                $('#subcat-form').attr('action', action_url);
                $('#subcat-form').prepend('<input name="id" type="hidden" value="' + sid + '">');
                $('#subcat-add').val('Update');
            });
        }

        $(function () {
            var cid = '{{ $categories[0]->id }}';
            getSubCategory(cid);

            $('#newsubcat').click(function () {
                $('input#subcat_title').val('');
            });
        });

        function deleteCat(id) {
            url = "{{ url('/delete-category') }}/" + id;
            window.location = url;
        }
    </script>

@endsection