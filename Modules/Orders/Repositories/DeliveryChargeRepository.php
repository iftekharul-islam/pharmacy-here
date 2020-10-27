<?php


namespace Modules\Orders\Repositories;

use Carbon\Carbon;
use Modules\Address\Entities\CustomerAddress;
use Modules\Orders\Entities\Models\Order;
use Modules\Orders\Entities\Models\OrderCancelReason;
use Modules\Orders\Entities\Models\OrderHistory;
use Modules\Orders\Entities\Models\OrderItems;
use Modules\Orders\Entities\Models\OrderPrescription;
use Modules\Points\Entities\Models\Points;
use Modules\User\Entities\Models\PharmacyBusiness;
use Modules\User\Entities\Models\User;
use Modules\User\Entities\Models\UserDeviceId;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DeliveryChargeRepository
{
    public function deliveryCharge($amount, $customer_id = null)
    {
        $normalDeliveryCharge = $amount > config('subidha.free_delivery_limit') ? 0.00 : config('subidha.normal_delivery_charge');

        $normalDelivery = [
            'delivery_charge' => $normalDeliveryCharge,
            'cash'  => number_format($amount * config('subidha.cash_payment_charge_percentage') / 100, 2)
        ];

        $expressDelivery = [
            'delivery_charge' => config('subidha.express_delivery_charge'),
            'cash'  =>  number_format($amount * config('subidha.cash_payment_charge_percentage') / 100, 2)
        ];

        $collectFromPharmacyCash = config('subidha.collect_from_pharmacy_charge') - ($amount * config('subidha.collect_from_pharmacy_discount_percentage') / 100);

        $collectFromPharmacy = [
            'delivery_charge' => config('subidha.collect_from_pharmacy_charge'),
            'cash'      => number_format($collectFromPharmacyCash, 2),
            'discount'  => number_format($amount * config('subidha.collect_from_pharmacy_discount_percentage') / 100, 2)
        ];

        //check if ecash payment allowed
        if ($amount <= config('subidha.ecash_payment_limit'))
        {
            $normalDelivery ['ecash'] = number_format(($normalDeliveryCharge + $amount) * (config('subidha.ecash_payment_charge_percentage') / 100), 2);

            $expressDelivery['ecash'] = number_format((config('subidha.express_delivery_charge') + $amount) * config('subidha.ecash_payment_charge_percentage') / 100, 2);

            $collectFromPharmacy['ecash'] = number_format((config('subidha.collect_from_pharmacy_charge') + $amount) * config('subidha.ecash_payment_charge_percentage') / 100, 2);
        }

        return [
            'normal_delivery'       => $normalDelivery,
            'express_delivery'      => $expressDelivery,
            'collect_from_pharmacy' => $collectFromPharmacy,
            'points' => Points::where('user_id', $customer_id)->sum('points'),
            'amount_per_point' => 0.01,
            'customer_point_redeem' => config('subidha.customer_point_redeem'),
            'point_redeem_discount_percentage' => config('subidha.point_redeem_discount_percentage'),
        ];
    }
}
