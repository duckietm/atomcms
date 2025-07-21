<?php

namespace App\Http\Controllers;

use App\Actions\SendCurrency;
use App\Enums\CurrencyTypes;
use App\Services\SettingsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BadgeController extends Controller
{
    public function show(SettingsService $settingsService)
    {
        $cost = (int) $settingsService->getOrDefault('drawbadge_currency_value', 150);
        $currencyType = $settingsService->getOrDefault('drawbadge_currency_type', 'credits');

        return view('draw-badge', compact('cost', 'currencyType'));
    }

    public function buy(Request $request, SendCurrency $sendCurrency, SettingsService $settingsService)
    {
        $user = Auth::user();
        $cost = (int) $settingsService->getOrDefault('drawbadge_currency_value', 150);
        $currencyType = $settingsService->getOrDefault('drawbadge_currency_type', 'credits');

        // Get current amount based on currency type
        $currentAmount = match ($currencyType) {
            'credits' => $user->credits ?? 0,
            'duckets' => $user->currencies()->where('type', CurrencyTypes::Duckets)->value('amount') ?? 0,
            'diamonds' => $user->currencies()->where('type', CurrencyTypes::Diamonds)->value('amount') ?? 0,
            'points' => $user->currencies()->where('type', CurrencyTypes::Points)->value('amount') ?? 0,
            default => 0,
        };

        // Check if user has enough of the specified currency
        if ($currentAmount < $cost) {
            return response()->json(['success' => false, 'message' => 'Insufficient ' . $currencyType . '.'], 400);
        }

        // Deduct currency (negative amount to reduce)
        $result = $sendCurrency->execute($user, $currencyType, -$cost);

        if ($result === false) {
            return response()->json(['success' => false, 'message' => 'Failed to deduct ' . $currencyType . '.'], 500);
        }

        // Get badge data from request
        $badgeData = $request->input('badge_data');
        if (!$badgeData) {
            return response()->json(['success' => false, 'message' => 'No badge data provided.'], 400);
        }

        // Decode base64 (remove data URL prefix)
        $badgeData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $badgeData));

        // Get badges path from settings service
        $badgesPath = $settingsService->getOrDefault('badge_path_filesystem');
        if (!$badgesPath) {
            return response()->json(['success' => false, 'message' => 'Badges path not configured.'], 500);
        }

        // Generate filename: user_id_timestamp.gif
        $filename = $user->id . '_' . time() . '.gif';

        // Save the file directly to the filesystem path
        $fullPath = rtrim($badgesPath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $filename;
        if (!file_put_contents($fullPath, $badgeData)) {
            return response()->json(['success' => false, 'message' => 'Failed to save badge file.'], 500);
        }

        // Optionally, save badge info to database or assign via RCON here

        return response()->json(['success' => true, 'badge_path_filesystem' => $fullPath]);
    }
}