@php
    use Behin\SimpleWorkflow\Models\Entities\Users_profile;
    $customerId = $case->getVariable('user_profile_id');
    $customer = Users_profile::find($customerId);
    dd($customer);
@endphp