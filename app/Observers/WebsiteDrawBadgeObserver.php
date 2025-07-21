<?php

namespace App\Observers;

use App\Models\WebsiteDrawBadge;
use Illuminate\Support\Facades\DB;

class WebsiteDrawBadgeObserver
{
    public function updated(WebsiteDrawBadge $websiteDrawBadge): void
    {
        if ($websiteDrawBadge->wasChanged('published')) {
            $badgeCode = pathinfo($websiteDrawBadge->badge_path, PATHINFO_FILENAME);

            if ($websiteDrawBadge->published) {
                // Add badge to users_badges if it doesn't exist
                $exists = DB::table('users_badges')
                    ->where('user_id', $websiteDrawBadge->user_id)
                    ->where('badge_code', $badgeCode)
                    ->exists();

                if (!$exists) {
                    DB::table('users_badges')->insert([
                        'user_id' => $websiteDrawBadge->user_id,
                        'slot_id' => 0,
                        'badge_code' => $badgeCode,
                    ]);
                }
            } else {
                // Remove badge from users_badges
                DB::table('users_badges')
                    ->where('user_id', $websiteDrawBadge->user_id)
                    ->where('badge_code', $badgeCode)
                    ->delete();
            }
        }
    }
}