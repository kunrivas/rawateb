<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .background-image {
            position: absolute;
            /* background-image: url("{{ asset('/public/ats/img/ATS_F2.png') }}"); */
            background-image: url('/rawateb/public/ats/img/ATS_F2.png');
            background-repeat: no-repeat;
            background-size: 1580px 1100px;
            /*  1754 × 1274 px*/
            background-position: left top;
            left: 0px;
            top: 0px;
            width: 1580px;
            height: 1100px;
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

        .text-center {
            text-align: center;
        }

        .text-rigth {
            text-align: right;
        }

        .text-left {
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
                size: landscape;
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
    <div class="background-image"></div>




    @foreach ($data as $item)
        {{--  $loop->index It represents the current iteration index
	calibrator and y  are sent by data in ats controller
/*  calibrator the espace between the lines of table  of affichage of page2 positiion (top)  */
'calibrator'            => 35,
/*  y is the first line in the table  of affichage of page2 positiion (top) */
'y'                     => 155, --}}

        <div style="left: 73px;top: {{ $y + $loop->index * $calibrator }}px ;"
            class="editable pos-absolute m-0 font28 bold">{{ $item->month . '-' . $item->year }}</div>

        <!-- عدد الأيام المعمول فيها -->
        <div style="left: 450px;top: {{ $y + $loop->index * $calibrator }}px ;"
            class="editable pos-absolute m-0 font28 bold">{{ $item->workdays }}</div>

        <!-- سبب الغياب -->
        <div style="left: 650px;top: {{ $y + $loop->index * $calibrator }}px ;width:270px;"
            class="editable pos-absolute m-0 font28 bold text-center ">
            {{ empty($item->absensecoz) ? '/' : $item->absensecoz }}</div>

        <!-- الأجر الخاضع للاشتراك  -->
        <div style="left: 945px;top: {{ $y + $loop->index * $calibrator }}px ;width:270px;"
            class="editable pos-absolute m-0 font28 bold text-center  0border-1">{{ $item->cotz }}</div>

        <!-- حصة العامل   -->
        <div style="left: 1257px;top: {{ $y + $loop->index * $calibrator }}px ;width:270px;"
            class="editable pos-absolute m-0 font28 bold text-center  0border-1">{{ $item->sc }}</div>
    @endforeach


    <!-- الشهر المرجعي -->


    <!-- حررت في  -->
    <div style="left: 1392px;top: 672px ;" class="editable pos-absolute m-0 font22 bold">{{ $edited_at }}</div>

    <!-- بـــ -->
    <div style="left: 1085px;top: 672px ;" class="editable pos-absolute m-0 font22 bold">{{ $location }}</div>

    <!-- اسم و لقب   -->
    <div style="left: 1322px;top: 744px ;" class="editable pos-absolute m-0 font22 bold">{{ $edit_owner }}</div>

    <!-- صفة الموقع -->
    <div style="left: 1070px;top: 744px ;" class="editable pos-absolute m-0 font22 bold">{{ $edit_ownertype }}</div>



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
