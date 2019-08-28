<?php

use Illuminate\Database\Seeder;

use App\Models\Payment;

class PaymentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = app(Faker\Generator::class);

        $names = [
            ['weChatPay','微信支付'],
            ['aliPay','支付宝支付']
        ];

        $payments = factory(Payment::class)->times(2)->make()->each(function($payment, $index) use ($faker,$names){
            $payment->char = $names[$index][0];
            $payment->name = $names[$index][1];
        });

        Payment::insert($payments->toArray());
    }
}
