<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    <thead class="text-center bg-gray-100">
    <tr class="py-0">
        <th rowspan="2" width="5%">#</th>
        <th rowspan="2" width="25%">Bo'lim nomi <span
                style="font-weight:normal">(Hodimlar soni)</span></th>
        <th rowspan="2" width="15%">Mas'ul hodim</th>
        {{--                            <th rowspan="2" width="8%">Jami hodimlar soni</th>--}}
        <th colspan="{{count($shifts)}}">Smenalar</th>
        <th colspan="2" width="7%">Jami</th>
        <th colspan="{{count($absenceTypes)}}">Sabablar</th>
    </tr>
    <tr>
        @foreach($shifts as $shift)
            <th>{{ $shift->name }}</th>
        @endforeach
        <th>Hodimlar</th>
        <th>Mehmonlar</th>
        @foreach($absenceTypes as $absenceType)
            <th>{{ $absenceType->name }}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach ($departments as $dKey => $department)
        <tr>
            <td class="text-center">
                {{ ++$dKey }}
            </td>
            <td>
                {{ $department['name'] }} ({{$department['totalEmployees']}})
            </td>
            <td>
                {{ $department['employee']['name'] }}
                <small> {{ $department['employee']['phone'] ? '(Tel:'. $department['employee']['phone'] . ')': '-'}}
                </small>
            </td>
            @foreach($shifts as $shKey => $shift)
                <td class="text-center">
                    {{ array_key_exists($shift->id, $department['shifts']) ? $department['shifts'][$shift->id] : 0 }}
                </td>
            @endforeach
            <td class="text-center">
                {{$department['existEmployees'] }}
            </td>
            <td class="text-center">
                {{$department['guests'] }}
            </td>
            @foreach($absenceTypes as $shKey => $absenceType)
                <td class="text-center">
                    {{ array_key_exists($absenceType->id, $department['absenceTypes']) ?
                        $department['absenceTypes'][$absenceType->id] : 0 }}
                </td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr class="bg-gray-100 font-weight-bold">
        <td></td>
        <td colspan="2">Jami ({{ $total['totalEmployees'] }}):</td>
        @foreach($shifts as $shKey => $shift)
            <td class="text-center">
                <a href="{{ route('attendances.reportFiltered',  ['date' => $date, 'shift_id' => $shift->id]) }}">
                    {{ $total['shifts'][$shift->id] }} </a>
            </td>
        @endforeach
        <td class="text-center">
            {{$total['existEmployees'] }}
        </td>
        <td class="text-center">
            {{$total['guests'] }}
        </td>
        @foreach($absenceTypes as $shKey => $absenceType)
            <td class="text-center">
                <a href="{{ route('attendances.reportFiltered',  ['date' => $date, 'absence_type_id' => $absenceType->id]) }}">
                    {{ $total['absenceTypes'][$absenceType->id] }} </a>
            </td>
        @endforeach
    </tr>
    </tfoot>
</table>
