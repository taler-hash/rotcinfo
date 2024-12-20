<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Document</title>
    <style>
        @page {
            margin: 0.5in 0.5in 0.5in 0.5in;
            /* Remove default page margins */
            padding: 0;
            box-sizing: border-box;
        }


        .a4 {
            width: 11.69in;
            height: fit-content;
            border: 2px;
            /* border-color: black; */
            /* border-style: solid; */
        }

        * {
            font-family: Arial, sans-serif !important;
        }

        .content {
            width: 10.69in;
        }

        .header {
            width: 100%;
        }

        .title {
            font-size: 1rem;
            text-align: center;
        }

        .title p {
            font-weight: normal;
        }

        .date {
            width: 80%;
            padding: 0 5rem;
            margin: 1rem 0 1rem 0;
            text-align: right;
        }

        .page-break {
            page-break-after: always;
        }

        .cadet-profile {
            text-align: center;
            padding-bottom: 5px;
        }

        .ms {
            padding: 5px 0 5px;
            margin: 0;
            background-color: #4640f5;
            font-weight: bold;
            font-size: large;
            border: 1px solid black;
        }

        .fields {
            padding: 0;
            margin: 0;
        }

        .fields th {
            border: 1px solid black;
        }

        .fields td {
            border: 1px solid black;
        }

        .staff {
            margin-top: 60px;
            width: 100%;
            font-weight: normal;
        }

        .f-normal {
            font-weight: normal;
        }

        .f-bold {
            font-weight: bold;
        }

        table {
            border-collapse: collapse;
        }

        .t-small {
            font-size: small;
        }
        .t-smaller {
            font-size: smaller;
        }
        .t-xsmall {
            font-size: x-small;
        }
    </style>
</head>

<body>
    <div class="a4">
        <div class="content">
            <table class="header">
                <tr>
                    <th>
                        <div><img src="{{public_path('assets/cdc.png')}}" style="width: 120px"></div>
                    </th>
                    <th>
                        <div class="title">
                            <div class="f-normal">CEBU TECHNOLOGICAL UNIVERSITY CONSOLACION CAMPUS ROTC UNIT</div>
                            <div class="f-normal">DEPARTMENT OF MILITARY SCIENCE AND TACTICS</div>
                            <div><b>CEBU TECHNOLOGICAL UNIVERSITY CONSOLACION CAMPUS ROTC UNIT</b></div>
                            <div class="f-normal">701ST (CEB) COMMUNITY DEFENSE CENTER, 7RCDG, RESCOM, PA</div>
                            <div class="f-normal">Laray, Consolacion, Cebu </p>
                            </div>
                    </th>
                    <th>
                        <div><img src="{{public_path('assets/rotcr.png')}}" style="width: 120px; height:100px;"></div>
                    </th>
                </tr>
            </table>
            <div class="date">
                {{ $date }}
            </div>
            <div class="cadet-profile">
                <div style="padding-bottom: 5px;">
                    <b>CADETS PROFILE</b>
                </div>
                <div class="">
                    <b>{{ $semester == 1 ? '1st' : '2nd'}} Semester SY {{ $sy }}</b>
                </div>
            </div>
            @foreach($cadets as $subjectKey => $subject)

            @foreach($subject as $genderKey => $gender)
            <table class="content">
                <thead>
                    <tr>
                        <th colspan="11" class="ms">
                            <div>{{ strtoupper($subjectKey) }}{{ $semester }} {{ ucfirst($genderKey) }}</div>
                        </th>
                    </tr>
                    <tr class="fields">
                        <th>
                            No.
                        </th>
                        <th>
                            Name
                        </th>
                        <th>
                            Gender
                        </th>
                        <th>
                            Age
                        </th>
                        <th>
                            DOB
                        </th>
                        <th>
                            Address
                        </th>
                        <th>
                            Course
                        </th>
                        <th>
                            Religion
                        </th>
                        <th>
                            B-Type
                        </th>
                        <th>
                            Height
                        </th>
                        <th>
                            Beneficiary
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($gender as $cadetKey => $cadet)
                    <tr class="fields">
                        <td>{{ $cadetKey+1 }}</td>
                        <td class="{{ $setFontSize($cadet['name']) }}">{{ $cadet['name'] }}</td>
                        <td>{{ $cadet['gender']}}</td>
                        <td>{{ $cadet['age'] }}</td>
                        <td class="t-smaller">{{ $cadet['dob'] }}</td>
                        <td class="{{ $setFontSize($cadet['name']) }}">{{ $cadet['address'] }}</td>
                        <td>{{ $cadet['course']}}</td>
                        <td>{{ $cadet['religion']}}</td>
                        <td>{{ $cadet['b_type'] }}</td>
                        <td>{{ $cadet['height']}}</td>
                        <td class="{{ $setFontSize($cadet['name']) }}">{{ $cadet['beneficiary']}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endforeach
            @if($subjectKey !== 'ms-4')
            <div class="page-break"></div>
            @endif
            @endforeach

            <div class="high-rank">
                <table class="staff">
                    <tr style="width: 70%;">
                        <th style="text-align: left;">
                            <div class="f-normal" style="margin-bottom: 50px">
                                Prepared By:
                            </div>
                            <div class="f-normal">{{ ucfirst($admin_nco) }}</div>
                            <div class="f-normal">{{ $admin_nco_rank}}</div>
                            <div class="f-normal">Admin NCO</div>
                        </th>
                        <th style="font-weight: normal; text-align:left; width:30%;">
                            <div style="margin-bottom: 50px">
                                CERTIFIED CORRECT:
                            </div>
                            <div class="f-bold">{{ strtoupper($commandant)}}</div>
                            <div class="f-normal">{{ strtoupper($commandant_rank)}}</div>
                            <div class="f-normal">Commandant</div>
                        </th>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>

</html>