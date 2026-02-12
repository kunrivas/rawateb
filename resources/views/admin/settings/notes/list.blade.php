@extends('layouts.admin')
@section('title')
    تسير الاعلانات
@endsection
@section('content-title')
    <h1>  تسير الاعلانات </h1>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">الاعلانات </a></li>
    <li class="breadcrumb-item"><a href="#">  تسير الاعلانات</a></li>
@endsection



@section('contents')
    <div class="row mb-2">
        <div class="col"></div>
        <div class="col-2">
            <a class="btn btn-success " href="{{ route('admin-settings-note-create') }}">إضافة اعلان جديد</a>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">الترتيب</th>
                        <th scope="col">المحتوى</th>
                        <th scope="col">العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($notes as $note)
                        <tr>


                            <td>
                            {{$loop->index+1}}
                            </td>
                            <td>
                                {{ $note->text }}

                            </td>

                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-outline-success btn-sm"
                                      >العمليات</button>
                                    <button type="button" class="btn btn-outline-success btn-sm dropdown-toggle"
                                        data-toggle="dropdown" aria-expanded="false"
                                     >
                                        <span class="sr-only"> </span>
                                    </button>
                                    <div class="dropdown-menu" role="menu" style="">

                                        <form action="{{ route('admin-settings-note-delete') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="id"
                                                value="{{ $note->id }}">
                                            <button type="submit" class="dropdown-item text-danger font-weight-bold"
                                                href="#">حذف</button>
                                        </form>
                                    </div>
                                </div>
                            </td>

                        </tr>
                    @endforeach


                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('js')
    <script defer>
        $(".run").click(function(evt) {
            let _token = $('meta[name="csrf-token"]').attr('content');
            megration = $(this).attr("megration");
            data = [];
            data["ID_MEGRATION"] = megration;
            data["_token"] = _token;
            console.log(data);

            $.ajax({
                type: 'POST',
                url: "{{ route('admin-megration-salary-run') }}",
                data: {
                    ID_MEGRATION: megration,
                    _token: _token
                },
            });
            $(this).attr('disabled', 'disabled');
            setTimeout(() => {
                location.reload();
            }, 5000);

        });
    </script>
@endsection
