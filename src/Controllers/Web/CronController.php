<?php 

namespace App\Controllers\Web;

use Gregwar\Image\GarbageCollect;

class CronController extends Controller
{
    // This could be a cron called each day @3:00AM for instance
    // Removes all the files from ../cache that are more than 30 days
    // old. A verbose output will explain which files are deleted
    GarbageCollect::dropOldFiles(__DIR__.'/../../../cache', 30, true);
}