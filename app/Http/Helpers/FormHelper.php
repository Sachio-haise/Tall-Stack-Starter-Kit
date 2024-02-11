<?php
namespace App\Http\Helpers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;

class FormHelper
{
    public static $moreData = ['created_by', 'updated_by', 'created_at', 'updated_at', 'deleted_at'];

    public static function getEdit($model, $id)
    {
        $routes = self::getModelRoute($model, $id, 'edit');
        return '<a class="inline-flex items-center gap-x-1 text-sm text-blue-600 decoration-2 font-light dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="' . $routes . '">Edit</a>';
    }

    private static function getModelRoute($model, $id, $action)
    {
        return route($model . '.' . $action, ['id' => $id]);
        // return route(self::$prefix.".".$model.".".$action, ['id' => $id]);
    }


    public static function getDetails($model, $id)
    {
        $routes = self::getModelRoute($model, $id, 'show');
        return '<a href="' . $routes . '" class="inline-flex items-center gap-x-1 text-sm text-blue-600 decoration-2 font-light dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">Details</a>';
    }

    public static function getDestroy($model, $id)
    {
        $routes = self::getModelRoute($model, $id, 'destroy');
        return '
            <form id="deleteForm' .
        $id .
            '" style="display: none;" action="' .
            $routes .
            '" method="post">
                <input name="_method" type="hidden" value="DELETE">
                <input name="_token" type="hidden" value="' .
            csrf_token() .
            '">
            </form>
            <button class="inline-flex items-center gap-x-1 text-sm text-blue-600 decoration-2 font-light dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" onclick="showDeleteConfirmation' .
            $id .
            '()">
                Delete
            </button>
            <script>
                function showDeleteConfirmation' .
            $id .
            '() {
                Swal.fire({
                    title: "Are you sure?",
                    text: "You want to delete this record!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#31C48D",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById("deleteForm' .
            $id .
            '").submit();
                            }
                        });
                }
            </script>';
    }

    public static function getRestore($model, $id)
    {
        $routes = self::getModelRoute($model, $id, 'restore');
        return '<a class="text-gray-300 inline-flex items-center gap-x-1 text-sm decoration-2 font-light dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="' . $routes . '">Restore</a>';
    }
}

