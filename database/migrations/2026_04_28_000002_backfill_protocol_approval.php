<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('ProtocolApprovalTree')) {
            return;
        }

        $protocolIds = DB::table('ProtocolApprovalTree')
            ->whereIn('ProtocolApprovalTypeID', [1, 2])
            ->whereNotNull('ProtocolID')
            ->whereNotNull('UserID')
            ->distinct()
            ->pluck('ProtocolID');

        foreach ($protocolIds as $pid) {
            $protocol = DB::table('Protocol')->where('ProtocolID', $pid)->first();
            $statusId = (int) ($protocol->ProtocolStatusID ?? 1);

            $assignments = DB::table('ProtocolApprovalTree')
                ->where('ProtocolID', $pid)
                ->whereIn('ProtocolApprovalTypeID', [1, 2])
                ->whereNotNull('UserID')
                ->orderBy('ProtocolApprovalTypeID')
                ->orderBy('ID')
                ->get();

            $reviewerComments = DB::table('ProtocolReviewer')
                ->where('ProtocolID', $pid)
                ->orderBy('CreateDate')
                ->get()
                ->keyBy('UserID');

            $approverComments = DB::table('ProtocolApprover')
                ->where('ProtocolID', $pid)
                ->orderBy('CreateDate')
                ->get()
                ->keyBy('UserID');

            $rows = [];
            $step = 0;

            foreach ($assignments as $assignment) {
                $step++;
                $isReviewer = (int) $assignment->ProtocolApprovalTypeID === 1;
                $userId     = (int) $assignment->UserID;

                $commentRow = $isReviewer
                    ? ($reviewerComments[$assignment->UserID] ?? null)
                    : ($approverComments[$assignment->UserID] ?? null);

                $decision  = 'Pending';
                $decidedAt = null;
                $comment   = null;

                if ($commentRow) {
                    $comment   = $commentRow->Comment ?? null;
                    $decidedAt = $commentRow->CreateDate ?? null;
                    if ($isReviewer) {
                        $decision = 'Approved';
                    } elseif ($statusId === 5) {
                        $decision = 'Declined';
                    } else {
                        $decision = 'Approved';
                    }
                }

                $rows[] = [
                    'ProtocolID'     => $pid,
                    'StepOrder'      => $step,
                    'Role'           => $isReviewer ? 'Reviewer' : 'Approver',
                    'AssignedUserID' => $userId,
                    'AssignedBy'     => null,
                    'AssignedAt'     => $assignment->CreateDate ?? now(),
                    'Decision'       => $decision,
                    'Comment'        => $comment,
                    'DecidedAt'      => $decidedAt,
                ];
            }

            if ($rows) {
                DB::table('ProtocolApproval')->insert($rows);
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('ProtocolApproval')) {
            DB::table('ProtocolApproval')->truncate();
        }
    }
};
