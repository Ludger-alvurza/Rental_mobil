<?php

namespace App\Export;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TeacherXLS implements FromView
{

    public function view(): View
    {
        $rows = User::query()->get();
        return view('content.user.export-excel', [
            "rows" => $rows
        ]);
    }
}
