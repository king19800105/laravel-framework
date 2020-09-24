<?php

namespace App\Observers;

use App\Models\Admin;

class AdminObserver
{
    public function creating(Admin $admin)
    {
        $admin->password = bcrypt($admin->password);
    }

    public function updating(Admin $admin)
    {
        if ($admin->isDirty('password') && !empty($admin->password)) {
            $admin->password = bcrypt($admin->password);
        }
    }

}
