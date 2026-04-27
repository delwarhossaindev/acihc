<?php

use App\Models\Audit;
use App\Models\Protocol;
use App\Models\Role;
use App\Models\SampleReport;
use App\Models\Setting;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

if (! function_exists('domain')) {
    function domain(): string
    {
        return App::make('url')->to('/');
    }
}

if (! function_exists('imagePath')) {
    function imagePath(?string $image): string
    {
        if ($image === null) {
            return '';
        }
        return preg_replace('/URL: /', '', $image);
    }
}

if (! function_exists('getSystemSettings')) {
    function getSystemSettings(string $key, ?string $default = null): ?string
    {
        return Cache::remember("system_setting:{$key}", now()->addMinutes(10), function () use ($key, $default) {
            return Setting::where('key', $key)->value('value') ?? $default;
        });
    }
}

if (! function_exists('userActivityLog')) {
    function userActivityLog(int $limit = 100)
    {
        return Audit::with('user:id,name')
            ->latest('id')
            ->limit($limit)
            ->get();
    }
}

if (! function_exists('userRolePermissions')) {
    function userRolePermissions($roleId)
    {
        return DB::table('permission_role')
            ->where('role_id', $roleId)
            ->get();
    }
}

if (! function_exists('getUserRoleAndPermission')) {
    function getUserRoleAndPermission()
    {
        return Role::withCount(['users', 'permissions'])
            ->with('users:id,name')
            ->get();
    }
}

if (! function_exists('csrfInput')) {
    function csrfInput(): string
    {
        return '<input type="hidden" name="_token" value="' . csrf_token() . '"/>';
    }
}

if (! function_exists('safeUrl')) {
    function safeUrl(?string $url): string
    {
        return htmlspecialchars((string) $url, ENT_QUOTES, 'UTF-8');
    }
}

if (! function_exists('getDynamicButtonLink')) {
    function getDynamicButtonLink($edit = '', $delete = ''): string
    {
        $edit = safeUrl($edit);
        $delete = safeUrl($delete);

        return "
            <div class='action-button-inline'>
                <a href='{$edit}' class='btn btn-primary btn-sm py-0'>Edit</a>&nbsp;
                <form method='POST' action='{$delete}'>" . csrfInput() . "
                    <button type='submit' class='btn btn-danger btn-sm py-1 show_confirm' data-toggle='tooltip' title='Delete'>Delete</button>
                </form>
            </div>";
    }
}

if (! function_exists('getDynamicButtonLinkForModal')) {
    function getDynamicButtonLinkForModal($edit = '', $delete = ''): string
    {
        $edit = safeUrl($edit);
        $delete = safeUrl($delete);

        return "
            <div class='action-button-inline'>
                <button data-toggle='modal' data-target='#myDynamicModal' data-link='{$edit}' class='btn btn-primary btn-sm py-0 ajax-modal-btn'>Edit</button>&nbsp;
                <form method='POST' action='{$delete}'>" . csrfInput() . "
                    <button type='submit' class='btn btn-danger btn-sm py-1 show_confirm' data-toggle='tooltip' title='Delete'>Delete</button>
                </form>
            </div>";
    }
}

if (! function_exists('getDynamicButtonLinkForEditModal')) {
    function getDynamicButtonLinkForEditModal($edit = null, $delete = null): string
    {
        $editBtn = $edit
            ? "<button data-toggle='modal' data-target='#myDynamicEditModal' data-link='" . safeUrl($edit) . "' class='btn btn-primary btn-sm py-0 dynamic-edit-modal-btn ajax-modal-btn'>Edit</button>"
            : "<a href='#' class='btn btn-primary btn-sm py-0 rounded-pill'>Edit</a>";

        $deleteBtn = $delete
            ? "<form method='POST' action='" . safeUrl($delete) . "'>" . csrfInput() . "
                <button type='submit' class='btn btn-danger btn-sm py-1 show_confirm' data-toggle='tooltip' title='Delete'>Delete</button>
              </form>"
            : "<a href='#' class='btn btn-danger btn-sm py-1 rounded-pill'>Delete</a>";

        return "<div class='action-button-inline'>{$editBtn}&nbsp;{$deleteBtn}</div>";
    }
}

if (! function_exists('sampleButton')) {
    function sampleButton($edit, $show, $delete): string
    {
        $edit = safeUrl($edit);
        $show = safeUrl($show);
        $delete = safeUrl($delete);

        return "
            <div class='action-button-inline'>
                <button data-toggle='modal' data-target='#myDynamicEditModal' data-link='{$edit}' class='btn btn-primary btn-sm py-0 dynamic-edit-modal-btn ajax-modal-btn' style='margin-right:3px'>Edit</button>
                <a href='{$show}' class='btn btn-dark btn-sm py-0' style='margin-right:3px;line-height:25px'>Create Report</a>
                <form method='POST' action='{$delete}'>" . csrfInput() . "
                    <button type='submit' class='btn btn-danger btn-sm py-1 show_confirm' data-toggle='tooltip' title='Delete'>Delete</button>
                </form>
            </div>";
    }
}

if (! function_exists('batch_button')) {
    function batch_button($edit, $show, $delete): string
    {
        $edit = safeUrl($edit);
        $delete = safeUrl($delete);

        return "
            <div class='action-button-inline'>
                <a href='{$edit}' class='btn btn-success btn-sm py-0' style='margin-right:3px;line-height:25px'>Edit</a>
                <form method='POST' action='{$delete}'>" . csrfInput() . "
                    <button type='submit' class='btn btn-danger btn-sm py-1 show_confirm' data-toggle='tooltip' title='Delete'>Delete</button>
                </form>
            </div>";
    }
}

if (! function_exists('sampleReportButton')) {
    function sampleReportButton($report, $delete, $edit, $SampleReportID = null): string
    {
        $report = safeUrl($report);
        $edit = safeUrl($edit);
        $delete = safeUrl($delete);

        $btn = "
            <div class='action-button-inline'>
                <a href='{$report}' class='btn btn-dark btn-sm py-0' style='margin-right:3px;line-height:25px' target='_blank'>Report</a>
                <a href='{$edit}' class='btn btn-primary btn-sm' style='margin-right:3px'>Edit</a>
                <form method='POST' action='{$delete}' style='display:inline;'>" . csrfInput() . "
                    <button type='submit' class='btn btn-danger btn-sm py-1 show_confirm' data-toggle='tooltip' title='Delete'>Delete</button>
                </form>";

        if ($SampleReportID) {
            $sampleReport = SampleReport::where('SampleReportID', $SampleReportID)->first();
            $authId = Auth::id();

            if ($sampleReport && $authId && $sampleReport->UserID == $authId) {
                $btn .= "
                <button data-toggle='modal' data-target='#dynamicApprovalModal' data-id='" . (int) $SampleReportID . "'
                    class='btn btn-primary btn-sm py-1 dynamic-approval-modal-btn ajax-approval-modal-btn' style='margin-left:3px'>
                    Assignment
                </button>";
            }
        }

        return $btn . "</div>";
    }
}

if (! function_exists('ProtocolButton')) {
    function ProtocolButton($edit = '', $show = '', $ProtocolID = ''): string
    {
        $edit = safeUrl($edit);
        $show = safeUrl($show);

        $btn = "
            <div class='action-button-inline'>
                <a href='{$edit}' class='btn btn-primary btn-sm' style='margin-right:3px'>Update</a>
                <a href='{$show}' class='btn btn-dark btn-sm' style='margin-right:3px' target='_blank'>Protocol</a>";

        if ($ProtocolID) {
            $protocol = Protocol::where('ProtocolID', $ProtocolID)->first();
            $authId = Auth::id();

            if ($protocol && $authId && $protocol->CreatedBy == $authId) {
                $btn .= "
                <button data-toggle='modal' data-target='#dynamicApprovalModal' data-id='" . (int) $ProtocolID . "' class='btn btn-primary btn-sm py-0 dynamic-approval-modal-btn ajax-approval-modal-btn' style='margin-right:3px'>Approval</button>";
            }
        }

        return $btn . "</div>";
    }
}

if (! function_exists('WithdrawButton')) {
    function WithdrawButton($BatchID = ''): string
    {
        if (! $BatchID) {
            return '';
        }

        return "<button data-toggle='modal' data-target='#dynamicApprovalModal' data-id='" . (int) $BatchID . "' class='btn btn-primary btn-sm dynamic-approval-modal-btn ajax-approval-modal-btn'>Withdraw</button>";
    }
}

if (! function_exists('convertJsonToArray')) {
    function convertJsonToArray($json): array
    {
        $decoded = json_decode($json);

        if (! is_array($decoded) && ! is_object($decoded)) {
            return [];
        }

        $collections = [];
        foreach ($decoded as $key => $value) {
            $collections[$key] = $value->value ?? null;
        }

        return $collections;
    }
}

if (! function_exists('get_stability_chamber_month_value')) {
    function get_stability_chamber_month_value($protocolID): array
    {
        $protocol = Protocol::with('statbilityStudy.study.details')->find($protocolID);

        if (! $protocol) {
            return [];
        }

        $months = [];
        foreach ($protocol->statbilityStudy as $stability) {
            $studyMonths = optional($stability->study?->details)->pluck('StudyTypeMonth') ?? collect();
            foreach ($studyMonths as $key => $month) {
                $months[$key] = $month;
            }
        }

        return $months;
    }
}

if (! function_exists('study_month')) {
    function study_month($month): ?string
    {
        return match ((string) $month) {
            '0', '1', '2', '3', '4', '5' => 'AC',
            '6'                          => 'AC, IN, LT',
            '9', '12'                    => 'IN, LT',
            '18', '24', '36', '48', '60' => 'LT',
            default                      => null,
        };
    }
}
