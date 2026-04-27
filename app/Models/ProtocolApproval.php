<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProtocolApproval extends Model
{
    use HasFactory;

    protected $table = 'ProtocolApproval';

    protected $primaryKey = 'ID';

    public $timestamps = false;

    public const ROLE_REVIEWER = 'Reviewer';
    public const ROLE_APPROVER = 'Approver';

    public const DECISION_PENDING  = 'Pending';
    public const DECISION_APPROVED = 'Approved';
    public const DECISION_DECLINED = 'Declined';

    protected $fillable = [
        'ProtocolID',
        'StepOrder',
        'Role',
        'AssignedUserID',
        'AssignedBy',
        'AssignedAt',
        'Decision',
        'Comment',
        'DecidedAt',
    ];

    protected $casts = [
        'AssignedAt' => 'datetime',
        'DecidedAt'  => 'datetime',
    ];

    public function protocol()
    {
        return $this->belongsTo(Protocol::class, 'ProtocolID', 'ProtocolID');
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'AssignedUserID');
    }

    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'AssignedBy');
    }

    public function scopeForProtocol($query, $protocolId)
    {
        return $query->where('ProtocolID', $protocolId)->orderBy('StepOrder');
    }

    public function scopePendingFor($query, $userId)
    {
        return $query->where('AssignedUserID', $userId)->where('Decision', self::DECISION_PENDING);
    }

    public function isPending(): bool
    {
        return $this->Decision === self::DECISION_PENDING;
    }

    public function isApproved(): bool
    {
        return $this->Decision === self::DECISION_APPROVED;
    }

    public function isDeclined(): bool
    {
        return $this->Decision === self::DECISION_DECLINED;
    }

    public function isReviewer(): bool
    {
        return $this->Role === self::ROLE_REVIEWER;
    }

    public function isApprover(): bool
    {
        return $this->Role === self::ROLE_APPROVER;
    }
}
