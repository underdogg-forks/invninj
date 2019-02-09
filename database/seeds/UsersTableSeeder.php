<?php

use App\DataMapper\DefaultSettings;
use App\Models\Account;
use App\Models\Customer;
use App\Models\CustomerContact;
use App\Models\User;
use App\Models\UserAccount;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    use \App\Utils\Traits\MakesHash;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $this->command->info('Running UsersTableSeeder');

        Eloquent::unguard();

        $faker = Faker\Factory::create();

        $account = factory(\App\Models\Account::class)->create();
        $company = factory(\App\Models\Company::class)->create([
            'account_id' => $account->id,
        ]);

        $account->default_company_id = $company->id;
        $account->save();

        $user = factory(\App\Models\User::class)->create([
            'account_id' => $account->id,
            'confirmation_code' => $this->createDbHash(config('database.default'))
        ]);


        $userPermissions = collect([
                                    'view_invoice',
                                    'view_customer',
                                    'edit_customer',
                                    'edit_invoice',
                                    'create_invoice',
                                    'create_customer'
                                ]);

        $userSettings = DefaultSettings::userSettings();

        $user->companies()->attach($company->id, [
            'account_id' => $account->id,
            'is_owner' => 1,
            'is_admin' => 1,
            'permissions' => $userPermissions->toJson(),
            'settings' => json_encode($userSettings),
            'is_locked' => 0,
        ]);

        $customer = factory(\App\Models\Customer::class)->create([
            'user_id' => $user->id,
            'company_id' => $company->id
        ]);


        CustomerContact::create([
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'email' => config('ninja.testvars.customername'),
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

        });


    }
}
