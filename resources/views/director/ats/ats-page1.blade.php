<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        * {
            font-family: "Arial" !important;
        }

        .background-image {
            position: absolute;
            background-image: url('/rawateb/public/ats/img/ATS_F1.png');
            background-repeat: no-repeat;
            background-size: 1200px 1620px;
            /*1275px 1755px*/
            background-position: left top;
            left: 0px;
            top: 0px;
            width: 1200px;
            height: 1620px;
            z-index: -1;
        }

        .pos-absolute {
            position: absolute;
        }

        .m-0 {
            margin: 0px;
        }

        .font22 {
            font-size: 22px;
        }

        .font28 {
            font-size: 28px;
        }

        .font32 {
            font-size: 32px;
        }

        .font96 {
            font-size: 96px;
        }

        .rigth {
            text-align: right;
        }

        .left {
            text-align: left;
        }

        .bold {
            font-weight: bold;
        }

        .border-1 {
            border: 2px solid black;
        }

        .editable {
            background-color: lightpink;
            /* border: 2px solid red; */
        }

        .editable:hover {
            border: 2px solid red;
        }

        .editable-control {
            font-size: medium;
            font-weight: bold;
            border: 2px solid red;
        }

        @media print {
            @page {
                size: auto;
                margin: 0.5cm 0.5cm 0.5cm 0.5cm;
            }

            @page :footer {
                display: none
            }

            @page :header {
                display: none
            }

            body {
                -webkit-print-color-adjust: exact;
            }

            .editable {
                background-color: unset;
                border: unset;
            }

            .editable:hover {
                border: unset;
            }
        }
    </style>
</head>

<body>
    <!--  -->
    <!--  -->

    <!-- خلفية  -->
     <div class="background-image">&nbsp;</div>

    <!-- الاسم و اللقب رب العمل -->
    <div style="left: 350px;top: 400px ;" class="editable pos-absolute m-0 font32 bold">{!! $bossName ?? '&nbsp;&nbsp;' !!}</div>

    <!-- رقم المنخرط -->
    <div style="left: 479px;top: 444px ;" class="editable pos-absolute m-0 font32 bold">{!! $bossId ?? '&nbsp;&nbsp;' !!}</div>

    <!-- الطبيعة الاجتماعية -->
    <div style="left: 480px;top: 488px ;" class="editable pos-absolute m-0 font28 bold">{!! $estabType ?? '&nbsp;&nbsp;' !!}</div>

    <!-- العنوان -->
    <div style="left: 400px;top: 522px ;" class="editable pos-absolute m-0 font28 bold">{!! $bossAddress ?? '&nbsp;&nbsp;' !!}</div>

    <!-- الأجير -->
    <div style="left: 472px;top: 654px ;" class="editable pos-absolute m-0 font28 bold">{!! $employeeName ?? '&nbsp;&nbsp;' !!}</div>

    <!-- رقم التسجيل -->
    <div style="left: 460px;top: 702px ;" class="editable pos-absolute m-0 font32 bold">{!! $employeeId ?? '&nbsp;&nbsp;' !!}</div>

    <!-- تاريخ الميلاد -->
    <div style="left: 970px;top: 740px ;" class="editable pos-absolute m-0 font28 bold">{!! $birthDate['d']['r'] ?? '&nbsp;&nbsp;' !!}
    </div>
    <div style="left: 934px;top: 740px ;" class="editable pos-absolute m-0 font28 bold">{!! $birthDate['d']['l'] ?? '&nbsp;&nbsp;' !!}
    </div>
    <div style="left: 897px;top: 740px ;" class="editable pos-absolute m-0 font28 bold">{!! $birthDate['m']['r'] ?? '&nbsp;&nbsp;' !!}
    </div>
    <div style="left: 862px;top: 740px ;" class="editable pos-absolute m-0 font28 bold">{!! $birthDate['m']['l'] ?? '&nbsp;&nbsp;' !!}
    </div>
    <div style="left: 826px;top: 740px ;" class="editable pos-absolute m-0 font28 bold">{!! $birthDate['y']['r'] ?? '&nbsp;&nbsp;' !!}
    </div>
    <div style="left: 791px;top: 740px ;" class="editable pos-absolute m-0 font28 bold">{!! $birthDate['y']['l'] ?? '&nbsp;&nbsp;' !!}
    </div>

    <!-- الولاية -->
    <div style="left: 463px;top: 748px ;" class="editable pos-absolute m-0 font28 bold">{!! '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' !!}</div>

    <!-- العنوان للأجير -->
    <div style="left: 463px;top: 785px ;" class="editable pos-absolute m-0 font28 bold">{!! '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'  !!}</div>

    <!-- المهنة -->
    <div style="left: 624px;top: 819px ;" class="editable pos-absolute m-0 font28 bold">{!! $employeeGrade ?? '&nbsp;&nbsp;' !!}</div>

    <!-- تاريخ التوظيف -->
    <div style="left: 660px;top: 941px ;" class="editable pos-absolute m-0 font28 bold">{!! $hiringDate['d']['r'] ?? '&nbsp;&nbsp;' !!}
    </div>
    <div style="left: 624px;top: 941px ;" class="editable pos-absolute m-0 font28 bold">{!! $hiringDate['d']['l'] ?? '&nbsp;&nbsp;' !!}
    </div>
    <div style="left: 587px;top: 941px ;" class="editable pos-absolute m-0 font28 bold">{!! $hiringDate['m']['r'] ?? '&nbsp;&nbsp;' !!}
    </div>
    <div style="left: 552px;top: 941px ;" class="editable pos-absolute m-0 font28 bold">{!! $hiringDate['m']['l'] ?? '&nbsp;&nbsp;' !!}
    </div>
    <div style="left: 516px;top: 941px ;" class="editable pos-absolute m-0 font28 bold">{!! $hiringDate['y']['r'] ?? '&nbsp;&nbsp;' !!}
    </div>
    <div style="left: 481px;top: 941px ;" class="editable pos-absolute m-0 font28 bold">{!! $hiringDate['y']['l'] ?? '&nbsp;&nbsp;' !!}
    </div>

    <!-- تاريخ اخر يوم عمل -->
    <div style="left: 660px;top: 973px ;" class="editable pos-absolute m-0 font28 bold">
        {!! $lastWorkDayDate['d']['r'] ?? '&nbsp;&nbsp;' !!}</div>
    <div style="left: 624px;top: 973px ;" class="editable pos-absolute m-0 font28 bold">
        {!! $lastWorkDayDate['d']['l'] ?? '&nbsp;&nbsp;' !!}</div>
    <div style="left: 587px;top: 973px ;" class="editable pos-absolute m-0 font28 bold">
        {!! $lastWorkDayDate['m']['r'] ?? '&nbsp;&nbsp;' !!}</div>
    <div style="left: 552px;top: 973px ;" class="editable pos-absolute m-0 font28 bold">
        {!! $lastWorkDayDate['m']['l'] ?? '&nbsp;&nbsp;' !!}</div>
    <div style="left: 516px;top: 973px ;" class="editable pos-absolute m-0 font28 bold">
        {!! $lastWorkDayDate['y']['r'] ?? '&nbsp;&nbsp;' !!}</div>
    <div style="left: 481px;top: 973px ;" class="editable pos-absolute m-0 font28 bold">
        {!! $lastWorkDayDate['y']['l'] ?? '&nbsp;&nbsp;' !!}</div>

    <!-- تاريخ استأناف العمل -->
    <div style="left: 660px;top: 1008px ;" class="editable pos-absolute m-0 font28 bold">
        {!! $commanceWorkDate['d']['r'] ?? '&nbsp;&nbsp;' !!}</div>
    <div style="left: 624px;top: 1008px ;" class="editable pos-absolute m-0 font28 bold">
        {!! $commanceWorkDate['d']['l'] ?? '&nbsp;&nbsp;' !!}</div>
    <div style="left: 587px;top: 1008px ;" class="editable pos-absolute m-0 font28 bold">
        {!! $commanceWorkDate['m']['r'] ?? '&nbsp;&nbsp;' !!}</div>
    <div style="left: 552px;top: 1008px ;" class="editable pos-absolute m-0 font28 bold">
        {!! $commanceWorkDate['m']['l'] ?? '&nbsp;&nbsp;' !!}</div>
    <div style="left: 516px;top: 1008px ;" class="editable pos-absolute m-0 font28 bold">
        {!! $commanceWorkDate['y']['r'] ?? '&nbsp;&nbsp;' !!}</div>
    <div style="left: 481px;top: 1008px ;" class="editable pos-absolute m-0 font28 bold">
        {!! $commanceWorkDate['y']['l'] ?? '&nbsp;&nbsp;' !!}</div>

    <!-- تاريخ لم يستأنف العمل -->
    <div style="left: 660px;top: 1045px ;" class="editable pos-absolute m-0 font28 bold">
        {!! $doesntcommanceWorkDate['d']['r'] ?? '&nbsp;&nbsp;' !!}</div>
    <div style="left: 624px;top: 1045px ;" class="editable pos-absolute m-0 font28 bold">
        {!! $doesntcommanceWorkDate['d']['l'] ?? '&nbsp;&nbsp;' !!}</div>
    <div style="left: 587px;top: 1045px ;" class="editable pos-absolute m-0 font28 bold">
        {!! $doesntcommanceWorkDate['m']['r'] ?? '&nbsp;&nbsp;' !!}</div>
    <div style="left: 552px;top: 1045px ;" class="editable pos-absolute m-0 font28 bold">
        {!! $doesntcommanceWorkDate['m']['l'] ?? '&nbsp;&nbsp;' !!}</div>
    <div style="left: 516px;top: 1045px ;" class="editable pos-absolute m-0 font28 bold">
        {!! $doesntcommanceWorkDate['y']['r'] ?? '&nbsp;&nbsp;' !!}</div>
    <div style="left: 481px;top: 1045px ;" class="editable pos-absolute m-0 font28 bold">
        {!! $doesntcommanceWorkDate['y']['l'] ?? '&nbsp;&nbsp;' !!}</div>







    @if ($forInformations)
        <!-- للإستعـــلامـــات -->
        <div style="left: 271px;top: 1300px ;transform: rotate(-25deg);" class="editable pos-absolute m-0 font96 bold ">
            للإستعــــــلامــــــات</div>
    @endif




    <script>
        //array selects all HTML elements with the class name "editable" and stores them in the variable mydiv.
        var mydiv = document.getElementsByClassName("editable");
       // loop to iterate over each element with the class "editable" in mydiv array
        for (var i = 0; i < mydiv.length; i++) {
            //var  old text stores the initial text content of the current element
            let oldtext = mydiv[i].innerText;
           // When an element is clicked, the provided function is executed.
            mydiv[i].addEventListener("click", function() {
                //It checks if the element does not already contain an input field.
                if (!this.getElementsByTagName("input")[0]) {
                  // The input field is pre-filled with the original text (oldtext).
                    this.innerHTML = '<input type="text" value="' + oldtext +
                        '" onkeyup="refreshdata(this,event);" onfocusout="losefocus(this)" class="editable-control"/>';
                }
            });
        }
       /*  function is called when the user presses a key in the input field.
         It checks if the pressed key is Enter (keyCode 13).
         If it is, the function replaces the parent element's content with the value of the input field,
          effectively saving the changes made by the user. */
        function refreshdata(element, event) {
            if (event.keyCode === 13) {
                element.parentNode.innerHTML = (element.value.length > 0) ? element.value : "&nbsp;&nbsp;";
            }
        }
        /* The losefocus function is called when the input field loses focus (e.g., when the user clicks outside of it).
         It also replaces the parent element's content with the value of the input field,
         effectively saving any changes. */
        function losefocus(element) {
            element.parentNode.innerHTML = (element.value.length > 0) ? element.value : "&nbsp;&nbsp;";
        }
    </script>

</body>

</html>
