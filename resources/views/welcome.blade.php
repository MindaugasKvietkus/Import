<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <script src="{{ asset('js/jQuery.js') }}"></script>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

        <!-- Optional theme -->
        <link rel="stylesheet" href="{{ asset('css/bootstrap-theme.min.css') }}">

        <!-- Latest compiled and minified JavaScript -->
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

        <style>
        </style>

    </head>
    <body>

    <div class="container-fluid col-lg-12" style="padding-top: 100px;">
        <div class="col-lg-6 col-lg-offset-3">
            <form action="{{ url('/import') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Įkelti .csv failą" readonly>
                    <label class="input-group-btn">
                        <span class="btn btn-primary">
                        Upload&hellip; <input type="file" style="display: none;" name="file">
                        </span>
                    </label>
                </div>
            </form>
            @if (session('success'))
                <div class="alert alert-success text-center">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session('success') }}
                </div>
            @endif
            @if (session('empty'))
                <div class="alert alert-danger text-center">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session('empty') }}
                </div>
            @endif
        </div>
    </div>

    <div class="container-fluid col-lg-12" style="padding-top: 50px">
        <div class="col-lg-8 col-lg-offset-2 text-center">
            @foreach($cells as $cell)
                @if($cell->created_at === $last_record->created_at)
                    <div class="col-lg-12" id="cell_{{ $cell->id }}" style="padding: 5px; border-bottom: 1px solid black;">
                        <form action="{{ url('/update/'.$cell->id) }}" method="post" id="formDeleteProduct">
                            {{ csrf_field() }}
                            <div class="col-lg-2">
                                @if(empty($cell->cell_first))
                                    <div id="cell_first_{{ $cell->id }}" onclick="document.getElementById('cell_first({{ $cell->id }})').style.display='inline';
                                            $('#cell_first_{{ $cell->id }}').hide();" style="display: block">
                                        &nbsp;
                                    </div>
                                @else
                                    <p id="cell_first_{{ $cell->id }}" onclick="document.getElementById('cell_first({{ $cell->id }})').style.display='inline';
                                            $('#cell_first_{{ $cell->id }}').hide();">
                                        {{ $cell->cell_first }}
                                    </p>
                                @endif
                                <input id="cell_first({{ $cell->id }})" style="display:none"
                                       class="text-center" type="text" name="cell_first" value="{{ $cell->cell_first }}">
                            </div>
                            <div class="col-lg-2">
                                @if(empty($cell->cell_second))
                                    <p id="cell_second_{{ $cell->id }}" onclick="document.getElementById('cell_second({{ $cell->id }})').style.display='inline';
                                            $('#cell_second_{{ $cell->id }}').hide();">
                                        &nbsp;
                                    </p>
                                @else
                                    <p id="cell_second_{{ $cell->id }}" onclick="document.getElementById('cell_second({{ $cell->id }})').style.display='inline';
                                            $('#cell_second_{{ $cell->id }}').hide();">
                                        {{ $cell->cell_second }}
                                    </p>
                                @endif
                                <input id="cell_second({{ $cell->id }})" style="display:none"
                                       class="text-center" type="text" name="cell_second" value="{{ $cell->cell_second }}">
                            </div>
                            <div class="col-lg-2">
                                @if(empty($cell->cell_third))
                                    <p id="cell_third_{{ $cell->id }}" onclick="document.getElementById('cell_third({{ $cell->id }})').style.display='inline';
                                            $('#cell_third_{{ $cell->id }}').hide();">
                                        &nbsp;
                                    </p>
                                @else
                                    <p id="cell_third_{{ $cell->id }}" onclick="document.getElementById('cell_third({{ $cell->id }})').style.display='inline';
                                            $('#cell_third_{{ $cell->id }}').hide();">
                                        {{ $cell->cell_third }}
                                    </p>
                                @endif
                                <input id="cell_third({{ $cell->id }})" style="display:none"
                                       class="text-center" type="text" name="cell_third" value="{{ $cell->cell_third }}">
                            </div>
                            <div class="col-lg-2">
                                @if(empty($cell->cell_fourth))
                                    <p id="cell_fourth_{{ $cell->id }}" onclick="document.getElementById('cell_fourth({{ $cell->id }})').style.display='inline';
                                            $('#cell_fourth_{{ $cell->id }}').hide();">
                                        &nbsp;
                                    </p>
                                @else
                                    <p id="cell_fourth_{{ $cell->id }}" onclick="document.getElementById('cell_fourth({{ $cell->id }})').style.display='inline';
                                            $('#cell_fourth_{{ $cell->id }}').hide();">
                                        {{ $cell->cell_fourth }}
                                    </p>
                                @endif
                                <input id="cell_fourth({{ $cell->id }})" style="display:none"
                                       class="text-center" type="text" name="cell_fourth" value="{{ $cell->cell_fourth }}">
                            </div>
                            <div class="col-lg-4">
                                <button type="submit" class="btn btn-danger text-danger deleteProduct_{{ $cell->id }}" id="btnDeleteProduct" data-id={{ $cell->id }}>
                                    Šalinti
                                </button>
                            </div>
                        </form>
                    </div>
                @else

                @endif
                <script>
                    $('.deleteProduct_{{ $cell->id }}').on('click', function(e) {

                        var inputData = $('#formDeleteProduct').serialize();
                        var dataId = $(this).attr('data-id');

                        $.ajax({
                            url: '{{ url('/delete') }}' + '/' + dataId,
                            type: 'DELETE',
                            data: inputData,
                            success: function() {
                                $('#cell_{{ $cell->id }}').slideUp(300, function () {});
                            }
                        });
                        return false;
                    });
                </script>
            @endforeach
        </div>
    </div>

    <script>
        $("input[name='file']").change(function() {
            this.form.submit();
        });
    </script>
    </body>
</html>
