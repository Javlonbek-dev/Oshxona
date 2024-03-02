<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    <thead class="text-center bg-gray-100">
    <tr class="py-0">
        <th>#</th>
        <th>Bo'lim nomi</th>
        <th>Hodim F.I.Sh.</th>
        <th>J.Sh.Sh.I.R</th>
        <th>Jami tushlik soni</th>
        <th>Telefon raqami</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($employees as $eKey => $employee)
        <tr>
            <td class="text-center"> {{ ++$eKey }} </td>
            <td> {{ $employee->department?->name }}</td>
            <td> {{ $employee->fullName }}</td>
            <td> {{ $employee->pnfl }}</td>
            <td> {{ $employee->count }} </td>
            <td> {{ $employee->mobile_number }} </td>
        </tr>
    @endforeach
    </tbody>
</table>
