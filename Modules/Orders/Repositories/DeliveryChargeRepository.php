<?php


namespace Modules\Orders\Repositories;

use Carbon\Carbon;
use Modules\Address\Entities\CustomerAddress;
use Modules\Orders\Entities\Models\Order;
use Modules\Orders\Entities\Models\OrderCancelReason;
use Modules\Orders\Entities\Models\OrderHistory;
use Modules\Orders\Entities\Models\OrderItems;
use Modules\Orders\Entities\Models\OrderPrescription;
use Modules\User\Entities\Models\PharmacyBusiness;
use Modules\User\Entities\Models\User;
use Modules\User\Entities\Models\UserDeviceId;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DeliveryChargeRepository
{
    public function deliveryCharge($amount)
    {
        $orderAmount = $amount;
        $normalDelivery = [];
        $expressDelivery = [];
        $collectFromPharmacy = [];

        $data = [];

        if ($orderAmount <= config('subidha.ecash_payment_limit')) {
            $normalEcash = (config('subidha.normal_delivery_charge') + $amount) * config('subidha.ecash_payment_charge_percentage') / 100;
            $expressEcash = (config('subidha.express_delivery_charge') + $amount) * config('subidha.ecash_payment_charge_percentage') / 100;
            $normalDelivery = [
                'cash' =>  $amount  > config('subidha.free_cashon_delivery_limit') ?  0.00 : number_format(config('subidha.normal_delivery_charge') + $amount * config('subidha.cash_payment_charge_percentage') / 100, 2),
                'ecash' => number_format(config('subidha.normal_delivery_charge') + $normalEcash, 2)
            ];

            $expressDelivery = [
                'cash' => number_format(config('subidha.express_delivery_charge') + ($amount * config('subidha.cash_payment_charge_percentage') / 100), 2),
                'ecash' => number_format(config('subidha.express_delivery_charge') + $expressEcash, 2)
            ];

            $collectFromPharmacy = [
                'cash' => number_format(config('subidha.collect_from_pharmacy_charge') - ($amount * config('subidha.collect_from_pharmacy_discount_percentage') / 100), 2),
                'ecash' => number_format($amount * config('subidha.ecash_payment_charge_percentage') / 100, 2),
                'discount' => number_format($amount * config('subidha.collect_from_pharmacy_discount_percentage') / 100, 2)
            ];

            $data = [
                'normal_delivery' => $normalDelivery,
                'express_delivery' => $expressDelivery,
                'collect_from_pharmacy' => $collectFromPharmacy
            ];
        }
        else {
            $normalEcash = (config('subidha.normal_delivery_charge') + $amount) * config('subidha.ecash_payment_charge_percentage') / 100;
            $expressEcash = (config('subidha.express_delivery_charge') + $amount) * config('subidha.ecash_payment_charge_percentage') / 100;
            $normalDelivery = [
                'ecash' => number_format(config('subidha.normal_delivery_charge') + $normalEcash, 2)
            ];

            $expressDelivery = [
                'ecash' => number_format(config('subidha.express_delivery_charge') + $expressEcash, 2)
            ];

            $collectFromPharmacy = [
                'ecash' => number_format($amount * config('subidha.ecash_payment_charge_percentage') / 100, 2),
                'ecash_discount' => 0.00
            ];

            $data = [
                'normal_delivery' => $normalDelivery,
                'express_delivery' => $expressDelivery,
                'collect_from_pharmacy' => $collectFromPharmacy
            ];
        }

        return $data;
    }
}
