<?php

namespace App\Traits;

use App\Models\RecipientAccount;

trait HasRecipientAccount
{
    public function recipientAccount()
    {
        return $this->morphOne(RecipientAccount::class, 'recipientable')->where('is_active', true);
    }

    public function recipientAccounts()
    {
        return $this->morphMany(RecipientAccount::class, 'recipientable');
    }

    public function getActiveRecipientAccountAttribute()
    {
        return $this->recipientAccount;
    }
}