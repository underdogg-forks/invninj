<?php

use App\Models\Account;
use App\Models\Customer;
use App\Models\CustomerContact;
use App\Models\User;
use App\Models\UserAccount;
use Illuminate\Database\Seeder;

class RandomDataSeeder extends Seeder
{
    use \App\Utils\Traits\MakesHash;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $this->command->info('Running RandomDataSeeder');

        Eloquent::unguard();

        $faker = Faker\Factory::create();

        $account = factory(\App\Models\Account::class)->create();
        $company = factory(\App\Models\Company::class)->create([
            'account_id' => $account->id,
        ]);

        $account->default_company_id = $company->id;
        $account->save();

        $user = factory(\App\Models\User::class)->create([
            'email'             => $faker->email,
            'account_id' => $account->id,
            'confirmation_code' => $this->createDbHash(config('database.default'))
        ]);

        $user->companies()->attach($company->id, [
            'account_id' => $account->id,
            'is_owner' => 1,
            'is_admin' => 1,
            'is_locked' => 0,
        ]);

        $customer = factory(\App\Models\Customer::class)->create([
            'user_id' => $user->id,
            'company_id' => $company->id
        ]);


        CustomerContact::create([
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'email' => $faker->email,
            'company_id' => $company->id,
            'password' => Hash::make(config('ninja.testvars.password')),
            'email_verified_at' => now(),
            'customer_id' =>$customer->id,
        ]);


        factory(\App\Models\Customer::class, 500)->create(['user_id' => $user->id, 'company_id' => $company->id])->each(function ($c) use ($user, $company){

            factory(\App\Models\CustomerContact::class,1)->create([
                'user_id' => $user->id,
                'customer_id' => $c->id,
                'company_id' => $company->id,
                'is_primary' => 1
            ]);

            factory(\App\Models\CustomerContact::class,15)->create([
                'user_id' => $user->id,
                'customer_id' => $c->id,
                'company_id' => $company->id
            ]);
/*
            factory(\App\Models\CustomerLocation::class,1)->create([
                'customer_id' => $c->id,
                'is_primary_billing' => 1
            ]);

            factory(\App\Models\CustomerLocation::class,10)->create([
                'customer_id' => $c->id,
            ]);
*/
        });


    }
}
