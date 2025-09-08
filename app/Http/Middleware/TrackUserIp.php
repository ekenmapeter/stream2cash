<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\UserIpRecord;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;

class TrackUserIp
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only track authenticated users
        if (Auth::check()) {
            $this->trackUserIp($request);
        }

        return $response;
    }

    /**
     * Track user IP address and device information
     */
    private function trackUserIp(Request $request)
    {
        $user = Auth::user();
        $ipAddress = $request->ip();
        $userAgent = $request->userAgent();

        // Check if this IP was already recorded recently (within last hour)
        $recentRecord = UserIpRecord::where('user_id', $user->id)
            ->where('ip_address', $ipAddress)
            ->where('created_at', '>=', now()->subHour())
            ->first();

        if (!$recentRecord) {
            $agent = new Agent();
            $agent->setUserAgent($userAgent);

            // Detect device information
            $deviceType = $this->getDeviceType($agent);
            $browser = $agent->browser();
            $os = $agent->platform();

            // Check for suspicious activity
            $isSuspicious = $this->isSuspiciousActivity($user, $ipAddress);

            UserIpRecord::create([
                'user_id' => $user->id,
                'ip_address' => $ipAddress,
                'user_agent' => $userAgent,
                'country' => $this->getCountryFromIp($ipAddress),
                'city' => $this->getCityFromIp($ipAddress),
                'device_type' => $deviceType,
                'browser' => $browser,
                'os' => $os,
                'is_suspicious' => $isSuspicious,
                'notes' => $isSuspicious ? 'Suspicious activity detected' : null,
            ]);
        }
    }

    /**
     * Get device type from user agent
     */
    private function getDeviceType(Agent $agent)
    {
        if ($agent->isMobile()) {
            return 'mobile';
        } elseif ($agent->isTablet()) {
            return 'tablet';
        } else {
            return 'desktop';
        }
    }

    /**
     * Check for suspicious activity
     */
    private function isSuspiciousActivity($user, $ipAddress)
    {
        // Check for multiple IPs in short time
        $recentIps = UserIpRecord::where('user_id', $user->id)
            ->where('created_at', '>=', now()->subDay())
            ->pluck('ip_address')
            ->unique()
            ->count();

        // Check for VPN/Proxy IPs (simplified check)
        $isVpn = $this->isVpnOrProxy($ipAddress);

        return $recentIps > 5 || $isVpn;
    }

    /**
     * Simple VPN/Proxy detection (you can enhance this with a service)
     */
    private function isVpnOrProxy($ipAddress)
    {
        // This is a simplified check - in production, use a proper service
        $suspiciousRanges = [
            '10.0.0.0/8',
            '172.16.0.0/12',
            '192.168.0.0/16',
        ];

        foreach ($suspiciousRanges as $range) {
            if ($this->ipInRange($ipAddress, $range)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if IP is in range
     */
    private function ipInRange($ip, $range)
    {
        if (strpos($range, '/') === false) {
            return $ip === $range;
        }

        list($subnet, $bits) = explode('/', $range);
        $ip = ip2long($ip);
        $subnet = ip2long($subnet);
        $mask = -1 << (32 - $bits);
        $subnet &= $mask;

        return ($ip & $mask) === $subnet;
    }

    /**
     * Get country from IP (simplified - use a proper service in production)
     */
    private function getCountryFromIp($ipAddress)
    {
        // In production, use a service like ipapi.co or MaxMind
        return 'Unknown';
    }

    /**
     * Get city from IP (simplified - use a proper service in production)
     */
    private function getCityFromIp($ipAddress)
    {
        // In production, use a service like ipapi.co or MaxMind
        return 'Unknown';
    }
}
