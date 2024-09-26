<?php

// File: app/Helpers/PermissionHelper.php

if (! function_exists('checkPermission')) {
    /**
     * Check if the given permission exists in the permission group.
     *
     * @param array $permissions
     * @param string $permission
     * @return bool
     */
    function checkPermission(array $permissions, string $permission): bool
    {
        return in_array($permission, $permissions);
    }
}

function currentRole()
{
    return session('switched_role') ?: auth()->user()->roles->first()->name;
}