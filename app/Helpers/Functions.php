<?php

use App\Models\Audit;
use App\Models\Protocol;
use App\Models\SampleReport;
use App\Models\Role;
use App\Models\Setting;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

if (!function_exists('domain')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function domain(): string
    {
        return App::make('url')->to('/');
    }
}

if (!function_exists('imagePath')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function imagePath($image): string
    {
        return preg_replace('/URL: /', '', $image);
    }
}

if (!function_exists('getSystemSettings')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function getSystemSettings(string $key): string
    {
        return Setting::where('key', $key)->first()['value'];
    }
}

if (!function_exists('userActivityLog')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function userActivityLog()
    {
        return Audit::with('user:id,name')
            ->get();
    }
}

if (!function_exists('userRolePermissions')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function userRolePermissions($roleId)
    {
        return DB::table('permission_role')
            ->where('role_id', $roleId)
            ->get();
    }
}

if (!function_exists('getUserRoleAndPermission')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function getUserRoleAndPermission()
    {
        return Role::withCount(['users', 'permissions'])
            ->with('users')
            ->get();
    }
}

if (!function_exists('getDynamicButtonLink')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function getDynamicButtonLink($edit = '', $delete = '')
    {
        $btn = "
            <div class='action-button-inline'>
            <a href='" . $edit . "' class='btn btn-primary btn-sm py-0'>Edit</a>
            &nbsp
            <form method='POST' action='" . $delete . "'>
            <input type='hidden' name='_token' id='csrf-token' value='" . csrf_token() . "'/>
            <button type='submit' class='btn btn-danger btn-sm py-1 show_confirm' data-toggle='tooltip' title='Delete'>Delete</button>
            </form>
            </div>";
        return $btn;
    }
}

if (!function_exists('getDynamicButtonLinkForModal')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function getDynamicButtonLinkForModal($edit = '', $delete = '')
    {
        $btn = "
            <div class='action-button-inline'>
            <button data-toggle='modal' data-target='#myDynamicModal' data-link='" . $edit . "' class='btn btn-primary btn-sm py-0 ajax-modal-btn'>Edit</button>
            &nbsp
            <form method='POST' action='" . $delete . "'>
            <input type='hidden' name='_token' id='csrf-token' value='" . csrf_token() . "'/>
            <button type='submit' class='btn btn-danger btn-sm py-1 show_confirm' data-toggle='tooltip' title='Delete'>Delete</button>
            </form>
            </div>";
        return $btn;
    }
}

if (!function_exists('getDynamicButtonLinkForEditModal')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function getDynamicButtonLinkForEditModal($edit = '', $delete = '')
    {
        $btn = "
            <div class='action-button-inline'>
            <button data-toggle='modal' data-target='#myDynamicEditModal' data-link='" . $edit . "' class='btn btn-primary btn-sm py-0 dynamic-edit-modal-btn ajax-modal-btn'>Edit</button>
            &nbsp
            <form method='POST' action='" . $delete . "'>
            <input type='hidden' name='_token' id='csrf-token' value='" . csrf_token() . "'/>
            <button type='submit' class='btn btn-danger btn-sm py-1 show_confirm' data-toggle='tooltip' title='Delete'>Delete</button>
            </form>
            </div>";
        return $btn;
    }
}

if (!function_exists('sampleButton')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function sampleButton($edit, $show, $delete)
    {
        $btn = "
            <div class='action-button-inline'>
            <button data-toggle='modal' data-target='#myDynamicEditModal' data-link='" . $edit . "' class='btn btn-primary btn-sm py-0 dynamic-edit-modal-btn ajax-modal-btn' style='margin-right:3px'>Edit</button>
            <a href='" . $show . "' class='btn btn-dark btn-sm py-0' style='margin-right:3px;line-height:25px'>Create Report</a>
            <form method='POST' action='" . $delete . "'>
            <input type='hidden' name='_token' id='csrf-token' value='" . csrf_token() . "'/>
            <button type='submit' class='btn btn-danger btn-sm py-1 show_confirm' data-toggle='tooltip' title='Delete'>Delete</button>
            </form>
            </div>";
        return $btn;
    }
}

if (!function_exists('batch_button')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function batch_button($edit, $show, $delete)
    {
        $btn = "
            <div class='action-button-inline'>
            <a href='" . $edit . "' class='btn btn-success btn-sm py-0' style='margin-right:3px;line-height:25px'>Edit</a>
            <a href='" . $show . "' class='btn btn-primary btn-sm py-0' style='margin-right:3px;line-height:25px'>Clone</a>
            <form method='POST' action='" . $delete . "'>
            <input type='hidden' name='_token' id='csrf-token' value='" . csrf_token() . "'/>
            <button type='submit' class='btn btn-danger btn-sm py-1 show_confirm' data-toggle='tooltip' title='Delete'>Delete</button>
            </form>
            </div>";
        return $btn;
    }
}

if (!function_exists('sampleReportButton')) {

    
    function sampleReportButton($report, $delete, $edit, $SampleReportID = null)
    {
        $SampleReport = $SampleReportID ? SampleReport::where('SampleReportID', $SampleReportID)->first() : null;

        $btn = "
        <div class='action-button-inline'>
            <a href='" . $report . "' class='btn btn-dark btn-sm py-0' style='margin-right:3px;line-height:25px' target='_blank'>Report</a>
            <a href='" . $edit . "' class='btn btn-primary btn-sm' style='margin-right:3px'>Edit</a>
            <form method='POST' action='" . $delete . "' style='display:inline;'>
                <input type='hidden' name='_token' value='" . csrf_token() . "'/>
                <button type='submit' class='btn btn-danger btn-sm py-1 show_confirm' data-toggle='tooltip' title='Delete'>Delete</button>
            </form> ";

            if ($SampleReport->UserID == auth()->user()->id) {
            $btn .= "
            <button data-toggle='modal' data-target='#dynamicApprovalModal' data-id='" .  $SampleReportID . "' 
                class='btn btn-primary btn-sm py-1 dynamic-approval-modal-btn ajax-approval-modal-btn' style='margin-left:3px'> 
                Assignment
            </button>";
            }

            // $btn .= "
            // <button data-toggle='modal' data-target='#dynamicApprovalModal2' data-id='" .  $SampleReportID . "' 
            //     class='btn btn-primary btn-sm py-1 dynamic-approval-modal-btn ajax-approval-modal-btn2' style='margin-left:3px'> 
            //     Approval
            // </button>";

        $btn .= "</div>";
        
        return $btn;
    }
}


if (!function_exists('ProtocolButton')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function ProtocolButton($edit = '', $show = '', $ProtocolID = '')
    {
        $Protocol = $ProtocolID ? Protocol::where('ProtocolID', $ProtocolID)->first() : null;
    
        $btn = "
            <div class='action-button-inline'>
                <a href='" . $edit . "' class='btn btn-primary btn-sm' style='margin-right:3px'>Update</a>
                <a href='" . $show . "' class='btn btn-dark btn-sm' style='margin-right:3px' target='_blank'>Protocol</a>";
    
        if ($Protocol->CreatedBy == auth()->user()->id) {
            $btn .= "
                <button data-toggle='modal' data-target='#dynamicApprovalModal' data-id='" . $ProtocolID . "' class='btn btn-primary btn-sm py-0 dynamic-approval-modal-btn ajax-approval-modal-btn' style='margin-right:3px'>Approval</button>";
        }
    
        $btn .= "
            </div>";
    
        return $btn;
    }
}

if (!function_exists('WithdrawButton')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function WithdrawButton($BatchID = '')
    {
       
        if ($BatchID)
        {
            $btn = "
                <button data-toggle='modal' data-target='#dynamicApprovalModal' data-id='" . $BatchID . "' class='btn btn-primary btn-sm dynamic-approval-modal-btn ajax-approval-modal-btn'>Withdraw</button>";
        }
    
        $btn .= "
            </div>";
    
        return $btn;
    }
}

if (!function_exists('convertJsonToArray')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function convertJsonToArray($json): array
    {
        $collections = [];

        foreach (json_decode($json) as $key => $value) {
            $collections[$key] = $value->value;
        }

        return $collections;
    }
}

function get_stability_chamber_month_value($protocolID)
{
    $AC = [];
    $IN = [];
    $protocol = Protocol::find(1);
    foreach ($protocol->statbilityStudy as $statbility) {
        $duration = $statbility->study->details->pluck('StudyTypeMonth');
        foreach ($duration as $month) {
            // dd($month);
            foreach ($protocol->statbilityStudy as $key => $statbility) {
                $study_months = $statbility->study->details->pluck('StudyTypeMonth');
                if (isset($study_months[$key]) && $month == $study_months[$key]) {
                    $AC[$key] = $study_months[$key];
                }
                $IN[$key] = $study_months[$key];
            }
        }
    }
    return $AC;
}

function study_month($month)
{
    switch ($month) {
        case '0':
            return 'AC';
            break;
        case '1':
            return 'AC';
            break;
        case '2':
            return 'AC';
            break;
        case '3':
            return 'AC';
            break;
        case '4':
            return 'AC';
            break;
        case '5':
            return 'AC';
            break;
        case '6':
            return 'AC, IN, LT';
            break;
        case '9':
            return 'IN, LT';
            break;
        case '12':
            return 'IN, LT';
            break;
        case '18':
            return 'LT';
            break;
        case '24':
            return 'LT';
            break;
        case '36':
            return 'LT';
            break;
        case '48':
            return 'LT';
            break;
        case '60':
            return 'LT';
            break;
        default:
            break;
    }
}
