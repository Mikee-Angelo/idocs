<?php

/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Brackets\AdminAuth\Models\AdminUser::class, function (Faker\Generator $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->email,
        'password' => bcrypt($faker->password),
        'remember_token' => null,
        'activated' => true,
        'forbidden' => $faker->boolean(),
        'language' => 'en',
        'deleted_at' => null,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        'last_login_at' => $faker->dateTime,
        
    ];
});/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\GadPlan::class, static function (Faker\Generator $faker) {
    return [
        'role_id' => $faker->sentence,
        'model_type' => $faker->sentence,
        'model_id' => $faker->sentence,
        'status' => $faker->boolean(),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\GadPlanList::class, static function (Faker\Generator $faker) {
    return [
        'gad_plans_id' => $faker->sentence,
        'gad_issue_mandate' => $faker->text(),
        'cause_of_issue' => $faker->text(),
        'gad_statement_objective' => $faker->text(),
        'relevant_agencies' => $faker->sentence,
        'gad_activity' => $faker->text(),
        'indicator_target' => $faker->text(),
        'budget_requirement' => $faker->randomFloat,
        'budget_source' => $faker->sentence,
        'responsible_unit' => $faker->sentence,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\School::class, static function (Faker\Generator $faker) {
    return [
        'name' => $faker->firstName,
        'address' => $faker->text(),
        'admin_users_id' => $faker->sentence,
        'status' => $faker->boolean(),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->firstName,
        'email' => $faker->email,
        'email_verified_at' => $faker->dateTime,
        'password' => bcrypt($faker->password),
        'remember_token' => null,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
    ];
});

/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\RelevantAgency::class, static function (Faker\Generator $faker) {
    return [
        'name' => $faker->firstName,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\SourceOfBudget::class, static function (Faker\Generator $faker) {
    return [
        'name' => $faker->firstName,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Proposal::class, static function (Faker\Generator $faker) {
    return [
        'gad_plans_id' => $faker->sentence,
        'letter_body' => $faker->text(),
        'proposal_body' => $faker->text(),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Liquidation::class, static function (Faker\Generator $faker) {
    return [
        'purpose' => $faker->text(),
        'admin_users_id' => $faker->sentence,
        'status' => $faker->boolean(),
        'isSent' => $faker->boolean(),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Supplier::class, static function (Faker\Generator $faker) {
    return [
        'name' => $faker->firstName,
        'added_by' => $faker->sentence,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Unit::class, static function (Faker\Generator $faker) {
    return [
        'name' => $faker->firstName,
        'added_by' => $faker->sentence,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Reimbursement::class, static function (Faker\Generator $faker) {
    return [
        'letter_body' => $faker->text(),
        'admin_user_id' => $faker->sentence,
        'status' => $faker->boolean(),
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\EventType::class, static function (Faker\Generator $faker) {
    return [
        'name' => $faker->firstName,
        'admin_user_id' => $faker->sentence,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Announcement::class, static function (Faker\Generator $faker) {
    return [
        'event_type_id' => $faker->randomNumber(5),
        'header_img' => $faker->text(),
        'title' => $faker->text(),
        'description' => $faker->text(),
        'url' => $faker->text(),
        'starts_at' => $faker->dateTime,
        'ends_at' => $faker->dateTime,
        'created_by' => $faker->sentence,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
