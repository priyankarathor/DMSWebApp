<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class userhierarchytab extends Model
{
    protected $table = 'userhierarchytabs';

    protected $fillable = [
        // Hierarchy
        'zonalId',
        'userId',
        'assignid',
        'framname',
        'roleid',
        'rgid',

        // Personal
        'username',
        'email',
        'password',
        'contactno',
        'alternativenum',
        'udyamcard',
        'file',

        // Company
        'registerid',
        'insertdate',
        'gstcode',
        'city',
        'state',
        'tehsils',
        'region',
        'pincode',
        'postalcode',
        'address',

        // Bank
        'bankname',
        'accountnum',
        'ifsccode',
        'holdername',
        'accounttype',

        // Status
        'active',
    ];

    /**
     * Hide password from JSON responses.
     */
    protected $hidden = ['password'];

    // ── Relationships ────────────────────────────────────────────────────────

    /** Direct parent in the hierarchy */
    public function parent()
    {
        return $this->belongsTo(userhierarchytab::class, 'zonalId');
    }

    /** Direct children in the hierarchy */
    public function children()
    {
        return $this->hasMany(userhierarchytab::class, 'zonalId')
            ->where('active', '!=', 'deactivate');
    }
}
