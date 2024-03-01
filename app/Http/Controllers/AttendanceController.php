<?php

namespace App\Http\Controllers;

use App\Exports\DepartmentReportExport;
use App\Exports\DepartmentReportFilterExport;
use App\Exports\EmployeeReportExport;
use App\Exports\Report1cExport;
use App\Models\AbsenceType;
use App\Models\Attendance;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Guest;
use App\Models\Record;
use App\Models\Shift;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;

class AttendanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $date = $request->get('date') ?? Carbon::today()->format('Y-m-d');
        $departmentId = auth()->user()->department_id;

        $upsert = Attendance::query()->whereDate('date', $date)
            ->where('department_id', $departmentId)->count();

        $shifts = Shift::query()->with([
            'guests' => function ($query) use ($date, $departmentId) {
                $query->whereDate('date', $date)
                    ->where('department_id', $departmentId);
            }
        ])->get();

        $employees = Employee::query()
            ->where('department_id', $departmentId)
            ->with([
                'attendances' => function ($query) use ($date) {
                    $query->whereDate('date', $date);
                }
            ])
            ->orderBy('id')
            ->get();

        $absenceTypes = AbsenceType::all();

        $currentDate = date("Y-m-d");
        $diff = abs(strtotime($currentDate) - strtotime($date));
        $daysDiff = floor($diff / (60 * 60 * 24));

        return view('attendances.index', [
            'date' => $date,
            'shifts' => $shifts,
            'upsert' => $upsert,
            'daysDiff' => $daysDiff,
            'employees' => $employees,
            'absenceTypes' => $absenceTypes
        ]);
    }

    public function store()
    {
        $date = request('date');
        $attendanceData = request('attendanceData');
        $guestsData = [];

        if (isset($attendanceData['guests'])) {
            $guestsData = $attendanceData['guests'];
            unset($attendanceData['guests']);
        }

        $departmentId = reset($attendanceData)['department_id'];

        try {
            Attendance::query()->where([
                'date' => $date,
                'department_id' => $departmentId,
            ])->delete();

//        Mehmonlarni hisloblash
            foreach ($guestsData as $shiftId => $guestsDatum) {
                $guest = Guest::query()
                    ->where('shift_id', $shiftId)
                    ->where('date', $date)
                    ->where('department_id', $departmentId)->first();

                if ($guest && !$guestsDatum) {
                    $guest->delete();
                    continue;
                }

                if ($guest && $guestsDatum) {
                    $guest->update(['quantity' => $guestsDatum]);
                    continue;
                }

                if (!$guest && $guestsDatum) {
                    Guest::query()->create([
                        'date' => $date,
                        'shift_id' => $shiftId,
                        'quantity' => $guestsDatum,
                        'department_id' => $departmentId
                    ]);
                }
            }

            foreach ($attendanceData as $employeeId => $attendanceDatum) {
                if (!$attendanceDatum['absence_type_id'] && !isset($attendanceDatum['shifts'])) {
                    return redirect()->back()->with('error', 'Birorta smenani yoki kelmaganlik sababini tanlang');
                }

                if (!Employee::query()->find($employeeId)) {
                    continue;
                }

                if ($attendanceDatum['absence_type_id']) {
                    unset($attendanceDatum['shifts']);
                }

                if (isset($attendanceDatum['shifts'])) {
                    foreach ($attendanceDatum['shifts'] as $shiftId => $shift) {
                        Attendance::query()->create([
                            'employee_id' => $employeeId,
                            'date' => $date,
                            'shift_id' => $shiftId,
                            'department_id' => $attendanceDatum['department_id'],
                        ]);
                    }
                } else {
                    Attendance::query()->create([
                        'employee_id' => $employeeId,
                        'date' => $date,
                        'absence_type_id' => $attendanceDatum['absence_type_id'],
                        'department_id' => $attendanceDatum['department_id'],
                    ]);
                }
            }

            return redirect()->route('attendances.index', ['date' => $date])->with(
                'success',
                'Muvaffaqiyatli bajarildi'
            );
        } catch (\Exception $exception) {
            return redirect()->route('attendances.index')->with(
                'error',
                $exception->getMessage()
            );
        }
    }

    public function copyFromDate()
    {
        $copy_date = request('copy_date');
        $date = request('date');

        if ($copy_date == $date) {
            return redirect()->back()->with(
                'error',
                'Bugungi kundan ko\'chirish mumkin emas'
            );
        }

        $departmentId = auth()->user()->department_id;

        $guests = Guest::query()
            ->where('date', $copy_date)
            ->where('department_id', $departmentId)->get();


        $attendances = Attendance::query()
            ->where('date', $copy_date)
            ->where('department_id', $departmentId)
            ->get();

        // Delete guests and attendances in current date

        Guest::query()
            ->where('date', $date)
            ->where('department_id', $departmentId)->delete();

        Attendance::query()
            ->where('date', $date)
            ->where('department_id', $departmentId)->delete();

        foreach ($guests as $guest) {
            $guest->date = $date;
            Guest::query()->create($guest->toArray());
        }

        foreach ($attendances as $attendance) {
            if (!Employee::query()->find($attendance->employee_id)) {
                continue;
            }
            $attendance->date = $date;
            Attendance::query()->create($attendance->toArray());
        }

        return redirect()->route('attendances.index', ['date' => $date])->with('success', 'Muvaffaqiyatli bajarildi');
    }

    public function report(Request $request)
    {
        $date = $request->get('date') ?? Carbon::today()->format('Y-m-d');

        $shifts = Shift::all();
        $employees = Employee::query()
            ->whereHas('attendances', function ($query) use ($date) {
                $query->whereDate('date', $date);
            })
            ->orderBy('id')
            ->get();

        $absenceTypes = AbsenceType::all();

        return view('attendances.report', [
            'date' => $date,
            'shifts' => $shifts,
            'employees' => $employees,
            'absenceTypes' => $absenceTypes
        ]);
    }

    public function departmentReport()
    {
        $data = $this->departmentReportData();
        return view('attendances.departmentReport', $data);
    }

    public static function departmentReportData()
    {
        $date = request()->get('date') ?? Carbon::today()->format('Y-m-d');
        $shifts = Shift::all();
        $absenceTypes = AbsenceType::all();
        $departments = Department::query()
            ->withCount('employees as totalEmployees')
            ->with([
                'attendances' => function ($query) use ($date) {
                    $query->where('date', $date);
                }
            ])
            ->with([
                'guests' => function ($query) use ($date) {
                    $query->where('date', $date);
                }
            ])
//            ->withCount([
//                'attendances as existEmployees' => function ($query) use ($date) {
//                    $query->where('date', $date)
//                        ->whereNotNull('shift_id');
//                }
//            ])
            ->get();


        $result = [];

        foreach ($departments as $dKey => $department) {
            $dep = $department;
            $result[$dKey] = [
                'id' => $department->id,
                'name' => $department->name,
                'totalEmployees' => $department->totalEmployees,
                'existEmployees' => $department->attendances
                    ->where('date', $date)
                    ->where('shift_id', '>', 0)
                    ->groupBy('employee_id')
                    ->count(),
                'guests' => $department->guests->sum('quantity'),
                'employee' => [
                    'name' => $department->admin?->last_name . ' ' . $department->admin?->first_name,
                    'phone' => $department->admin?->mobile_number,
                ],
            ];

            foreach ($shifts as $shift) {
                $employeesCount = $dep->attendances
                    ->where('department_id', $department->id)
                    ->where('shift_id', $shift->id)
                    ->groupBy('employee_id')
                    ->count();

                $guestsCount = $dep->guests
                    ->where('department_id', $department->id)
                    ->where('shift_id', $shift->id)
                    ->sum('quantity');

                $result[$dKey]['shifts'][$shift->id] = $employeesCount + $guestsCount;
            }

            foreach ($absenceTypes as $absenceType) {
                $result[$dKey]['absenceTypes'][$absenceType->id] =
                    $dep->attendances
                        ->where('department_id', $department->id)
                        ->where('absence_type_id', $absenceType->id)
                        ->count();
            }
        }

        $total['totalEmployees'] = array_sum(array_column($result, 'totalEmployees'));
        $total['existEmployees'] = array_sum(array_column($result, 'existEmployees'));
        $total['guests'] = array_sum(array_column($result, 'guests'));
        $totalShifts = array_column($result, 'shifts');
        $totalAbsenceTypes = array_column($result, 'absenceTypes');

        foreach ($shifts as $shift) {
            $total['shifts'][$shift->id] = array_sum(array_column($totalShifts, $shift->id));
        }
        foreach ($absenceTypes as $absenceType) {
            $total['absenceTypes'][$absenceType->id] = array_sum(array_column($totalAbsenceTypes, $absenceType->id));
        }

        return [
            'date' => $date,
            'shifts' => $shifts,
            'departments' => $result,
            'absenceTypes' => $absenceTypes,
            'total' => $total,
        ];
    }

    public function report1c()
    {
        $data = $this->report1cData();
        return view('attendances.report1c', $data);
    }

    public static function report1cData()
    {
        $date = request()->get('date') ?? Carbon::today()->format('Y-m-d');

        $shifts = Shift::all();

        $records = Record::query()->whereDate('event_date', $date)->get();

        $departments = Department::query()
            ->with('admin')
            ->withCount('employees as totalEmployees')
            ->with([
                'guests' => function ($query) use ($date) {
                    $query->where('date', $date);
                }
            ])
            ->get();

        $result = [];

        foreach ($departments as $dKey => $department) {
            $dep = $department;
            $result[$dKey] = [
                'id' => $department->id,
                'name' => $department->name,
                'totalEmployees' => $department->totalEmployees,
                'guestsCount' => $department->guests->sum('quantity'),
                'employee' => [
                    'name' => $department->admin?->last_name . ' ' . $department->admin?->first_name,
                    'phone' => $department->admin?->mobile_number,
                ],
            ];
            $result[$dKey]['employeesCount'] = 0;
            foreach ($shifts as $shift) {
                $recordsByShift = $records
                    ->where('event_date', '>', $date . ' ' . $shift->begin_date)
                    ->where('event_date', '<', $date . ' ' . $shift->end_date)
                    ->pluck('user_id');

                $employeesCount = $dep->employees()
                    ->whereIn('tabel', $recordsByShift)
                    ->count();

                $guestsCount = $dep->guests
                    ->where('shift_id', $shift->id)
                    ->sum('quantity');

                $result[$dKey]['shifts'][$shift->id]['employees'] = $employeesCount;
                $result[$dKey]['shifts'][$shift->id]['guests'] = $guestsCount;
                $result[$dKey]['employeesCount'] += $result[$dKey]['shifts'][$shift->id]['employees'];
            }
        }

        return [
            'date' => $date,
            'shifts' => $shifts,
            'records' => $records,
            'departments' => $result,
        ];
    }

    public function employeesReport()
    {
        $data = $this->employeesReportData();
        return view('attendances.employeesReport', $data);
    }

    public static function employeesReportData()
    {
        $from = request('from') ?? date('Y-m-01');
        $to = request('to') ?? date('Y-m-t');
        $rows = request('rows') ?? 25;
        $employees = Employee::query();
        $shifts = Shift::all();
        $departments = Department::all();


//        $records = Record::query()
//            ->whereDate('event_date', '>', $from . ' 00:00:00')
//            ->whereDate('event_date', '<', $to . ' 23:59:59')
//            ->get();

        $departmentId = request('department_id') ?? null;
        if ($departmentId) {
            $employees->where('department_id', $departmentId);
        }

        $search = request('search') ?? null;
        if ($search) {
            $employees->where(function ($query) use ($search) {
                $query->where('first_name', 'like', '%' . $search . '%');
                $query->orWhere('last_name', 'like', '%' . $search . '%');
                $query->orWhere('middle_name', 'like', '%' . $search . '%');
                $query->orWhere('tabel', $search);
                $query->orWhere('pnfl', $search);
                $query->orWhere('mobile_number', 'like', '%' . $search . '%');
            });
        }

        $employees = $employees->with(['department'])
            ->select('first_name', 'last_name', 'middle_name', 'tabel', 'department_id', 'pnfl', 'mobile_number')
            ->orderBy('department_id', 'ASC')
            ->orderBy('last_name', 'ASC')->paginate($rows);

        $employees->getCollection()->transform(function ($employee) use ($shifts, $from, $to) {
            $period = Carbon::parse($from)->daysUntil(Carbon::parse($to));
            $count = 0;

            $records = Record::query()
                ->whereDate('event_date', '>=', $from)
                ->whereDate('event_date', '<=', $to)
                ->where('user_id', $employee->tabel)
                ->get();

            foreach ($period as $date) {
                foreach ($shifts as $shift) {
                    $startTime = Carbon::parse($date->format('Y-m-d') . ' ' . $shift->begin_date);
                    if ($shift->end_date < $shift->begin_date) {
                        $finishTime = Carbon::parse($date->addDay()->format('Y-m-d') . ' ' . $shift->end_date);
                    } else {
                        $finishTime = Carbon::parse($date->format('Y-m-d') . ' ' . $shift->end_date);
                    }

                    $recordsByShift = $records
                        ->where('event_date', '>', $startTime)
                        ->where('event_date', '<', $finishTime)
                        ->count();
                    if ($recordsByShift > 0) {
                        $count++;
                    }
                }
            }

            $employee->count = $count;
            return $employee;
        });

        return [
            'rows' => $rows,
            'from' => $from,
            'to' => $to,
            'employees' => $employees,
            'departmentId' => $departmentId,
            'search' => $search,
            'departments' => $departments,
//            'records' => $records,
        ];
    }

    public function exportDepartmentReport()
    {
        return Excel::download(new DepartmentReportExport(), 'report.xlsx');
    }

    public function exportDepartmentFilterReport()
    {
        return Excel::download(new DepartmentReportFilterExport(), 'report.xlsx');
    }

    public function exportEmployeesReport()
    {
        return Excel::download(new EmployeeReportExport(), 'report.xlsx');
    }

    public function export1cReport()
    {
        return Excel::download(new Report1cExport(), 'report.xlsx');
    }

    public function reportFiltered()
    {
        $data = $this->reportFilteredData();
        return view('attendances.departmentReportFilter', $data);
    }

    public static function reportFilteredData(): array
    {
        $shiftId = request()->shift_id;
        $absenceTypeId = request()->absence_type_id;
        $date = request()->date;

        $data = [];

        if ($shiftId) {
            $shift = Shift::find($shiftId);
            $guests = Department::query()->whereHas('guests', function ($q) use ($shiftId, $date) {
                return $q->where('date', $date)->where('shift_id', $shiftId);
            })->withSum([
                'guests' => fn($query) => $query->where('date', $date)
                    ->where('shift_id', $shiftId)
            ], 'quantity')
                ->get();

            $data = Attendance::where('shift_id', $shiftId)
                ->where('date', $date)
                ->with(['employee', 'department'])
                ->get();

        }

        if ($absenceTypeId) {
            $absenceType = AbsenceType::find($absenceTypeId);
            $data = Attendance::where('absence_type_id', $absenceTypeId)->where('date', $date)
                ->with(['employee', 'department'])->get();
        }

        return [
            'date' => $date,
            'shift' => $shift ?? null,
            'absenceType' => $absenceType ?? null,
            'guests' => $guests ?? [],
            'data' => $data,
        ];
    }

}
