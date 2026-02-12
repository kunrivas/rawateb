@extends('layouts.index')
@section('title')
    كشف الراتب الجماعي
@endsection
@section('content-title')
    <h1> كشف الراتب الجماعي
    </h1>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">كشف راتب</a></li>
    <li class="breadcrumb-item"><a href="#">جماعي</a></li>
@endsection

@section('contents')
    <div class="row">
        <div class="col">

            <div class="card shade  mb-3">
                <div class="card-header">
                    <h3>اختيارات</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            {{-- the form  action post of select adm in view --}}
                            <form class="row" method="POST" {{-- route post method with param id_megration --}}
                                action="{{ route('salary-global-view-post', $current_megration->ID_MEGRATION) }}">
                                <div class="col-2  text-center">الادارة</div>
                                <select class="col-5 " name="adms_select">
                                    @foreach ($adms as $key => $value)
                                        <option value="{{ $value->ADM }}"
                                            @if ($adms_select == $value->ADM) selected @endif>
                                            {{ $value->LIBTABA }}</span>
                                    @endforeach
                                </select>
                                <div class="col">
                                    {{-- we can remplace it by @csrf after th <form> directly --}}
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <button type="submit" class="btn btn-info">عرض</button>
                                </div>

                            </form>
                        </div>
                        <div class="col">
                            <div class="row">
                                <div class="col"></div>
                                <div class="col d-flex">

                                    {{-- the form  action post of print btn 
                                        send 2 params adms_select and id_megration --}}
                                    <form method="POST" class="mx-2" target="_blank"
                                        action="{{ route('salary-global-print') }}">
                                        @csrf
                                        <input type="hidden" name="adms_select" value="{{ $adms_select }}">
                                        <input type="hidden" name="ID_MEGRATION"
                                            value="{{ $current_megration->ID_MEGRATION }}">
                                        <button type="submit" class="btn outlined  btn-primary">طباعة</button>
                                    </form>

                                    <form method="POST" target="_blank" action="{{ route('salary-single-global-print') }}">
                                        @csrf
                                        <input type="hidden" name="adms_select" value="{{ $adms_select }}">
                                        <input type="hidden" name="ID_MEGRATION"
                                            value="{{ $current_megration->ID_MEGRATION }}">
                                        <button type="submit" class="btn outlined btn-warning"> طباعة فردية جماعية</button>
                                    </form>
                                </div>
                            </div>


                        </div>
                    </div>

                </div>
            </div>

            <div class="card shade ">
                <div class="card-header pagination">

                </div>
                <div class="card-body">
                    {{-- using table responsive to affiche all the datas (big table) --}}
                    <table class="table table-responsive  table-bill-global ">
                        <thead>
                            <tr>
                                <th>الرمز</th>
                                <th>الادارة</th>
                                <th> اللقب الإسم </th>
                                <th> الحالة العائلية </th>
                                <th>الصنف الدرجة </th>
                                <th>أيام العمل </th>
                                <th>
                                    <div>الأجر القاعدي </div>
                                    <div>م.الخبرة المهنية </div>
                                    <div>م.المنصب العالي </div>
                                </th>
                                <th>
                                    <div>م.خ البداغوجية</div>
                                    <div>م.ت. المالي والمادي</div>
                                </th>
                                <th>
                                    <div>م.جزافية</div>
                                    <div>م.أ.المشتركة</div>
                                    <div>م.ن.الادارية</div>

                                </th>
                                <th>
                                    <div>م.التوثيق </div>
                                    <div>م.التأهيل</div>
                                    <div>م.ذ.م.بيداغوجية</div>
                                </th>
                                <th>
                                    <div>م.السكن</div>
                                    <div>م.المنطقة</div>
                                    <div>م.المنصب</div>
                                </th>
                                <th>
                                    <div>ت.الزام.ش.طبي</div>
                                    <div>ت دعم.ن.ش.طبي </div>
                                    <div>منحة العدوى</div>
                                </th>
                                <th>
                                    <div>الاجر الوحيد</div>
                                    <div>المنح العائلية</div>
                                    <div>اطفال 10س</div>
                                </th>
                                <th>الخام</th>
                                <th>
                                    <div>الخاضع.ض</div>
                                    <div>إ ض.إجتماعي</div>
                                </th>
                                <th>
                                    <div>إق.الضريبة</div>
                                    <div>اق.التعاضدية</div>
                                </th>
                                <th>
                                    <div>الخدمات1</div>
                                    <div>الخدمات2</div>
                                    <div>حدمات اجتماعية</div>
                                </th>
                                <th>
                                    <div>اقتطاع الغياب</div>
                                    <div>اقتطاع الاضراب</div>
                                    <div>اقتطاع المعارضة</div>
                                </th>

                                <th> الصافي </th>
                            </tr>
                        </thead>
                        <tbody>

                            @if (!empty($data))
                                {{-- fetch data in key value --}}
                                @foreach ($data as $key => $value)
                                    <tr>
                                        <td>{{ $value['matri'] }}</td>
                                        <td>{{ $value['ADM'] }}</td>
                                        <td>{{ $value['fullName'] }}</td>
                                        <td>{{ $value['SITFAM'] }}</td>
                                        <td>
                                            <div>{{ $value['CATEG'] }}</div>
                                            <div>{{ $value['ECH'] }}</div>
                                        </td>
                                        <td>{{ $value['NBRTRAV'] }}</td>
                                        <td>
                                            {{-- if 'V001' is exisst in $data key(ind of grant_info) 
                                             affiche his value (grant->montant)
                                             else affiche "/"   --}}
                                            <div>
                                                {{ array_key_exists('V001', $value) ? $value['V001'] : '/' }}
                                            </div>
                                            <div>
                                                {{ array_key_exists('V101', $value) ? $value['V101'] : '/' }}
                                            </div>
                                            <div>
                                                {{ array_key_exists('V105', $value) ? $value['V105'] : '/' }}
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                {{ array_key_exists('V103', $value) ? $value['V103'] : '/' }}
                                            </div>
                                            <div>
                                                {{ array_key_exists('V241', $value) ? $value['V241'] : '/' }}
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                {{ array_key_exists('V208', $value) ? $value['V208'] : '/' }}
                                            </div>
                                            <div>
                                                {{ array_key_exists('V270', $value) ? $value['V270'] : '/' }}
                                            </div>
                                            <div>
                                                {{ array_key_exists('V273', $value) ? $value['V273'] : '/' }}
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                {{ array_key_exists('V290', $value) ? $value['V290'] : '/' }}
                                            </div>
                                            <div>
                                                {{ array_key_exists('V246', $value) ? $value['V246'] : '/' }}
                                            </div>
                                            <div>
                                                {{ array_key_exists('V280', $value) ? $value['V280'] : '/' }}
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                {{ array_key_exists('V211', $value) ? $value['V211'] : '/' }}
                                            </div>
                                            <div>
                                                {{ array_key_exists('V255', $value) ? $value['V225'] : '/' }}
                                            </div>
                                            <div>
                                                {{ array_key_exists('V260', $value) ? $value['V260'] : '/' }}
                                            </div>
                                        </td>

                                        <td>
                                            <div>
                                                {{ array_key_exists('V212', $value) ? $value['V212'] : '/' }}
                                            </div>
                                            <div>
                                                {{ array_key_exists('V213', $value) ? $value['V213'] : '/' }}
                                            </div>
                                            <div>
                                                {{ array_key_exists('V214', $value) ? $value['V214'] : '/' }}
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                {{ array_key_exists('V401', $value) ? $value['V401'] : '/' }}
                                            </div>
                                            <div>
                                                {{ array_key_exists('V990', $value) ? $value['V990'] : '/' }}
                                            </div>
                                            <div>
                                                {{ array_key_exists('V991', $value) ? $value['V991'] : '/' }}
                                            </div>
                                        </td>
                                        <td>{{ $value['TOTGAIN'] }}</td>
                                        <td>
                                            <div>
                                                {{ array_key_exists('BRUTSS', $value) ? $value['BRUTSS'] : '/' }}
                                            </div>
                                            <div>
                                                {{ array_key_exists('RETSS', $value) ? $value['RETSS'] : '/' }}
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                {{ array_key_exists('V980', $value) ? $value['V980'] : '/' }}
                                            </div>
                                            <div>
                                                {{ array_key_exists('V660', $value) ? $value['V660'] : '/' }}
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                {{ array_key_exists('V397', $value) ? $value['V397'] : '/' }}
                                            </div>
                                            <div>
                                                {{ array_key_exists('V398', $value) ? $value['V398'] : '/' }}
                                            </div>
                                            <div>
                                                {{ array_key_exists('V399', $value) ? $value['V399'] : '/' }}
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                {{ array_key_exists('V301', $value) ? $value['V301'] : '/' }}
                                            </div>
                                            <div>
                                                {{ array_key_exists('V302', $value) ? $value['V302'] : '/' }}
                                            </div>
                                            <div>
                                                {{ array_key_exists('V303', $value) ? $value['V303'] : '/' }}
                                            </div>
                                        </td>
                                        <td>{{ array_key_exists('V999', $value) ? $value['V999'] : '/' }}
                                        </td>


                                    </tr>
                                @endforeach
                            @else
                                <tr>

                                    <td colspan="10">There are no data.</td>

                                </tr>
                            @endif
                        </tbody>

                    </table>

                </div>
            </div>
        </div>
    </div>
@endsection
