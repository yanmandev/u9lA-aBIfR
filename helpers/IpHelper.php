<?php

namespace app\helpers;

use IPLib\Factory;
use IPLib\Address\IPv4 as IPv4Class;
use IPLib\Address\IPv6 as IPv6Class;

class IpHelper
{
    public static function mask($ip): ?string
    {
        try {
            $address = Factory::parseAddressString($ip);
        } catch (\Exception $e) {
            return null;
        }

        if ($address === null) {
            return null;
        }

        if ($address instanceof IPv4Class) {
            $v4 = $address->toString();
            $parts = explode('.', $v4);

            if (count($parts) !== 4) {
                return null;
            }

            return sprintf('%s.%s.%s.%s', $parts[0], $parts[1], '**', '**');
        }

        if ($address instanceof IPv6Class) {
            try {
                $ipv4 = $address->toIPv4();
            } catch (\Throwable $e) {
                $ipv4 = null;
            }
            if ($ipv4 instanceof IPv4Class) {
                $v4 = $ipv4->toString();
                $parts = explode('.', $v4);

                return sprintf('%s.%s.%s.%s', $parts[0], $parts[1], '**', '**');
            }

            $packed = @inet_pton($address->toString());
            if ($packed === false) {
                return null;
            }

            $hex = unpack('H*hex', $packed)['hex'];
            $hextets = str_split($hex, 4);
            $firstFour = array_slice($hextets, 0, 4);
            $firstFourStr = array_map(function ($h) {
                return strtolower($h);
            }, $firstFour);

            return implode(':', $firstFourStr) . ':****:****:****:****';
        }

        return null;
    }
}