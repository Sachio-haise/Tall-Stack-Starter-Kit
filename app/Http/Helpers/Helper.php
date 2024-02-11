<?php

namespace App\Http\Helpers;

use Spatie\Permission\Models\Role;

class Helper
{
    public static function getPermission($permission, $title)
    {
        foreach ($permission as $key => $value) {
            if ($value->name == $title) {
                return true;
            }
        }
    }

    public static function getRoles($roles)
    {
        foreach ($roles as $role) {
            return "<span class='mr-2 rounded bg-yellow-500 px-2.5 py-0.5 text-xs font-medium text-green-800 dark:bg-green-900 dark:text-green-300'>" . $role['name'] . '</span>';
        }
    }

    public static function setRoles()
    {
        $roles = Role::pluck('name')->toArray();
        return 'role:' . implode('|', $roles);
    }

    public static function getHumanTime($time)
    {
        return \Carbon\Carbon::createFromTimestamp(strtotime($time))->diffForHumans();
    }

    public static function jsonEncode($array)
    {
        if (is_array($array)) {
            return json_encode($array);
        } else {
            return $array;
        }
    }

    // TODO: If don't use remove it
    public static function jsonDecode($string)
    {
        return json_decode($string, true);
    }

    // TODO: If don't use remove it
    public static function getDecodeData($data)
    {
        $array = self::jsonDecode($data);
        if (!$array) {
            return '-';
        } else {
            return implode('/', $array);
        }
    }

    public static function getFormatTime($time)
    {
        $formattedTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $time, 'UTC');
        return $formattedTime->format('Y-m-d');
    }

    // TODO: If don't use remove it
    public static function getIntake($intake)
    {
        switch ($intake) {
            case '01':
                return '01~January';
            case '04':
                return '04~April';
            case '07':
                return '07~July';
            case '10':
                return '10~October';
        }
    }

    public static function getArrayMerge($array1)
    {
        return array_merge($array1, FormHelper::$moreData);
    }

    public static function getHandleData($message, $route, $id = null, $e = null)
    {
        if ($e) {
            if ($e->getCode() == 23000) {
                return self::handleException($route, $message . ' (Error Code: 23000)' . $e->getMessage(), $id);
            } else {
                return self::handleException($route, $message . ' (Error Code: ' . $e->getCode() . ':' . $e->getMessage() . ')', $id);
            }
        } else {
            return self::handleSuccess($route, $message, $id);
        }
    }

    public static function handleException($route, $message, $id = null)
    {
        return redirect()
            ->route($route, $id ?? '')
            ->with([
                'message' => $message,
                'style' => 'danger',
            ]);
    }

    public static function handleSuccess($route, $message, $id = null)
    {
        return redirect()
            ->route($route, $id ?? '')
            ->with([
                'message' => $message,
                'style' => 'success',
            ]);
    }
}
