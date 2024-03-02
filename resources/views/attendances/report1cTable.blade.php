<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    <thead class="text-center bg-gray-100">
    <tr class="py-0">
        <th rowspan="2" width="5%">#</th>
        <th rowspan="2" width="25%">Bo'lim nomi <span
                style="font-weight:normal">(Hodimlar soni)</span></th>
        {{--        <th rowspan="2" width="15%">Mas'ul hodim</th>--}}
        <th colspan="2" width="7%">Jami</th>
        <th colspan="{{count($shifts)}}">Hodimlar</th>
        <th colspan="{{count($shifts)}}">Mehmonlar</th>
    </tr>
    <tr>
        <th>Hodimlar</th>
        <th>Mehmonlar</th>

        @foreach($shifts as $shift)
            <th>{{ $shift->name }}</th>
        @endforeach
        @foreach($shifts as $shift)
            <th>{{ $shift->name }}</th>
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

            <td class="text-center">
                {{ $department['employeesCount'] }}
            </td>

            <td class="text-center">
                {{ $department['guestsCount'] }}
                {{--                                    {{ $department->guests->sum('quantity') }}--}}
            </td>
            @foreach($shifts as $shKey => $shift)
                <td class="text-center">
                    {{ array_key_exists($shift->id,  $department['shifts']) ? $department['shifts'][$shift->id]['employees'] : 0 }}
                </td>
            @endforeach
            @foreach($shifts as $shKey => $shift)
                <td class="text-center">
                    {{ array_key_exists($shift->id,  $department['shifts']) ? $department['shifts'][$shift->id]['guests'] : 0 }}

                    {{--                                        {{  $department->guests->where('shift_id', $shift->id)->sum('quantity') }}--}}
                </td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr class="bg-gray-100 font-weight-bold">
        <td></td>
        <td colspan="1">Jami :  <small><i class="text-info"> (Hisoblanmoqda) </i></small> </td>
        <td class="text-center">--
            {{--                {{ $total['shifts'][$shift->id] }}--}}
        </td>
        <td class="text-center">--
            {{--                {{ $total['shifts'][$shift->id] }}--}}
        </td>
                @foreach($shifts as $shKey => $shift)
                    <td class="text-center">
                        {{ '--' }}
                    </td>
                    <td class="text-center">
                        {{ '--' }}
                    </td>
                @endforeach

    </tr>
    </tfoot>
</table>
