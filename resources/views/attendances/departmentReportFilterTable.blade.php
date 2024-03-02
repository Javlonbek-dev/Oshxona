<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    <thead class="text-center bg-gray-100">
    <tr class="py-0">
        <th width="5%">#</th>
        <th width="15%">Hodim</th>
        <th width="25%">Bo'lim nomi</th>
    </tr>
    </thead>
    <tbody>
    @if(count($data) == 0)
        <tr>
            <td class="text-center" colspan="3">
                Malumot yo'q ...
            </td>
        </tr>

    @endif
    @foreach ($data as $dKey => $datum)
        <tr>
            <td class="text-center">
                {{ ++$dKey }}
            </td>
            <td>
                {{ $datum->employee->fullName }}
            </td>
            <td>
                {{ $datum->department->name }}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
